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

  <script src="app_handover_audit.js?<?php echo time(); ?>"></script>

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
                        <!-- Location -->
                        <div class="form-group" ng-init="locationOpen=false; locationSearch='';"
                          click-outside="locationOpen=false">

                          <span class="addon" style="font-size:18px; margin-bottom:6px;">{{lang.location}}<sup
                              style="color: red;">*</sup></span>

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
                                <div ng-repeat="x in area | filter:locationSearch"
                                  ng-if="x.title !== 'ALL'"
                                  ng-click="selectLocation(x.title)"
                                  style="padding:8px; cursor:pointer;">
                                  {{x.title}}
                                </div>

                              </div>
                            </div>
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


                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:7px; top: 10px;">
                        <div class="form-group">
                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>PERSONAL HYGIENE:</b></h6>
                          <div style="margin-top: 12px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.identification_details}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identification_details" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identification_details" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.identification_details" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.identification_details_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.vital_signs}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vital_signs" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vital_signs" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vital_signs" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.vital_signs_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.surgery}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgery" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgery" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgery" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.surgery_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.complaints_communicated}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaints_communicated" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaints_communicated" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaints_communicated" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.complaints_communicated_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.intake}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.intake" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.intake" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.intake" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.intake_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.output}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.output" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.output" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.output" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.output_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.allergies}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.allergies" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.allergies" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.allergies" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.allergies_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.medication}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medication" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.medication_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>UTENSILS AND EQUIPMENT:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.diagnostic}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.diagnostic" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.diagnostic" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.diagnostic" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.diagnostic_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.lab_results}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lab_results" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lab_results" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.lab_results" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.lab_results_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.pending_investigation}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pending_investigation" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pending_investigation" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pending_investigation" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.pending_investigation_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.medicine_order}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_order" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_order" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.medicine_order" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.medicine_order_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>CLEANING:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.facility_communicated}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.facility_communicated" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.facility_communicated" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.facility_communicated" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.facility_communicated_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <!-- <h4 style="font-size: 17px;margin-left:-6px;margin-top:17px;"><b>During Procedure:</b></h4> -->
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.health_education}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.health_education" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.health_education" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.health_education" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.health_education_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.risk_assessment}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.risk_assessment" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.risk_assessment" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.risk_assessment" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.risk_assessment_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.urethral}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urethral" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urethral" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urethral" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.urethral_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.urine_sample}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_sample" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_sample" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.urine_sample" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.urine_sample_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>GARBAGE DISPOSAL:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.bystander}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bystander" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bystander" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.bystander" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.bystander_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.instruments}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.instruments" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.instruments_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <!-- <h4 style="font-size: 17px;margin-left:-6px;margin-top:17px;"><b>After Procedure:</b></h4> -->
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.sterile}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sterile" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sterile" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sterile" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.sterile_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.antibiotics}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotics" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotics" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.antibiotics" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.antibiotics_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.surgical_site}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgical_site" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgical_site" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.surgical_site" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.surgical_site_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>PEST CONTROL:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.wound}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.wound" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.wound" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.wound" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.wound_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>RECEIVING:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.documented}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documented" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documented" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.documented" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.documented_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.adequate_facilities}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate_facilities" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate_facilities" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.adequate_facilities" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.adequate_facilities_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.sufficient_lighting}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sufficient_lighting" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sufficient_lighting" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.sufficient_lighting" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.sufficient_lighting_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.storage_facility_for_food}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_facility_for_food" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_facility_for_food" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_facility_for_food" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.storage_facility_for_food_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.personnel_hygiene_facilities}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.personnel_hygiene_facilities" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.personnel_hygiene_facilities" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.personnel_hygiene_facilities" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.personnel_hygiene_facilities_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>STORAGE:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.food_material_testing}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_material_testing" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_material_testing" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_material_testing" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.food_material_testing_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.incoming_material}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.incoming_material" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.incoming_material" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.incoming_material" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.incoming_material_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.raw_materials_inspection}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_inspection" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_inspection" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_inspection" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.raw_materials_inspection_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.storage_of_materials}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_of_materials" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_of_materials" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.storage_of_materials" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.storage_of_materials_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>TRANSPORT:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.raw_materials_cleaning}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_cleaning" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_cleaning" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.raw_materials_cleaning" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.raw_materials_cleaning_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_sanitization}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_sanitization" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_sanitization" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_sanitization" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.equipment_sanitization_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.frozen_food_thawing}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.frozen_food_thawing" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.frozen_food_thawing" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.frozen_food_thawing" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.frozen_food_thawing_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>HEALTH:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.vegetarian_and_non_vegetarian}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vegetarian_and_non_vegetarian" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vegetarian_and_non_vegetarian" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.vegetarian_and_non_vegetarian" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.vegetarian_and_non_vegetarian_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cooked_food_cooling}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cooked_food_cooling" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cooked_food_cooling" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.cooked_food_cooling" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.cooked_food_cooling_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          <h6 style="font-size: 16px;margin-left:-6px;margin-top:13px;"><b>QUALITY:</b></h6>
                          <div style="margin-top: 8px; text-align: left;margin-left:-6px;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.food_portioning}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_portioning" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_portioning" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.food_portioning" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                            </div>
                            <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.food_portioning_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                          </div>

                          
                        
                          <!-- <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group" style="margin-top: 15px; margin-left: -16px;">

                              <span class="addon" style="font-size: 16px; margin-top:10px;">{{lang.audited_by}}<sup style="color:red">*</sup></span>

                              <span class="has-float-label">

                                <input class="form-control" placeholder="{{lang.audited_by_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.auditedBy" autocomplete="off" style="padding-top:0px;" />

                                <label for="contactnumber"></label>

                              </span>

                            </div>

                          </div> -->


                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 13px;">
                        <p style="font-size: 16px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
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