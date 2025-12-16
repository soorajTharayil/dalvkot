<!DOCTYPE html>

<html lang="en">



<!-- head part start -->

<!-- IP FEEDBACK INDEX PAGE -->



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

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>


  <script src="app.js?<?php echo time(); ?>"></script>

</head>

<!-- head part end -->



<!-- body part start -->



<body ng-app="ehandorApp" ng-controller="PatientFeedbackCtrl" style="display:none;" id="body">



  <!-- top navbar start -->

  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">

    <!-- logo of efeedor -->

    <a class="navbar-brand" href="#"><img style="    height: 36px;"></a>

    <!-- dropdown for three language start -->

    <!-- Add a button to trigger the modal -->
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal" style="margin: 4px; float:right;">
      {{type2}}
      <i class="fa fa-language" aria-hidden="true"></i>
    </button>
    <!-- dropdown for three language end -->

  </nav>

  <!-- top navbar end -->



  <!-- when we sumbit the feedback more than one time this div part shows in UI -->

  <div class="container-fluid" id="grad1" ng-show="feedback.feedbac_summited == 'submitted'" style=" height: 100vh;">

    <div class="jumbotron text-center">

      <h1 class="display-3">Thank You!</h1>

      <p class="lead"><strong>Your feedback is already submmited</strong></p>

      <hr>



    </div>

  </div>

  <!-- this div end here -->

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
              <div class="box box-primary profilepage" style="background: transparent;">
                <div class="box-body box-profile" style="display: inline-block;">

                  <div class="card" style=" border: 2px solid #000;">
                    <div class="card-body" ng-click="language('english')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
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
                    <div class="card-body" ng-click="language('lang2')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
                      <span style="margin-left: -133px; color:#4b4c4d;">
                        ಕನ್ನಡ
                      </span><br>
                      <span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
                        ಕ
                      </span>
                    </div>
                  </div>
                  <br>

                  <div class="card" style=" border: 2px solid #000;">
                    <div class="card-body" ng-click="language('lang3')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
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
                  </div>
                  <br> -->

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ip  -->

  <div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">

      <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
        <img src="{{setting_data.logo}}" style="    height: 50px;">

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

                  <br>



                  <!-- Please provide your 10 digit registered Mobile number to proceed -->

                  <div class="form-card">

                    <div class="row">

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;"> {{lang.reg_mobile_message}} <sup style="color:red;font-size:15px;">*</sup></span>

                          <span class="has-float-label">

                            <br><br>
                            <!-- oninput="restrictToNumerals(event)" -->
                            <input class="form-control" placeholder="{{lang.reg_mobile_message_placeholder}}" oninput="restrictToNumerals(event)" maxlength="10" name="contactnumber" type="tel" id="contactnumber" ng-model="feedback.contactnumber" autocomplete="on" style=" padding-top:0px;" step="1" />

                            <label for="emailid"></label>

                          </span>

                        </div>

                      </div>

                      <p>&nbsp;</p>

                    </div>

                  </div>

                  <!-- next button  -->

                  <input type="button" name="next" style="background: #4285F4 ; font-size:small; " ng-click="next0()" class="next action-button" value="{{lang.next}}" />

                </fieldset>

                <!-- Registered Mobile Number page end-->





                <!-- PATIENT INFORMATION page start -->

                <fieldset ng-show="step1 == true">

                  <h4><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <!-- Patient Name -->

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="    font-size: 16px;"> {{lang.patientname}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.patient_name_placeholder}}" name="name" maxlength="25" type="text" oninput="restrictToAlphabets(event)" id="emailid" ng-model="feedback.name" onblur="this.value = this.value.toUpperCase();" autocomplete="off" style=" padding-top:0px;" />

                            <label for="emailid"></label>

                          </span>

                        </div>

                      </div>

                      <!-- Patient UHID -->

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="    font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.enter_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" placeholder="Numerical digits only" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>



                      <!-- Select Floor/ Ward -->

                      <!--<div class="col-xs-12 col-sm-12 col-md-12	">-->

                      <!--	<div class="form-group">-->

                      <!--		<span class="" style="font-size:16px;">{{lang.wardtitle}} <sup style="color:red">*</sup></span>-->

                      <!--		<span class="has-float-label">-->

                      <!--			<select class="form-control" ng-model="feedback.ward">-->

                      <!--				<option value="">Select Floor/ Ward</option>-->

                      <!--				<option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}" required>{{x.title}}</option>-->

                      <!--			</select>-->



                      <!--		</span>-->

                      <!--	</div>-->

                      <!--</div>-->

                      <!-- <div class="col-xs-12 col-sm-12 col-md-12	">

                        <div class="form-group">

                          <span class="" style="font-size:16px;">{{lang.wardtitle}} <sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <select class="form-control" ng-model="feedback.ward" ng-change="change_ward()" ng-required="true">

                              <option value="">{{lang.wardtitle}}</option>

                              <option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">

                                {{x.title}}
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

                            <select class="form-control" ng-model="feedback.bedno" ng-required="true">

                              <option value="">{{lang.bedno}}</option>

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

                      <p>&nbsp;</p>

                      <!-- <div class="col-xs-12 col-sm-12 col-md-12	">

                        <div class="form-group">

                          <span class="" style="font-size:16px;">{{lang.speciality}} <sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <select class="form-control" ng-model="feedback.consultant_cat" ng-change="change_ward2()" ng-required="true">

                              <option value="">{{lang.speciality}}</option>

                              <option ng-repeat="x in wardlist.consultant" ng-show="x.title != 'ALL'" value="{{x.title}}">

                                {{x.title}}
                              </option>

                            </select>



                          </span>

                        </div>

                      </div>

                      <p>&nbsp;</p>



                      <div class="col-xs-12 col-sm-12 col-md-12	">

                        <div class="form-group">

                          <span class="" style="font-size:16px;">{{lang.consultant}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <select class="form-control" ng-model="feedback.consultant_doc" ng-required="true">

                              <option value="">{{lang.consultant}}</option>

                              <option ng-repeat="x in pconsultant" value="{{x}}">

                                {{x}}
                              </option>

                            </select>



                          </span>

                        </div>

                      </div>

                      <p>&nbsp;</p> -->

                      <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <span class="addon" style="    font-size: 16px;">{{lang.bedno}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" placeholder="{{lang.bedno}}" type="text" id="bednumber" ng-required="true" ng-model="feedback.bedno" autocomplete="off" style="padding-top:0px;" />
                            <label for="contactnumber"></label>
                          </span>
                        </div>
                      </div> -->


                      <!-- <div class="col-xs-12 col-sm-12 col-md-12">
											<div class="form-group">
											   <span class=""  style="font-size: 16px;">{{lang.email}}</span>
											   <span class="has-float-label">
											   <input class="form-control" type="email" id="contactnumber" ng-model="feedback.email" autocomplete="off" placeholder="{{lang.emailid}}"  style="padding-top:0px;"  />
											   <label for="contactnumber"></label>
											   </span>
											</div>
										 </div>
										  -->
                      <!-- Mobile No -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="display: none;">

                        <div class="form-group">

                          <span class="addon" style="    font-size: 16px;">{{lang.mobileno}}</span>

                          <span class="has-float-label">

                            <input class="form-control" type="tel" maxlength="10" id="contactnumber" ng-model="feedback.contactnumber" style="padding-top:0px;" autocomplete="off" placeholder="{{lang.mobile_placeholder}}" step="1" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                    </div>

                  </div>

                  <!-- next button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;" ng-click="prev0()" value="{{lang.previous}}" />

                  <input type="button" name="next" ng-click="next1()" style="background: #4285F4 ; font-size:small; ;" class="next action-button" value="{{lang.next}}" />

                </fieldset>

                <!-- PATIENT INFORMATION page end -->



                <fieldset ng-show="step2 == true">

                  <div class="form-card">

                    <!--INPATIENT FEEDBACK FORM page start -->





                    <h3 class="sectiondivision" style="font-weight:bold;" ng-show="feedback.section == 'IP'">

                      {{lang.pagetitle}}
                    </h3>

                    <p style="margin:0px;font-size: 18px;">{{lang.gustname}} {{feedback.name}},</p>

                    <p style="margin:0px;font-size: 18px;">{{lang.gustmessage}} </p>



                    <!--this div will repeat  -->

                    <div ng-repeat="x in questioset">

                      <div class="setsection">



                        <!--"Admission Experience" in three language start -->

                        <h3 class="sectiondivision" ng-show="typel != 'lang2' && typel != 'lang3'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.category}}</h3>

                        <h3 class="sectiondivision" ng-show="typel == 'lang2'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.categoryk}}</h3>

                        <h3 class="sectiondivision" ng-show="typel == 'lang3'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.categorym}}</h3>

                        <!--"Admission Experience" in three language end -->





                        <div class="questionset" ng-repeat="q in x.question">



                          <!--this div contain one question but in three languages---- start-->

                          <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">

                            <p style="font-size:18px;margin-top:12px;" ng-show="typel != 'lang2' && typel != 'lang3'">

                              {{q.question}}
                            </p>

                            <p style="font-size:18px;margin-top:12px;" ng-show="typel == 'lang2'">{{q.questionk}}</p>

                            <p style="font-size:18px;margin-top:12px;" ng-show="typel == 'lang3'">{{q.questionm}}</p>

                          </div>

                          <!--this div contain one question but in three languages---- end-->





                          <!--emoji section start -->

                          <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">

                            <ul class="modulelist">

                              <li ng-click="questionvalueset(1,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 1" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/unhappy_plus_grey.png" class="img-responsive img-centre">

                                <p style=" margin-top: 5px;">{{lang.worst}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 1" ng-show="prompt_vpoor_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating1.png" class="img-responsive img-centre">

                                <p style=" margin-top: 5px;">{{lang.worst}}</p>

                              </li>



                              <li ng-click="questionvalueset(2,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 2" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/unhappy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.poor}}

                                </p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 2" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating2.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.poor}}

                                </p>

                              </li>



                              <li ng-click="questionvalueset(3,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 3" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/medium_happy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.average}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 3" ng-show="prompt_neutral_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating3.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.average}}</p>

                              </li>





                              <li ng-click="questionvalueset(4,q.shortkey,q)" ng-show="q.valuetext == 0 || q.valuetext != 4" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/happy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.good}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 4" ng-show="prompt_excellent_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating4.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.good}}</p>

                              </li>



                              <li ng-click="questionvalueset(5,q.shortkey,q)" ng-show="q.valuetext == 0 || q.valuetext != 5" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/happy_plus_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.excellent}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 5" ng-show="prompt_definite_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating5.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.excellent}}</p>

                              </li>

                            </ul>

                          </div>

                          <!--emoji section ends -->







                          <div class="col-xs-12 col-sm-12 col-md-12 errorsection text-left">

                            <span class="has-float-label" ng-show="x.errortitle == true">

                              <p style="font-weight:bold;" class="sectionpagere">{{lang.telluswrong}}</p>

                              <div class="form-check" ng-repeat="z in q.negative">

                                <input class="form-check-input" style="width:20px; height:20px; margin: 0px -17px 0" type="checkbox" ng-model="feedback.reasonSet[q.type][z.shortkey]">

                                <label class="form-check-label" for="flexCheckChecked{{z.id}}" style="  margin-left:12px; font-size:16px;  vertical-align: super; margin-top: -3px">

                                  <span ng-show="typel != 'lang2' && typel != 'lang3'"> {{z.question}} </span>

                                  <span ng-show="typel == 'lang2'">{{z.questionk}}</span>
                                  <span ng-show="typel == 'lang3'">{{z.questionm}}</span>
                                </label>




                              </div>

                              <input class="form-control " placeholder="{{lang.optional}}" id="diagnosticComment" ng-model="feedback.commentSet[q.type][q.type]" ng-change="setthevaluefeedback(x.question,this.value)" style="display: table;margin:0 auto;"></br>



                            </span>

                          </div>



                        </div>

                      </div>

                    </div>

                  </div>

                  <!-- div repeatation end here -->









                  <!-- previous button and next button -->

                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;" ng-click="prev1()" value="{{lang.previous}}" />

                  <input type="button" name="next" class="next  action-button" ng-click="next2()" style="background: #4285F4 ; font-size:small; " value="{{lang.next}}" />

                </fieldset>

                <!-- INPATIENT FEEDBACK FORM page end -->





                <!-- Promoters,Detractors and Passives-------  deciding page start -->

                <fieldset ng-show="step3 == true">

                  <div class="form-card">

                    <!-- On a scale from 0-10, how likely are you to recommend this hospital to your friends or family members?----this message will show-->

                    <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">

                      <p style="font-size:18px;margin-top:12px;"><b>{{lang.recommendationmessage}}</b></p>

                    </div>

                    <!-- 0-10 scale display start -->

                    <div class="container">

                      <div class="row">

                        <div class="rating">

                          <input type="radio" id="star10" name="rating" ng-model="recommend1_definite_grey" value="10" />

                          <label for="star10" class="star10" title="Rocks!">10</label>

                          <input type="radio" id="star9" name="rating" ng-model="recommend1_definite_grey" value="9" />

                          <label for="star9" class="star9" title="Rocks!">9</label>

                          <input type="radio" id="star8" 8name="rating" ng-model="recommend1_definite_grey" value="8" />

                          <label for="star8" class="star8" title="Pretty good">8</label>

                          <input type="radio" id="star7" name="rating" ng-model="recommend1_definite_grey" value="7" />

                          <label for="star7" class="star7" title="Pretty good">7</label>

                          <input type="radio" id="star6" name="rating" ng-model="recommend1_definite_grey" value="6" />

                          <label for="star6" class="star6" title="Meh">6</label>

                          <input type="radio" id="star5" name="rating" ng-model="recommend1_definite_grey" value="5" />

                          <label for="star5" class="star5" title="Meh">5</label>

                          <input type="radio" id="star4" name="rating" ng-model="recommend1_definite_grey" value="4" />

                          <label for="star4" class="star4" title="Kinda bad">4</label>

                          <input type="radio" id="star3" name="rating" ng-model="recommend1_definite_grey" value="3" />

                          <label for="star3" class="star3" title="Kinda bad">3</label>

                          <input type="radio" id="star2" name="rating" ng-model="recommend1_definite_grey" value="2" />

                          <label for="star2" class="star2" title="Sucks big tim">2</label>

                          <input type="radio" id="star1" name="rating" ng-model="recommend1_definite_grey" value="1" />

                          <label for="star1" class="star1" title="Sucks big time">1</label>

                          <input type="radio" id="star0" name="rating" ng-model="recommend1_definite_grey" value="0" />

                          <label for="star0" class="star0" title="Sucks big time">0</label>

                        </div>

                        <ul class="likemessage">

                          <li style="text-align:left;">NOT AT ALL <br />LIKELY</li>

                          <li style="text-align:right;">EXTREMELY <br />LIKELY</li>



                        </ul>

                      </div>

                    </div>

                    <!-- 0-10 scale display end -->
                    <div>
                      <input type="text" id="npsdtractor" ng-model="feedback.detractorcomment" style="display:none;" placeholder="{{lang.detractor}}">
                      <input type="text" id="npspassive" ng-model="feedback.passivecomment" style="display:none;" placeholder="Passive feedback...">
                      <input type="text" id="npspromoter" ng-model="feedback.promotercomment" style="display:none;" placeholder="Promoter feedback...">
                    </div>



                    <!-- Your reason for selecting our hospital----------message will show -->

                    <div class="col-xs-12 col-sm-12 col-md-12" style=" margin-top:3%;   margin-bottom: 4%;">

                      <!-- <h3 class="sectiondivision" style="text-align: left;margin-top:0px; font-size:18px; padding-top:36px;"><b>

                          Reason for discharge?</b></h3>
              

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.reason_for_discharge" value="On advice by doctor" id="location" type="radio" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="location">On advice by doctor</span>

                      </div>




                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.reason_for_discharge" id="spec_service"  value="Permanent cure impossible" type="radio" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="spec_service">Permanent cure impossible

                        </span>

                      </div>



               

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.reason_for_discharge" id="referred" value="Financial Reason" type="radio" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="referred">Financial Reason</span>

                      </div>



                    

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.reason_for_discharge" id="friend" value="Need Higher Centre" type="radio" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="friend">Need Higher Centre</span>

                      </div>



                  

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.reason_for_discharge" id="previous" type="radio" value="Not satisfied with the treatment received" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="previous">Not satisfied with the treatment received</span>

                      </div> -->


                      <h3 class="sectiondivision" style="text-align: left;margin-top:0px; font-size:18px; padding-top:36px;"><b>
                          {{lang.yourreason}} </b></h3>
                      <!-- Location / Proximity -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.location" id="location" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="location"> {{lang.location}}</span>

                      </div>



                      <!-- Specific Services offered -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.specificservice" id="spec_service" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="spec_service">{{lang.specificservices}}

                        </span>

                      </div>



                      <!-- Referred by doctor -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.referred" id="referred" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="referred">{{lang.referredbydoc}} </span>

                      </div>



                      <!-- Friend/ Family recommendation -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.friend" id="friend" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="friend"> {{lang.friendfamily}}</span>

                      </div>



                      <!-- Previous Experience -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.previous" id="previous" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="previous"> {{lang.previousexp}} </span>

                      </div>



                      <!-- Insurance facilities -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.docAvailability" id="doctor" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="doctor"> {{lang.yourdoctor}} </span>

                      </div>



                      <!-- Company Recommendation/ Empanelment -->

                      <div class="col-xs-12 col-md-12 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.companyRecommend" id="company" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="company">{{lang.companyreco}}</span>

                      </div>



                      <!-- Print/ Online Media -->

                      <div class="col-xs-12 col-md-6 col-sm-6" style="margin-left: -10px;">

                        <input ng-model="feedback.otherReason" id="company" type="checkbox" style="width: 18px;height: 18px;" />

                        <span style="font-size:18px;margin-left:2%;" for="company">{{lang.other}} </span>

                      </div>




                      <br>

                      <!-- Staff Recognition: -->

                      <h3 class="sectiondivision" style="text-align: left;margin-top:0px; padding-top:0px; font-size:18px; margin-bottom:5px; font-weight:bolder;">

                        {{lang.stafrecognition}}
                      </h3>



                      <!-- Please help us recognize a staff member of our hospital who may have performed services beyond your expectations. -->

                      <p style="font-size:18px;margin-top:0%;margin-bottom:5%;"> {{lang.recognizeateam}}</p>



                      <!-- Staff name -->

                      <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-6">

                          <div class="form-group input-group">

                            <span class="input-group-addon">{{lang.staffname}}</span>

                            <span class="has-float-label">

                              <input class="form-control" type="text" ng-model="feedback.staffname" style=" height: 22px; margin-left:5px ; margin-top:5px;" />


                            </span>

                          </div>

                        </div>

                      </div>


                      <!-- Other feedbacks/ suggestions: div start-->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right:0px;padding-left:0px;">

                        <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">

                          <p style="font-size:18px;margin-top:12px;"><b>{{lang.feedbacksuggestion}}</b></p>

                          <textarea style="border: 2px solid #ccc;" class="form-control" ng-model="feedback.suggestionText" rows="5" id="comment"></textarea>

                        </div>

                      </div>

                      <!-- Other feedbacks/ suggestions: div end-->

                    </div>


                  </div>
                  <br>



                  <!-- previous button and submit button -->

                  <input type="button" name="previous" class="previous action-button-previous" style="font-size:small;" ng-click="prev2()" value="{{lang.previous}}" />

                  <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />

                  <!-- <img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true"> -->

                </fieldset>

                <!-- Promoters,Detractors and Passives-------  deciding page end -->





                <!-- Thank you page start -->

                <fieldset ng-show="step4 == true">

                  <div class="form-card">





                    <!-- happy customer code start		 -->
                    <div class="row justify-content-center"
                    ng-show="positivefeedback == true && (feedback.overallScore > psat_score || feedback.recommend1Score >= nps_score)">

                      <div class="col-12 text-center">
                        <br>
                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>
                        <img src="dist/happy100x100.png"> <br>
                        <p style="text-align:center; margin-top: 15px; font-weight: 300;" class="lead">
                          {{lang.happythankyoumessage}}
                        </p><br>
                        <p style="text-align:center;">
                          <a ng-href="https://{{ getReviewLink() }}" target="_blank">
                            <img style="width:268px" src="dist/ggg.jpg">
                          </a>
                        </p>
                        <p style="text-align:center;">
                          <a ng-href="https://{{ getReviewLink() }}" target="_blank" class="btn btn-primary">
                            Review Us Now
                          </a>
                        </p>
                      </div>

                    </div>


                    <!-- happy customer code end		 -->



                    <!-- unhappy customer code start		 -->

                    <div class="row justify-content-center" ng-show="positivefeedback == false || feedback.recommend1Score < recommend1Score || feedback.overallScore < overallScore">

                      <div class="col-12 text-center">

                        <br>

                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2><br>

                        <img src="dist/tick.png"> <br>

                        <p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">

                          {{lang.unhappythankyoumessage}}
                        </p>

                      </div>

                    </div>

                    <!-- unhappy customer code end		 -->

                  </div>

                </fieldset>

                <!-- Thank you page end -->

              </form>

              <!-- form end -->

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</body>

<!-- body part start -->





<!-- css code start  -->

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

  .dropdown-menu {

    /* width: 70px; */

    position: absolute;

    left: auto;

    right: 0px;

    padding: 0px;

    width: 100%;

    list-style: none;

  }



  ul.dropdown-menu.show li a {

    padding: 7px 22px;

    /* background: #007bff; */

    width: 100%;

    display: block;

  }



  .dropdown-toggle {

    font-size: 18px;

    color: #fff;

    margin-top: -16px;

    text-transform: capitalize;


  }




  .image-container {

    display: flex;

    flex-wrap: wrap;

    padding: 1%;

  }



  .image-container img {

    width: 20%;

    height: auto;

    object-fit: cover;

  }





  #text-box input {

    background: none;

    border-radius: 0px;

    width: 100%;

    border-bottom: 1px solid;

    border-top: none;

    border-left: none;

    border-right: none;

    border-color: #6c757d;

    box-sizing: border-box;

  }



  ::placeholder {

    font-size: 15px;

  }
</style>

<!-- css code end  -->





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
</script>

<!-- script code end  -->



</html>
