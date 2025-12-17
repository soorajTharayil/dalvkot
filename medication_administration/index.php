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

  <script src="app_medication_administration.js?<?php echo time(); ?>"></script>

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
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:7px; top:-16px;">
                        <div class="form-group">

                          <div style="margin-top: 12px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.gloves}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.gloves" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.gloves" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.gloves" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.gloves_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.mask}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mask" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mask" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.mask" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.mask_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.cap}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cap" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cap" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cap" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.cap_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.apron}}</p>
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
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.lead_apron}}</p>
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

                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.use_xray_barrior}}</p>
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
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.patient_file}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patient_file" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patient_file" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.patient_file" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.patient_file_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.verified}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.verified" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.verified" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.verified" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.verified_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.indication}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.indication" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.indication" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.indication" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.indication_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.medicine}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.medicine_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.alert}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.alert" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.alert" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.alert" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.alert_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.dilution}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dilution" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dilution" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.dilution" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.dilution_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.administering}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.administering" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.administering" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.administering" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.administering_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.privacy}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.privacy" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.privacy" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.privacy" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.privacy_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.vials}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vials" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vials" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vials" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.vials_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.cannula}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cannula" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cannula" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cannula" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.cannula_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.flush}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.flush" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.flush" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.flush" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.flush_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.medications}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medications" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medications" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medications" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.medications_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.reassess}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.reassess" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.reassess" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.reassess" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.reassess_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.oral}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.oral" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.oral" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.oral" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.oral_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.discarded}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.discarded" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.discarded" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.discarded" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.discarded_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.handwashing}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handwashing" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handwashing" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.handwashing" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.handwashing_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left: -7px;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.procedures}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedures" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedures" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.procedures" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.procedures_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
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