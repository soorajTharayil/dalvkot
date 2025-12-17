<!DOCTYPE html>

<html lang="en">



<!-- head part start -->

<!-- IP FEEDBACK INDEX PAGE -->



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

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

  <script src="app_mock_drill_audit.js?<?php echo time(); ?>"></script>

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
      <!--  {{type2}}-->
      <!--  <i class="fa fa-language" aria-hidden="true"></i>-->
      <!--</button>-->
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

                <!-- PATIENT INFORMATION page start -->
                <fieldset ng-show="step0 == true">

                  <h4 style="font-size: 22px;"><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <!-- Audit Type -->
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin: 0px 0px 0 0px;">
                        <!-- <h6 style="font-size: 18px;margin-left:1px;margin-top:0px;"><b>Audit Details</b></h6> -->
                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 0px;">{{lang.name}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" type="text" ng-model="feedback.audit_type" placeholder="Enter audit name" ng-required="true" style="margin-top: 0px;" disabled />
                          </span>
                        </div>



                        <!-- Date of Audit -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 6px;">
                            {{lang.dtandtym}}<sup style="color:red">*</sup><br>
                            <p style="font-size: 14px; margin: 4px 0 0 0; color:#6c757d;">
                              {{lang.format}}
                            </p>
                          </span>

                          <!-- Input -->
                          <div style="position: relative; width: 100%;">
                            <input class="form-control" ng-model="feedback.audit_date" type="datetime-local" id="formula_para1_hr" ng-required="true" min="{{minDateTime}}" max="{{todayDateTime}}"
                              autocomplete="off" onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()"
                              style="padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; margin-top: 8px; width: 100%;" />
                          </div>
                        </div>



                        <!-- Audit By -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 2px;">{{lang.audby}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" type="text" ng-model="feedback.audit_by" placeholder="Enter auditor name" ng-required="true" style="margin-top: 2px;" />
                          </span>
                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.location}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.location_name_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.location" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;">{{lang.department}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <select class="form-control" id="department" ng-required="true" ng-model="feedback.checklist" autocomplete="off" style="padding-top:0px;margin-top: 5px;">
                              <option value="" disabled selected>Select Hospital Emergency Code</option>
                              <option ng-repeat="x in emergency_code.emergency_code" ng-show="x.title != 'ALL'" value="{{x.title}}">{{x.title}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div>



                      <!-- <p>&nbsp;</p> -->

                      <div class="col-xs-12 col-sm-12 col-md-12" ng-show="feedback.checklist === 'Code Red'" style="margin-left:7px;">
                        <div class="form-group">


                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px;margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para1}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para2}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr2" max="{{todayDateTime}}" type="datetime-local" id="formula_para2_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group" style="margin-left: -20px;margin-top: 20px;">
                              <span class="addon" style="font-size: 18px;">{{lang.number_of_code}}<sup style="color:red">*</sup></span>
                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.number_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.number_of_code" autocomplete="off" style="padding-top:0px;" />
                                <label for="contactnumber"></label>

                              </span>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;margin-top: -15px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.yel2}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr3" max="{{todayDateTime}}" type="datetime-local" id="formula_para3_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group" style="margin-left: -20px;margin-top: 20px;">
                              <span class="addon" style="font-size: 18px;">{{lang.respondents}}<sup style="color:red">*</sup></span>
                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.number_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.respondents" autocomplete="off" style="padding-top:0px;" />
                                <label for="contactnumber"></label>

                              </span>
                            </div>
                          </div>


                          <div style="margin-top: 28px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.situation}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.situation" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.situation" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.situation" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.situation_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.fire}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.fire" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.fire" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.fire" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.fire_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.demonstrated}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.demonstrated" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.demonstrated" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.demonstrated" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.demonstrated_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.lift}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.lift_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.doors}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.doors" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.doors" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.doors" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.doors_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.safety}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.safety_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.transportation}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.transportation" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.transportation" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.transportation" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.transportation_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.action}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.action" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.action" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.action" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.action_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.assembly_point}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assembly_point" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assembly_point" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assembly_point" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.assembly_point_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.follow_up}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.follow_up" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.follow_up" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.follow_up" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.follow_up_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para4}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr4" max="{{todayDateTime}}" type="datetime-local" id="formula_para4_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.deviations}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.deviations_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.debrief}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.debrief_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para5}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr5" max="{{todayDateTime}}" type="datetime-local" id="formula_para5_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: -13px; margin-top: 0px;">
                            <p style="font-size: 18px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                            <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                            <div style="margin-top: 8px; text-align: left; margin-left:-6px;">
                              <label for="fileInput" class="custom-file-upload" style="font-weight: bold;font-size:18px;">
                                Upload file( Evidences, proofs, etc)
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
                            </div>
                          </div>


                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" ng-show="feedback.checklist === 'Code Pink'" style="margin-left:7px;">
                        <div class="form-group">


                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px;margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para6}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para7}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr2" type="datetime-local" id="formula_para2_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group" style="margin-left: -20px;margin-top: 20px;">
                              <span class="addon" style="font-size: 18px;">{{lang.number_of_code}}<sup style="color:red">*</sup></span>
                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.number_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.number_of_code" autocomplete="off" style="padding-top:0px;" />
                                <label for="contactnumber"></label>

                              </span>
                            </div>
                          </div>



                          <div style="margin-top: 28px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.child_announce}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.child_announce" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.child_announce" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.child_announce" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.child_announce_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.code_pink_team}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.code_pink_team" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.code_pink_team" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.code_pink_team" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.code_pink_team_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.exit_points}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.exit_points" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.exit_points" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.exit_points" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.exit_points_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.security_guard}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.security_guard" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.security_guard" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.security_guard" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.security_guard_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.counseling_to_mother}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.counseling_to_mother" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.counseling_to_mother" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.counseling_to_mother" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.counseling_to_mother_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.searched}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.searched" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.searched" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.searched" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.searched_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.suspicious}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.suspicious" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.suspicious" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.suspicious" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.suspicious_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.cctv}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cctv" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cctv" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cctv" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.cctv_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.handing}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handing" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handing" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handing" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.handing_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.events}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.events" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.events" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.events" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.events_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para8}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr4" max="{{todayDateTime}}" type="datetime-local" id="formula_para4_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.deviations}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.deviations_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.debrief_p}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief_p" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief_p" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debrief_p" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.debrief_p_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para9}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr5" max="{{todayDateTime}}" type="datetime-local" id="formula_para5_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>

                            </div>

                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: -13px; margin-top: 0px;">
                            <p style="font-size: 18px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                            <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                            <div style="margin-top: 8px; text-align: left; margin-left:-6px;">
                              <label for="fileInput" class="custom-file-upload" style="font-weight: bold;font-size:18px;">
                                Upload file( Evidences, proofs, etc)
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
                            </div>
                          </div>


                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" ng-show="feedback.checklist === 'Code Blue'" style="margin-left:7px;">
                        <div class="form-group">


                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px;margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para1}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para2}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr2" max="{{todayDateTime}}" type="datetime-local" id="formula_para2_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group" style="margin-left: -20px;margin-top: 20px;">
                              <span class="addon" style="font-size: 18px;">{{lang.number_of_code}}<sup style="color:red">*</sup></span>
                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.number_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.number_of_code" autocomplete="off" style="padding-top:0px;" />
                                <label for="contactnumber"></label>

                              </span>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;margin-top: -15px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para3}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr3" max="{{todayDateTime}}" type="datetime-local" id="formula_para3_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group" style="margin-left: -20px;margin-top: 20px;">
                              <span class="addon" style="font-size: 18px;">{{lang.respondents}}<sup style="color:red">*</sup></span>
                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.number_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.respondents" autocomplete="off" style="padding-top:0px;" />
                                <label for="contactnumber"></label>

                              </span>
                            </div>
                          </div>


                          <div style="margin-top: 28px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.emergency}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.emergency" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.emergency" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.emergency" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.emergency_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.identified}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identified" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identified" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identified" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.identified_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.response}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.response" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.response" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.response" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.response_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.circulation}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.circulation" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.circulation" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.circulation" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.circulation_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.airway}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.airway" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.airway" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.airway" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.airway_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.breathing}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.breathing" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.breathing" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.breathing" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.breathing_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.cpr}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cpr" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cpr" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cpr" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.cpr_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.compressions}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.compressions" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.compressions" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.compressions" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.compressions_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.rescue}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.rescue" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.rescue" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.rescue" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.rescue_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.mode}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mode" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mode" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mode" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.mode_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.safety_measure}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety_measure" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety_measure" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.safety_measure" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.safety_measure_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.lift_avail}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift_avail" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift_avail" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lift_avail" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.lift_avail_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.shift_ccu}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shift_ccu" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shift_ccu" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shift_ccu" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.shift_ccu_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para10}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr4" max="{{todayDateTime}}" type="datetime-local" id="formula_para4_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.medical}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medical" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medical" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medical" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.medical_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.adequate}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.adequate_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.condition}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.condition" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.condition" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.condition" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.condition_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.shock}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shock" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shock" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shock" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.shock" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.shock_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.deviations_c}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations_c" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations_c" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.deviations_c" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.deviations_c_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.repetition}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.repetition" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.repetition" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.repetition" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.repetition_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.debriefed}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debriefed" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debriefed" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.debriefed" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.debriefed_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para11}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr5" max="{{todayDateTime}}" type="datetime-local" id="formula_para5_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: -13px; margin-top: 0px;">
                            <p style="font-size: 18px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                            <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                            <div style="margin-top: 8px; text-align: left; margin-left:-6px;">
                              <label for="fileInput" class="custom-file-upload" style="font-weight: bold;font-size:18px;">
                                Upload file( Evidences, proofs, etc)
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
                            </div>
                          </div>


                        </div>
                      </div>




                      <div class="col-xs-12 col-sm-12 col-md-12" ng-show="feedback.checklist === 'Code Yellow'" style="margin-left:7px;">
                        <div class="form-group">


                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.yel1}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" type="datetime-local" id="formula_para2_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>


                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.formula_para3}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr2" max="{{todayDateTime}}" type="datetime-local" id="formula_para2_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>


                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel3}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell2" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell2" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell2" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell2_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel4}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell3" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell3" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell3" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell3_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel5}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell4" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell4" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell4" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell4_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel6}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell5" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell5" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell5" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell5_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel7}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell6" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell6" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell6" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell6_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel8}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell7" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell7" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell7" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell7_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel9}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell8" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell8" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell8" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell8_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel10}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell9" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell9" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell9" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell9_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel11}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell10" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell10" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell10" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell10_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel12}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell11" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell11" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell11" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell11_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel13}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell12" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell12" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell12" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell12_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel14}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell13" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell13" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell13" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell13_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>


                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel15}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell14" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell14" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell14" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell14_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.yel16}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr3" max="{{todayDateTime}}" type="datetime-local" id="formula_para4_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel17}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell16" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell16" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell16" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell16_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel18}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell17" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell17" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell17" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell17_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel19}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell18" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell18" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell18" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell18_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px; margin-bottom:13px; margin-top: 10px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.yel20}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr4" max="{{todayDateTime}}" type="datetime-local" id="formula_para4_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border:1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel21}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell19" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell19" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell19" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell19_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel22}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell20" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell20" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell20" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell20_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel23}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell21" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell21" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell21" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell21_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel24}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell22" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell22" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell22" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell22_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.yel25}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell23" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell23" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.yell23" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.yell23_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:-21px;margin-bottom:13px; margin-top: 7px;">
                            <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                              <span class="addon" style="font-size: 18px; margin-bottom: -10px;">{{lang.yel26}}<sup style="color:red">*</sup><br>
                                <p style="font-size: 14px;">{{lang.format}}</p>
                              </span>

                              <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                <input class="form-control" ng-model="feedback.initial_assessment_hr5" max="{{todayDateTime}}" type="datetime-local" id="yell31" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                                <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                                  <i class="fa fa-calendar-alt"></i>
                                </span>
                                <label for="para1"></label>
                              </div>
                            </div>
                          </div>

                          
                          <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: -13px; margin-top: 0px;">
                            <p style="font-size: 18px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                            <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                            <div style="margin-top: 8px; text-align: left; margin-left:-6px;">
                              <label for="fileInput" class="custom-file-upload" style="font-weight: bold;font-size:18px;">
                                Upload file( Evidences, proofs, etc)
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
                            </div>
                          </div>


                        </div>
                      </div>



                    </div>

                  </div>

                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;margin-top:35px;" ng-click="prev()" value="{{lang.previous}}" />

                  <div>
                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:12px;margin-top:35px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
                    <img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true">
                  </div>

                </fieldset>
            </div>

          </div>




          <fieldset ng-show="step4 == true">

            <div class="form-card">

              <!-- happy customer code start		 -->

              <!-- <div class="row justify-content-center">

                      <div class="col-12 text-center">

                        <br>

                        <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2> <br>

                        <img src="dist/happy100x100.png"> <br>

                        <p style="text-align:center; margin-top: 15px; font-weight: 300;" class="lead">

                          {{lang.happythankyoumessage}}
                        </p><br>

                        <p style="text-align:center;"><a href="{{setting_data.google_review_link}}" target="_blank"><img style="width:268px" src="dist/ggg.jpg"></a></p>

                      </div>

                    </div> -->

              <!-- happy customer code end		 -->



              <!-- unhappy customer code start		 -->

              <div class="row justify-content-center">

                <div class="col-12 text-center">

                  <br>

                  <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2><br>

                  <img src="dist/tick.png"> <br>

                  <p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">

                    {{lang.unhappythankyoumessage}}
                  </p>
                  <div class="thankyou-buttons" style="margin-top: 40px;">
                    <button type="button" class="btn btn-primary" ng-click="repeatAudit()">
                      🔄 Repeat Audit
                    </button>
                    <a ng-href="/audit_forms?user_id={{user_id}}" class="btn btn-secondary"
                      style="margin-left: 15px;">
                      🏠 Audits Home Page
                    </a>
                  </div>

                </div>

              </div>

              <!-- unhappy customer code end		 -->

            </div>

          </fieldset>







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
  .transparent-placeholder input::placeholder {
    opacity: 0.5;

  }

  textarea {
    transition: height 0.3s ease-in-out;
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
  // This function returns the current month and year in the format 'Month Year'
  function getCurrentMonthYear() {
    const date = new Date();
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const currentMonth = monthNames[date.getMonth()];
    const currentYear = date.getFullYear();
    return `${currentMonth} ${currentYear}`;
  }

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