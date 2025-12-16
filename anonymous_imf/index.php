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

	<script src="anonymous_app.js?<?php echo time(); ?>"></script>

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
														<img src="{{setting_data.logo}}" style="height: 100px; width:100%">
													</a>
												</div>
												<br>
												<div style="color: red; text-align: center;" class="alert-error" ng-show="loginerror.length > 3">{{loginerror}}</div>

												<input type="text" name="email" id="email" class="input-field" placeholder="Enter email/ mobile no." ng-model="loginvar.userid" style="padding: 12px;font-size: 16px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px; margin-bottom: 15px; width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">

												<div class="password-container">
													<input type="password" name="password" id="password" class="input-field" placeholder="Enter password" ng-model="loginvar.password" style="padding: 12px;font-size: 16px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px; margin-bottom: 15px; width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
													<span style="color: rgba(0, 0, 0, 0.8);" class="password-toggle" onclick="togglePassword()">
														<i class="fa fa-eye-slash" aria-hidden="true"></i>
													</span>
												</div>

												<div style="display: flex; justify-content: center; align-items: center;">
													<input ng-click="login()" type="submit" value="LOGIN" style="width: 100px; height: 45px; background: #34a853; border: 1px solid rgba(0, 0, 0, 0.1); padding: 10x; font-size: 16px; border-radius: 50px; cursor: pointer; margin-top: 20px; color: white;">
												</div>

												<p style="margin-top: 12px;">OR</p>
												<!-- Add the 'Raise anonymous incident' button below -->
												<div style="display: flex; justify-content: center; align-items: center;">
													<a href="../anonymous_imf"  
														style=" border-radius: 45px; font-size: 16px; 
              box-shadow: 0px 1px 1px rgba(0,0,0,0.5); 
              background-color: #f44336; border: none; color: white; 
              text-align: center; display: inline-block; width: 200px; 
              height: 45px; line-height: 45px; cursor: pointer;">
														Raise anonymous incident
													</a>
												</div>
											</form>
										</div>
										<br><br>
										<div class="form-footer" style="display: flex; justify-content: center; align-items: center;">
											<img src="./power.png" style="max-width: 100%; height: 45px;" alt="">
										</div>
									</div>
								</div>
							</fieldset>

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
											Anonymous,
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



												<div ng-repeat="q in questioset">
													<ul>
														<li ng-repeat="p in q.question | filter:searchTextmain" ng-click="selectQuestionCategory1(p, q)" ng-show="p.question != 'Other'">
															<label class="container">
																<span ng-show="typel == 'english'">{{p.question}}</span>
																<span ng-show="typel == 'lang2'">{{p.questionk}}</span>
																<span ng-show="typel == 'lang3'">{{p.questionm}}</span>
																<input type="checkbox" ng-model="p.valuetext" ng-show="p.showQuestion">
																<span class="checkmark" style="border-radius: 50%;"></span>
															</label>
															<!-- Include other languages as necessary -->
														</li>
													</ul>
													<!-- Display this div when the li tags are empty -->

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
									</div>



									<br>
									<h4 style="font-size: 18px; margin-bottom: 22px; padding-top: 10px;"><b>{{lang.chooseCategory}}</b></h4>
									<div class="" style="width: 94%; margin: 0px auto;">
										<div class="row">
											<div ng-repeat="q in questioset" class="col-6" ng-show="q.category != 'Other'">
												<div class="card" ng-click="selectQuestion(q)">
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
										<br><br>

										<!-- <div>
											<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activeStep('step0')" value="{{lang.previous}}" />
										</div> -->
									</div>



								</fieldset>



								<fieldset ng-show="step3 == true">
									<div class="text-left">


										<!-- <span>{{searchTextmain}}</span> -->
										<br />


										<!-- <div class="text-left" style="width: 94%; margin: 0px auto;" ng-show="feedback.parameter.length != 0"> -->

										<div class="text-left" style="width: 94%; margin: 0px auto;" ng-show="selectedQuestionObject.question.length != 0">

											<input type="text" placeholder="Search..." ng-click="filterFunction()" ng-model="searchText" oninput="restrictToAlphabets(event)">
											<i class="fa fa-search search-icon"></i>
											<h4 style="font-size: 18px; margin-bottom: 22px;"><br><b>{{lang.telluswrong}}{{category}}</b></h4>

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

								<!-- card click -->
								<fieldset ng-show="step4 == true">
									<div class="form-card" style="margin-top: 10px;">
										<div class="form-group" style="margin-left: 13px; margin-right:13px;" ng-show="submit_as_concern == true">

											<label for="comment">{{lang.u_select}} <br>
												<b> {{lang.incident_category}}</b>{{selectedParameterObject.title}} <br>
												<b> {{lang.incident_parameter}}</b> {{selectedParameterObject.question}}</label>
										</div>


										<div class="form-group" style="margin-left: 13px; margin-right:13px;">
											<h4 style="font-size: 18px; margin-bottom: 22px;"><b>{{lang.add_details_to_incident}}</b></h4>
											<label for="comment">{{lang.describe_incident}}<br></label>
											<textarea placeholder="{{lang.describe_incident_placeholder}}" style="border: 2px solid #ccc;margin-top:7px" class="form-control" ng-model="feedback.other" rows="5" id="comment"></textarea>
										</div>

										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.incident_type" style=" width: 94%; margin: 0px auto; margin-top:20px;">
															<option value="">{{lang.incident_Type}}</option>
															<option ng-repeat="x in wardlist.incident_type" value="{{x.title}}" required>{{x.title}}</option>
														</select>
													</span>
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.priority" style=" width: 94%; margin: 0px auto;">
															<option value="">{{lang.priority}}</option>
															<option ng-repeat="x in wardlist.priority" value="{{x.title}}" required>{{x.title}}</option>
														</select>
													</span>
												</div>
											</div>
										</div>
										<br />
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.ward" ng-change="change_ward()" style=" width: 94%; margin: 0px auto;">
															<option value="" disabled>{{lang.floor}}</option>
															<option ng-repeat="x in wardlist.ward" ng-show="x.title !== 'ALL' " value="{{x.title}}" required>{{x.title}}</option>

														</select>
													</span>
												</div>
											</div>
										</div>
										<br />
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="form-group">
													<span class="has-float-label">
														<select class="form-control" ng-model="feedback.bedno" style=" width: 94%; margin: 0px auto;">
															<option value="" disabled>{{lang.location}}</option>
															<option ng-repeat="x in bed_no" value="{{x}}" required>{{x}}</option>
														</select>
													</span>
												</div>
											</div>
										</div>
										<br>
										<button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#tagPatientModal" style="margin-left: 12px;">
											<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{{lang.tag_incident}}
										</button>
										<br>
										<div class="form-group" style="margin-left: 13px; margin-right:13px;margin-top:30px;">

											<label for="imageInput" class="custom-file-upload" style="font-weight: bold;">
												{{lang.attach_img}}
											</label>
											<input style="border-bottom: 0px;" type="file" accept="image/jpeg, image/png, image/gif" ng-model="feedback.image" onchange="angular.element(this).scope().encodeImage(this)" />
											<br>
											<img ng-src="{{feedback.image}}" alt="Encoded Image" ng-show="feedback.image" />


										</div>
									</div>


									<br><br>
									<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activateStepBasedOnShowBack()" value="{{lang.previous}}" />
									<input type="button" name="next" ng-click="next4()" style="background: #4285F4 ; font-size:small;" class="next action-button" value="{{lang.next}}" />


								</fieldset>

								<!-- INTERIM FEEDBACK FORM page end  -->


								<fieldset ng-show="step5 == true">
									<div class="form-card">

										<div class="text-left details-section" style="background: white;">
											<label for="comment"><b style="font-size: 18px;">{{lang.submission_pat_details}}</b></label>
											<br>
											<table class="details-content" style="border-spacing: 10px; border-collapse: collapse; width: 100%; margin-bottom: 0px; border: 1px solid #dddddd;">
												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;"><b style="font-size: 15px;">{{lang.detail}}</b></td>
												</tr>

												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showincident_type}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.incident_type}}</td>
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

												<tr ng-show="description == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.descb}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.other}}</td>
												</tr>
												<tr ng-show="image == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.image}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;"> <img ng-src="{{feedback.image}}" alt="Encoded Image" ng-show="feedback.image" /> </td>

												</tr>

												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showpriority}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.priority}}</td>
												</tr>

												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;"><b style="font-size: 15px;">{{lang.occurred}}</b></td>
												</tr>
												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showfloor}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.ward}}</td>
												</tr>
												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showlocation}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.bedno}}</td>
												</tr>

												<tr>
													<td colspan="2" class="details-label" style="padding: 10px;"><b style="font-size: 15px;">{{lang.reported}}</b></td>
												</tr>
												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.employeename}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">Anonymous</td>
												</tr>
												<!-- <tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.employeeid}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{loginid}}</td>
												</tr>

												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showmobileno}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{loginnumber}}</td>
												</tr>
												<tr>
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.showemail}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{loginemail}}</td>
												</tr>
 -->

												<tr ng-show="tagpatient == true">
													<td colspan="2" class="details-label" style="padding: 10px;"><b style="font-size: 15px;">{{lang.tag_detail}}</b></td>
												</tr>

												<tr ng-show="tagpatient == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.tag_name}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.tag_name}}</td>
												</tr>
												<tr ng-show="tagpatient == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.tag_id}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.tag_patientid}}</td>
												</tr>
												<tr ng-show="tagpatient == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.tag_type}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.tag_patient_type}}</td>
												</tr>
												<tr ng-show="tagpatient == true">
													<td class="details-label" style="border: 1px solid #dddddd; padding: 10px;">{{lang.tag_consultant}}</td>
													<td style="border: 1px solid #dddddd; padding: 10px;">{{feedback.tag_consultant}}</td>
												</tr>
											</table>
											<br><br>
											<input type="button" name="previous" style="font-size:small;" class="previous action-button-previous" ng-click="activeStep('step4')" value="{{lang.previous}}" />
											<input type="button" name="make_payment" style="background: #4285F4 ; font-size:small;" ng-show="loader == false" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
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
										<h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>
										<div class="row justify-content-center">

											<!-- Your issue is registered with us! One of our executive will get in touch with you shortly. -->
											<div class="col-12 text-center">
												<img src="dist/tick.png"> <br>
												<p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">{{lang.thankyoumessage}}</p>
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
<div class="modal fade" id="tagPatientModal" tabindex="-1" role="dialog" aria-labelledby="tagPatientModalLabel" aria-hidden="true">
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
						<input class="form-control" placeholder="Enter Name" maxlength="25" name="name" type="text" id="emailid" ng-model="feedback.tag_name" onblur="this.value = this.value.toUpperCase();" autocomplete="off" style=" padding-top:0px;" />
						<label for="emailid"></label>
					</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<span class="addon" style="    font-size: 16px;">{{lang.tag_id}}</span>
					<span class="has-float-label">
						<input class="form-control" placeholder="Enter ID" type="text" maxlength="10" id="contactnumber" ng-required="true" ng-model="feedback.tag_patientid" autocomplete="off" placeholder="Numerical digits only" style="padding-top:0px;" />
						<label for="contactnumber"></label>
					</span>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<span class="has-float-label">
							<select class="form-control" ng-model="feedback.tag_patient_type" style=" width: 94%; margin: 0px auto;">
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
						<input class="form-control" placeholder="Enter Name" maxlength="25" name="name" type="text" id="emailid" ng-model="feedback.tag_consultant" onblur="this.value = this.value.toUpperCase();" autocomplete="off" style=" padding-top:0px;" />
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
						<input class="form-control" placeholder="{{lang.forgot_mainplaceholder}}" maxlength="25" name="name" type="text" id="emailid" ng-model="feedback.pin_contactnumber" autocomplete="on" style=" padding-top:0px;" />
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
		right: 30px;
		top: 39%;
		transform: translateY(-50%);
		cursor: pointer;
	}
</style>