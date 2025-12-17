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

  <script src="app_xray_time.js?<?php echo time(); ?>"></script>

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

                      

                      <!-- Patient UHID -->

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

                      </div>


                      <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:16px;margin-bottom:13px;">
                          <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 18px;; margin-bottom: -10px;">{{lang.formula_para1}}<sup style="color:red">*</sup><br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.initial_assessment_hr1" max="{{todayDateTime}}" onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()" oninput="restrictYearLength(this)" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px; border: 1px solid #ced4da;margin-top:9px;width: calc(100% - 29px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-45px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:16px; margin-bottom:13px;">
                          <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 18px;; margin-bottom: -10px;">{{lang.formula_para2}}<sup style="color:red">*</sup><br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.initial_assessment_hr2" max="{{todayDateTime}}" onclick="this.showPicker && this.showPicker()"
                              onfocus="this.showPicker && this.showPicker()" oninput="restrictYearLength(this)" type="datetime-local" id="formula_para1_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px; border: 1px solid #ced4da;margin-top:9px;width: calc(100% - 29px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-45px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                        <button type="button" class="btn btn-primary" ng-click="calculateTimeFormat()" style=" margin-top:15px; margin-left:33px;">
                          Calculate xray wait time
                        </button>

                      </div>

                    </div>
                  </div>

                  <div ng-if="calculatedResultTime" style="margin-top: 15px;text-align:left;"><br>
                    <div style="margin-left:15px;">
                      <strong>Waiting time for Xray: <span style="color: blue; font-size:16px;">{{calculatedResultTime}}</span></strong><br><br>
                      <!-- <strong>Bench Mark Time: 04:00:00</strong> -->
                    </div>
                  </div>



                  <div class="form-card">

                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:5px; margin-top: 20px;">
                        <div class="form-group transparent-placeholder" style="display: flex; flex-direction: column; position: relative;">
                          <span class="addon" style="font-size: 18px;; margin-bottom: -10px;">{{lang.formula_para3}}<sup style="color:red">*</sup><br>
                            <p style="font-size: 14px;">{{lang.format}}</p>
                          </span>

                          <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                            <input class="form-control" ng-model="feedback.initial_assessment_hr3" max="{{todayDateTime}}" oninput="restrictYearLength(this)" type="datetime-local" id="formula_para3_hr" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px; border: 1px solid #ced4da;margin-top:9px;width: calc(100% - 5px);" />
                            <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                              <svg class="calendar-icon" style="margin-left:-22px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                    </div>

                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                    <p style="font-size: 18px;; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
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




                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;margin-top:40px;" ng-click="prev()" value="{{lang.previous}}" />

                  <div ng-if="calculatedResult">
                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:12px;margin-top:40px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
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

  <!-- Popup overlay -->
  <!-- <div class="audit-overlay" ng-show="showAuditMsg">
    <div class="audit-modal">


      <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
        <tr>
          <td style="padding:6px 0;">Audit Name:</td>
          <td style="padding:6px 0; text-align:left;">{{title || 'N/A'}}</td>
        </tr>
        <tr>
          <td style="padding:6px 0;">Audit Type:</td>
          <td style="padding:6px 0; text-align:left;">{{audit_type || 'N/A'}}</td>
        </tr>

        <tr>
          <td style="padding:6px 0;">Frequency:</td>
          <td style="padding:6px 0; text-align:left;">{{auditFreq || 'N/A'}}</td>
        </tr>
        <tr>
          <td style="padding:6px 0;">Target Sample Size (Minimum per month):</td>
          <td style="padding:6px 0; text-align:lect;">{{auditTargetPerMonth}}</td>
        </tr>
        <tr>
          <td style="padding:6px 0;">Conducted this month:</td>
          <td style="padding:6px 0; text-align:left;">{{auditConductedMonth}}</td>
        </tr>
        <tr ng-if="auditRemaining !== '—'">
          <td style="padding:6px 0;">Remaining:</td>
          <td style="padding:6px 0; text-align:left;">{{auditRemaining}}</td>
        </tr>
        <tr>
          <td style="padding:6px 0;">Last audit date:</td>
          <td style="padding:6px 0; text-align:left;">{{auditLastDate || 'N/A'}}</td>
        </tr>
      </table>

      <hr style="margin:12px 0;">

      <p style="margin:0 0 12px 0;"><strong>Summary:</strong> {{auditSentence}}</p>

      <div style="text-align:right;">
        <button type="button" class="btn btn-primary btn-sm" ng-click="closeAuditMsg()">OK</button>
      </div>
    </div>
  </div> -->

  <style>
    .audit-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1050;
    }

    .audit-modal {
      background: #fff;
      width: 92%;
      max-width: 560px;
      border-radius: 10px;
      padding: 16px 20px;
      box-shadow: 0 14px 38px rgba(0, 0, 0, .22);
    }
  </style>

  <!-- Poupup end -->

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

  .btn-primary {
    background-color: #686DE0;
    border-color: #686DE0;
    border-radius: 7px;
    color: white;
    padding: 8px 16px;
    font-size: 18px;;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  /* Hover effect */
  .btn-primary:hover {
    background-color: #5B56D6;
    border-color: #5B56D6;
  }

  /* Focus and active state (clicked) */
  .btn-primary:focus,
  .btn-primary:active {
    outline: none;
    box-shadow: 0 0 10px rgba(104, 109, 224, 0.5);
  }

  /* Optional: add a transition effect when hovering */
  .btn-primary {
    transition: background-color 0.3s, box-shadow 0.3s;
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

<!-- script code end  -->



</html>