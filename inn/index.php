<!DOCTYPE html>
<html lang="en">
<!-- head part start -->
<!-- Interim feedback -->

<head>
	<title>Efeedor Healthcare Experience Management Platform</title>
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

	<script src="app_incident.js?<?php echo time(); ?>"></script>
	<style>
		/* Global placeholder styling */
		::placeholder {
			opacity: 0.3;
			/* reduced visibility */
			font-size: 14px;
			/* default size */
			color: #6c757d;
			/* default gray */
		}

		/* Vendor prefixes for compatibility */
		::-webkit-input-placeholder {
			opacity: 0.3;
			font-size: 14px;
			color: #6c757d;
		}

		:-ms-input-placeholder {
			opacity: 0.3;
			font-size: 14px;
			color: #6c757d;
		}

		::-ms-input-placeholder {
			opacity: 0.3;
			font-size: 14px;
			color: #6c757d;
		}

		.priority-dropdown {
			width: 95%;
			border: 1px solid #ccc;
			border-radius: 6px;
			padding: 8px;
			margin-left: -2px;
			margin-bottom: 15px;
			background: #fff;
			cursor: pointer;
		}

		.priority-selected {
			display: flex;
			align-items: center;
			gap: 8px;
		}

		.priority-menu {
			position: absolute;
			top: 100%;
			left: 0;
			right: 0;
			background: #fff;
			border: 1px solid #ccc;
			border-radius: 6px;
			margin-top: 2px;
			z-index: 1000;
		}

		.priority-item {
			display: flex;
			align-items: center;
			padding: 6px 10px;
			cursor: pointer;
		}

		.priority-item:hover {
			background: #f5f5f5;
		}

		.priority-box {
			display: inline-block;
			/* <-- important */
			width: 14px;
			height: 14px;
			border-radius: 3px;
			/* margin-right: 7px; */
			vertical-align: middle;
		}

		.p1 {
			background: #ff4d4d;
			margin-right: 7px;
		}

		/* Critical */
		.p2 {
			background: #ff9800;
			margin-right: 7px;
		}

		/* High */
		.p3 {
			background: #fbc02d;
			margin-right: 7px;
		}

		/* Medium */
		.p4 {
			background-color: #19ca6eff;
			margin-right: 7px;
		}

		.priority-box.p1 {
			background-color: #e74c3c;
		}

		/* Red */
		.priority-box.p2 {
			background-color: #e67e22;
		}

		/* Orange */
		.priority-box.p3 {
			background-color: #f1c40f;
		}

		/* Yellow */
		.priority-box.p4 {
			background-color: #19ca6eff;
		}

		/* Green */
		/* Low */
		.risk-box {
			display: inline-block;
			width: 14px;
			height: 14px;
			border-radius: 3px;
			margin-right: 5px;
			vertical-align: middle;
		}

		.p1 {
			background: #e74c3c;
		}

		/* High - Red */
		.p2 {
			background: #f1c40f;
		}

		/* Medium - Yellow */
		.p3 {
			background: #19ca6eff;
		}

		/* Low - Green */

		/* Low */
	</style>

</head>
<!-- head part end -->


<!-- body part start -->

<body ng-app="ehandorApp" ng-controller="PatientFeedbackCtrl" style="display:none;" id="body">
	<!-- top navbar start -->
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
		<!-- logo of efeedor -->
		<a class="navbar-brand" href="#"><img style="    height: 36px;"></a>
		<!-- dropdown for three language start -->
		<button type="button" class="btn btn-success" style="margin: -30px;" ng-click="raiseAnonymousIncident()"
			ng-show="AnonymousIncident_show == true && step1 == true ">
			<i class="fa fa-user-times" aria-hidden="true" style="margin-right:5px;"></i>
			Report Anonymous Incident

		</button>
		<!-- dropdown for three language start -->
		<!-- <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal"
			style="margin: 4px; float:right;">
			{{type2}}
			<i class="fa fa-language" aria-hidden="true"></i>
		</button> -->
		<!-- dropdown for three language end -->
	</nav>
	<!-- top navbar end -->
	<!-- Create a modal for language selection -->
	<div class="modal fade" id="languageModal" tabindex="-1" role="dialog" aria-labelledby="languageModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!-- <div class="modal-header">
					<h5 class="modal-title" id="languageModalLabel">Select Language</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div> -->
				<div class="modal-body">
					<!-- Place your language selection options here -->



					<div class=" col-lg-12 col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
						<div class=" px-0 pt-2 pb-0">
							<div class="left"
								style="margin-left: 68vw; max-width: 100%; margin-top: 5px; margin-right: -10px;">
								<a href="../">
									<img src="./user.png" style="max-width: 100%; height: 45px;" alt="">
								</a>
							</div>
							<div style="text-align: left; align-items: left; margin-left: 25px; margin-right: 25px;">
							</div>
							<div class="box box-primary profilepage">
								<div class="box-body box-profile" style="display: inline-block;">

									<!-- <div class="card" style=" border: 2px solid #000;">
										<div class="" ng-click="language('english')"
											style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -133px; color: #4b4c4d;">
												English
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												A
											</span>
										</div>
									</div>
									<br> -->

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
										<div class="" ng-click="language('lang3')"
											style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
											<span style="margin-left: -100px; color: #4b4c4d;">
												മലയാളം
											</span><br>
											<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
												അ
											</span>
										</div>
									</div>
									<br> -->

									<!--<div class="card" style=" border: 2px solid #000;">-->
									<!--	<div class="" ng-click="language('lang3')"-->
									<!--		style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">-->
									<!--		<span style="margin-left: -100px; color: #4b4c4d;">-->
									<!--			தமிழ்-->
									<!--		</span><br>-->
									<!--		<span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">-->
									<!--			த-->
									<!--		</span>-->
									<!--	</div>-->
									<!--</div>-->
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
				<div ng-show="toplogo == true">
					<img ng-src="{{setting_data.logo}}" style="    height: 50px;">
					<br>
				</div>
				<div class="card px-0 pt-2 pb-0 mt-2 mb-3">
					<div class="row">
						<div class="col-md-12 mx-0">
							<!-- form start -->

							<fieldset ng-show="step0 == true">
								<div class="main-container">
									<div class="form-container" style="margin-top: 15px; margin-bottom:30px;">
										<div class="form-body" style="align-items:center;">
											<form class="the-form">
												<div style="text-align: center;">
													<a class="navbar-brand" href="#">
														<img src="{{setting_data.logo}}"
															style="height: 100px; width:100%">
													</a>
												</div>
												<br>
												<div style="color: red; text-align: center;" class="alert-error"
													ng-show="loginerror.length > 3">{{loginerror}}</div>

												<input type="text" name="email" id="email" class="input-field"
													placeholder="Enter email/ mobile no." ng-model="loginvar.userid"
													style="padding: 12px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px; margin-bottom: 15px; width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">

												<div class="password-container">
													<input type="password" name="password" id="password"
														class="input-field" placeholder="Enter password"
														ng-model="loginvar.password"
														style="padding: 12px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px; margin-bottom: 15px; width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
													<span style="color: rgba(0, 0, 0, 0.8);" class="password-toggle"
														onclick="togglePassword()">
														<i class="fa fa-eye-slash" aria-hidden="true"></i>
													</span>
												</div>

												<div
													style="display: flex; justify-content: center; align-items: center;">
													<input ng-click="login()" type="submit" value="LOGIN"
														style="width: 100px; height: 45px; background: #34a853; border: 1px solid rgba(0, 0, 0, 0.1); padding: 10x; font-size: 16px; border-radius: 50px; cursor: pointer; margin-top: 20px; color: white;">
												</div>

												<p style="margin-top: 12px;">OR</p>


											</form>
										</div>
										<br><br>
										<div class="form-footer"
											style="display: flex; justify-content: center; align-items: center;">
											<img src="./power.png" style="max-width: 100%; height: 45px;" alt="">
										</div>
									</div>
								</div>
							</fieldset>

							<form id="msform">


								<!-- PATIENT INFORMATION page start -->
								<fieldset ng-show="step1 == true">
									<h4><strong>{{lang.employee_info}}</strong></h4>
									<!--<p>Fill all form field to go to next step</p>-->
									<br />
									<div class="form-card">

										<!-- Form start -->
										<div class="row">

											<!-- Patient Name -->
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">
														{{lang.employeename}} <sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control"
															placeholder="{{lang.employee_name_placeholder}}"
															oninput="restrictToAlphabets(event)" maxlength="25"
															name="name" type="text" id="emailid"
															ng-model="feedback.name"
															onblur="this.value = this.value.toUpperCase();"
															autocomplete="off" />
														<label for="emailid"></label>
													</span>
												</div>
											</div>
											<!-- Patient UHID -->
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">{{lang.employeeid}}
														<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control"
															placeholder="{{lang.enter_placeholder}}" type="text"
															maxlength="10" id="contactnumber" ng-required="true"
															ng-model="feedback.patientid" autocomplete="off"
															placeholder="Numerical digits only" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>
											<!-- Select Floor/ Ward -->


											<!-- <div class="col-xs-12 col-sm-12 col-md-12	">
												<div class="form-group">
													<span class="" style="font-size:16px;">{{lang.role}}<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.role">
															<option value="" disabled>{{lang.role}}</option>
															<option ng-repeat="x in wardlist.role" ng-show="x.title !== 'ALL'" value="{{x.title}}" required>{{x.title}}</option>
														</select>
													</span>
												</div>
											</div> -->
											<p></p>
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">{{lang.mobileno}}
														<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control" type="tel" maxlength="10"
															oninput="restrictToNumerals(event)" id="contactnumber"
															ng-model="feedback.contactnumber" autocomplete="off"
															placeholder="{{lang.mobile_placeholder}}" step="1" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>
											<p></p>
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon"
														style="    font-size: 16px;">{{lang.email}}</span>
													<span class="has-float-label">
														<input class="form-control" type="email" id="contactnumber"
															ng-model="feedback.email" autocomplete="off"
															placeholder="{{lang.pa_email}}" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<!-- <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;" ng-click="activeStep('step0')" value="{{lang.previous}}" /> -->

									<input type="button" name="next" ng-click="next1()"
										style="background: #4285F4 ; font-size:small;" class="next action-button"
										value="{{lang.next}}" />

								</fieldset>
								<!-- PATIENT INFORMATION page end -->


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
											{{feedback.name}},
										</p>
										<br>
										<p style="margin:0px;font-size: 16px;">{{lang.gustmessageint}}</p>
									</div>
									<br />

									<div class="text-left" style="width: 94%; margin: 0px auto;">
										<div class="search-container">

											<input type="text" ng-model="searchTextmain" ng-change="searchChanged()" placeholder="{{lang.mainSearch}}">
											<i class="fa fa-search search-icon"></i>

											<div class="dropdown-results" ng-if="searchTextmain && searchTextmain.length > 1">

												<li ng-repeat="p in allQuestions | questionSearch:searchTextmain | questionSort:searchTextmain"
													ng-click="selectQuestionCategory1(p)"
													ng-show="p.question != 'Other'">

													<label class="container">
														<span ng-show="typel == 'english'">{{p.question}}</span>
														<span ng-show="typel == 'lang2'">{{p.questionk}}</span>
														<span ng-show="typel == 'lang3'">{{p.questionm}}</span>
													</label>

												</li>

											</div>

											<div class="dropdown-results" ng-if="searchTextmain != TRUE && searchTextmain.length > 1">
												<div ng-click="customTicket()">
													<label class="container">
														Submit your concern as "{{searchTextmain}}"
													</label>
												</div>

											</div>

										</div>
									</div>



									<br>
									<h4 style="font-size: 18px; margin-bottom: 22px; padding-top: 10px;">
										<b>{{lang.chooseCategory}}</b>
									</h4>
									<div class="" style="width: 94%; margin: 0px auto;">
										<div class="" style="width: 94%; margin: 0px auto;">
											<!-- Clinical Incidents Section -->
											<div class="row">
												<!-- <h4 class="col-12" style="font-size :20px;">Clinical Incidents</h4> -->
												<div ng-repeat="q in questioset" class="col-6">
													<div class="card" ng-click="selectQuestion(q)">
														<div class="row">
															<div class="col-12">
																<div class="card product-card"
																	style="margin-bottom: 10px;">
																	<div class="card-body">
																		<p class="text" ng-bind-html="q.icon"
																			style="color: #5c5959;font-size: 36px;"></p>
																		<p class="text ellipsis"
																			ng-show="typel == 'english'">{{q.category}}
																		</p>
																		<p class="text ellipsis"
																			ng-show="typel == 'lang2'">{{q.categoryk}}
																		</p>
																		<p class="text ellipsis"
																			ng-show="typel == 'lang3'">{{q.categorym}}
																		</p>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<br>
											<!-- Non-Clinical Incidents Section -->

										</div>


										<br><br>

										<div>
											<input type="button" name="previous" style="font-size:small;"
												class="previous action-button-previous" ng-click="refresh_back()"
												value="{{lang.previous}}" />
										</div>
									</div>



								</fieldset>



								<fieldset ng-show="step3 == true">
									<div class="text-left">
										<h3 class="sectiondivision" style="font-weight:bold;">{{lang.pagetitle}}</h3>


										<!-- <span>{{searchTextmain}}</span> -->
										<br />


										<!-- <div class="text-left" style="width: 94%; margin: 0px auto;" ng-show="feedback.parameter.length != 0"> -->

										<div class="text-left" style="width: 94%; margin: 0px auto;"
											ng-show="selectedQuestionObject.question.length != 0">

											<input type="text" placeholder="Search..." ng-click="filterFunction()"
												ng-model="searchText" oninput="restrictToAlphabets(event)">
											<i class="fa fa-search search-icon"></i>
											<h4 style="font-size: 18px; margin-bottom: 22px;">
												<br><b>{{lang.telluswrong}} {{category}}</b>
											</h4>

											<div
												ng-repeat="p in selectedQuestionObject.question | filter:filterFunction">
												<!-- <div ng-repeat="p in feedback.parameter.question"> -->
												<label class="container">
													<!-- your label content here -->
													<span ng-show="typel == 'english'">{{p.question}}</span>
													<span ng-show="typel == 'lang2'">{{p.questionk}}</span>
													<span ng-show="typel == 'lang3'">{{p.questionm}}</span>
													<input type="checkbox"
														ng-click="selectQuestionCategory(p,selectedQuestionObject)"
														ng-model="p.valuetext" ng-show="p.showQuestion">
													<span class="checkmark" style="border-radius: 50%;"></span>
												</label>
											</div>
											<!-- rest of your code -->
											<!-- <div class="form-group" ng-show="feedback.parameter.length != 0">
												<label for="comment"><b>{{lang.commentt}}:</b></label>
												<textarea style="border: 1px solid #ccc;" class="form-control" ng-model="feedback.other" rows="5" id="comment"></textarea>
											</div> -->
											<br />
											<br />
											<input type="button" name="previous" style="font-size:small;"
												class="previous action-button-previous" ng-click="activeStep('step2')"
												value="{{lang.previous}}" />
										</div>
										<!-- submit button  -->
										<!-- <div ng-show="feedback.parameter.length != 0">

											<input type="button" name="make_payment" style="background: #4285F4 ; font-size:small;" class="next action-button" ng-click="savefeedback()" ng-show="loader == false" value="{{lang.submit}}" />
										</div> -->
										<img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif"
											ng-show="loader == true">
									</div>
								</fieldset>

								<!-- card click -->
								<fieldset ng-show="step4 == true">
									<div class="form-card" style="margin-top: 10px;">
										<h3 class="sectiondivision" style="font-weight:bold;">{{lang.pagetitle}}</h3>

										<div class="form-group" style="margin-left: 13px; margin-right:13px;"
											ng-show="submit_as_concern == true">

											<label for="comment"><b
													style="font-size: 18px;margin-bottom:10px;">{{lang.u_select}}
												</b><br>
												<b> •{{lang.incident_category}}</b>{{selectedParameterObject.title}}
												<br>
												<b> •{{lang.incident_parameter}}</b>
												{{selectedParameterObject.question}}</label>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:5px;">
											<div class="form-group transparent-placeholder"
												style="display: flex; flex-direction: column; position: relative;">

												<label for="comment"
													style="margin-left: -6px;"><b>{{lang.incident_occurred}}</b><sup
														style="color:red">*</sup><br></label>


												<div
													style="display: flex; flex-direction: row; align-items: center; width: 100%; margin-left: -6px; position: relative;">
													<input class="form-control" ng-model="feedback.incident_occured_in"
														type="datetime-local" id="incident_occured_in"
														ng-required="true" autocomplete="off"
														onclick="this.showPicker && this.showPicker()"
														onfocus="this.showPicker && this.showPicker()" style="padding-top: 2px; padding-left: 6px; border: 1px solid
													#ced4da; margin-top:9px; width: calc(100% - 20px);" />

													<!-- Calendar icons (optional decoration) -->
													<!-- Calendar icons (optional decoration) -->
													<span class="calendar-icon-container"
														style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">
														<svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg"
															width="16" height="16" fill="currentColor"
															viewBox="0 0 16 16">
															<path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2
					 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 
					 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 5v9a1 1 0 
					 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
														</svg>
													</span>
													<span
														style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
														<i class="fa fa-calendar-alt"></i>
													</span>
												</div>
											</div>
										</div>

										<br />
										<div class="form-group" style="margin-left: 13px; margin-right:13px;">
											<label for="comment"><b style="font-size: 18px;">Location of
													Incident</label><br><br>
											<label for="comment">{{lang.floor}}</label><sup
												style="color:red">*</sup><br></label>

											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<div class="form-group"
														style="margin-left: 13px; margin-right:13px;">
														<span class="has-float-label">
															<select class="form-control" ng-model="feedback.ward"
																ng-change="change_ward()" id="ward"
																style=" width: 100%; margin-left: -16px; ">
																<option value="" disabled>{{lang.select_floor}}</option>
																<option ng-repeat="x in wardlist.ward"
																	ng-show="x.title !== 'ALL' " value="{{x.title}}"
																	required>
																	{{x.title}}
																</option>

															</select>
														</span>
													</div>
												</div>
											</div>
										</div>
										<br />
										<div class="form-group"
											style="margin-left: 13px; margin-right:13px;margin-top:-15px;">
											<label for="comment">{{lang.location}}<sup
													style="color:red">*</sup><br></label>

											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<div class="form-group"
														style="margin-left: 13px; margin-right:13px;">
														<span class="has-float-label">
															<select class="form-control" ng-model="feedback.bedno"
																id="bedno" style=" width: 100%;  margin-left: -16px; ">
																<option value="" disabled>{{lang.select_location}}
																</option>
																<option ng-repeat="x in bed_no" value="{{x}}" required>
																	{{x}}
																</option>
															</select>
														</span>
													</div>
												</div>
											</div>
										</div>


										<div class="form-group" style="margin-left: 13px; margin-right:13px;">
											<!-- <h4 style="font-size: 18px; margin-bottom: 22px;">
												<b>{{lang.add_details_to_incident}}</b>
											</h4> -->
											<label for="comment">{{lang.describe_incident}}<sup
													style="color:red">*</sup><br></label>
											<textarea placeholder="{{lang.describe_incident_placeholder}}"
												style="border: 2px solid #ccc;margin-top:7px" class="form-control"
												ng-model="feedback.other" rows="5" id="comment"></textarea>
										</div>
										<div class="form-group" style="margin-left: 13px; margin-right:13px;">

											<label for="comment"></label>{{lang.what_went_wrong}}<br></label>
											<textarea placeholder="{{lang.what_went_wrong_pla}}"
												style="border: 2px solid #ccc;margin-top:7px" class="form-control"
												ng-model="feedback.what_went_wrong" rows="5" id="comment"></textarea>
										</div>
										<div class="form-group" style="margin-left: 13px; margin-right:13px;">

											<label for="comment">{{lang.action_taken}}<br></label>
											<textarea placeholder="{{lang.action_taken_pla}}"
												style="border: 2px solid #ccc;margin-top:7px" class="form-control"
												ng-model="feedback.action_taken" rows="5" id="comment"></textarea>
										</div>
										<br>
										<div class="form-group" style="margin-left: 13px; margin-right:13px;">

											<label for="comment">{{lang.select_risk_matrix}}<br></label>

											<div class="risk-matrix" style="margin-top:10px;">
												<table class="risk-table">
													<!-- Axis headers -->
													<tr>
														<th rowspan="5"
															style="writing-mode: vertical-rl; transform: rotate(180deg);border:none;">
															IMPACT
														</th>
													</tr>


													<!-- High Impact row -->
													<tr>
														<th style="border:none;">High</th>
														<td ng-click="setRisk('High','Low','Medium')"
															ng-class="{'selected-cell': isSelected('High','Low')}"
															class="risk-medium">Medium</td>
														<td ng-click="setRisk('High','Medium','High')"
															ng-class="{'selected-cell': isSelected('High','Medium')}"
															class="risk-high">High</td>
														<td ng-click="setRisk('High','High','High')"
															ng-class="{'selected-cell': isSelected('High','High')}"
															class="risk-high">High</td>

													</tr>

													<!-- Medium Impact row -->
													<tr>
														<th style="border:none;">Medium</th>
														<td ng-click="setRisk('Medium','Low','Low')"
															ng-class="{'selected-cell': isSelected('Medium','Low')}"
															class="risk-low">Low</td>
														<td ng-click="setRisk('Medium','Medium','Medium')"
															ng-class="{'selected-cell': isSelected('Medium','Medium')}"
															class="risk-medium">Medium</td>
														<td ng-click="setRisk('Medium','High','High')"
															ng-class="{'selected-cell': isSelected('Medium','High')}"
															class="risk-high">High</td>

													</tr>

													<!-- Low Impact row -->
													<tr>
														<th style="border:none;">Low</th>
														<td ng-click="setRisk('Low','Low','Low')"
															ng-class="{'selected-cell': isSelected('Low','Low')}"
															class="risk-low">Low</td>
														<td ng-click="setRisk('Low','Medium','Low')"
															ng-class="{'selected-cell': isSelected('Low','Medium')}"
															class="risk-low">Low</td>
														<td ng-click="setRisk('Low','High','Medium')"
															ng-class="{'selected-cell': isSelected('Low','High')}"
															class="risk-medium">Medium</td>

													</tr>
													<tr>
														<th style="border:none;"></th>
														<th style="border:none;">Low</th>
														<th style="border:none;">Medium</th>
														<th style="border:none;">High</th>
													</tr>
													<tr>
														<th style="border:none;"></th>
														<th style="border:none;"> </th>
														<th style="border:none;" colspan="3">LIKELIHOOD</th>

													</tr>

												</table>

												<p style="margin-top:15px;">
													Assigned Risk :

													<!-- Risk Level with color -->
													<span class="risk-box" ng-class="{'p1': feedback.risk_matrix.level=='High',
										'p2': feedback.risk_matrix.level=='Medium',
										'p3': feedback.risk_matrix.level=='Low'}"></span>
													<strong>{{feedback.risk_matrix.level}}</strong>

													(
													{{feedback.risk_matrix.impact}} Impact ×
													{{feedback.risk_matrix.likelihood}} Likelihood )
													</span>
												</p>
											</div>
										</div>
										<br>
										<!-- Priority Dropdown -->
										<div class="form-group"
											style="margin-left: 13px; margin-right:13px; margin-top:-15px;">
											<label for="comment">{{lang.priority}}<br></label>

											<div class="dropdown" ng-init="showMenu=false">
												<!-- Selected item (closed state) -->
												<div class="priority-dropdown" ng-click="showMenu=!showMenu">
													<span ng-if="!feedback.priority">{{lang.select_priority}}</span>
													<span ng-if="feedback.priority" class="priority-selected">
														<span
															class="priority-box {{priorityCode(feedback.priority)}}"></span>
														{{feedback.priority}}
													</span>
												</div>

												<!-- Dropdown options -->
												<div class="dropdown-menu show" ng-if="showMenu" style="width:100%;">
													<div class="priority-item" ng-click="setPriority('')">
														<span class=""></span> Select Action Priority
													</div>
													<div class="priority-item" ng-click="setPriority('P1-Critical')">
														<span class="priority-box p1"></span> P1 - Critical
													</div>
													<div class="priority-item" ng-click="setPriority('P2-High')">
														<span class="priority-box p2"></span> P2 - High
													</div>
													<div class="priority-item" ng-click="setPriority('P3-Medium')">
														<span class="priority-box p3"></span> P3 - Medium
													</div>
													<div class="priority-item" ng-click="setPriority('P4-Low')">
														<span class="priority-box p4"></span> P4 - Low
													</div>
												</div>
											</div>
										</div>
										<br>

										<div class="form-group" style="margin-left: 13px; margin-right:13px;">
											<label for="comment">{{lang.incident_Type}}<br></label>

											<div class="dropdown" ng-init="showIncidentMenu=false">
												<!-- Selected item -->
												<div class="priority-dropdown"
													ng-click="showIncidentMenu=!showIncidentMenu">
													<span
														ng-if="!feedback.incident_type">{{lang.select_incident_Type}}</span>
													<span ng-if="feedback.incident_type" class="priority-selected">
														<span
															class="priority-box {{priorityCode(feedback.incident_type)}}"></span>
														{{feedback.incident_type}}
													</span>
												</div>

												<!-- Dropdown menu -->
												<div class="dropdown-menu show" ng-if="showIncidentMenu"
													style="width:100%;">
													<div class="priority-item" ng-click="setIncidentType('')">
														<span></span> Select Incident Severity
													</div>
													<div class="priority-item" ng-click="setIncidentType('Sentinel')">
														<span class="priority-box p1"></span> Sentinel
													</div>
													<div class="priority-item" ng-click="setIncidentType('Adverse')">
														<span class="priority-box p2"></span> Adverse
													</div>
													<div class="priority-item" ng-click="setIncidentType('No-harm')">
														<span class="priority-box p3"></span> No-harm
													</div>
													<div class="priority-item" ng-click="setIncidentType('Near miss')">
														<span class="priority-box p4"></span> Near miss
													</div>
												</div>
											</div>
										</div>




										<br>
										<!-- <button type="button" class="btn btn-outline-dark" data-toggle="modal"
											data-target="#tagPatientModal" style="margin-left: 12px;">
											<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{{lang.tag_incident}}
										</button> -->
										<br>
										<div class="form-group" style="margin-top:-30px;">

											<label
												style="margin-left: 12px; margin-bottom: 25px; font-weight: bold; display: inline-flex; align-items: center;"
												for="imageInput" class="custom-file-upload">
												Tag Patient/ Employee/ Equipment
											</label>
											<br>
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<!-- <span class="addon"
														style="font-size: 16px;">{{lang.tag_type}}</span> -->
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.tag_type"
															ng-init="feedback.tag_type = ''" style="padding-top:0px;">
															<option value="">-- Select Tag Type --</option>
															<option value="patient">Tag Patient</option>
															<option value="employee">Tag Employee</option>
															<option value="equipment">Tag Equipment</option>
														</select>
														<label for="tag_type"></label>
													</span>
												</div>
											</div>

											<!-- PATIENT FIELDS -->
											<div ng-show="feedback.tag_type == 'patient'">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon"
															style="font-size: 16px;">{{lang.tag_name}}</span>
														<span class="has-float-label">
															<input class="form-control" placeholder="Enter Patient Name"
																maxlength="25" name="patient_name" type="text"
																ng-model="feedback.tag_name"
																onblur="this.value = this.value.toUpperCase();"
																autocomplete="off" style="padding-top:0px;" />
															<label for="patient_name"></label>
														</span>
													</div>
												</div>

												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon"
															style="font-size: 16px;">{{lang.tag_id}}</span>
														<span class="has-float-label">
															<input class="form-control" placeholder="Enter Patient ID"
																type="text" maxlength="10"
																ng-model="feedback.tag_patientid" autocomplete="off"
																style="padding-top:0px;" />
															<label for="patient_id"></label>
														</span>
													</div>
												</div>
											</div>

											<!-- EMPLOYEE FIELDS -->
											<div ng-show="feedback.tag_type == 'employee'">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon" style="font-size: 16px;">Employee
															Name</span>
														<span class="has-float-label">
															<input class="form-control"
																placeholder="Enter Employee Name" maxlength="25"
																type="text" ng-model="feedback.employee_name"
																onblur="this.value = this.value.toUpperCase();"
																autocomplete="off" style="padding-top:0px;" />
														</span>
													</div>
												</div>

												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon" style="font-size: 16px;">Employee ID</span>
														<span class="has-float-label">
															<input class="form-control" placeholder="Enter Employee ID"
																type="text" maxlength="10"
																ng-model="feedback.employee_id" autocomplete="off"
																style="padding-top:0px;" />
														</span>
													</div>
												</div>
											</div>

											<!-- EQUIPMENT FIELDS -->
											<div ng-show="feedback.tag_type == 'equipment'">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon" style="font-size: 16px;">Equipment
															Name</span>
														<span class="has-float-label">
															<input class="form-control" placeholder="Enter Asset Name"
																maxlength="25" type="text"
																ng-model="feedback.asset_name"
																onblur="this.value = this.value.toUpperCase();"
																autocomplete="off" style="padding-top:0px;" />
														</span>
													</div>
												</div>

												<div class="col-xs-12 col-sm-12 col-md-6">
													<div class="form-group">
														<span class="addon" style="font-size: 16px;">Equip. ID/ Asset
															Code</span>
														<span class="has-float-label">
															<input class="form-control" placeholder="Enter Asset Code"
																type="text" maxlength="10"
																ng-model="feedback.asset_code" autocomplete="off"
																style="padding-top:0px;" />
														</span>
													</div>
												</div>
											</div>

										</div>
										<div class="form-group"
											style="margin-left: 13px; margin-right:13px;margin-top:30px;">
											<label for="imageInput" class="custom-file-upload"
												style="font-weight: bold;">
												{{lang.image}}
											</label>
											<input id="imageInput" style="border-bottom: 0px;" type="file"
												accept="image/jpeg, image/png, image/gif" multiple
												ng-model="feedback.images"
												onchange="angular.element(this).scope().encodeImages(this)" />


											<button type="button" class="btn btn-primary btn-sm"
												ng-show="feedback.images && feedback.images.length > 0"
												ng-click="triggerFileInput()" style="margin-left: 0px;margin-top:10px;">
												<i class="fa fa-plus"></i> Add More
											</button>
											<br>
											<div ng-repeat="image in feedback.images track by $index"
												style="display: inline-block; margin-right: 10px; margin-top: 10px; position: relative;">
												<img ng-src="{{image}}" alt="Encoded Image" ng-click="editImage($index)"
													style="max-width: 100px; max-height: 100px; cursor: pointer; border: 1px solid #ccc;" />
												<button type="button" class="btn btn-danger btn-xs"
													ng-click="removeImage($index)"
													style="position: absolute; top: 0; right: 0;">
													<i class="fa fa-times"></i>
												</button>
											</div>
											<!-- Modal for Image Editing -->
											<div id="imageEditorModal"
												style="display:none; position: fixed; top: 10%; left: 10%; background: white; border: 1px solid #ccc; padding: 10px; z-index: 9999;">
												<canvas id="fabricCanvas"></canvas>
												<div
													style="position: absolute; top: 10px; right: 10px; z-index: 10000;">
													<button class="btn btn-sm btn-warning" ng-click="undoLast()">⟲
														Undo</button>
													<button class="btn btn-sm btn-danger" ng-click="closeEditor()">✖
														Close</button>
												</div>
											</div>


										</div>
										<div class="form-group"
											style="margin-left: 13px; margin-right:13px;margin-top:30px;">


											<br>
											<label for="fileInput" class="custom-file-upload"
												style="font-weight: bold;">
												{{lang.attach_file}}
											</label>

											<!-- File Input for Document Upload -->
											<input style="border-bottom: 0px;" type="file" accept="*" multiple
												onchange="angular.element(this).scope().encodeFiles(this)" />
											<br>

											<!-- Display the list of uploaded files -->
											<div ng-if="feedback.files_name && feedback.files_name.length > 0">
												<h3 style="font-size: 18px; margin-top:16px;">Uploaded Files:</h3>
												<ul style="margin-left: 19px;">
													<li ng-repeat="files_name in feedback.files_name track by $index"
														style="display: flex; align-items: center;">
														<a href="{{files_name.url}}" target="_blank"
															style="margin-right: 8px;">{{files_name.name}}</a>
														<span style="cursor: pointer; color: red; font-weight: bold;"
															ng-click="removeFile($index)">&#10060;</span>
													</li>
												</ul>
											</div>
											<!-- Display file name after upload -->
										</div>

									</div>


									<br><br>

									<input type="button" name="previous" style="font-size:small;"
										class="previous action-button-previous" ng-click="activateStepBasedOnShowBack()"
										value="{{lang.previous}}" />
									<input type="button" name="next" ng-click="next4()"
										style="background: #4285F4 ; font-size:small;" class="next action-button"
										value="{{lang.next}}" />


								</fieldset>

								<!-- INTERIM FEEDBACK FORM page end  -->


								<fieldset ng-show="step5 == true">
									<div class="form-card">
										<h3 class="sectiondivision" style="font-weight:bold;">{{lang.pagetitle}}</h3>

										<div class="text-left details-section" style="background: white;">
											<label for="comment"
												style="font-size: 18px;font-weight:bold;">{{lang.submission_pat_details}}</label>
											<br>
											<table class="details-content"
												style="border-spacing: 10px; border-collapse: collapse; width: 100%; margin-bottom: 0px; border: 1px solid #dddddd;">
												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;
															font-size: 15px; font-weight:bold;">{{lang.detail}}</td>
												</tr>


												<tr ng-show="submit_as_concern == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.SelectedCategory}}
													</td>
													<td ng-show="selectedParameterObject.title && selectedParameterObject.title != 'Other'"
														style="border: 1px solid #dddddd; padding: 10px;">
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'english'">{{selectedParameterObject.title}}</span>
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'lang2'">{{selectedParameterObject.titlek}}</span>
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'lang3'">{{selectedParameterObject.titlem}}</span>
													</td>
												</tr>
												<tr ng-show="submit_as_concern == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.concern_request}}
													</td>
													<td ng-show="selectedParameterObject.title && selectedParameterObject.title != 'Other'"
														style="border: 1px solid #dddddd; padding: 10px;">
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'english'">{{selectedParameterObject.question}}</span>
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'lang2'">{{selectedParameterObject.questionk}}</span>
														<span style="margin-left: 0px;" class="lang-content"
															ng-show="typel == 'lang3'">{{selectedParameterObject.questionm}}</span>
													</td>
												</tr>
												<tr ng-if="feedback.incident_occured_in">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.incident_occurred}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.incident_occured_in | date:'dd MMM, yyyy - h:mm a'}}
													</td>
												</tr>

												<tr ng-show="description == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.descb}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.other}}
													</td>
												</tr>
												<tr ng-show="what_went_wrong == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.what_went_wrong}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.what_went_wrong}}
													</td>
												</tr>
												<tr ng-show="action_taken == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.action_taken}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.action_taken}}
													</td>
												</tr>
												<tr ng-show="feedback.images && feedback.images.length > 0">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.image}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														<div ng-repeat="image in feedback.images track by $index"
															style="margin: 5px;">
															<img ng-src="{{image}}" alt="Encoded Image"
																style="max-width: 100px; max-height: 100px; border: 1px solid #ccc;" />
														</div>
													</td>
												</tr>
												<!-- Display Other Files (Excel, Word, PDF, etc.) -->
												<!-- Display Other Files (Excel, Word, CSV, etc.) -->
												<tr ng-show="feedback.files_name && feedback.files_name.length > 0">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">{{lang.file}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														<ul style="padding-left: 15px; margin: 0;">
															<li ng-repeat="file in feedback.files_name">
																<a ng-href="{{file.url}}"
																	download="{{file.name}}">{{file.name}}</a>
															</li>
														</ul>
													</td>
												</tr>

												<tr>
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.risk_matrixed}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														<span ng-if="!feedback.risk_matrix.level">Unassigned</span>
														<span ng-if="feedback.risk_matrix.level">
															<span class="risk-box" ng-class="{'p1': feedback.risk_matrix.level=='High',
										'p2': feedback.risk_matrix.level=='Medium',
										'p3': feedback.risk_matrix.level=='Low'}"></span>
															<strong>{{feedback.risk_matrix.level}}</strong>

															(
															{{feedback.risk_matrix.impact}} Impact ×
															{{feedback.risk_matrix.likelihood}} Likelihood )
														</span>
													</td>
												</tr>

												<tr>
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showpriority}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														<span ng-if="!feedback.priority">Unassigned</span>
														<span ng-if="feedback.priority"
															class="priority-box {{priorityCode(feedback.priority)}}"></span>
														<span ng-if="feedback.priority">{{feedback.priority}}</span>

													</td>
												</tr>
												<tr>
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showincident_type}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														<span ng-if="!feedback.priority">Unassigned</span>
														<span ng-if="feedback.priority"
															class="priority-box {{priorityCode(feedback.incident_type)}}"></span>
														<span
															ng-if="feedback.priority">{{feedback.incident_type}}</span>

													</td>

												</tr>




												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;
															font-size: 15px; font-weight:bold;">{{lang.occurred}}</td>
												</tr>
												<tr>
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showfloor}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.ward}}
													</td>
												</tr>
												<tr>
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showlocation}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.bedno}}
													</td>
												</tr>

												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;
															font-size: 15px;font-weight:bold;">{{lang.reported}}</td>
												</tr>
												<tr ng-show="employeename == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.employeename}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.name}}
													</td>
												</tr>
												<tr ng-show="employeeid == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.employeeid}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.patientid}}
													</td>
												</tr>

												<tr ng-show="showmobileno == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showmobileno}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.contactnumber}}
													</td>
												</tr>
												<tr ng-show="showemail == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.showemail}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.email}}
													</td>
												</tr>


												<tr
													ng-if="feedback.tag_patientid || feedback.employee_id || feedback.asset_name || feedback.asset_code">
													<td colspan="2" class="details-label" style="padding: 10px;
														font-size: 15px; font-weight:bold;">Tagged Details
													</td>
												</tr>


												<!-- PATIENT NAME -->
												<tr ng-if="feedback.tag_name">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.tag_name}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.tag_name}}
													</td>
												</tr>

												<!-- PATIENT ID -->
												<tr ng-if="feedback.tag_patientid">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.tag_id}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.tag_patientid}}
													</td>
												</tr>

												<!-- EMPLOYEE NAME -->
												<tr ng-if="feedback.employee_name">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														Employee Name
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.employee_name}}
													</td>
												</tr>

												<!-- EMPLOYEE ID -->
												<tr ng-if="feedback.employee_id">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														Employee ID
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.employee_id}}
													</td>
												</tr>

												<!-- ASSET NAME -->
												<tr ng-if="feedback.asset_name">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														Asset Name
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.asset_name}}
													</td>
												</tr>

												<!-- ASSET CODE -->
												<tr ng-if="feedback.asset_code">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														Asset Code
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.asset_code}}
													</td>
												</tr>

												<tr ng-show="tagpatient == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.tag_type}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.tag_patient_type}}
													</td>
												</tr>
												<tr ng-show="tagpatient == true">
													<td class="details-label"
														style="border: 1px solid #dddddd; padding: 10px;">
														{{lang.tag_consultant}}
													</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">
														{{feedback.tag_consultant}}
													</td>
												</tr>
											</table>
											<br><br>
											<input type="button" name="previous" style="font-size:small;"
												class="previous action-button-previous" ng-click="activeStep('step4')"
												value="{{lang.previous}}" />
											<input type="button" name="make_payment"
												style="background: #4285F4 ; font-size:small;" ng-show="loader == false"
												class="next action-button" ng-click="savefeedback()"
												value="{{lang.submit}}" />
										</div>
									</div>
								</fieldset>


								<!-- Thank you page start -->
								<fieldset ng-show="step6 == true">
									<div class="form-card">
										<!-- logo  -->
										<div class="row justify-content-center">
											<!--<div class="col-3"> <img src="dist/tick.png" class="fit-image"> </div>-->
										</div>
										<br><br>
										<!-- thank you  -->
										<h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}
										</h2> <br>
										<div class="row justify-content-center">

											<!-- Your issue is registered with us! One of our executive will get in touch with you shortly. -->
											<div class="col-12 text-center">
												<img src="dist/tick.png"> <br>
												<p style="text-align:center; margin-top: 45px; font-weight: 300;"
													class="lead">
													{{lang.thankyoumessage}}
												</p>
												<br>

											</div>
										</div>
									</div>
								</fieldset>
								<!-- Thank you page end -->
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

<script>
	function setMaxDateTime() {
		const now = new Date();

		// format: YYYY-MM-DDTHH:MM (what datetime-local needs)
		const formatted = now.toISOString().slice(0, 16);

		document.getElementById("incident_occured_in").setAttribute("max", formatted);
	}

	// set max once on load
	setMaxDateTime();

	// OPTIONAL: keep refreshing every minute so "now" moves forward
	setInterval(setMaxDateTime, 60000);
</script>
<!-- CSS -->
<style>
	.risk-table {
		border-collapse: collapse;
		text-align: center;
	}

	.risk-table td,
	.risk-table th {
		border: 1px solid #ccc;
		padding: 14px;
		cursor: pointer;
	}

	.risk-low {
		background: #28a745;
		color: #fff;
	}

	/* green */
	.risk-medium {
		background: #ffc107;
		color: #000;
	}

	/* yellow */
	.risk-high {
		background: #dc3545;
		color: #fff;
	}

	/* red */
	.selected-cell {
		outline: 3px solid #000;
		/* highlight box */
	}

	.calendar-icon-container {
		display: none;
	}

	@media (max-width: 800px) {
		.calendar-icon-container {
			display: block;
		}
	}
</style>
<script>
	function restrictYearLength(input) {
		if (!input.value) return;

		// Extract parts of datetime-local input
		const parts = input.value.split("T");
		const date = parts[0]; // YYYY-MM-DD
		const time = parts[1] || "";

		const segments = date.split("-");
		if (segments.length === 3) {
			let year = segments[0];
			if (year.length > 4) {
				year = year.slice(0, 4); // Trim to 4 digits
			}
			// Rebuild and assign trimmed datetime
			input.value = year + '-' + segments[1] + '-' + segments[2] + (time ? 'T' + time : '');
		}
	}
</script>
<style>
	img {
		max-width: 100%;
		max-height: 300px;
		/* Adjust the max height as needed */
	}

	.ellipsis {

		overflow: hidden;
		text-overflow: ellipsis;
		max-width: 100%;
	}

	/* Default desktop/tablet view */
	.risk-table th[rowspan="5"] {
		writing-mode: vertical-rl;
		transform: rotate(180deg);
		padding: 10px;
		white-space: nowrap;
	}

	/* Mobile view adjustments */
	@media (max-width: 768px) {
		.risk-table th[rowspan="5"] {
			writing-mode: horizontal-tb;
			transform: none;
			text-align: center;
			white-space: normal;
			font-size: 12px;
			/* shrink text a bit */
		}

		.risk-table {
			font-size: 12px;
		}

		.risk-table th,
		.risk-table td {
			padding: 5px;
		}
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
<!-- script code start  -->

<!-- Activate popover on click -->
<script>
	$(document).ready(function() {
		$('#questionMark').popover({
			trigger: 'manual'
		});

		$('#questionMark').on('click', function() {
			$(this).popover('toggle');

			// Hide the popover after 2 seconds
			setTimeout(function() {
				$('#questionMark').popover('hide');
			}, 2000);
		});
	});
</script>

<script>
	setTimeout(function() {

		$('#body').show();

	}, 2000);

	function restrictToAlphabets(event) {
		const inputElement = event.target;
		const currentValue = inputElement.value;
		const filteredValue = currentValue.replace(/[^A-Za-z ]/g, ''); // Remove all characters except A-Z, a-z, and spaces
		if (currentValue !== filteredValue) {
			inputElement.value = filteredValue;
		}
	}

	function restrictToNumerals(event) {
		const inputElement = event.target;
		const currentValue = inputElement.value;
		const filteredValue = currentValue.replace(/\D/g, ''); // Remove all non-digit characters
		if (currentValue !== filteredValue) {
			inputElement.value = filteredValue;
		}
	}

	document.getElementById("refreshBtn").addEventListener("click", function() {
		location.reload(); // This will refresh the page when the button is clicked
	});
</script>
<!-- script code end  -->


<!-- Modal -->
<div class="modal fade" id="tagPatientModal" tabindex="-1" role="dialog" aria-labelledby="tagPatientModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tagPatientModalLabel">{{lang.tag_detail}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Add your content here -->
				<!-- <fieldset ng-show="step100 == true">

					<div class="form-card">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group" style="margin-bottom: 0px;">
									<span class="addon" style="    font-size: 16px;"> Enter patient mobile number to tag <sup style="color:red;font-size:15px;">*</sup></span>
									<span class="has-float-label"><br><br>
										<input class="form-control" placeholder="{{lang.reg_mobile_message_placeholder}}" name="contactnumber" type="tel" pattern="\d*" maxlength="10" id="emailid" ng-model="feedback.patient_number" oninput="restrictToNumerals(event)" style=" padding-top:0px;" />
										<label for="emailid"></label>
									</span>
								</div>
							</div>
						</div>
					</div>
				
					<button type="button" name="next" ng-click="next_popup()" class="btn btn-light">Click here to proceed</button>
					<br>
				</fieldset> -->
			</div>
			<!-- <fieldset ng-show="step200 == true"> -->
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<span class="addon" style="    font-size: 16px;">{{lang.tag_name}}</span>
					<span class="has-float-label">
						<input class="form-control" placeholder="Enter Name" maxlength="25" name="name" type="text"
							id="emailid" ng-model="feedback.tag_name" onblur="this.value = this.value.toUpperCase();"
							autocomplete="off" style=" padding-top:0px;" />
						<label for="emailid"></label>
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<span class="addon" style="    font-size: 16px;">{{lang.tag_id}}</span>
					<span class="has-float-label">
						<input class="form-control" placeholder="Enter ID" type="text" maxlength="10" id="contactnumber"
							ng-required="true" ng-model="feedback.tag_patientid" autocomplete="off"
							placeholder="Numerical digits only" style="padding-top:0px;" />
						<label for="contactnumber"></label>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<span class="has-float-label">
							<select class="form-control" ng-model="feedback.tag_patient_type"
								style=" width: 94%; margin: 0px auto;">
								<option value="" disabled selected>{{lang.tag_type}}</option>
								<option value="Inpatient">Inpatient</option>
								<option value="Outpatient">Outpatient</option>
								<option value="Other">Other</option>

								<!-- Add more options as needed -->
							</select>
						</span>
					</div>
				</div>
			</div>
			<br>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<span class="addon" style="    font-size: 16px;">{{lang.tag_consultant}}</span>
					<span class="has-float-label">
						<input class="form-control" placeholder="Enter Name" maxlength="25" name="name" type="text"
							id="emailid" ng-model="feedback.tag_consultant"
							onblur="this.value = this.value.toUpperCase();" autocomplete="off"
							style=" padding-top:0px;" />
						<label for="emailid"></label>
					</span>
				</div>
			</div>

			<!-- </fieldset> -->

			<div class="modal-footer">
				<!-- <div ng-show="tagpatient == true" class="d-flex justify-content-between w-100"> -->
				<!-- <button type="button" ng-click="prev_pop()" class="btn btn-light">Back</button> -->
				<button type="button" class="btn btn-dark" ng-click="save_popup()">Save</button>
				<!-- </div> -->
				<!-- Add additional buttons if needed -->
			</div>


		</div>
	</div>
</div>


<div class="modal fade" id="pinModel" tabindex="-1" role="dialog" aria-labelledby="pinModelLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pinModelLabel">{{lang.forgot_heading}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<!-- <fieldset ng-show="step200 == true"> -->
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<span class="addon" style=" font-size: 16px;">{{lang.forgot_mainforgot}}</span>
					<p></p>
					<span class="has-float-label">
						<input class="form-control" placeholder="{{lang.forgot_mainplaceholder}}" maxlength="25"
							name="name" type="text" id="emailid" ng-model="feedback.pin_contactnumber" autocomplete="on"
							style=" padding-top:0px;" />
						<label for="emailid"></label>
					</span>
					<span class="has-float-label" ng-show="no_email == true">
						<p id="errorMessage" style="color: red;">{{lang.nodata}}</p>
					</span>
					<span class="has-float-label" ng-show="please == true">
						<p id="errorMessage" style="color: red;">{{lang.forgot_alert}}</p>
					</span>

				</div>
			</div>

			<!-- </fieldset> -->

			<div class="modal-footer">
				<!-- <div ng-show="tagpatient == true" class="d-flex justify-content-between w-100"> -->
				<!-- <button type="button" ng-click="prev_pop()" class="btn btn-light">Back</button> -->
				<button type="button" class="btn btn-dark" ng-click="pin_popup()">{{lang.sentpin}}</button>
				<!-- </div> -->
				<!-- Add additional buttons if needed -->
			</div>


		</div>
	</div>
</div>


</html>

<script>
	function setMaxDateTime() {
		const now = new Date();

		// Build YYYY-MM-DDTHH:MM in LOCAL time
		const year = now.getFullYear();
		const month = String(now.getMonth() + 1).padStart(2, '0');
		const day = String(now.getDate()).padStart(2, '0');
		const hours = String(now.getHours()).padStart(2, '0');
		const minutes = String(now.getMinutes()).padStart(2, '0');

		const formatted = `${year}-${month}-${day}T${hours}:${minutes}`;

		document.getElementById("incident_occured_in").setAttribute("max", formatted);
	}

	// Run once on load
	setMaxDateTime();

	// OPTIONAL: update every minute so "now" moves forward
	setInterval(setMaxDateTime, 60000);
</script>

<script>
	function togglePassword() {
		var passwordField = document.getElementById("password");
		var passwordToggle = document.querySelector(".password-toggle");

		if (passwordField.type === "password") {
			passwordField.type = "text";
			passwordToggle.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>'; // Change HTML to eye icon
		} else {
			passwordField.type = "password";
			passwordToggle.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>'; // Change HTML to eye slash icon
		}
	}

	function restrictToAlphabets(event) {
		const inputElement = event.target;
		const currentValue = inputElement.value;
		const filteredValue = currentValue.replace(/[^A-Za-z ]/g, ''); // Remove all characters except A-Z, a-z, and spaces
		if (currentValue !== filteredValue) {
			inputElement.value = filteredValue;
		}
	}

	function restrictToNumerals(event) {
		const inputElement = event.target;
		const currentValue = inputElement.value;
		const filteredValue = currentValue.replace(/\D/g, ''); // Remove all non-digit characters
		if (currentValue !== filteredValue) {
			inputElement.value = filteredValue;
		}
	}
</script>

<style>
	.input-field {
		padding: 12px;
		font-size: 16px;
		border: 1px solid rgba(0, 0, 0, 0.2);
		/* Add border */
		border-radius: 25px;
		/* Add border radius */
		margin-bottom: 15px;
		width: 100%;
		box-sizing: border-box;
		color: #000;
		box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
		/* Add box shadow */
	}

	.password-container {
		position: relative;
	}

	.password-input {
		width: calc(100% - 40px);
		/* Adjust width to accommodate the show/hide button */
	}

	.password-toggle {
		position: absolute;
		right: 45px;
		top: 39%;
		transform: translateY(-50%);
		cursor: pointer;
	}
</style>