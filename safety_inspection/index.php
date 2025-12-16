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

  <script src="app_safety_inspection.js?<?php echo time(); ?>"></script>

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

                <!-- PATIENT INFORMATION page start -->
                <fieldset ng-show="step0 == true">

                  <h4><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                          <span class="addon" style="font-size: 16px;">Select Department</span>
                          <span class="has-float-label">
                            <select class="form-control" id="dep" ng-required="true" ng-model="feedback.dep" autocomplete="off" style="padding-top:0px;margin-top: 5px;">
                              <option value="Select Department" disabled>Select Department</option>
                              <option value="St.Thomas Ward">St. Thomas Ward</option>
                              <option value="St.Alphonsa Ward">St. Alphonsa Ward</option>
                              <option value="St.Martins Ward">St. Martins Ward</option>
                              <option value="St.Anns Ward">St. Ann’s Ward</option>
                              <option value="St.Antonys Ward">St. Antony’s Ward</option>
                              <option value="Paediatric-Observation">Paediatric- Observation</option>
                              <option value="OT">OT</option>
                              <option value="CCU/ICU">CCU/ ICU</option>
                              <option value="Casualty">Casualty</option>
                              <option value="Dialysis">Dialysis</option>
                              <option value="Injection Room">Injection Room</option>
                              <option value="NICU">NICU</option>
                              <option value="Laboratory">Laboratory</option>
                              <option value="Basement-Common Area">Basement- Common Area</option>
                              <option value="Ground Floor-Common Area">Ground Floor- Common Area</option>
                              <option value="First Floor-Common Area">First Floor- Common Area</option>
                              <option value="Bio-Medical Waste Storage Area">Bio-Medical Waste Storage Area</option>
                              <option value="Water Storage">Water Storage</option>
                              <option value="Electrical Room/Area">Electrical Room/Area</option>
                              <option value="Oxygen Cylinder Storage Area">Oxygen Cylinder Storage Area</option>

                            </select>
                            <label for="bed"></label>
                          </span>
                        </div>
                      </div>


                      <div style="display: flex; flex-direction: column; gap: 20px;" ng-show="showDepartments.includes(feedback.dep)">

                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">STAIRWAYS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'STAIRWAYS'" />

                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_stairways_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_stairways_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_stairways_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.slippery}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.rails}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">CORRIDOR & FLOORS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'CORRIDOR & FLOORS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_corridor_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_corridor_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_corridor_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.floors_slip}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.avoid_falls}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.carpet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.warning_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">LIGHTING ALL OVER THE AREA</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'LIGHTING ALL OVER THE AREA'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.natural_light}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.illumination}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.glare}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.night_lights}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">ELECTRICAL</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'ELECTRICAL'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.plug_points}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_damaged}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cables_exposed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_mats}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_prevent}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_conditions}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">OXYGEN CYLINDERS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'OXYGEN CYLINDERS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.sufficient_oxygen}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['sufficient_oxygen' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['sufficient_oxygen' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['sufficient_oxygen' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.ro_water}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['ro_water' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['ro_water' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['ro_water' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cylinder_chart}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_chart' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_chart' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_chart' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cylinder_stand}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_stand' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_stand' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cylinder_stand' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">BIO-MEDICAL WASTE</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'BIO-MEDICAL WASTE'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.containers_coded}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_coded' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_coded' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_coded' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.containers_closed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_closed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_closed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_closed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.biohazard}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['biohazard' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['biohazard' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['biohazard' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.segregation}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['segregation' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['segregation' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['segregation' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.containers_fill}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_fill' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_fill' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['containers_fill' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SPILL KIT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'SPILL KIT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.kit_accessible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['kit_accessible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['kit_accessible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['kit_accessible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.items_present}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['items_present' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['items_present' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['items_present' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.staff_knowledge}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_knowledge' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_knowledge' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_knowledge' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">MULTI-DOSE VIALS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'MULTI-DOSE VIALS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.vial_needle}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_needle' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_needle' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_needle' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.opening_date}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['opening_date' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['opening_date' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['opening_date' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.storage}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['storage' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['storage' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['storage' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.vial_expire}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_expire' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_expire' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['vial_expire' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">REFRIGERATOR</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'REFRIGERATOR'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;margin-left: -7px;">{{lang.temperature_chart}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_chart' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_chart' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_chart' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.temperature_limits}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_limits' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_limits' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['temperature_limits' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.freezing_done}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['freezing_done' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['freezing_done' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['freezing_done' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.medical_items}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medical_items' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medical_items' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medical_items' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.expired_medicine}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['expired_medicine' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['expired_medicine' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['expired_medicine' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">EMERGENCY TRAY/CRASH CART</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'EMERGENCY TRAY/CRASH CART'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.medicines_avail}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_avail' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_avail' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_avail' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.medicines_near_exp}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_near_exp' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_near_exp' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['medicines_near_exp' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.overdated}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['overdated' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['overdated' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['overdated' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extra_medicines}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extra_medicines' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extra_medicines' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extra_medicines' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">HAZARDOUS SUBSTANCES</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'HAZARDOUS SUBSTANCES'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.hazardous_material}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['hazardous_material' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['hazardous_material' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['hazardous_material' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.msds_sheet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['msds_sheet' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['msds_sheet' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['msds_sheet' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.workplace_storage}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['workplace_storage' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['workplace_storage' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['workplace_storage' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">FIRE AND EVACUATION</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'FIRE AND EVACUATION'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_accessible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_avail}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_trained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_route}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_doors}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_maintained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">PERSONAL PROTECTIVE EQUIPMENT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'PERSONAL PROTECTIVE EQUIPMENT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.use_ppe}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['use_ppe' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['use_ppe' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['use_ppe' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.staff_trained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_trained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_trained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['staff_trained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_devices}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_devices' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_devices' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_devices' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">GENERAL CONDITION OF THE DEPARTMENT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'GENERAL CONDITION OF THE DEPARTMENT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.work_station_neat}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cleaning_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_accidents}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washrooms_clean}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washroom_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">EQUIPMENTS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'EQUIPMENTS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_numbered}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_numbered" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_numbered" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_numbered" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.log_sheet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.log_sheet" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.log_sheet" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.log_sheet" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_maintain}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_maintain" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_maintain" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.equipment_maintain" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.assets_numbered}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assets_numbered" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assets_numbered" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.assets_numbered" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.asset_register}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.asset_register" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.asset_register" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.asset_register" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.complaint_updated}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaint_updated" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaint_updated" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.complaint_updated" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.periodic_maintain}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.periodic_maintain" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.periodic_maintain" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback.periodic_maintain" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-left: 19px;margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SIGNAGES</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'SIGNAGES'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.patient_right_visible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.signages_placed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.mission}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                      </div>

                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Basement-Common Area'">

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">STAIRWAYS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'STAIRWAYS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.slippery}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.rails}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">CORRIDOR & FLOORS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'CORRIDOR & FLOORS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.floors_slip}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.avoid_falls}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.carpet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.warning_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">LIGHTING ALL OVER THE AREA</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'LIGHTING ALL OVER THE AREA'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.natural_light}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.illumination}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.glare}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.night_lights}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">ELECTRICAL</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'ELECTRICAL'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.plug_points}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_damaged}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cables_exposed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_mats}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_prevent}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_conditions}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">FIRE AND EVACUATION</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'FIRE AND EVACUATION'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_accessible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_avail}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_trained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_route}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_doors}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_maintained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">GENERAL CONDITION OF THE DEPARTMENT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'GENERAL CONDITION OF THE DEPARTMENT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.work_station_neat}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cleaning_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_accidents}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washrooms_clean}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washroom_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SIGNAGES</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'SIGNAGES'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.patient_right_visible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.signages_placed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.mission}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                      </div>

                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Ground Floor-Common Area'">

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">STAIRWAYS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'STAIRWAYS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.slippery}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.rails}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">CORRIDOR & FLOORS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'CORRIDOR & FLOORS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.floors_slip}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.avoid_falls}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.carpet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.warning_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">LIGHTING ALL OVER THE AREA</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'LIGHTING ALL OVER THE AREA'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.natural_light}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.illumination}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.glare}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.night_lights}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">ELECTRICAL</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'ELECTRICAL'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.plug_points}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_damaged}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cables_exposed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_mats}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_prevent}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_conditions}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">FIRE AND EVACUATION</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'FIRE AND EVACUATION'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_accessible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_avail}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_trained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_route}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_doors}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_maintained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">GENERAL CONDITION OF THE DEPARTMENT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'GENERAL CONDITION OF THE DEPARTMENT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.work_station_neat}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cleaning_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_accidents}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washrooms_clean}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washroom_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SIGNAGES</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'SIGNAGES'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.patient_right_visible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.signages_placed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.mission}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'First Floor-Common Area'">

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">STAIRWAYS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'STAIRWAYS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.slippery}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['slippery' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.rails}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['rails' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">CORRIDOR & FLOORS</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'CORRIDOR & FLOORS'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.obstruction}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['obstruction_' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.floors_slip}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['floors_slip' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.avoid_falls}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['avoid_falls' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.carpet}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['carpet' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.warning_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['warning_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">LIGHTING ALL OVER THE AREA</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'LIGHTING ALL OVER THE AREA'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.natural_light}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['natural_light' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.illumination}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['illumination' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.glare}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['glare' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.night_lights}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['night_lights' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">ELECTRICAL</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'ELECTRICAL'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.plug_points}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['plug_points' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_damaged}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_damaged' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cables_exposed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cables_exposed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_mats}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_mats' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_prevent}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_prevent' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cords_conditions}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cords_conditions' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">FIRE AND EVACUATION</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'FIRE AND EVACUATION'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_accessible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_accessible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_avail}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_avail' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.safety_trained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['safety_trained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_route}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_route' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.fire_doors}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['fire_doors' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.extinguishers_maintained}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['extinguishers_maintained' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.exit_signages}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['exit_signages' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">GENERAL CONDITION OF THE DEPARTMENT</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'GENERAL CONDITION OF THE DEPARTMENT'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.work_station_neat}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['work_station_neat' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cleaning_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['cleaning_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.equipment_accidents}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['equipment_accidents' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washrooms_clean}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washrooms_clean' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.washroom_checklist}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['washroom_checklist' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                        <div class="form-group" style="margin-top:-12px;">
                          <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">SIGNAGES</h6>
                          <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'SIGNAGES'" />
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.patient_right_visible}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['patient_right_visible' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.signages_placed}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['signages_placed' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>
                          <div style="margin-top: 8px; text-align: left;">
                            <p style="font-size: 16px; margin-bottom: 6px;">{{lang.mission}}</p>
                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="yes" />
                                <span style="margin-left: 5px;">Yes</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="no" />
                                <span style="margin-left: 5px;">No</span>
                              </label>
                              <label style="display: flex; align-items: center;">
                                <input type="radio" ng-model="feedback['mission' + feedback.dep + '_' + feedback.location]" value="Not Applicable" />
                                <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                              </label>
                            </div>
                          </div>

                        </div>

                      </div>


                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Bio-Medical Waste Storage Area'">
                        <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">BIO-MEDICAL WASTE STORAGE AREA</h6>
                        <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'BIO-MEDICAL WASTE STORAGE AREA'" />
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.bm_waste_store}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_store" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_store" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_store" value="Not Applicable" />
                              <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.bm_waste_record}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_record" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_record" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.bm_waste_record" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.storage_area}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.storage_area" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.storage_area" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.storage_area" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>

                      </div>
                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Water Storage'">
                        <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">WATER STORAGE</h6>
                        <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'WATER STORAGE'" />
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.enough_water}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.enough_water" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.enough_water" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.enough_water" value="Not Applicable" />
                              <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.tank_cleaning}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.tank_cleaning" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.tank_cleaning" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.tank_cleaning" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.plant_maintain}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.plant_maintain" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.plant_maintain" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.plant_maintain" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>

                      </div>
                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Electrical Room/Area'">
                        <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">ELECTRICAL ROOM/AREA</h6>
                        <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'ELECTRICAL ROOM/AREA'" />
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.transformer_status}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.transformer_status" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.transformer_status" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.transformer_status" value="Not Applicable" />
                              <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.generators_status}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generators_status" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generators_status" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.generators_status" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.electrical_areas}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_areas" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_areas" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_areas" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.electrical_boxes}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_boxes" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_boxes" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.electrical_boxes" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.precautions_to_fire}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.precautions_to_fire" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.precautions_to_fire" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.precautions_to_fire" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>

                      </div>
                      <div class="form-group" style="margin-left: 19px;margin-top:-12px;" ng-show="feedback.dep === 'Oxygen Cylinder Storage Area'">
                        <h6 style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">OXYGEN CYLINDER STORAGE AREA</h6>
                        <input type="hidden" ng-model="feedback.location" ng-init="feedback.location = 'OXYGEN CYLINDER STORAGE AREA'" />
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.cylinders_chained}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.cylinders_chained" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.cylinders_chained" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.cylinders_chained" value="Not Applicable" />
                              <span style="margin-left: 5px; white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.empty_cylinders}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.empty_cylinders" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.empty_cylinders" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.empty_cylinders" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>
                        <div style="margin-top: 8px; text-align: left;">
                          <p style="font-size: 16px; margin-bottom: 6px;">{{lang.warning_signage}}</p>
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.warning_signage" value="yes" />
                              <span style="margin-left: 5px;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.warning_signage" value="no" />
                              <span style="margin-left: 5px;">No</span>
                            </label>
                            <label style="display: flex; align-items: center;">
                              <input type="radio" ng-model="feedback.warning_signage" value="Not Applicable" />
                              <span style="margin-left: 5px;white-space: nowrap;">Not Applicable</span>
                            </label>
                          </div>
                        </div>

                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 7px; margin-top: 0px;">
                        <p style="font-size: 16px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                        <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
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