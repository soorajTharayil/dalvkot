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

  <script src="app_surgical_safety.js?<?php echo time(); ?>"></script>

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

                  <!--<h4><strong>AUDIT & PATIENT INFORMATION</strong></h4>-->
                  <h4 style="font-size:22px;"><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <!-- Audit Type -->
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin: 0px 0px 0 0px;">
                        <h6 style="font-size: 18px;margin-left:1px;margin-top:0px;"><b>Audit Details</b></h6>
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



                        <!-- Audit Short Name -->

                        <!--<div class="form-group">-->
                        <!--  <span class="addon" style="font-size: 18px; margin-bottom: 6px;">{{lang.stname}}</span>-->
                        <!--  <span class="has-float-label" style="margin-top: 8px;">-->
                        <!--    <input class="form-control" type="text" ng-model="feedback.audit_shortname" placeholder="Enter short name" maxlength="30" autocomplete="off" />-->
                        <!--  </span>-->
                        <!--</div>-->

                        <!-- Audit By -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 2px;">{{lang.audby}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" type="text" ng-model="feedback.audit_by" placeholder="Enter auditor name" ng-required="true" style="margin-top: 2px;" />
                          </span>
                        </div>


                        <h6 style="font-size: 18px;margin-left:1px;margin-top:30px;"><b>Patient Information</b></h6>
                        <!-- MID No -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;margin-bottom: 6px; ">Patient UHID<sup style="color:red">*</sup></span>
                          <span class="has-float-label" style="margin-top: 12px;">
                            <input type="text" class="form-control" maxlength="20" ng-model="feedback.mid_no" placeholder="Enter Patient UHID" autocomplete="off" />
                          </span>
                        </div>


                        <!-- Patient Name -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;margin-bottom: 6px;">{{lang.patname}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label" style="margin-top: 8px;">
                            <input type="text" class="form-control" ng-model="feedback.patient_name" placeholder="Enter Patient Name" maxlength="50" autocomplete="off" />
                          </span>
                        </div>


                        <!-- Patient Age (Numbers Only) -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;margin-bottom: 6px;">{{lang.patage}}</span>
                          <span class="has-float-label" style="margin-top: 8px;">
                            <input type="number" class="form-control" ng-model="feedback.patient_age" placeholder="Enter Age" min="0" max="120" />
                          </span>
                        </div>


                        <!-- Patient Gender -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;margin-bottom: 6px;">{{lang.patgen}}</span>
                          <span class="has-float-label">
                            <select class="form-control" style="margin-top: 8px;" ng-model="feedback.patient_gender">
                              <option value="" disabled selected>{{lang.selgen}}</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Other">Other</option>
                            </select>
                          </span>
                        </div>

                        <!-- Location -->
                        <div class="form-group"
                          ng-init="locationOpen=false; locationSearch='';"
                          click-outside="locationOpen=false">

                          <span class="addon" style="font-size:18px; margin-bottom:6px;">{{lang.location}}<sup style="color:red">*</sup></span>

                          <div style="margin-top:8px; position:relative;">
                            <!-- Trigger -->
                            <div class="form-control" ng-click="locationOpen=!locationOpen">
                              {{ feedback.location || 'Select Area' }}
                            </div>

                            <!-- Dropdown panel -->
                            <div ng-show="locationOpen"
                              style="position:absolute; z-index:1000; left:0; right:0; margin-top:4px; background:#fff; border:1px solid #ced4da; border-radius:6px; padding:8px; box-shadow:0 8px 24px rgba(0,0,0,.1);">
                              <input class="form-control" placeholder="Search Area" ng-model="locationSearch"
                                style="margin-bottom:8px;" autofocus />

                              <div style="max-height:200px; overflow:auto;">
                                <div ng-repeat="loc in locations | filter:locationSearch"
                                  ng-click="selectLocation(loc)"
                                  style="padding:8px; cursor:pointer;">
                                  {{loc}}
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>






                        <!-- Department -->
                        <div class="form-group" ng-init="depOpen=false; depSearch='';" click-outside="closeDepartment()">
                          <span class="addon" style="font-size:18px; margin-bottom:6px;">{{lang.dep}}<sup style="color:red">*</sup></span>

                          <div style="position:relative; margin-top:8px;">
                            <!-- Trigger -->
                            <div class="form-control" ng-click="depOpen = !depOpen">
                              {{ feedback.department || lang.seldep }}
                            </div>

                            <!-- Dropdown -->
                            <div ng-show="depOpen"
                              style="position:absolute; left:0; right:0; z-index:1000; margin-top:4px; background:#fff; border:1px solid #ccc; border-radius:6px; padding:8px; box-shadow:0 8px 24px rgba(0,0,0,.1);">

                              <!-- Search box -->
                              <input class="form-control" placeholder="Search Department" ng-model="depSearch" style="margin-bottom:8px;" />

                              <!-- Options -->
                              <div style="max-height:200px; overflow:auto;">
                                <div ng-repeat="x in auditdept.auditdept | filter:depSearch"
                                  ng-if="x.title !== 'ALL'"
                                  ng-click="selectDepartment(x.title)"
                                  style="padding:8px; cursor:pointer;">
                                  {{x.title}}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>




                        <!-- Attended Doctor -->
                        <div class="form-group" ng-init="docOpen=false; docSearch='';" click-outside="closeDoctor()">
                          <span class="addon" style="font-size:18px; margin-bottom:6px;">{{lang.atdoc}}<sup style="color:red">*</sup></span>

                          <div style="position:relative; margin-top:8px;">
                            <!-- Trigger -->
                            <div class="form-control" ng-click="docOpen = !docOpen">
                              {{ feedback.attended_doctor || lang.seldoc }}
                            </div>

                            <!-- Dropdown -->
                            <div ng-show="docOpen"
                              style="position:absolute; left:0; right:0; z-index:1000; margin-top:4px; background:#fff; border:1px solid #ccc; border-radius:6px; padding:8px; box-shadow:0 8px 24px rgba(0,0,0,.1);">

                              <!-- Search box -->
                              <input class="form-control" placeholder="Search Doctor..." ng-model="docSearch" style="margin-bottom:8px;" />

                              <!-- Options -->
                              <div style="max-height:200px; overflow:auto;">
                                <div ng-repeat="x in doctor.doctor | filter:docSearch"
                                  ng-if="x.title !== 'ALL'"
                                  ng-click="selectDoctor(x.title)"
                                  style="padding:8px; cursor:pointer;">
                                  {{x.title}}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>



                        <!-- Admission Date -->

                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 6px;">
                            {{lang.admidat}}<sup style="color:red">*</sup><br>
                            <p style="font-size: 14px; margin: 0px 0 0 0; color:#6c757d;">{{lang.format}}</p>
                          </span>

                          <!-- Input -->
                          <div style="position: relative; width: 100%;">
                            <input class="form-control"
                              ng-model="feedback.initial_assessment_hr6"
                              type="datetime-local"
                              id="formula_para1_hr6"
                              ng-required="true"
                              autocomplete="off"
                              max="{{todayDateTime}}"
                              onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()"
                              style="padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; margin-top: 8px; width: 100%;" />
                          </div>
                        </div>
                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 6px;">
                            {{lang.discha}}<sup style="color:red"></sup><br>
                            <p style="font-size: 14px; margin: 0px 0 0 0; color:#6c757d;">{{lang.format}}</p>
                          </span>

                          <!-- Input -->
                          <div style="position: relative; width: 100%;">
                            <input class="form-control" ng-model="feedback.discharge_date_time" type="datetime-local" id="formula_para1_discharge"
                              ng-required="true" autocomplete="off" max="{{todayDateTime}}"
                              onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()"
                              style="padding: 6px 8px; border: 1px solid #ced4da; border-radius: 4px; margin-top: 8px; width: 100%;" />
                          </div>
                        </div>


                        <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small; margin-top: 30px;" ng-click="prev()" value="{{lang.previous}}" />

                        <input type="button" name="next" ng-click="next1()" style="background: #4285F4 ; font-size:small;  margin-top: 30px;" class="next action-button" value="{{lang.next}}" />

                </fieldset>



                <fieldset ng-show="step1 == true">

                  <h4><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">


                      <!-- <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">{{lang.patientname}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.patient_name}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.patientname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>
                      

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -14px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.patient_name_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -14px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">{{lang.age}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.test_name_placeholder}}" maxlength="20" type="number" id="contactnumber" ng-required="true" ng-model="feedback.age" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -14px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">{{lang.staffname}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.staff_name_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.staffname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div> -->



                      <!-- <p>&nbsp;</p> -->




                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -5px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.test_name}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.test_name_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.surgeryname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>



                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:16px;margin-bottom:13px; margin-top: -5px;">
                        <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                          <span class="addon" style="font-size: 18px; margin-bottom: -10px;margin-left: -14px;">{{lang.formula_para1}}<sup style="color:red">*</sup><br>
                            <p style="font-size: 14px;">{{lang.format}}</p>
                          </span>

                          <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                            <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()" oninput="restrictYearLength(this)" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;margin-left: -14px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 0px);" />
                            <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                              <svg class="calendar-icon" style="margin-left:-32px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm0 1V1h8v-.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v2H1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 1 0V1zm-2 4v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
                              </svg>
                            </span>
                            <span style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%);">
                              <i class="fa fa-calendar-alt"></i>
                            </span>
                            <label for="para1"></label>
                          </div>
                        </div>
                      </div>


                      <!-- <p>&nbsp;</p> -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:7px;">
                        <div class="form-group">
                          <h4 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>Sign in Pre-Op/ Pre anaesthesia check list – Before Induction of Anesthesia</b></h4>
                          <div style="margin-top: 16px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.antibiotic}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.antibiotic_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.checklist}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.checklist" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.checklist" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.checklist" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.checklist_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.bundle_care}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bundle_care" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bundle_care" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bundle_care" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.bundle_care_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.time_out}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.time_out" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.time_out" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.time_out" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.time_out_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.unplanned_return}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.unplanned_return" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.unplanned_return" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.unplanned_return" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.unplanned_return_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.last_oral}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.last_oral" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.last_oral" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.last_oral" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.last_oral_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.patients_weight}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_weight" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_weight" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_weight" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.patients_weight_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.urine_void}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_void" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_void" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_void" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.urine_void_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.anaesthesia}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.anaesthesia_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.drug_allergy}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_allergy" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_allergy" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_allergy" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.drug_allergy_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.prophylaxis}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prophylaxis" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prophylaxis" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prophylaxis" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.prophylaxis_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.antibiotic_given}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic_given" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic_given" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotic_given" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.antibiotic_given_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>


                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.thromboprophylaxis}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.thromboprophylaxis" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.thromboprophylaxis" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.thromboprophylaxis" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.thromboprophylaxis_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <h4 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>Time Out– Before Skin Incision</b></h4>

                          <div style="margin-top: 16px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.anaesthesia_professionals}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia_professionals" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia_professionals" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anaesthesia_professionals" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.anaesthesia_professionals_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.clinical_events}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.clinical_events" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.clinical_events" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.clinical_events" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.clinical_events_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.anticipated_equipment}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anticipated_equipment" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anticipated_equipment" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.anticipated_equipment" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.anticipated_equipment_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.prosthesis}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prosthesis" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prosthesis" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.prosthesis" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.prosthesis_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.imaging}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.imaging" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.imaging" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.imaging" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.imaging_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <h4 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>Sign Out- Before patient leaves Operating Room</b></h4>
                          <h6 style="font-size: 17px;margin-left:-6px;margin-top:13px;">Nurses verbally confirmed the following with the team:</h6>

                          <div style="margin-top: 16px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.procedure_name}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedure_name" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedure_name" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedure_name" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.procedure_name_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.instruments_counts}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments_counts" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments_counts" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments_counts" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.instruments_counts_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.closure_time}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.closure_time" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.closure_time" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.closure_time" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.closure_time_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.specimen_labeling}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.specimen_labeling" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.specimen_labeling" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.specimen_labeling" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.specimen_labeling_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.equipment_report}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_report" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_report" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_report" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.equipment_report_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>


                          <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.patients_recovery}}</p>

                            <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_recovery" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_recovery" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patients_recovery" value="N/A" />
                                <span style="margin-left: 5px;">N.A.</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.patients_recovery_text" placeholder="Remarks"
                                style="margin-left:-2px;margin-top:5px;" />
                            </span>


                            <!-- Remarks box -->


                          </div>



                          <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: -13px; margin-top: 20px;">
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

                          <!-- <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group" style="margin-top: 15px; margin-left: -21px;">

                              <span class="addon" style="font-size: 18px; margin-top:10px;">{{lang.audited_by}}<sup style="color:red">*</sup></span>

                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.audited_by_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.auditedBy" ng-init="feedback.auditedBy = loginname" autocomplete="off" style="padding-top:0px;" />

                                <label for="contactnumber"></label>

                              </span>

                            </div>

                          </div> -->

                        </div>
                      </div>







                    </div>

                  </div>

                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;" ng-click="prev1()" value="{{lang.previous}}" />

                  <div>
                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:12px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
                    <img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true">
                  </div>

                </fieldset>




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
  .calendar-icon-container {
    display: none;
  }

  @media (max-width: 800px) {
    .calendar-icon-container {
      display: block;
    }
  }

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

    document.getElementById("initial_assessment_hr1").setAttribute("max", formatted);
  }

  // Run once on load
  setMaxDateTime();

  // OPTIONAL: update every minute so "now" moves forward
  setInterval(setMaxDateTime, 60000);
</script>

<!-- script code end  -->



</html>