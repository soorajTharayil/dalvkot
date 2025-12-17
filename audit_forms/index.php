<!DOCTYPE html>
<html lang="en">
<!-- head part start -->
<!-- Interim feedback -->

<head>
	<title>Quality Audit Management Software - Efeedor Healthcare Experience Management Platform</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="style.css?<?php echo time(); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.7.9/angular-sanitize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-load-image/2.21.0/load-image.all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/image-conversion@1.0.1/dist/browser.js"></script>

	<script src="app_grievance.js?<?php echo time(); ?>"></script>
</head>
<!-- head part end -->


<!-- body part start -->

<body ng-app="ehandorApp" ng-controller="PatientFeedbackCtrl" style="display:none;" id="body">
	<!-- top navbar start -->
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed">
		<!-- Logo of efeedor -->
		<!-- <a class="navbar-brand" href="#"><img src="{{setting_data.logo}}" style="height: 36px; margin-left: -10px;" alt="Efeedor Logo"></a> -->

		<!-- Section for Buttons and Language Button -->
		<div class="ml-auto d-flex justify-content-between align-items-center w-100">
			<div class="left-buttons d-flex">
				<a ng-href="/login/?userid={{ userId }}" class="btn btn-light mr-3 dashboard-btn" style="width: 100px; height: 32px; font-size: 14px; font-weight: bold; text-align: left; display: flex; align-items: center; padding-left: 10px;">
					Dashboard
				</a>
			</div>



			<!-- Right Side: Language Button -->
			<div class="right-buttons d-flex align-items-center">
				<button type="button" class="btn btn-dark language-btn" data-toggle="modal" data-target="#languageModal" style="margin: 4px;">
					<!--  {{type2}}-->
					<!--  <i class="fa fa-language" aria-hidden="true"></i>-->
					<!--</button>-->
					<button class="btn btn-dark menu-toggle" ng-click="menuVisible = !menuVisible" style="margin: 4px;">
						<i class="fa fa-bars"></i>
					</button>
			</div>
		</div>
	</nav>
	<div class="menu-dropdown" ng-show="menuVisible" style="margin-top: 32px; margin-right: 10px;">
		<div class="user-info" style="display: flex; align-items: center; padding: 10px; border-bottom: 1px solid #ddd; background: #f5f5f5;">
			<i class="fa fa-user-circle" style="font-size: 24px; margin-right: 10px; color: #333;"></i>
			<div>
				<div style="font-weight: bold; font-size: 14px;">{{ profilen.name }}</div>
				<div style="font-size: 12px; font-weight: bold;">{{ profilen.email }}</div>
			</div>
		</div>
		<ul style="margin-left: -5px;">
			<li><a href="#" ng-click="showAllContent()"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#" ng-click="showDashboard()"><i class="fa fa-globe"></i> Web Dashboard Access</a></li>
			<li><a href="/login/?userid={{ adminId }}&redirectType=userActivity"><i class="fa fa-user"></i> User Activity</a></li>
			<li><a href="#" ng-click="showAppDown()"><i class="fa fa-download"></i> App Download</a></li>
			<li><a href="#" ng-click="showSupport()"><i class="fa fa-phone"></i> Support</a></li>
			<li><a href="#" ng-click="showAbout()"><i class="fa fa-info-circle"></i> About</a></li>
			<li><a href="/form_login"><i class="fa fa-sign-out"></i> Logout</a></li>
		</ul>
	</div>

	<!-- About Content Section -->
	<div ng-show="aboutVisible" class="about-section" style="background-color: white; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
		<h2>About</h2>
		<!-- <img src="/Efeedor_logo.png" alt="Colorful Image" style="max-width: 100%; height: auto; margin-bottom: 20px;"> -->
		<p><strong>Version:</strong> 8.01.05</p>
		<p>
			The Efeedor Mobile App is an extension of Efeedor's Healthcare Experience Management Suite, developed by ITATONE POINT CONSULTING LLP, a global health tech company specializing in enterprise applications for healthcare experience management. Designed for healthcare staff on the go, the app simplifies tasks like collecting patient feedback, addressing concerns, and reporting incidents or internal tickets. With its intuitive interface, you can easily track and manage activities and tickets.
		</p>
		<p>
			Record patient feedback, concerns, and requests, report incidents and grievances, and raise internal tickets effortlessly. The Efeedor Mobile App puts healthcare experience management at your fingertips, streamlining operations for better care delivery.
		</p>
		<p><i class="fa fa-globe"></i> <a href="https://www.efeedor.com" target="_blank">www.efeedor.com</a></p>
		<p><i class="fa fa-envelope"></i> <a href="mailto:contact@efeedor.com">contact@efeedor.com</a></p>
	</div>

	<!-- Support Content Section -->
	<div ng-show="supportVisible" class="support-section" style="background-color: white; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
		<h2>Support</h2>
		<p>
			For dedicated assistance ensuring your satisfaction and success with our software, please complete the details below to create your support ticket.
		</p>

		<iframe width="500" height="650" src="https://crm.efeedor.com/forms/ticket" frameborder="0" allowfullscreen></iframe>
	</div>

	<!-- App Download Section -->
	<div ng-show="appDownloadVisible" class="app-download-section" style="background-color: white; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
		<h2>App Download</h2>
		<p>
			Download the Efeedor Mobile App to enhance your healthcare experience management. Click the button below to get the latest version of the APK.
		</p>

		<!-- Button for APK Download -->
		<button ng-click="downloadApk()"
			ng-disabled="!setting_data.android_apk"
			style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
			<i class="fa fa-download"></i> Download APK
		</button>
	</div>

	<!-- Web Dashboard section -->
	<div ng-show="dashboardVisible" class="dashboard-section" style="background-color: white; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
		<h2>Explore Web Dashboard</h2>
		<p>
			To access the web dashboard, please log in with your credentials using the following link. If you hold an Admin role, you will have access to view reports and analytics based on the permissions granted. If you are a department head or in charge of a department, you will be able to access the dashboard to view reports and analytics specific to your department and take action on the tickets assigned to you or your team.
		</p>

		<!-- Button for APK Download -->
		<a href="/login/?userid={{ adminId }}"
			style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
			<i class="fa fa-globe"></i> Click here to open the link
		</a>
	</div>
	<!-- top navbar end -->
	<!-- Create a modal for language selection -->
	<div class="modal fade" id="languageModal" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="languageModalLabel">Select Language</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Place your language selection options here -->



					<div class=" col-lg-12 col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
						<div class=" px-0 pt-2 pb-0">

							<div style="text-align: left; align-items: left; margin-left: 25px; margin-right: 25px;"></div>
							<div class="box box-primary profilepage">
								<div class="box-body box-profile" style="display: inline-block;">

									<div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('english')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -133px; color: #4b4c4d;">
												English
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												A
											</span>
										</div>
									</div>
									<br>

									<!-- <div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('lang2')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -133px; color: #4b4c4d;">
												ಕನ್ನಡ
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												ಕ
											</span>
										</div>
									</div>
									<br> -->

									<!-- <div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('lang3')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -100px; color: #4b4c4d;">
												മലയാളം
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												അ
											</span>
										</div>
									</div>
									<br> -->

									<!--	<div class="card" style=" border: 2px solid #000;">
										<div class="card-body" ng-click="language('lang3')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -100px; color: #4b4c4d;">
												தமிழ்
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												த
											</span>
										</div>
									</div> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="grad1" ng-show="!aboutVisible && !supportVisible && !appDownloadVisible && !dashboardVisible">
		<div class="row justify-content-center mt-0" style="height:max-content;">
			<div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
				<img ng-src="{{setting_data.logo}}" style="    height: 50px;">
				<br>
				<div class="card px-0 pt-2 pb-0 mt-2 mb-3">
					<div class="row">
						<div class="col-md-12 mx-0">
							<!-- form start -->
							<form id="msform">


								<!-- INTERIM FEEDBACK FORM page start  -->
								<fieldset ng-show="step2 == true">
									<div class="form-card">
										<h3 class="sectiondivision" style="font-weight:bold;">{{lang.pagetitle}}</h3>

										<p style="margin:0px; margin-top:10px;font-size: 16px;">
											<?php
											date_default_timezone_set('Asia/Kolkata');
											$hour = date('H');

											if ($hour < 12) {
												echo '{{lang.goodmorning}}';
											} elseif ($hour < 18) {
												echo '{{lang.goodafternoon}}';
											} else {
												echo '{{lang.goodevening}}';
											} ?>
											<!-- {{lang.gustname}}  -->
											{{loginname}}
											<br>
										<p style="margin:0px;font-size: 16px;">{{lang.gustmessageint}}</p>
									</div>
									<br />


									<h4 style="font-size: 18px; margin-bottom: 22px; padding-top: 10px;">
										<b>{{lang.chooseCategory}}
											<!-- <select ng-model="selectedMonth" ng-change="saveSelection()" ng-options="month for month in months" style="font-size: 16px; margin-left: 10px; border: 1px solid grey; background: white; padding: 2px 5px; border-radius: 4px; font-weight: bold;">
											</select>
											<select ng-model="selectedYear" ng-change="saveSelection()" ng-options="year for year in years" style="font-size: 16px; margin-left: 10px; border: 1px solid grey; background: white; padding: 2px 5px; border-radius: 4px; font-weight: bold;">
											</select> -->
										</b>
									</h4>

									<!-- Search box -->
									<input type="text" ng-model="searchAudit" placeholder="🔍 Search audits..."
										style="width:94%;margin:10px auto;display:block; padding:8px 10px;border:1px solid #ccc; border-radius:4px;font-size:16px;">







									<div class="" style="width: 94%; margin: 0px auto; margin-top: 25px;" title="Ensures record completeness, accuracy & compliance (times, consent, discharge) per NABH, WHO, CAHO, ICMR, JCI standards.">
										<div class="row" ng-if="hasAuditList([1,8,9,10,12,14,15,16,17,18,19,22])">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size: 18px; font-weight: bold;">
													Clinical Audits
												</h4>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT1'] == true" ng-show="matchSearch('MRD Audit form')">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">

															<div class="card product-card" style="margin-bottom: 10px;">
																<a href="../mrd_audit" class="card" style="text-decoration: none; background-color: #F5F5F5; color: black;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">MRD Audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures record completeness, accuracy & compliance (times, consent, discharge) per NABH, WHO, CAHO, ICMR, JCI standards."></i></p>

																	</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT8'] == true" ng-show="matchSearch('Operating Room Safety audit checklist')" title="Validates OR safety compliance—patient ID, consent, site marking, infection control & equipment checks as per NABH, JCI, CAHO, WHO Safe Surgery & CDC perioperative standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../surgical_safety" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Operating Room Safety audit checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Validates OR safety compliance—patient ID, consent, site marking, infection control & equipment checks as per NABH, JCI, CAHO, WHO Safe Surgery & CDC perioperative standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT9'] == true" ng-show="matchSearch('Medication management process audit form')" title="Assesses safe prescribing, dispensing & administration of medications as per NABH, JCI, CAHO, WHO Medication Safety, ISMP & CDSCO standards to ensure compliance and patient safety.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../medicine_dispense" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Medication management process audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Assesses safe prescribing, dispensing & administration of medications as per NABH, JCI, CAHO, WHO Medication Safety, ISMP & CDSCO standards to ensure compliance and patient safety."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT10'] == true" ng-show="matchSearch('Medication administration audit form')" title="Ensures safe, timely & accurate medication administration with patient rights, infection control & documentation checks as per NABH, JCI, CAHO & WHO safe medication standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../medication_administration" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Medication administration audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures safe, timely & accurate medication administration with patient rights, infection control & documentation checks as per NABH, JCI, CAHO & WHO safe medication standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT12'] == true" ng-show="matchSearch('Prescriptions audit form')" title="Audits prescriptions for legibility & completeness—drug, dose, route, frequency, patient ID & doctor signature—as per NABH, JCI, CAHO, MCI & WHO safe prescribing standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../prescriptions" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Prescriptions audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits prescriptions for legibility & completeness—drug, dose, route, frequency, patient ID & doctor signature—as per NABH, JCI, CAHO, MCI & WHO safe prescribing standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT14'] == true" ng-show="matchSearch('Turn around time for issue of blood and blood components')" title="Monitors turnaround time for blood and component requests to ensure timely transfusion, as per NABH, JCI, CAHO, NACO & WHO standards on blood bank safety and transfusion practices.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../tat_blood" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Turn around time for issue of blood and blood components <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Monitors turnaround time for blood and component requests to ensure timely transfusion, as per NABH, JCI, CAHO, NACO & WHO standards on blood bank safety and transfusion practices."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT15'] == true" ng-show="matchSearch('Nurse-Patient ratio for ICU')" title="Tracks ICU nurse-patient ratio to ensure safe staffing and quality care, aligned with NABH, JCI, CAHO, MoHFW & Indian Nursing Council standards for critical care units.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../nurse_patients_ratio" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Nurse-Patient ratio for ICU <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks ICU nurse-patient ratio to ensure safe staffing and quality care, aligned with NABH, JCI, CAHO, MoHFW & Indian Nursing Council standards for critical care units."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT16'] == true" ng-show="matchSearch('Return to ICU within 48 hours after being discharged from ICU')" title="Monitors ICU readmissions within 48 hours of discharge to evaluate care quality, prevent adverse events, and improve outcomes as per NABH, JCI, CAHO, MoHFW & ICMR patient safety standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_i" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Return to ICU within 48 hours after being discharged from ICU <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Monitors ICU readmissions within 48 hours of discharge to evaluate care quality, prevent adverse events, and improve outcomes as per NABH, JCI, CAHO, MoHFW & ICMR patient safety standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT17'] == true" ng-show="matchSearch('Return to ICU within 48 hours after being discharged from ICU- Data Verification')" title="Validates ICU readmission data within 24–48 hrs to ensure accuracy, support quality reviews, and minimize errors as per NABH, JCI, CAHO, MoHFW & ICMR patient safety guidelines.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_icu" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Return to ICU within 48 hours after being discharged from ICU- Data Verification <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Validates ICU readmission data within 24–48 hrs to ensure accuracy, support quality reviews, and minimize errors as per NABH, JCI, CAHO, MoHFW & ICMR patient safety guidelines."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT18'] == true" ng-show="matchSearch('Retun to Emergency Department within 72 hours with similar presenting complaints')" title="Tracks ED revisits within 72 hours with similar complaints to assess care adequacy, detect missed diagnoses, and enhance patient safety as per NABH, JCI, CAHO, MoHFW & ICMR guidelines.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_ed" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Retun to Emergency Department within 72 hours with similar presenting complaints <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks ED revisits within 72 hours with similar complaints to assess care adequacy, detect missed diagnoses, and enhance patient safety as per NABH, JCI, CAHO, MoHFW & ICMR guidelines."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT19'] == true" ng-show="matchSearch('Retun to Emergency Department within 72 hours with similar presenting complaints- Data Verification')" title="Verifies ED revisit data within 24–72 hrs to ensure accurate documentation, monitor patient outcomes, and improve emergency care as per NABH, JCI, CAHO, MoHFW & ICMR standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_emr" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Retun to Emergency Department within 72 hours with similar presenting complaints- Data Verification <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Verifies ED revisit data within 24–72 hrs to ensure accurate documentation, monitor patient outcomes, and improve emergency care as per NABH, JCI, CAHO, MoHFW & ICMR standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT22'] == true" ng-show="matchSearch('Nurse-Patient ratio for Ward')" title="Monitors nurse-to-patient ratios in wards to ensure adequate staffing and safe patient care, aligned with NABH, JCI, CAHO & Indian hospital staffing standards.">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../nurse_patients_ratio_ward" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Nurse-Patient ratio for Ward <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Monitors nurse-to-patient ratios in wards to ensure adequate staffing and safe patient care, aligned with NABH, JCI, CAHO & Indian hospital staffing standards."></i></p>
																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="hasAuditList([13,23,24,25,26,27,28])">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size: 18px; font-weight: bold;">
													Infection Control & Prevention Audits
												</h4>
											</div>
										</div>
											<div class="row" ng-if="profilen['AUDIT13'] == true" ng-show="matchSearch('Hand Hygiene audit form')" title="Tracks staff hand hygiene practices & compliance by role/department to prevent HAIs, aligned with NABH, JCI, CAHO, WHO 5 Moments & CDC infection control guidelines.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../hand_hygiene" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Hand Hygiene audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks staff hand hygiene practices & compliance by role/department to prevent HAIs, aligned with NABH, JCI, CAHO, WHO 5 Moments & CDC infection control guidelines."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="profilen['AUDIT23'] == true" ng-show="matchSearch('VAP Prevention Checklist')" title="Ensures compliance with VAP prevention in ICU patients—covering hygiene, positioning, sedation & prophylaxis—as per NABH, JCI, CAHO & Indian ICU care standards to improve safety and outcomes.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../vap_prevention" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">VAP Prevention Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures compliance with VAP prevention in ICU patients—covering hygiene, positioning, sedation & prophylaxis—as per NABH, JCI, CAHO & Indian ICU care standards to improve safety and outcomes."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT24'] == true" ng-show="matchSearch('Catheter Insertion Checklist')" title="Ensures safe, sterile urinary catheter insertion with patient ID, consent, aseptic technique & post-care education as per NABH, JCI, CAHO & Indian hospital catheter care standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../catheter_insert" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Catheter Insertion Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures safe, sterile urinary catheter insertion with patient ID, consent, aseptic technique & post-care education as per NABH, JCI, CAHO & Indian hospital catheter care standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT25'] == true" ng-show="matchSearch('SSI Bundle Care Policy')" title="Ensures compliance with SSI bundle—pre, intra & post-op care, sterile technique, antibiotic prophylaxis & documentation—as per NABH, JCI, CAHO & Indian surgical infection prevention standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../ssi_bundle" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">SSI Bundle Care Policy <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures compliance with SSI bundle—pre, intra & post-op care, sterile technique, antibiotic prophylaxis & documentation—as per NABH, JCI, CAHO & Indian surgical infection prevention standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT26'] == true" ng-show="matchSearch('Urinary Catheter Maintenance Checklist')" title="Audits urinary catheter care—aseptic handling, drainage, hygiene & documentation—to prevent CAUTI, aligned with NABH, JCI, CAHO & Indian infection control standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../urinary_catheter" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Urinary Catheter Maintenance Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits urinary catheter care—aseptic handling, drainage, hygiene & documentation—to prevent CAUTI, aligned with NABH, JCI, CAHO & Indian infection control standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT27'] == true" ng-show="matchSearch('Central Line Insertion Checklist')" title="Audits central line insertion—aseptic technique, site prep, consent, hand hygiene & documentation—to prevent CLABSI, aligned with NABH, JCI, CAHO & Indian infection control standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../central_line_insert" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Central Line Insertion Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits central line insertion—aseptic technique, site prep, consent, hand hygiene & documentation—to prevent CLABSI, aligned with NABH, JCI, CAHO & Indian infection control standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT28'] == true" ng-show="matchSearch('Central Line Maintenance Checklist')" title="Audits central line maintenance—hand hygiene, aseptic access, dressing care, daily assessment & documentation—to prevent CLABSI, aligned with NABH, JCI, CAHO & Indian infection control standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../central_maintenance" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Central Line Maintenance Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits central line maintenance—hand hygiene, aseptic access, dressing care, daily assessment & documentation—to prevent CLABSI, aligned with NABH, JCI, CAHO & Indian infection control standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="hasAuditList([3,4,5,6,7,11,29,30,31,33])">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size: 18px; font-weight: bold;">
													Process / Operational Audits
												</h4>
											</div>
										</div>
											<div class="row" ng-if="profilen['AUDIT3'] == true" ng-show="matchSearch('OP consultation waiting time')" title="Tracks OPD waiting time from registration to consultation as per NABH, JCI, CAHO, & WHO guidelines to monitor patient flow, enhance service efficiency, and support patient-centered care.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../consultation_time" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">OP consultation waiting time <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks OPD waiting time from registration to consultation as per NABH, JCI, CAHO, & WHO guidelines to monitor patient flow, enhance service efficiency, and support patient-centered care."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="profilen['AUDIT4'] == true" ng-show="matchSearch('Laboratory waiting time')" title="Monitors lab waiting time from billing to sample receipt as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to improve efficiency, streamline services, and enhance patient satisfaction.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../lab_time" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Laboratory waiting time <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Monitors lab waiting time from billing to sample receipt as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to improve efficiency, streamline services, and enhance patient satisfaction."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT5'] == true" ng-show="matchSearch('X-Ray waiting time')" title="Tracks X-ray waiting time from billing to procedure completion as per NABH, WHO, AERB, ICMR, CDC, CAHO & JCI standards to improve workflow, ensure safety, and enhance patient care.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../xray_time" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">X-Ray waiting time <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks X-ray waiting time from billing to procedure completion as per NABH, WHO, AERB, ICMR, CDC, CAHO & JCI standards to improve workflow, ensure safety, and enhance patient care."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT6'] == true" ng-show="matchSearch('USG waiting time')" title="Tracks USG waiting time from billing to report delivery as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to enhance efficiency, streamline workflow, and improve patient satisfaction.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../usg_time" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">USG waiting time <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks USG waiting time from billing to report delivery as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to enhance efficiency, streamline workflow, and improve patient satisfaction."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>


											<div class="row" ng-if="profilen['AUDIT7'] == true" ng-show="matchSearch('CT Scan waiting time')" title="Tracks CT scan waiting time from billing to procedure completion as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to optimize workflow, ensure safety, and enhance patient satisfaction.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../ctscan_time" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">CT Scan waiting time <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Tracks CT scan waiting time from billing to procedure completion as per NABH, WHO, ICMR, CDC, CAHO & JCI standards to optimize workflow, ensure safety, and enhance patient satisfaction."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="profilen['AUDIT11'] == true" ng-show="matchSearch('Handover audit form')" title="Monitors safe, complete patient handover including ID, vitals, meds, risks & pending results as per NABH, JCI, CAHO & WHO communication standards (SBAR/IPASS) to ensure continuity of care.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../handover" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Handover audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Monitors safe, complete patient handover including ID, vitals, meds, risks & pending results as per NABH, JCI, CAHO & WHO communication standards (SBAR/IPASS) to ensure continuity of care."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="profilen['AUDIT29'] == true" ng-show="matchSearch('Patient Room Cleaning Checklist')" title="Audits patient room cleaning—trash, linens, surfaces, high-touch areas, floors & toilets—ensuring hygiene as per NABH, JCI, CAHO & Indian hospital infection control and housekeeping standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../room_cleaning" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Patient Room Cleaning Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits patient room cleaning—trash, linens, surfaces, high-touch areas, floors & toilets—ensuring hygiene as per NABH, JCI, CAHO & Indian hospital infection control and housekeeping standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT30'] == true" ng-show="matchSearch('Other Area Cleaning Checklist')" title="Audits cleaning of non-patient areas—trash, surfaces, floors, fixtures, toilets & equipment—ensuring hygiene as per NABH, JCI, CAHO & Indian hospital housekeeping and infection control standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../other_area_cleaning" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Other Area Cleaning Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits cleaning of non-patient areas—trash, surfaces, floors, fixtures, toilets & equipment—ensuring hygiene as per NABH, JCI, CAHO & Indian hospital housekeeping and infection control standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT31'] == true" ng-show="matchSearch('Toilet Cleaning Checklist')" title="Audits toilet cleaning—hygiene, disinfection, supplies, odor control & maintenance—ensuring compliance with NABH, JCI, CAHO & Indian hospital infection control and housekeeping protocols.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../toilet_cleaning" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Toilet Cleaning Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits toilet cleaning—hygiene, disinfection, supplies, odor control & maintenance—ensuring compliance with NABH, JCI, CAHO & Indian hospital infection control and housekeeping protocols."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row" ng-if="profilen['AUDIT33'] == true" ng-show="matchSearch('Canteen Audit Checklist')" title="Audits canteen hygiene, food handling, storage, transport, pest control & staff training per NABH, JCI  & Indian hospital food safety and infection control standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../canteen_audit" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Canteen Audit Checklist <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits canteen hygiene, food handling, storage, transport, pest control & staff training per NABH, JCI & Indian hospital food safety and infection control standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="hasAuditList([2,20,21,32,34])">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size: 18px; font-weight: bold;">
													Management / System & Safety Audits
												</h4>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT20'] == true" ng-show="matchSearch('Mock Drills audit form')" title="Audits code mock drills to assess emergency response, child safety, staff readiness & debriefing, aligned with NABH, JCI, CAHO, MoHFW & hospital safety protocols for preparedness.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../mock_drill_audit" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Mock Drills audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits code mock drills to assess emergency response, child safety, staff readiness & debriefing, aligned with NABH, JCI, CAHO, MoHFW & hospital safety protocols for preparedness."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

										<div class="row" ng-if="profilen['AUDIT32'] == true" ng-show="matchSearch('Code - Originals audit form')" title="Audits Code emergency response, CPR quality, patient transport & CCU readiness to ensure staff efficiency and patient safety, aligned with NABH, JCI, CAHO & hospital emergency protocols.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../code_originals" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Code - Originals audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits Code emergency response, CPR quality, patient transport & CCU readiness to ensure staff efficiency and patient safety, aligned with NABH, JCI, CAHO & hospital emergency protocols."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>

											



											
											<div class="row" ng-if="profilen['AUDIT21'] == true" ng-show="matchSearch('Facility safety inspection checklist & audit form')" title="Audits hospital facility safety—stairways, corridors, lighting, electricals, fire safety, cleanliness & signage—to prevent accidents and ensure compliance with NABH, JCI, CAHO & safety standards.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../safety_inspection" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Facility safety inspection checklist & audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Audits hospital facility safety—stairways, corridors, lighting, electricals, fire safety, cleanliness & signage—to prevent accidents and ensure compliance with NABH, JCI, CAHO & safety standards."></i></p>
																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row" ng-if="profilen['AUDIT2'] == true" ng-show="matchSearch('Radiology Safety Audit form')" title="Ensures radiology staff comply with PPE, ALARA, patient ID & hygiene protocols as per NABH, WHO, CAHO & CDC standards to enhance safety and minimize radiation risks.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../ppe_audit" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Radiology Safety Audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures radiology staff comply with PPE, ALARA, patient ID & hygiene protocols as per NABH, WHO, CAHO & CDC standards to enhance safety and minimize radiation risks."></i></p>

																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>


											


											<div class="row" ng-if="profilen['AUDIT34'] == true" ng-show="matchSearch('Laboratory Safety Audit form')" title="Ensures lab staff follow PPE, hygiene, biomedical waste, and biosafety protocols per NABH, WHO & JCI standards to ensure safety, compliance, and infection control.">
												<div class="col-12">
													<div class="card">
														<div class="row">
															<div class="col-12">
																<a href="../lab_safety_audit" class="card" style="text-decoration: none;">
																	<div class="card product-card" style="margin-bottom: 10px;">
																		<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																			<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																			<p class="text ">Laboratory Safety Audit form <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:6px;color:#6c757d;" title="Ensures lab staff follow PPE, hygiene, biomedical waste, and biosafety protocols per NABH, WHO & JCI standards to ensure safety, compliance, and infection control."></i></p>

																		</div>
																	</div>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>











											<br><br>


										</div>



								</fieldset>





							</form>
							<!-- form end  -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- body section end  -->


<!-- script code start  -->
<script>
	setTimeout(function() {

		$('#body').show();

	}, 2000);
</script>

<!-- script code end  -->



</html>