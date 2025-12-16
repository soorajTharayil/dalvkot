<!DOCTYPE html>

<html lang="en">



<!-- head part start -->

<!-- IP FEEDBACK INDEX PAGE -->



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

    <span style="margin-top: 25px;    font-size: 17px;    font-weight: bold; float:right;  ">

      <div class="dropdown-toggle" data-toggle="dropdown" style="   font-weight: bold; float:right;">

        <i class="fa fa-language "></i>

        <span ng-show="'english' == typel">தமிழ்</span>

        <!-- <span ng-show="'lang2' == typel">ಕನ್ನಡ</span> -->

        <span ng-show="'lang3' == typel">English</span>

        </a>

        <ul class="dropdown-menu" style="width: 70px;">



          <li>

            <a href="javascript:void(0)" id="englishid" class="nav-link  mr-4" ng-click="language('english')">English</a>

          </li>

          <!-- <li>

            <a href="javascript:void(0)" id="lang2" class="nav-link mr-4" ng-click="language('lang2')">ಕನ್ನಡ</a>



          </li> -->

          <li>

            <a href="javascript:void(0)" id="lang3" class="nav-link mr-4" ng-click="language('lang3')">தமிழ்</a>



          </li>

        </ul>

      </div>

    </span>

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

                            <input class="form-control" placeholder="{{lang.reg_mobile_message_placeholder}}" name="contactnumber" type="tel" maxlength="10" id="contactnumber" ng-model="feedback.contactnumber" autocomplete="on" pattern="[0-9]{10}" style=" padding-top:0px;" step="1" />

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

                            <input class="form-control" placeholder="{{lang.patient_name_placeholder}}" name="name" maxlength="20" type="text" oninput="restrictToAlphabets(event)" id="emailid" ng-model="feedback.name" onblur="this.value = this.value.toUpperCase();" autocomplete="off" style=" padding-top:0px;" />

                            <label for="emailid"></label>

                          </span>

                        </div>

                      </div>

                      <!-- Patient UHID -->

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="    font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.enter_placeholder}}" maxlength="10" type="text" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" placeholder="Numerical digits only" style="padding-top:0px;" />

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

                      <div class="col-xs-12 col-sm-12 col-md-12	">

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



                      <div class="col-xs-12 col-sm-12 col-md-12	" style="display: none;">

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

                      </div>

                      <p>&nbsp;</p>



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

                    <!-- <br>
                    <div>
                      <div class="col-xs-12 col-sm-12 col-md-12	" ng-if="pinfo_online == false">

                        <div class="form-group">

                          <span class="" style="font-size:16px;">{{lang.wardtitle}} <sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <select class="form-control" ng-model="feedback.ward" ng-change="change_ward()">

                              <option value="">{{lang.wardtitle}}</option>

                              <option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}">

                                {{x.title}}
                              </option>

                            </select>



                          </span>

                        </div>

                      </div>



                      <div class="col-xs-12 col-sm-12 col-md-12	" ng-if="pinfo_online == false">

                        <div class="form-group">

                          <span class="" style="font-size:16px;">{{lang.bedno}} <sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <select class="form-control" ng-model="feedback.bedno">

                              <option value="">{{lang.bedno}}</option>

                              <option ng-repeat="x in bed_no" value="{{x}}">

                                {{x}}
                              </option>

                            </select>



                          </span>

                        </div>

                      </div>

                    </div> -->





                    <!--this div will repeat  -->

                    <div ng-repeat="x in questioset">

                      <div class="setsection">



                        <!--"Admission Experience" in three language start -->
                        <!-- 
                        <h3 class="sectiondivision" ng-show="typel != 'lang2' && typel != 'lang3'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.category}}</h3>

                        <h3 class="sectiondivision" ng-show="typel == 'lang2'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.categoryk}}</h3>

                        <h3 class="sectiondivision" ng-show="typel == 'lang3'" style="text-align: center;     margin-top: 10px;font-weight:bold;">{{x.categorym}}</h3> -->

                        <!--"Admission Experience" in three language end -->





                        <div class="questionset" ng-repeat="q in x.question">



                          <!--this div contain one question but in three languages---- start-->

                          <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">
                            <b>
                              <p style="font-size:18px;margin-top:12px;" ng-show="typel != 'lang2' && typel != 'lang3'">

                                {{q.question}}
                              </p>

                              <p style="font-size:18px;margin-top:12px;" ng-show="typel == 'lang2'">{{q.questionk}}</p>

                              <p style="font-size:18px;margin-top:12px;" ng-show="typel == 'lang3'">{{q.questionm}}</p>
                            </b>
                          </div>

                          <!--this div contain one question but in three languages---- end-->





                          <!--emoji section start -->

                          <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px; display:none">

                            <ul class="modulelist">

                              <li ng-click="questionvalueset(1,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 1" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/unhappy_plus_grey.png" class="img-responsive img-centre">

                                <p style=" margin-top: 5px;">{{lang.poor}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 1" ng-show="prompt_vpoor_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating1.png" class="img-responsive img-centre">

                                <p style=" margin-top: 5px;">{{lang.poor}}</p>

                              </li>



                              <li ng-click="questionvalueset(2,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 2" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/unhappy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.average}}

                                </p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 2" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating2.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.average}}

                                </p>

                              </li>



                              <li ng-click="questionvalueset(3,q.shortkey,q)" ng-show="q.valuetext == 0  || q.valuetext != 3" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/medium_happy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.good}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 3" ng-show="prompt_neutral_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating3.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.good}}</p>

                              </li>





                              <li ng-click="questionvalueset(4,q.shortkey,q)" ng-show="q.valuetext == 0 || q.valuetext != 4" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/happy_grey.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.verygood}}</p>

                              </li>

                              <li ng-click="questionvalueset(0,q.shortkey,q)" ng-show="q.valuetext == 4" ng-show="prompt_excellent_grey == true" class="text-center" style="width:20%;font-size: 14px;">

                                <img src="dist/img/Rating4.png" class="img-responsive img-centre">

                                <p style="margin-top:4px;">{{lang.verygood}}</p>

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

                            <span class="has-float-label">


                              <!-- <div class="form-check" ng-repeat="z in q.negative">

                                <input class="form-check-input" style="width:20px; height:20px; margin: 0px -17px 0" type="checkbox"  ng-model="feedback.reason[z.marks]">

                                <label class="form-check-label" for="flexCheckChecked{{z.id}}" style="  margin-left:12px; font-size:16px;  vertical-align: super; margin-top: -3px">

                                  <span ng-show="typel != 'lang2' && typel != 'lang3'"> {{z.question}} </span>

                                  <span ng-show="typel == 'lang2'">{{z.questionk}}</span>
                                  <span ng-show="typel == 'lang3'">{{z.questionm}}</span>
                                </label>

                              </div> -->


                              <!-- <div ng-repeat="z in q.negative">
                                  <input class="form-check-input" style="width: 20px; height: 20px; margin: 0px -17px 0" type="radio" name="{{z.title}}" ng-model="selectedNegativeOption" ng-value="z.id" ng-click="handleRadioSelection(z.id,z.marks)" />
                                  <label class="form-check-label" for="flexCheckChecked{{z.id}}" style="margin-left: 12px; font-size: 16px; vertical-align: super; margin-top: -3px">
                                    <span ng-show="typel !== 'lang2' && typel !== 'lang3'">{{z.question}}</span>
                                    <span ng-show="typel === 'lang2'">{{z.questionk}}</span>
                                    <span ng-show="typel === 'lang3'">{{z.questionm}}</span>
                                  </label>
                                </div>
                             -->
                              <div ng-repeat="z in q.negative">
                                <input class="form-check-input" style="width: 20px; height: 20px; margin: 0px -17px 0" type="radio" name="{{z.title}}" ng-model="feedback.checboxset[q.type]" ng-value="z.marks" ng-click="handleRadioSelection(q.type,z.shortkey,z.marks)" />
                                <label class="form-check-label" for="flexCheckChecked{{z.id}}" style="margin-left: 12px; font-size: 16px; vertical-align: super; margin-top: -3px">
                                  <span ng-show="typel !== 'lang2' && typel !== 'lang3'">{{z.question}}</span>
                                  <span ng-show="typel === 'lang2'">{{z.questionk}}</span>
                                  <span ng-show="typel === 'lang3'">{{z.questionm}}</span>
                                </label>
                              </div>








                              <input class="form-control " placeholder="{{lang.optional}}" id="diagnosticComment" ng-model="feedback.comment[q.type]" ng-change="setthevaluefeedback(x.question,this.value)" style="display: table;margin:0 auto;"></br>

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

                          <label for="star10" class="star10" title="Rocks!">100</label>

                          <input type="radio" id="star9" name="rating" ng-model="recommend1_definite_grey" value="9" />

                          <label for="star9" class="star9" title="Rocks!">90</label>

                          <input type="radio" id="star8" 8name="rating" ng-model="recommend1_definite_grey" value="8" />

                          <label for="star8" class="star8" title="Pretty good">80</label>

                          <input type="radio" id="star7" name="rating" ng-model="recommend1_definite_grey" value="7" />

                          <label for="star7" class="star7" title="Pretty good">70</label>

                          <input type="radio" id="star6" name="rating" ng-model="recommend1_definite_grey" value="6" />

                          <label for="star6" class="star6" title="Meh">60</label>

                          <input type="radio" id="star5" name="rating" ng-model="recommend1_definite_grey" value="5" />

                          <label for="star5" class="star5" title="Meh">50</label>

                          <input type="radio" id="star4" name="rating" ng-model="recommend1_definite_grey" value="4" />

                          <label for="star4" class="star4" title="Kinda bad">40</label>

                          <input type="radio" id="star3" name="rating" ng-model="recommend1_definite_grey" value="3" />

                          <label for="star3" class="star3" title="Kinda bad">30</label>

                          <input type="radio" id="star2" name="rating" ng-model="recommend1_definite_grey" value="2" />

                          <label for="star2" class="star2" title="Sucks big tim">20</label>

                          <input type="radio" id="star1" name="rating" ng-model="recommend1_definite_grey" value="1" />

                          <label for="star1" class="star1" title="Sucks big time">10</label>

                          <input type="radio" id="star0" name="rating" ng-model="recommend1_definite_grey" value="0" />

                          <label for="star0" class="star0" title="Sucks big time">0</label>

                        </div>

                        <ul class="likemessage">

                          <li style="text-align:left;">THE BEST HEALTH <br />YOU CAN IMAGINE</li>

                          <li style="text-align:right;">THE WORST HEALTH <br />YOU CAN IMAGINE</li>



                        </ul>

                      </div>

                    </div>

                    <!-- 0-10 scale display end -->
                    <!-- <div>
                      <input type="text" id="npsdtractor" ng-model="feedback.detractorcomment" style="display:none;" placeholder="{{lang.detractor}}">
                      <input type="text" id="npspassive" ng-model="feedback.passivecomment" style="display:none;" placeholder="Passive feedback...">
                      <input type="text" id="npspromoter" ng-model="feedback.promotercomment" style="display:none;" placeholder="Promoter feedback...">
                    </div> -->








                    <!-- Other feedbacks/ suggestions: div start-->

                    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right:0px;padding-left:0px;">

                      <div class="col-xs-12 col-sm-12  col-md-12" style="padding-right:0px;padding-left:0px;">

                        <p style="font-size:18px;margin-top:12px;"><b>{{lang.feedbacksuggestion}}</b></p>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div style="margin-top:2%;">

                          <span class="has-float-label">

                            <textarea style="border: 2px solid #ccc;" class="form-control" ng-model="feedback.suggestionText" rows="5" id="comment"></textarea>

                          </span>

                        </div>

                      </div>

                    </div>

                    <!-- Other feedbacks/ suggestions: div end-->

                  </div>

                  <br>



                  <!-- previous button and submit button -->

                  <input type="button" name="previous" class="previous action-button-previous" style="font-size:small;" ng-click="prev2()" value="{{lang.previous}}" />

                  <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />

                  <img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true">

                </fieldset>

                <!-- Promoters,Detractors and Passives-------  deciding page end -->





                <!-- Thank you page start -->

                <fieldset ng-show="step4 == true">

                  <div class="form-card">





                    <!-- happy customer code start		 -->

                    <!-- TODO : How to make total score dynamic -->
                    <div class="row justify-content-center" ng-show="totalSelectedMarks <= 6">

                      <div class="col-12 text-center">

                        <br>

                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>

                        <img src="dist/tick.png"> <br>

                        <p style="text-align:center; margin-top: 15px; font-weight: 300;" class="lead">

                          {{lang.happythankyoumessage}}
                        </p><br>

                        <p style="text-align:center;"><a href="{{setting_data.google_review_link}}" target="_blank"><img style="width:268px" src="dist/ggg.jpg"></a></p>

                      </div>

                    </div>

                    <!-- happy customer code end		 -->


                    <!-- passive customer code start		 -->

                    <div class="row justify-content-center" ng-show="totalSelectedMarks > 6 && totalSelectedMarks <= 12">

                      <div class="col-12 text-center">

                        <br>

                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>

                        <img src="dist/tick.png"> <br>

                        <p style="text-align:center; margin-top: 15px; font-weight: 300;" class="lead">

                          {{lang.passive}}
                        </p>

                        <br>
                        <a id="refreshBtn" class="btn btn-danger" style="padding: 15px; border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.5); background-color: #DB6B97; border: none;" href="https://www.indianahospital.in/appointments/">
                          {{lang.booking}}
                        </a>
                      </div>

                    </div>

                    <!-- happy customer code end		 -->



                    <!-- unhappy customer code start		 -->

                    <div class="row justify-content-center" ng-show="totalSelectedMarks >= 13">

                      <div class="col-12 text-center">

                        <br>

                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2><br>

                        <img src="dist/tick.png"> <br>

                        <p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">

                          {{lang.unhappythankyoumessage}}
                        </p>
                        <br>
                        <a id="refreshBtn" class="btn btn-danger" style="padding: 15px; border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.5); background-color: #DB6B97; border: none;" href="https://www.indianahospital.in/appointments/">
                          {{lang.booking}}
                        </a>
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
<style>
  /* Hide the browser's default checkbox */
  .container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  /* Create a custom checkbox */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
  }

  /* On mouse-over, add a grey background color */
  .container:hover input~.checkmark {
    background-color: #ccc;
  }

  /* When the checkbox is checked, add a blue background */
  .container input:checked~.checkmark {
    background-color: #2196F3;
  }

  /* Create the checkmark/indicator (hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the checkmark when checked */
  .container input:checked~.checkmark:after {
    display: block;
  }

  /* Style the checkmark/indicator */
  .container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
</style>



<!-- css code start  -->

<style>
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