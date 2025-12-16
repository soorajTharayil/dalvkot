<!--Code updates: 
Worked on UI allignment, fixed all the issues.
Last updated on 05-03-23 -->

<?php //echo lang_loader('ip','ip_allfeedbacks_dashboard'); exit; 
require_once 'quality_tables.php';
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
	<!-- Metric Boxes-->
	<div class="row">
		<?php if (isfeature_active('QUALITY-KPI1') === true) { ?>
			<?php
			// $fdate = $_SESSION['from_date'];
			// $tdate = $_SESSION['to_date'];
			// $table_feedback_1PSQ3a = 'bf_feedback_1PSQ3a';
			// $table_patients_1PSQ3a = 'bf_patients';
			// $desc_1PSQ3a = 'desc';
			// $sorttime = 'asc';
			// $setup = 'setup';
			//  $ip_feedbacks_count1 = $this->quality_model->patient_and_feedback_quality($table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;">
								<?php echo lang_loader('ip', 'kpi1'); ?>
								<a href="javascript:void()" data-toggle="tooltip" title="<?php echo $initial_assesment_info_tooltip; ?>">
									<i class="fa fa-info-circle" aria-hidden="true"></i>
								</a>
							</div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_1PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI2') === true) { ?>
			<?php
			// $table_feedback_1PSQ3a = 'bf_feedback_2PSQ3a';
			// $table_patients_1PSQ3a = 'bf_patients';
			// $desc_1PSQ3a = 'desc';
			// $sorttime = 'asc';
			// $setup = 'setup';
			// $ip_feedbacks_count2 = $this->quality_model->patient_and_feedback($table_patients_1PSQ3a, $table_feedback_1PSQ3a, $sorttime, $setup);
			?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi2'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $report_error_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-exclamation-triangle" style="font-size: 70px; margin-top:8px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_2PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI3') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi3'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $safety_precautions_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-shield" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_3PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI4') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi4'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $medication_errors_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_4PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI5') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi5'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $medication_charts_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-file-text-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_5PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI6') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi6'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $adverse_drug_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-heartbeat" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_6PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI7') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi7'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $unplanned_return_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-undo" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_7PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI8') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px; white-space: normal; word-wrap: break-word; width: calc(100% - 100px);">
								<?php echo lang_loader('ip', 'kpi8'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $wrong_surgery_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-check-square-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_8PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI9') === true) { ?>



			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi9'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $transfusion_reactions_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-tint" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_9PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI10') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi10'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $mortality_ratio_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-bar-chart" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_10PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI11') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi11'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $theemergency_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-ambulance" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_11PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI12') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi12'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $ulcers_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-bed" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_12PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI13') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi13'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $urinary_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_13PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI14') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi14'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $pneumonia_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-stethoscope" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_14PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI15') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi15'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $blood_infection_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-tint" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_15PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI16') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi16'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $site_infection_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-scissors" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_16PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>


		<?php if (isfeature_active('QUALITY-KPI17') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi17'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $hand_hygiene_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-hand-paper-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_17PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI18') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi18'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $prophylactic_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_18PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI19') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi19'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $re_scheduling_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-refresh" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_19PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI20') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi20'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $blood_components_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_20PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI21') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi21'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $nurse_patient_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-user-md" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_21PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI21a') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi21a'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $nurse_patient_ward_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-user-md" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_21aPSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI22') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi22'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $consultation_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_22PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI23a') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi23a'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $diagnostics_info_atooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_23aPSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI23b') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi23b'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $diagnostics_info_btooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_23bPSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI23c') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi23c'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $diagnostics_info_ctooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_23cPSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI23d') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi23d'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $diagnostics_info_dtooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_23dPSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI24') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi24'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $discharge_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_24PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI25') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi25'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $medical_records_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-file-text-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_25PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI26') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi26'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $emergency_medications_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_26PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI27') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi27'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $mock_drills_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-bullseye" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_27PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI28') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi28'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $patient_fall_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-wheelchair" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_28PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>

		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI29') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi29'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $near_misses_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-exclamation-triangle" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_29PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI30') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi30'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $stick_injuries_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-medkit" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_30PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI31') === true) { ?>


			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi31'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $shift_change_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-handshake-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_31PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI32') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi32'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $prescription_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-check-square-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_32PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (isfeature_active('QUALITY-KPI33') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi33'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $readmission_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-undo" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI34') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi34'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $beta_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-heartbeat" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_33PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI35') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px; white-space: normal; word-wrap: break-word; width: calc(100% - 100px);">
								<?php echo lang_loader('ip', 'kpi35'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $myocardial_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-heartbeat" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_34PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI36') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px; white-space: normal; word-wrap: break-word; width: calc(100% - 100px);">
								<?php echo lang_loader('ip', 'kpi36'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $hypoglycemia_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-tint" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_35PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI37') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi37'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $perineal_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-female" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_36PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI38') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi38'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $endophthalmitis_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-eye" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_37PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI39') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi39'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $colonoscopy_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-stethoscope" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_38PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI40') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi40'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $intervention_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-scissors" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_39PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI41') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi41'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $clinical_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-flask" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_40PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI42') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi42'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $gain_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-arrow-up" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_41PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI43') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi43'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $sepsis_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-ambulance" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_42PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI44') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi44'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $discharge_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-file-text-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_43PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI45') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo wordwrap(lang_loader('ip', 'kpi45'), 90, "<br>\n", true); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $stroke_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_44PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI46') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi46'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $bronchiolitis_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-exclamation-triangle" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_45PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI47') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo wordwrap(lang_loader('ip', 'kpi47'), 95, "<br>\n", true); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $oncology_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-users" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_46PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI48') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi48'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $radiopharmaceutical_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-bolt" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_47PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI49') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi49'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $extravasation_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-tint" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_48PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI50') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi50'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $triage_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-clock-o" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_49PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if (isfeature_active('QUALITY-KPI51') === true) { ?>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
				<div class="panel panel-bd">
					<!-- <a href="javascript:void()" data-toggle="tooltip" title="Total no. of Inpatient discharge feedbacks collected during the selected period."><i class="fa fa-info-circle" aria-hidden="true"></i></i></a> -->

					<div class="panel-body" style="height: 100px; padding-top:0px;">
						<div class="statistic-box" style="padding-top: 44px;">

							<div class="small" style="font-size: 20px;"> <?php echo lang_loader('ip', 'kpi51'); ?> <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $hemoglobin_info_tooltip; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></i></a></div>
							<div class="icon large-screen-only">
								<i class="fa fa-tint" style="font-size: 80px;"></i>
							</div>
							<a href="<?php echo $quality_feedback_50PSQ3a; ?>" style="float: right; font-size: 17px; margin-top: 7px;margin-bottom: 10px;margin-right: 1px">Explore</a>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>


</div>
<!-- Close Metric Boxes-->
<?php



?>




<!-- Close Why choose the hospital and patient comments -->


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/efeedor_chart.js"></script>
</div>

<style>
	.icon .fa {
		font-size: 60px;
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