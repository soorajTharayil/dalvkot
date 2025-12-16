<!DOCTYPE html>
<html lang="en">
<!-- head part start -->
<!-- Interim feedback -->

<head>
	<title>Efeedor Feedback System</title>
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
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
		<!-- logo of efeedor -->
		<a class="navbar-brand" href="#"><img style="    height: 36px;"></a>
		<!-- dropdown for three language start -->
		<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal" style="margin: 4px; float:right;">
			{{type2}}
			<i class="fa fa-language" aria-hidden="true"></i>
		</button>
		<!-- dropdown for three language end -->
	</nav>
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

									<div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('lang2')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -133px; color: #4b4c4d;">
												ಕನ್ನಡ
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												ಕ
											</span>
										</div>
									</div>
									<br>

									<div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('lang3')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -100px; color: #4b4c4d;">
												മലയാളം
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												അ
											</span>
										</div>
									</div>
									<br>

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
	<div class="container-fluid" id="grad1">
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






									<h4 style="font-size: 18px; margin-bottom: 22px; padding-top: 10px;"><b>{{lang.chooseCategory}}</b></h4>
									<div class="" style="width: 94%; margin: 0px auto;">
										<div class="row" ng-if="profilen['AUDIT1'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">

															<div class="card product-card" style="margin-bottom: 10px;">
																<a href="../mrd_audit" class="card" style="text-decoration: none; background-color: #F5F5F5; color: black;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>

																		<p class="text ">MRD Audit form</p>

																		<!-- First Rectangle Card -->


																		<!-- Second Rectangle Card -->
																		<!-- <div class="rectangle-card" style="background-color: #F5F5F5; padding: 10px; margin-top: 10px;  border: 3px solid #e0e0e0 ; border-radius: 5px;">
																		<div>
																			<a href="../1PSQ3a" class="card" style="text-decoration: none; background-color: #F5F5F5; color: black;">
																			Calculate KPI
																				</a>
																			
																		</div>
																	</div> -->
																	</div>
															</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT2'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../ppe_audit" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Safety Adherence Audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT3'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../consultation_time" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">OP consultation waiting time</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT4'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../lab_time" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Laboratory waiting time</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT5'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../xray_time" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">X-Ray waiting time</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT6'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../usg_time" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">USG waiting time</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT7'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../ctscan_time" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">CT Scan waiting time</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT8'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../surgical_safety" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Surgical Safety audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT9'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../medicine_dispense" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Medicine dispensing audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT10'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../medication_administration" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Medication administration audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT11'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../handover" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Handover audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT12'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../prescriptions" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Prescriptions audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT13'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../hand_hygiene" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Hand Hygiene audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT14'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../tat_blood" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Turn around time for issue of blood and blood components</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT15'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../nurse_patients_ratio" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Nurse-Patient ratio for ICU</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT16'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_i" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Return to ICU within 48 hours after being discharged from ICU</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>


										<div class="row" ng-if="profilen['AUDIT17'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_icu" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Return to ICU within 48 hours after being discharged from ICU- Data Verification</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT18'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_ed" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Retun to Emergency Department within 72 hours with similar presenting complaints</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT19'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../return_to_emr" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Retun to Emergency Department within 72 hours with similar presenting complaints- Data Verification</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT20'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../mock_drill_audit" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Mock Drills audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT32'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../code_originals" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Code - Originals audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT21'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../safety_inspection" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Facility safety inspection checklist & audit form</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['AUDIT22'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../nurse_patients_ratio_ward" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Nurse-Patient ratio for Ward</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										
										<div class="row" ng-if="profilen['AUDIT23'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../vap_prevention" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">VAP Prevention Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT24'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../catheter_insert" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Catheter Insertion Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT25'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../ssi_bundle" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">SSI Bundle Care Policy</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT26'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../urinary_catheter" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Urinary Catheter Maintenance Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT27'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../central_line_insert" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Central Line Insertion Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT28'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../central_maintenance" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Central Line Maintenance Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT29'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../room_cleaning" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Patient Room Cleaning Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT30'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../other_area_cleaning" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Other Area Cleaning Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT31'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../toilet_cleaning" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Toilet Cleaning Checklist</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['AUDIT33'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../canteen_audit" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">Canteen Audit Checklist</p>

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