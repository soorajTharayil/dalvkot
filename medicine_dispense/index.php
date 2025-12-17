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

  <script src="app_medicine_dispense.js?<?php echo time(); ?>"></script>

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
                        <h6 style="font-size: 18px;margin-left:1px;margin-top:0px;"><b>Audit Details</b></h6>
                        <div class="form-group">
                          <span class="addon" style="font-size: 18px; margin-bottom: 0px;">{{lang.name}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" type="text" ng-model="feedback.audit_type" placeholder="Enter audit name" ng-required="true" style="margin-top: 0px;" disabled/>
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

                          <span class="addon" style="font-size: 18px;">{{lang.consultant_name}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.consultant_name_placeholder}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.consultant_name" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -5px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.diagnosis}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.diagnosis_placeholder}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.diagnosis" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>



                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -5px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.test_name}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.test_name_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.medicinename" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>



                      <!-- <p>&nbsp;</p> -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:7px; top:-16px;">
                        <div class="form-group">
                          <h4 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>I. DOCTORS</b></h4>
                          <h6 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>1. Incorrect Prescription </b></h6>

                          <!-- a. Correct Medicine -->
                          <div style="margin-top: 12px; text-align: left; margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.correct_medicine}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_medicine" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_medicine" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_medicine" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_medicine_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- b. Correct Quantity -->
                          <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">b. {{lang.correct_quantity}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_quantity" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_quantity" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_quantity" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_quantity_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- c. Medicine Expiry -->
                          <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">c. {{lang.medicine_expiry}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_expiry" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_expiry" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_expiry" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.medicine_expiry_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- d. Apron -->
                          <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">d. {{lang.apron}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.apron" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.apron" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.apron" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.apron_text"
                                placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>


                          <!-- e. Lead Apron -->
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">e. {{lang.lead_apron}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.lead_apron" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.lead_apron" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.lead_apron" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.lead_apron_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>

                        <!-- f. Use X-ray Barrier -->
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">f. {{lang.use_xray_barrior}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.use_xray_barrior" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.use_xray_barrior" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.use_xray_barrior" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.use_xray_barrior_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>

                        <!-- g. Administration Rate -->
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">g. {{lang.administration_rate}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.administration_rate" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.administration_rate" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.administration_rate" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.administration_rate_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>

                        <!-- 2. Therapeutic Duplication -->
                        <h6 style="font-size: 17px; margin-left:-6px; margin-top:13px;"><b>2. Therapeutic Duplication </b></h6>
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.therapeutic_duplication}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.therapeutic_duplication" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.therapeutic_duplication" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.therapeutic_duplication" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.therapeutic_duplication_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>

                        <!-- 3. Illegible Handwriting -->
                        <h6 style="font-size: 17px; margin-left:-6px; margin-top:13px;"><b>3. Illegible Handwriting </b></h6>
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.handwriting_legible}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.handwriting_legible" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.handwriting_legible" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.handwriting_legible" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.handwriting_legible_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>

                        <!-- 4. Non-approved Abbreviations -->
                        <h6 style="font-size: 17px; margin-left:-6px; margin-top:13px;"><b>4. Non-approved Abbreviations </b></h6>
                        <div style="margin-top: 8px; text-align: left; margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.medical_abbreviations}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.medical_abbreviations" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.medical_abbreviations" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.medical_abbreviations" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>
                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.medical_abbreviations_text"
                              placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>


                          <h6 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>5. Non-usage of Capital Letters for Drug Names </b></h6>

                          <!-- 1. Capital Letters -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.capital_letters}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.capital_letters" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.capital_letters" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.capital_letters" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.capital_letters_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 2. Generic Name -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.generic_name}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.generic_name" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.generic_name" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.generic_name" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.generic_name_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 3. Drug-Drug Interaction -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.drug_interaction}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_interaction" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_interaction" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_interaction" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.drug_interaction_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 4. Food-Drug Interaction -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.food_drug}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_drug" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_drug" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_drug" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.food_drug_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 5. Drug Dispensed -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.drug_dispensed}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_dispensed" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_dispensed" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_dispensed" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.drug_dispensed_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 6. Dose Dispensed -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">b. {{lang.dose_dispensed}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_dispensed" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_dispensed" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_dispensed" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.dose_dispensed_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 7. Formulation Dispensed -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">c. {{lang.formulation_dispensed}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.formulation_dispensed" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.formulation_dispensed" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.formulation_dispensed" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.formulation_dispensed_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 8. Expired Drugs -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">d. {{lang.expired_drungs}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.expired_drungs" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.expired_drungs" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.expired_drungs" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.expired_drungs_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 9. Accurate Patient -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">e. {{lang.accurate_patient}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.accurate_patient" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.accurate_patient" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.accurate_patient" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.accurate_patient_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>

                          <!-- 10. Medication Dispense -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">f. {{lang.medication_dispese}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dispese" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dispese" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dispese" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.medication_dispese_text" placeholder="Remarks" style="width:100%; margin-top:5px;" />
                            </span>
                          </div>


                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                          <p style="font-size: 18px; margin-bottom: 6px;">g. {{lang.generic_substitution}}</p>
                          <div style="display: flex; gap: 20px; align-items: center;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generic_substitution" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generic_substitution" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generic_substitution" value="N/A" />
                              <span style="margin-left: 5px;">N/A</span>
                            </label>
                          </div>

                          <span class="has-float-label">
                            <input type="text" class="form-cont" ng-model="feedback.generic_substitution_text"
                                  placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                          </span>
                        </div>



                          <h4 style="font-size: 17px;margin-left:-6px;margin-top:13px;"><b>III. NURSES</b></h4>
                          <!-- a. Correct Patient -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">a. {{lang.correct_patient}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_patient" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_patient" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_patient" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_patient_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- b. Dose Omitted -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">b. {{lang.dose_omitted}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_omitted" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_omitted" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dose_omitted" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.dose_omitted_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- c. Medication Dose -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">c. {{lang.medication_dose}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dose" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dose" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication_dose" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.medication_dose_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- d. Drug Administered -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">d. {{lang.drug_administered}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administered" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administered" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administered" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.drug_administered_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- e. Correct Dosage -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">e. {{lang.correct_dosage}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_dosage" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_dosage" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_dosage" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_dosage_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- f. Correct Route -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">f. {{lang.correct_route}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_route" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_route" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_route" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_route_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- g. Correct Rate -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">g. {{lang.correct_rate}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_rate" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_rate" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_rate" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_rate_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- h. Correct Duration -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">h. {{lang.correct_duration}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_duration" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_duration" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_duration" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_duration_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- i. Correct Time -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">i. {{lang.correct_time}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_time" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_time" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.correct_time" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.correct_time_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- j. Drug Administration -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">j. {{lang.drug_administration}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administration" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administration" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.drug_administration" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.drug_administration_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- k. Nursing Staff -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">k. {{lang.nursing_staff}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.nursing_staff" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.nursing_staff" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.nursing_staff" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.nursing_staff_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>

                          <!-- l. Documentation Drug -->
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">l. {{lang.documentation_drug}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documentation_drug" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documentation_drug" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documentation_drug" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                              <input type="text" class="form-cont" ng-model="feedback.documentation_drug_text" placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                            </span>
                          </div>




                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: -15px;">
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

                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;margin-top:35px;" ng-click="prev1()" value="{{lang.previous}}" />

                  <div>
                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:12px;margin-top:35px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
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