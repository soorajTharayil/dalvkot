<!DOCTYPE html>
<html lang="en">
<!-- head part start -->
<!-- Interim feedback -->

<head>
	<title>Vyko Healthcare Experience Management Platform</title>
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
	<script src="app_interim.js?<?php echo time(); ?>"></script>
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
							<div class="left" style="margin-left: 68vw; max-width: 100%; margin-top: 5px; margin-right: -10px;">
								<a href="../">
									<img src="./user.png" style="max-width: 100%; height: 45px;" alt="">
								</a>
							</div>
							<div style="text-align: left; align-items: left; margin-left: 25px; margin-right: 25px;"></div>
							<div class="box box-primary profilepage" style="background: transparent;">
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

									<!-- <div class="card" style=" border: 2px solid #000;">
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
		<div class="row justify-content-center mt-0">
			<div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
				<img ng-src="{{setting_data.logo}}" style="    height: 50px;">
				<br>
				<div class="card px-0 pt-2 pb-0 mt-2 mb-3">
					<div class="row">
						<div class="col-md-12 mx-0">
							<!-- form start -->
							<form id="msform">

								<!-- Registered Mobile Number page start-->
								<fieldset ng-show="step0 == true">
									<!-- Registered Mobile Number -->
									<h4><strong>{{lang.reg_mobile}}</strong></h4>
									<br />
									<!-- Please provide your 10 digit registered Mobile number to proceed -->
									<div class="form-card">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;"> {{lang.reg_mobile_message}} <sup style="color:red;font-size:15px;">*</sup></span>
													<span class="has-float-label"><br><br>
														<input class="form-control" placeholder="{{lang.reg_mobile_message_placeholder}}" name="contactnumber" type="tel" pattern="\d*" maxlength="10" id="emailid" ng-model="feedback.contactnumber" oninput="restrictToNumerals(event)" autocomplete="on" style=" padding-top:0px;" step-1 />
														<label for="emailid"></label>
													</span>
												</div>
											</div>
											<p>&nbsp;</p>
										</div>
									</div>
									<!-- next button  -->

									<input type="button" name="next" ng-click="next0()" style="background: #4285F4 ; font-size:small;" class="next action-button" value="{{lang.next}}" />

								</fieldset>
								<!-- Registered Mobile Number page end-->


								<!-- PATIENT INFORMATION page start -->
								<fieldset ng-show="step1 == true">
									<h4><strong>{{lang.patient_info}}</strong></h4>
									<!--<p>Fill all form field to go to next step</p>-->
									<br />
									<div class="form-card">

										<!-- Form start -->
										<div class="row">

											<!-- Patient Name -->
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;"> {{lang.patientname}}<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control" placeholder="{{lang.patient_name_placeholder}}" maxlength="25" oninput="restrictToAlphabets(event)" name="name" type="text" id="emailid" ng-model="feedback.name" onblur="this.value = this.value.toUpperCase();" autocomplete="off" style=" padding-top:0px;" />
														<label for="emailid"></label>
													</span>
												</div>
											</div>
											<!-- Patient UHID -->
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control" placeholder="{{lang.enter_placeholder}}" type="text" maxlength="20" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" placeholder="Numerical digits only" style="padding-top:0px;" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>


											<div class="col-xs-12 col-sm-12 col-md-12" style="display:none;">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">Bed Number<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control" placeholder="Enter your Bed No." type="text" id="bednumber" ng-required="true" ng-model="feedback.bednumber" autocomplete="off" style="padding-top:0px;" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>

											<!-- <div class="col-xs-12 col-sm-12 col-md-12	">

												<div class="form-group">

													<span class="" style="font-size:16px;">{{lang.wardtitle}} <sup style="color:red">*</sup></span>

													<span class="has-float-label">

														<select class="form-control" ng-model="feedback.ward" ng-change="change_ward()">

															<option value="" disabled>{{lang.wardtitle}}</option>

															<option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">

																{{x.title}}
															</option>

														</select>



													</span>

												</div>

											</div>
											<p>&nbsp;</p>

											<div class="col-xs-12 col-sm-12 col-md-12">

												<div class="form-group">

													<span class="" style="font-size:16px;">{{lang.bedno}} <sup style="color:red">*</sup></span>

													<span class="has-float-label">

														<select class="form-control" ng-model="feedback.bedno">

															<option value="" disabled>{{lang.bedno}}</option>

															<option ng-repeat="x in bed_no" value="{{x}}">

																{{x}}
															</option>

														</select>

													</span>

												</div>

											</div> -->

											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="" style="font-size:16px;">{{lang.wardtitle}} <sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.ward" ng-change="change_ward()" ng-required="true" ng-show="typel == 'english'">
															<option value="">{{lang.wardtitle}}</option>
															<option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">
																{{x.title}}
															</option>
														</select>
														<select class="form-control" ng-model="feedback.ward" ng-change="change_wardk()" ng-required="true" ng-show="typel == 'lang2'">
															<option value="">{{lang.wardtitle}}</option>
															<option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">
																{{x.titlek}}
															</option>
														</select>
														<select class="form-control" ng-model="feedback.ward" ng-change="change_wardm()" ng-required="true" ng-show="typel == 'lang3'">
															<option value="">{{lang.wardtitle}}</option>
															<option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">
																{{x.titlem}}
															</option>
														</select>
													</span>
												</div>
											</div>

											<p>&nbsp;</p>



											<div class="col-xs-12 col-sm-12 col-md-12	">

												<div class="form-group">

													<span class="" style="font-size:16px;">{{lang.bedno}} <sup style="color:red">*</sup></span>

													<span class="has-float-label">

														<select class="form-control" ng-model="feedback.bedno" ng-required="true" ng-show="typel == 'english'">

															<option value="">{{lang.bedno}}</option>

															<option ng-repeat="(key, value) in bed_no" value="{{key}}">
																{{value}}
															</option>

														</select>
														<select class="form-control" ng-model="feedback.bedno" ng-required="true" ng-show="typel == 'lang2'">

															<option value="">{{lang.bedno}}</option>

															<option ng-repeat="(key, value) in bed_nok" value="{{key}}">
																{{value}}
															</option>

														</select>
														<select class="form-control" ng-model="feedback.bedno" ng-required="true" ng-show="typel == 'lang3'">

															<option value="">{{lang.bedno}}</option>

															<option ng-repeat="(key, value) in bed_nom" value="{{key}}">
																{{value}}
															</option>

														</select>



													</span>

												</div>

											</div>

											<!-- <div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">{{lang.bedno}}<sup style="color:red">*</sup></span>
													<span class="has-float-label">
														<input class="form-control" placeholder="{{lang.bedno}}" type="text" id="bednumber" ng-required="true" ng-model="feedback.bedno" autocomplete="off" style="padding-top:0px;" />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div> -->


											<!-- Mobile No -->
											<div class="col-xs-12 col-sm-12 col-md-12" style="display: none;">
												<div class="form-group">
													<span class="addon" style="    font-size: 16px;">{{lang.mobileno}}</span>
													<span class="has-float-label">
														<input class="form-control" type="tel" maxlength="10" id="contactnumber" ng-model="feedback.contactnumber" style="padding-top:0px;" autocomplete="off" placeholder="{{lang.mobile_placeholder}}" step="1" required />
														<label for="contactnumber"></label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;" ng-click="activeStep('step0')" value="{{lang.previous}}" />


									<!-- next button -->
									<input type="button" name="next" ng-click="next1()" style="background: #4285F4 ; font-size:small;" class="next action-button" value="{{lang.next}}" />
								</fieldset>
								<!-- PATIENT INFORMATION page end -->

								<!-- INTERIM FEEDBACK FORM page start  -->
								<fieldset ng-show="step2 == true">
									<div class="form-card">
										<h3 class="sectiondivision" style="font-weight:bold;" ng-show="feedback.section == 'INTERIM'">{{lang.pagetitle}}</h3>
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
										<p style="margin:0px;font-size: 16px;">{{lang.gustmessageint}}</p>
									</div>
									<br />
									<div class="text-left" style="width: 94%; margin: 0px auto;">
										<div class="search-container">
											<!-- <input type="text" ng-model="searchTextmain" ng-change="searchChanged()" placeholder="Search..."> -->

											<input type="text" placeholder="{{lang.mainSearch}}" ng-model="searchTextmain" ng-change="searchChanged()" value="searchTextmain" oninput="restrictToAlphabets(event)">
											<i class="fa fa-search search-icon"></i>

											<div class="dropdown-results" ng-if="searchTextmain && searchTextmain.length > 1">
												<!-- <ul> -->


												<div ng-repeat="q in questioset">
													<li ng-repeat="p in q.question | filter:searchTextmain" ng-click="selectQuestionCategory1(p ,q)" ng-show="p.question != 'Other'">
														<label class="container">
															<span ng-show="typel == 'english'">{{p.question}}</span>
															<span ng-show="typel == 'lang2'">{{p.questionk}}</span>
															<span ng-show="typel == 'lang3'">{{p.questionm}}</span>
															<input type="checkbox" ng-model="p.valuetext" ng-show="p.showQuestion">
															<span class="checkmark" style="border-radius: 50%;"></span>
														</label>
														<!-- Include other languages as necessary -->
													</li>
												</div>
												<!-- </ul> -->
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
									<h4 style="font-size: 18px; margin-bottom: 22px; padding-top: 10px;"><b>{{lang.chooseCategory}}</b></h4>
									<div class="" style="width: 92%; margin: 0px auto;">
										<div class="row">
											<div ng-repeat="q in questioset" class="col-6" ng-show="q.category != 'Other'">
												<div class="" ng-click="selectQuestion(q)">
													<div class="row">
														<div class="col-12">
															<div class="card product-card" style="margin-bottom: 10px;">
																<div class="card-body">
																	<p class="text" ng-bind-html="q.icon" style="color: #5c5959;font-size: 36px;"></p>
																	<p class="text ellipsis" ng-show="typel == 'english'">{{q.category}}</p>
																	<p class="text ellipsis" ng-show="typel == 'lang2'">{{q.categoryk}}</p>
																	<p class="text ellipsis" ng-show="typel == 'lang3'">{{q.categorym}}</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div>
											<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activeStep('step1')" value="{{lang.previous}}" />
										</div>
									</div>
								</fieldset>





								<!-- card click -->
								<fieldset ng-show="step3 == true">
									<div class="text-left">


										<!-- <span>{{searchTextmain}}</span> -->
										<br />


										<!-- <div class="text-left" style="width: 94%; margin: 0px auto;" ng-show="feedback.parameter.length != 0"> -->

										<div class="text-left" style="width: 94%; margin: 0px auto;" ng-show="selectedQuestionObject.question.length != 0">

											<input type="text" placeholder="Search..." ng-click="filterFunction()" ng-model="searchText" oninput="restrictToAlphabets(event)">
											<i class="fa fa-search search-icon"></i>
											<h4 style="font-size: 18px; margin-bottom: 22px;" ng-show="typel == 'english'"><br><b>{{lang.telluswrong}} {{category}}</b></h4>
											<h4 style="font-size: 18px; margin-bottom: 22px;" ng-show="typel == 'lang2'"><br><b>{{categoryk}} {{lang.telluswrong}}</b></h4>
											<h4 style="font-size: 18px; margin-bottom: 22px;" ng-show="typel == 'lang3'"><br><b>{{categorym}} {{lang.telluswrong}}</b></h4>

											<div ng-repeat="p in selectedQuestionObject.question | filter:filterFunction">
												<!-- <div ng-repeat="p in feedback.parameter.question"> -->
												<label class="container">
													<!-- your label content here -->
													<span ng-show="typel == 'english'">{{p.question}}</span>
													<span ng-show="typel == 'lang2'">{{p.questionk}}</span>
													<span ng-show="typel == 'lang3'">{{p.questionm}}</span>
													<input type="checkbox" ng-click="selectQuestionCategory(p,selectedQuestionObject)" ng-model="p.valuetext" ng-show="p.showQuestion">
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
											<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activeStep('step2')" value="{{lang.previous}}" />
										</div>
										<!-- submit button  -->
										<!-- <div ng-show="feedback.parameter.length != 0">

											<input type="button" name="make_payment" style="background: #4285F4 ; font-size:small;" class="next action-button" ng-click="savefeedback()" ng-show="loader == false" value="{{lang.submit}}" />
										</div> -->
										<img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true">
									</div>
								</fieldset>
								<!-- INTERIM FEEDBACK FORM page end  -->


								<fieldset ng-show="step4 == true">
									<div class="text-left details-section" style="background: white;">
										<label for="comment"><b style="font-size: 18px; margin-left:6px;">{{lang.submission_pat_details}}</b></label>
										<table class="details-content" style="border-spacing: 10px; border-collapse: collapse; width: 100%; margin-bottom: 0px; border: 1px solid #dddddd;">


											<tr ng-show="submit_as_concern == true">
												<td colspan="2" class="details-label" style="border: 1px solid #dddddd; padding: 10px;"><b>{{lang.details}}</b></td>

											</tr>
											<tr ng-show="submit_as_concern == true">
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.SelectedCategory}}</td>
												<td ng-show="selectedParameterObject.title && selectedParameterObject.title != 'Other'" style="border: 1px solid #dddddd; padding: 10px;">
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'english'">{{selectedParameterObject.title}}</span>
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'lang2'">{{selectedParameterObject.titlek}}</span>
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'lang3'">{{selectedParameterObject.titlem}}</span>
												</td>
											</tr>
											<tr ng-show="submit_as_concern == true">
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.concern_request}}</td>
												<td ng-show="selectedParameterObject.title && selectedParameterObject.title != 'Other'" style="border: 1px solid #dddddd; padding: 10px;">
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'english'">{{selectedParameterObject.question}}</span>
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'lang2'">{{selectedParameterObject.questionk}}</span>
													<span style="margin-left: 0px;" class="lang-content" ng-show="typel == 'lang3'">{{selectedParameterObject.questionm}}</span>
												</td>
											</tr>

											<tr>
												<td colspan="2" class="details-label" style="border: 1px solid #dddddd; padding: 10px;"><b>{{lang.raisedin}}</b></td>

											</tr>
											<tr>
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showwardtitle}}</td>
												<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.ward}}</td>
											</tr>
											<tr>
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.bedno}}</td>
												<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.bedno}}</td>
											</tr>
											<tr>
												<td colspan="2" class="details-label" style="border: 1px solid #dddddd; padding: 10px;"><b>{{lang.raisedby}}</b></td>

											</tr>
											<tr>
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.patientname}}</td>
												<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.name}}</td>
											</tr>
											<tr>
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.patientid}}</td>
												<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.patientid}}</td>
											</tr>

											<tr>
												<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.mobileno}}</td>
												<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.contactnumber}}</td>
											</tr>

										</table>
										<!-- <p class="details-content">
											<span class="details-label">{{lang.patientname}}:</span> {{feedback.name}}<br>
											<span class="details-label">{{lang.patientid}}:</span> {{feedback.patientid}}<br>
											<span class="details-label">{{lang.wardtitle}}:</span> {{feedback.ward}}<br>
											<span class="details-label">{{lang.bedno}}:</span> {{feedback.bedno}}<br>
											<span class="details-label">{{lang.mobileno}}:</span> {{feedback.contactnumber}}
										</p> -->
										<!-- <p class="details-content" ng-show="selectedParameterObject.title && selectedParameterObject.title != 'Other'">
											<span class="details-label">{{lang.SelectedCategory}}:</span>
											<span class="lang-content" ng-show="typel == 'english'">{{selectedParameterObject.title}}</span>
											<span class="lang-content" ng-show="typel == 'lang2'">{{selectedParameterObject.titlek}}</span>
											<span class="lang-content" ng-show="typel == 'lang3'">{{selectedParameterObject.titlem}}</span>
											<br>
											<span class="details-label">{{lang.concern_request}}:</span>
											<span class="lang-content" ng-show="typel == 'english'">{{selectedParameterObject.question}}</span>
											<span class="lang-content" ng-show="typel == 'lang2'">{{selectedParameterObject.questionk}}</span>
											<span class="lang-content" ng-show="typel == 'lang3'">{{selectedParameterObject.questionm}}</span>
										</p> -->
										<!-- <p class="details-content" ng-show="!selectedParameterObject.title || selectedParameterObject.title == 'Other'" style="display: none;">
											<select ng-model="OtherCategorySelected" ng-show="typel == 'english'">
												<option value="" disabled>{{lang.department}}</option>
												<option ng-repeat="qset in questioset" value="{{qset.settitle}}">{{qset.category}}</option>
											</select>
											<select ng-model="OtherCategorySelected" ng-show="typel == 'lang2'">
												<option value="" disabled>{{lang.department}}</option>
												<option ng-repeat="qset in questioset" value="{{qset.settitle}}">{{qset.categoryk}}</option>
											</select>
											<select ng-model="OtherCategorySelected" ng-show="typel == 'lang3'">
												<option value="" disabled>{{lang.department}}</option>
												<option ng-repeat="qset in questioset" value="{{qset.settitle}}">{{qset.categorym}}</option>
											</select>
										</p> -->
										<br>
										<div class="form-group">
											<label for="comment"><b style="font-size: 18px; margin-left:6px;">{{lang.issue_optional_title}}:</b></label>
											<textarea placeholder="{{lang.issue_optional_desc}}" style="border: 2px solid #ccc;margin-left:5px;" class="form-control" ng-model="feedback.other" rows="5" id="comment"></textarea>
										</div>
										<br><br>
										<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activateStepBasedOnShowBack()" value="{{lang.previous}}" />
										<input type="button" name="make_payment" style="background: #4285F4 ; font-size:small;" class="next action-button" ng-click="savefeedback()" ng-show="loader == false" value="{{lang.submit}}" />
									</div>
								</fieldset>


								<!-- Thank you page start -->
								<fieldset ng-show="step5	 == true">
									<div class="form-card">
										<!-- logo  -->
										<div class="row justify-content-center">
											<!--<div class="col-3"> <img src="dist/tick.png" class="fit-image"> </div>-->
										</div>
										<br><br>
										<!-- thank you  -->
										<h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>
										<div class="row justify-content-center">

											<!-- Your issue is registered with us! One of our executive will get in touch with you shortly. -->
											<div class="col-12 text-center">
												<img src="dist/tick.png"> <br>
												<p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">{{lang.thankyoumessage}}</p>
												<br>
												<button ng-click="activeStep('step2')" class="btn btn-danger " style="padding: 15px; border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); background-color:#DB6B97; border:none;">
													{{lang.refresh}}
												</button>
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

<style>
	@media (max-width: 768px) {
		.grecaptcha-badge {
			left: auto !important;
			right: 5px !important;
			width: 70px !important;
			height: 25px !important;
			bottom: 0px !important;
			transform: scale(1);
		}
	}

	.ellipsis {
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		max-width: 100%;
	}
</style>

<!-- script code start  -->
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

</html>
