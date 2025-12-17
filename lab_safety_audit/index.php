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

  <script src="app_ppe_audit.js?<?php echo time(); ?>"></script>

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

                      </div>



                      <!-- Patient UHID -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px;">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.staff_name}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.patient_name_placeholder}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.staffname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 18px;">{{lang.idno}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.idno_placeholder}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.idno" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>




                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <span class="addon" style="font-size: 18px;">{{lang.department}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <select class="form-control" id="department" ng-required="true" ng-model="feedback.department" autocomplete="off" style="padding-top:0px;margin-top: 5px;">
                              <option value="" disabled selected>Select Department</option>
                              <option ng-repeat="x in safety_adherence.safety_adherence" ng-show="x.title != 'ALL' && x.title != 'USG' && x.title != 'X-Ray'" value="{{x.title}}">{{x.title}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div>

                      <!-- <p>&nbsp;</p> -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:7px;">
                        <div class="form-group">
                          <!-- <span class="addon" style="font-size: 18px;">PPE Audit - Lab</span> -->

                          <div style="margin-top: 0; margin-left:0;">
                            <p style="font-size: 18px; margin-bottom: 6px;margin-left: -6px;">{{lang.action}}</p>
                            <input style="border: 1px ridge #ccc; margin-left: -5px; width: 100%; padding-top:5px;padding-left: 7px;" class="form-control" id="textarea1" placeholder="Enter the activity here" type="text" ng-model="feedback.comment_l">
                          </div>

                          <div style="margin-top: 28px; text-align: left;">
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
                          <div style="margin-top: 8px; text-align: left;">
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
                          <div style="margin-top: 8px; text-align: left;">
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
                          <div style="margin-top: 8px; text-align: left;">
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

                          <div style="margin-top: 8px; text-align: left;">
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
                          <div style="margin-top: 8px; text-align: left;">
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

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.use_tld_badge}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.use_tld_badge" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.use_tld_badge" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.use_tld_badge" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                              </div>
                              <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.use_tld_badge_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                  </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.ppe_to_patients}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.ppe_to_patients" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.ppe_to_patients" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.ppe_to_patients" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                              </div>
                              <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.ppe_to_patients_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                  </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.no_recapping}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.no_recapping" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.no_recapping" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.no_recapping" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                              </div>
                              <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.no_recapping_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                  </div>

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 18px; margin-bottom: 6px;">{{lang.pts_disinfection}}</p>
                            <div style="display: flex; gap: 20px; align-items: center;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pts_disinfection" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pts_disinfection" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.pts_disinfection" value="N/A" />
                                <span style="margin-left: 5px;">N/A</span>
                              </label>
                              </div>
                              <span class="has-float-label">
                          <input type="text" class="form-cont" ng-model="feedback.pts_disinfection_text"
                            placeholder="Remarks" style="margin-left:-2px;margin-top:5px;" />
                        </span>
                  </div>


                        </div>
                      </div>




                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 11px; margin-top: 0px;">
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

                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;margin-top:35px;" ng-click="prev()" value="{{lang.previous}}" />

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