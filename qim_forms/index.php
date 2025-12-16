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
										<h3 class="sectiondivision" style="font-weight:bold;" ng-show="feedback.section == 'GRIEVANCE'">{{lang.pagetitle}}</h3>

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
											<select ng-model="selectedMonth" ng-change="saveSelection()" ng-options="month for month in months" style="font-size: 16px; margin-left: 10px; border: 1px solid grey; background: white; padding: 2px 5px; border-radius: 4px; font-weight: bold;">
											</select>
											<select ng-model="selectedYear" ng-change="saveSelection()" ng-options="year for year in years" style="font-size: 16px; margin-left: 10px; border: 1px solid grey; background: white; padding: 2px 5px; border-radius: 4px; font-weight: bold;">
											</select>
										</b>
									</h4>

									<div class="" style="width: 94%; margin: 0px auto;">
									    <div class="row">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size: 18px; font-weight: bold;">Mandatory Indicators</h4>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI1'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">

															<div class="card product-card" style="margin-bottom: 10px;">
																<a href="../1PSQ3a" class="card" ng-click="saveSelection()" style="text-decoration: none; background-color: #F5F5F5; color: black;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>

																		<p class="text ">{{lang.initial_assesment}}</p>

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
										<div class="row" ng-if="profilen['KPI2'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../2PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.report_error}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI3'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../3PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.safety_precautions}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI4'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../4PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.medication_errors}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI5'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../5PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.medication_charts}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI6'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../6PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.adverse_drug}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI7'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../7PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.unplanned_return}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI8'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../8PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.wrong_surgery}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI9'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../9PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.transfusion_reactions}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI10'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../10PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.mortality_ratio}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI11'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../11PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.theemergency}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI12'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../12PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.ulcers}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI13'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../13PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.urinary}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI14'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../14PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.pneumonia}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI15'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../15PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.blood_infection}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI16'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../16PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.site_infection}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI17'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../17PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.hand_hygiene}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI18'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../18PSQ3b" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.prophylactic}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI19'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../19PSQ3c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.re_scheduling}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI20'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../20PSQ3c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.blood_components}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI21'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../21PSQ3c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.nurse_patient}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI21a'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../21aPSQ3c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.nurse_patient_w}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI22'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../22PSQ3c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.consultation}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI23a'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../23aPSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.diagnostics_l}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI23b'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../23bPSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.diagnostics_x}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI23c'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../23cPSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.diagnostics_u}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI23d'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../23dPSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.diagnostics_c}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI24'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../24PSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.discharge}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI25'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../25PSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.medical_records}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI26'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../26PSQ4c" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.emergency_medications}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI27'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../27PSQ4d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.mock_drills}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI28'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../28PSQ4d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.patient_fall}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI29'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../29PSQ4d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.near_misses}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI30'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../30PSQ3d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.stick_injuries}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI31'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../31PSQ3d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.shift_change}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row" ng-if="profilen['KPI32'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../32PSQ3d" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">{{lang.prescription}}</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										
										
										<div class="row">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size:18px; font-weight: bold;">Clinical Indicators</h4>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI34'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../33PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of Beta-blocker prescription with a diagnosis of CHF with reduced EF</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI35'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../34PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of patients with myocardial infarction for whom door to balloon time of 90 minutes is achieved</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI36'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../35PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of Hospitalized patients with hypoglycemia who achieved targeted blood glucose level</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI37'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../36PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Spontaneous Perineal Tear Rate</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI38'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../37PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Postoperative Endophthalmitis rate</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI39'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../38PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of patients undergoing colonoscopy who are sedated</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI40'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../39PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Bile Duct injury rate requiring operative intervention during Laparoscopic cholecystectomy</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI41'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../40PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of POCT results which led to a clinical intervention</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI42'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../41PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Functional gain following rehabilitation</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI43'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../42PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of sepsis patients who receive care as per the Hour-1 sepsis bundle</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI44'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../43PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of COPD patients receiving COPD Action plan at the time of discharge</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI45'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../44PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of stroke patients in whom the Door-to-Needle Time (DTN) of 60 minutes is achieved</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI46'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../45PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of bronchiolitis patients treated inappropriately</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI47'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../46PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of oncology patients who had treatment initiated following Multidisciplinary meeting (Tumour board)</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI48'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../47PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of adverse reaction to radiopharmaceutical</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI49'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../48PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of Intravenous Contrast Media Extravasation</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI50'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../49PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Time taken for triage</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row" ng-if="profilen['KPI51'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../50PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Percentage of patients undergoing dialysis who are able to achieve target hemoglobin levels</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>

										
										
										<div class="row">
											<div class="col-12">
												<h4 style="margin-top: 20px; font-size:18px; font-weight: bold;">Additional Indicators</h4>
											</div>
										</div>

										<div class="row" ng-if="profilen['KPI33'] == true">
											<div class="col-12">
												<div class="card">
													<div class="row">
														<div class="col-12">
															<a href="../PSQ3a" class="card" style="text-decoration: none;">
																<div class="card product-card" style="margin-bottom: 10px;">
																	<div class="card-body" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);">
																		<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ">PSQ3a - Readmission to ICU with 48 hours after being discharged from ICU</p>

																	</div>
																</div>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>


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