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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-load-image/2.21.0/load-image.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>



  <script src="app_asset.js?<?php echo time(); ?>"></script>

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

                  <!-- <div class="card" style=" border: 2px solid #000;">
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
                  </div> -->

                  <!-- <br> -->

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
        <div ng-show="toplogo == true">
          <img ng-src="{{setting_data.logo}}" style="    height: 50px;">
          <br>
        </div>
        <div class="card px-0 pt-2 pb-0 mt-2 mb-3">



          <div class="row">

            <div class="col-md-12 mx-0">

              <fieldset ng-show="step0 == true">
                <div class="main-container">
                  <div class="form-container" style="margin-top: 15px;margin-bottom:30px;">


                    <div class="form-body" style="align-items:center;">
                      <form class="the-form">
                        <div style="text-align: center;">
                          <a class="navbar-brand" href="#"><img src="{{setting_data.logo}}" style="height: 100px; width:100%"></a>
                        </div>
                        <br>
                        <div style="color: red; text-align: center;" class="alert-error" ng-show="loginerror.length > 3">{{loginerror}}</div>
                        <!-- <label for="text">Email / Mobile Number</label> -->
                        <input type="text" name="email" id="email" class="input-field" placeholder="Enter email/ mobile no." ng-model="loginvar.userid" style="padding: 12px;font-size: 16px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px;  margin-bottom: 15px;  width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                        <!-- <label for="password">Password</label> -->
                        <div class="password-container" style="margin-left: 0px;">
                          <input type="password" name="password" id="password" class="input-field" placeholder="Enter password" ng-model="loginvar.password" style="padding: 12px;font-size: 16px; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 25px;  margin-bottom: 15px;  width: 90%; box-sizing: border-box;color: #000; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                          <span style="color: rgba(0, 0, 0, 0.8);" class="password-toggle" onclick="togglePassword()">
                            <i class="fa fa-eye-slash" aria-hidden="true" style="margin-left: -26px;"></i>
                          </span>
                        </div>
                        <div style=" display: flex; justify-content: center; /* horizontally center */ align-items: center; ">
                          <input ng-click="login()" type="submit" value="LOGIN" style="width: 100px; height:45px; background: #34a853; border: 1px solid rgba(0, 0, 0, 0.1);  padding: 10x;   font-size: 16px; border-radius: 50px;  cursor: pointer;  margin-top: 20px; color: white;">
                        </div>
                      </form>
                    </div>
                    <!-- FORM BODY-->
                    <br><br>
                    <div class="form-footer" style=" display: flex; justify-content: center; /* horizontally center */  align-items: center; ">
                      <img src="./power.png" style="max-width: 100%; height: 45px; " alt="">
                    </div><!-- FORM FOOTER -->

                  </div><!-- FORM CONTAINER -->
                </div>
              </fieldset>

              <!-- form start -->

              <form id="msform">

                <!-- PATIENT INFORMATION page start -->
                <fieldset ng-show="step2 == true">

                  <h4><strong>{{lang.patient_info}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">Primary Asset Name<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="40" type="text" id="assetname" ng-model="feedback.assetname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <!-- component Asset name -->

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group">

                          <span class="addon" style="font-size: 16px;">{{lang.assetname}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="40" type="text" id="subassetname" ng-model="feedback.subassetname" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-top: -17px;">

                          <span class="addon" style="font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="40" type="text" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-top: -17px;">

                          <span class="addon" style="font-size: 16px;">Component Asset Brand</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.brand" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-top: -17px;">

                          <span class="addon" style="font-size: 16px;">Component Asset Model No.</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.model" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-top: -17px;">

                          <span class="addon" style="font-size: 16px;">Component Asset Serial No.</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="20" type="text" id="contactnumber" ng-required="true" ng-model="feedback.serial" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -17px;">
                          <span class="" style="font-size:16px;">{{lang.department}}</span>
                          <span class="has-float-label">
                            <select class="form-control" ng-model="feedback.ward" ng-change="change_asset()" style="margin-top: 6px;padding-left:0px;">
                              <option value="Select Asset Group/ Category">Select Asset Group/ Category</option>
                              <option ng-repeat="x in wardlist.ward" ng-show="x.title != 'ALL'" value="{{x.title}}" required>{{x.title}}</option>
                            </select>
                          </span>
                        </div>
                      </div>

                      <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-left: 0px; margin-top:7px;">
                          <span class="addon" style="font-size: 16px;">Select Asset Component<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <select class="form-control" ng-model="feedback.component" style="width: 100%; margin-top: 6px;">
                              <option value="Select Asset Component" disabled>Select Asset Component</option>
                              <option value="{{feedback.component}}">{{feedback.component}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div> -->

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -12px;">
                          <span class="addon" style="font-size: 16px;">{{lang.depart}}</span>
                          <span class="has-float-label">
                            <select class="form-control" id="assigned" ng-required="true" ng-model="feedback.depart" autocomplete="off" ng-change="updateAssetStatus()" style="padding-top:0px;margin-top: 5px;padding-left:0px;width:100%">
                              <option value="Select Asset Department">Select Asset Department</option>

                              <option ng-repeat="x in deptlist.depart" ng-show="x.title != 'ALL'" value="{{x.title}}" required>{{x.title}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -20px;">
                        <div class="form-group" style="margin-top: 0px;">
                          <span class="addon" style="font-size: 16px;">{{lang.assigned}}</span>
                          <span class="has-float-label">
                            <select class="form-control" id="assigned" ng-required="true" ng-model="feedback.assigned" autocomplete="off" style="padding-top:0px;margin-top: 5px;padding-left:0px;width:100%">
                              <option value="">Select Asset User</option>
                              <option value="{{feedback.assigned}}">{{feedback.assigned}}</option>
                            </select>
                            <label for="assigned"></label>
                          </span>
                        </div>
                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-left: 0px; margin-top:-17px;">
                          <span class="addon" style="font-size: 16px;">{{lang.floor}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <select class="form-control" ng-model="feedback.locationsite" style="width: 100%; margin-top: 6px;padding-left:0px;">
                              <option value="Select Floor/ Area" disabled>{{lang.floor}}</option>
                              <option ng-repeat="x in locationlist.ward" ng-show="x.title !== 'ALL'" value="{{x.title}}" required>{{x.title}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-left: 0px; margin-top:-17px;">
                          <span class="addon" style="font-size: 16px;">{{lang.location}}<sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <select class="form-control" ng-model="feedback.bedno" style="width: 100%; margin-top: 6px;">
                              <option value="Select Site" disabled>{{lang.location}}</option>
                              <option value="{{feedback.bedno}}">{{feedback.bedno}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
                        </div>
                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;">
                        <div class="form-group transparent-placeholder" style="margin-top: -21px; display: flex; flex-direction: column; position: relative;">
                          <span class="addon" style="font-size: 16px; margin-bottom: -18px;">{{lang.formula_para1}}<br>
                            <p style="font-size: 14px;">{{lang.format}}</p>
                          </span>

                          <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                            <input class="form-control" ng-model="feedback.purchaseDate" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                            <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                              <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                      <!-- Installation date -->
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;margin-top:10px;">
                        <div class="form-group transparent-placeholder" style="margin-top: -21px; display: flex; flex-direction: column; position: relative;">
                          <span class="addon" style="font-size: 16px; margin-bottom: -18px;">{{lang.install}}<br>
                            <p style="font-size: 14px;">{{lang.format}}</p>
                          </span>

                          <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                            <input class="form-control" ng-model="feedback.installDate" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                            <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                              <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -11px;margin-left:2px;">
                          <span class="addon" style="font-size: 16px;">Purchase Order No.</span>
                          <span class="has-float-label">
                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.porder" autocomplete="off" style="padding-top:0px;" />
                            <label for="contactnumber"></label>
                          </span>
                        </div>
                      </div>


                      <!-- Invoice No -->
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -11px;margin-left:2px;">
                          <span class="addon" style="font-size: 16px;">{{lang.invoice}}</span>
                          <span class="has-float-label">
                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.invoice" autocomplete="off" style="padding-top:0px;" />
                            <label for="contactnumber"></label>
                          </span>
                        </div>
                      </div>

                      <!-- GRN No -->
                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -17px;margin-left:2px;">
                          <span class="addon" style="font-size: 16px;">{{lang.grn_no}}</span>
                          <span class="has-float-label">
                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="text" id="contactnumber" ng-required="true" ng-model="feedback.grn_no" autocomplete="off" style="padding-top:0px;" />
                            <label for="contactnumber"></label>
                          </span>
                        </div>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -15px; text-align: left;">
                        <p style="font-size: 16px; margin-bottom: 6px;">PM applicable?</p>
                        <div style="display: flex; gap: 20px; align-items: center;">
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithPm" value="PM applicable" />
                            <span style="margin-left: 5px;">Yes</span>
                          </label>
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithPm" value="PM not applicable" />
                            <span style="margin-left: 5px;">No</span>
                          </label>
                        </div>
                      </div>

                      <div ng-show="feedback.assetWithPm === 'PM applicable'" style="width: 100%; display: block; margin-top: 5px;">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px; margin-top: 7px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -4px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">Last Preventive Maintenance Date<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.lastMaintenance" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -12px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">Upcoming Preventive Maintenance Due<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.upcomingMaintenance" type="datetime-local" id="warrenty" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 3px; text-align: left;">
                        <p style="font-size: 16px; margin-bottom: 6px;">Calibration applicable?</p>
                        <div style="display: flex; gap: 20px; align-items: center;">
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithCalibration" value="Calibration applicable" />
                            <span style="margin-left: 5px;">Yes</span>
                          </label>
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithCalibration" value="Calibration not applicable" />
                            <span style="margin-left: 5px;">No</span>
                          </label>
                        </div>
                      </div>

                      <div ng-show="feedback.assetWithCalibration === 'Calibration applicable'" style="width: 100%; display: block; margin-top: 5px;">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px; margin-top: 7px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -4px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">Last Calibration Date<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.lastCalibration" type="datetime-local" id="formula_para1_hr" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -12px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">Upcoming Calibration Due<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.upcomingCalibration" type="datetime-local" id="warrenty" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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


                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 5px; text-align: left;">
                        <p style="font-size: 16px; margin-bottom: 6px;">Warranty applicable?<sup style="color:red">*</sup></p>
                        <div style="display: flex; gap: 20px; align-items: center;">
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithWarranty" value="Warranty applicable" />
                            <span style="margin-left: 5px;">Yes</span>
                          </label>
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithWarranty" value="Warranty not applicable" />
                            <span style="margin-left: 5px;">No</span>
                          </label>
                        </div>
                      </div>


                      <!-- Warranty start and end date -->
                      <div ng-show="feedback.assetWithWarranty === 'Warranty applicable'" style="width: 100%; display: block; margin-top: 5px;">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -12px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">{{lang.warrenty}}<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.warrenty" type="datetime-local" id="warrenty" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:1px;margin-bottom:12px;">
                          <div class="form-group transparent-placeholder" style="margin-top: -12px; display: flex; flex-direction: column; position: relative;">
                            <span class="addon" style="font-size: 16px; margin-bottom: -18px;">{{lang.warrenty_end}}<br>
                              <p style="font-size: 14px;">{{lang.format}}</p>
                            </span>

                            <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                              <input class="form-control" ng-model="feedback.warrenty_end" type="datetime-local" id="warrenty_end" autocomplete="off" style="padding-top: 2px;padding-left: 6px;border: 1px solid #ced4da; margin-top:9px;width: calc(100% - 3px);" />
                              <span class="calendar-icon-container" style="position: absolute; right: 5px; top: 76%; transform: translateY(-50%); margin-left:-29px;">
                                <svg class="calendar-icon" style="margin-left:-19px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 5px; text-align: left;">
                        <p style="font-size: 16px; margin-bottom: 6px;">AMC/ CMC applicable?<sup style="color:red">*</sup></p>
                        <div style="display: flex; gap: 20px; align-items: center;">
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithAmc" value="AMC/ CMC applicable" />
                            <span style="margin-left: 5px;">Yes</span>
                          </label>
                          <label style="display: flex; align-items: center;">
                            <input type="radio" ng-model="feedback.assetWithAmc" value="AMC/ CMC not applicable" />
                            <span style="margin-left: 5px;">No</span>
                          </label>
                        </div>
                      </div>



                      <!-- AMC/CMC -->
                      <div ng-show="feedback.assetWithAmc === 'AMC/ CMC applicable'" style="width: 100%; display: block; margin-top: 5px;">

                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <div class="form-group" style="margin-left: 0px; margin-top:-14px;">
                            <span class="addon" style="font-size: 16px;">Select AMC/ CMC<sup style="color:red">*</sup></span>
                            <span class="has-float-label">
                              <select class="form-control" ng-model="feedback.contract" style="width: 100%; margin-top: 6px;padding-left:0px;">
                                <option value="" disabled selected>Select AMC/ CMC</option>
                                <option value="AMC">AMC</option>
                                <option value="CMC">CMC</option>
                              </select>
                              <label for="bednumber"></label>
                            </span>
                          </div>
                        </div>
                      </div>

                      <!-- AMC Details Section -->
                      <div ng-show="feedback.contract === 'AMC' && feedback.assetWithAmc === 'AMC/ CMC applicable'" style="width: 100%;">

                        <div class="form-group" style="margin-top: -18px; width: 100%;margin-left:15px;">
                          <label for="amc-start-date" style="margin-bottom: 5px;">AMC Start Date</label>
                          <div style="position: relative;">
                            <input type="datetime-local" class="form-control" id="amc-start-date"
                              ng-model="feedback.amcStartDate"
                              style="padding: 6px 10px; border: 1px solid #ced4da; width: 94%;"
                              autocomplete="off" />
                            <span class="calendar-icon-container" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                              <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" style="margin-right:29px;" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm0 1V1h8v-.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v2H1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 1 0V1zm-2 4v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
                              </svg>
                            </span>
                          </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px; width: 100%;margin-left:15px;">
                          <label for="amc-end-date" style="margin-bottom: 5px;">AMC End Date</label>
                          <div style="position: relative;">
                            <input type="datetime-local" class="form-control" id="amc-end-date"
                              ng-model="feedback.amcEndDate"
                              style="padding: 6px 10px; border: 1px solid #ced4da; width: 94%;"
                              autocomplete="off" />
                            <span class="calendar-icon-container" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                              <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" style="margin-right:29px;" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm0 1V1h8v-.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v2H1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 1 0V1zm-2 4v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
                              </svg>
                            </span>
                          </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px; width: 100%;margin-left:15px;">
                          <label for="amc-service-charges" style="margin-bottom: 0px;">AMC Cost</label>
                          <input type="number" class="form-control" id="amc-service-charges"
                            ng-model="feedback.amcServiceCharges"
                            style="padding: 6px 2px; width: 94%;"
                            placeholder="Your input here">
                        </div>
                      </div>


                      <!-- CMC Details Section -->
                      <div ng-show="feedback.contract === 'CMC' && feedback.assetWithAmc === 'AMC/ CMC applicable'" style="width: 100%;">

                        <div class="form-group" style="margin-top: -18px; width: 100%; margin-left: 15px;">
                          <label for="cmc-start-date" style="margin-bottom: 5px;">CMC Start Date</label>
                          <div style="position: relative;">
                            <input type="datetime-local" class="form-control" id="cmc-start-date"
                              ng-model="feedback.cmcStartDate"
                              style="padding: 6px 10px; border: 1px solid #ced4da; width: 94%;"
                              autocomplete="off" />
                            <span class="calendar-icon-container" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                              <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" style="margin-right:29px;" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm0 1V1h8v-.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v2H1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 1 0V1zm-2 4v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
                              </svg>
                            </span>
                          </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px; width: 100%; margin-left: 15px;">
                          <label for="cmc-end-date" style="margin-bottom: 5px;">CMC End Date</label>
                          <div style="position: relative;">
                            <input type="datetime-local" class="form-control" id="cmc-end-date"
                              ng-model="feedback.cmcEndDate"
                              style="padding: 6px 10px; border: 1px solid #ced4da; width: 94%;"
                              autocomplete="off" />
                            <span class="calendar-icon-container" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                              <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" style="margin-right:29px;" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm0 1V1h8v-.5a.5.5 0 0 1 1 0V1h1a1 1 0 0 1 1 1v2H1V2a1 1 0 0 1 1-1h1V.5a.5.5 0 0 1 1 0V1zm-2 4v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5H1z" />
                              </svg>
                            </span>
                          </div>
                        </div>

                        <div class="form-group" style="margin-top: 10px; width: 100%; margin-left: 15px;">
                          <label for="cmc-service-charges" style="margin-bottom: 0px;">CMC Cost</label>
                          <input type="number" class="form-control" id="cmc-service-charges"
                            ng-model="feedback.cmcServiceCharges"
                            style="padding: 6px 1px; width: 94%;"
                            placeholder="Your input here">
                        </div>
                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-top: 0px;">

                          <span class="addon" style="font-size: 16px;">{{lang.assetquantity}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" ng-change="calculateTotalPrice()" maxlength="30" type="number" id="assetquantity" ng-required="true" ng-model="feedback.assetquantity" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: -21px">

                          <span class="addon" style="font-size: 16px;">{{lang.unitprice}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" ng-change="calculateTotalPrice()" type="number" id="unitprice" ng-model="feedback.unitprice" autocomplete="off" style="padding-top:0px; width:100%" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group" style="margin-top: -11px;margin-left:2px;">
                          <span class="addon" style="font-size: 16px;">{{lang.depreciation}}</span>
                          <span class="has-float-label">
                            <input class="form-control" placeholder="{{lang.input}}" maxlength="30" type="number" id="contactnumber" ng-model="feedback.depreciation" autocomplete="off" style="padding-top:0px;" />
                            <label for="contactnumber"></label>
                          </span>
                        </div>
                      </div>

                      <!-- Button to calculate depreciation -->
                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: -5px;">
                        <button class="btn btn-primary" ng-click="calculateDepreciation()">Calculate Asset Value</button>
                      </div>

                      <!-- Depreciation result display -->
                      <div class="col-xs-12 col-sm-12 col-md-12" ng-if="calculatedDepreciation" style="margin-top: 16px;">
                        <p>Current value of the Asset is: {{assetCurrentValue | currency:"":0}}</p>
                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: 8px">

                          <span class="addon" style="font-size: 16px;">{{lang.totalprice}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.totalprice_placeholder}}" maxlength="40" type="number" id="totalprice" ng-required="true" ng-model="feedback.totalprice" autocomplete="off" style="padding-top:0px; width:100%" readonly>

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>


                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: -21px">

                          <span class="addon" style="font-size: 16px;">{{lang.supplierinfo}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="Your input here" maxlength="40" type="text" id="supplierinfo" ng-required="true" ng-model="feedback.supplierinfo" autocomplete="off" style="padding-top:0px; width:100%" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: -21px">

                          <span class="addon" style="font-size: 16px;">{{lang.servicename}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="Your input here" maxlength="40" type="text" id="servicename" ng-required="true" ng-model="feedback.servicename" autocomplete="off" style="padding-top:0px; width:100%" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: -21px">

                          <span class="addon" style="font-size: 16px;">{{lang.servicecon}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="Your input here" maxlength="10" type="text" id="servicecon" ng-required="true" ng-model="feedback.servicecon" autocomplete="off" ng-pattern="/^[1-9][0-9]{9}$/" style="padding-top:0px; width:100%" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12">

                        <div class="form-group" style="margin-left: 0px; margin-top: -21px">

                          <span class="addon" style="font-size: 16px;">{{lang.servicemail}}</span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="Your input here" maxlength="40" type="email" id="servicemail" ng-required="true" ng-model="feedback.servicemail" autocomplete="off" style="padding-top:0px; width:100%" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>



                      <div class="form-group" style="margin-left: 15px; margin-right: 13px; margin-top: -10px;">
                        <label for="imageInput" class="custom-file-uploadi" style="font-weight: bold;">
                          {{lang.attach_img}}
                        </label>
                        <input id="imageInput" style="border-bottom: 0px; display: none;" type="file" accept="image/jpeg, image/png, image/gif" multiple ng-model="feedback.images" onchange="angular.element(this).scope().encodeImages(this)" />
                        <button type="button" class="btn btn-primary btn-sm" ng-show="feedback.images && feedback.images.length > 0" ng-click="triggerFileInput()" style="margin-left: 10px;">
                          <i class="fa fa-plus"></i> Add More
                        </button>
                        <br>
                        <div ng-repeat="image in feedback.images track by $index" style="display: inline-block; margin-right: 10px; margin-top: 10px; position: relative;">
                          <img ng-src="{{image}}" alt="Encoded Image" style="max-width: 100px; max-height: 100px;" />
                          <button type="button" class="btn btn-danger btn-xs" ng-click="removeImage($index)" style="position: absolute; top: 0; right: 0;">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>

                        <br>

                        <label for="imageInput" class="custom-file-upload" style="font-weight: bold;">
                          Upload documents:
                        </label>
                        <label for="fileInput" class="custom-file-upload" style="font-weight: bold;">
                          {{lang.attach_file}}
                        </label>

                        <!-- File Input for Document Upload -->
                        <input style="border-bottom: 0px;" type="file" accept="*" multiple onchange="angular.element(this).scope().encodeFiles(this)" />
                        <br>

                        <!-- Display the list of uploaded files -->
                        <div ng-if="feedback.files_name && feedback.files_name.length > 0">
                          <h3 style="font-size: 18px; margin-top:16px;">Uploaded Files:</h3>
                          <ul style="margin-left: 19px;">
                            <li ng-repeat="files_name in feedback.files_name track by $index" style="display: flex; align-items: center;">
                              <a href="{{files_name.url}}" target="_blank" style="margin-right: 8px;">{{files_name.name}}</a>
                              <span style="cursor: pointer; color: red; font-weight: bold;" ng-click="removeFile($index)">&#10060;</span>
                            </li>
                          </ul>
                        </div>

                      </div>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                        <p style="font-size: 16px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                        <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 95%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                      </div>


                    </div>
                  </div>


                  <!-- <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                    <p style="font-size: 16px; text-align:left; margin-bottom: 6px; margin-left: -2px;">{{lang.data_analysis}}</p>
                    <textarea style="border:1px solid #ced4da; margin-left: -2px; margin-top: 6px; padding: 10px; width: 95%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                  </div> -->





                  <!-- submit button -->
                  <input type="button" name="previous" class="previous action-button-previous" style=" font-size:small;margin-left:12px;margin-top:40px;" ng-click="prev()" value="{{lang.previous}}" />

                  <div>
                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:12px;margin-top:40px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
                    <img src="https://media.tenor.com/8ZhQShCQe9UAAAAC/loader.gif" ng-show="loader == true">
                  </div>

                </fieldset>

                <!-- Thank you page -->
                <fieldset ng-show="step4 == true">

                  <div class="form-card">

                    <div class="row justify-content-center">

                      <div class="col-12 text-center">
                        <br>
                        <img src="dist/tick.png"> <br>

                        <p style="text-align:center; margin-top: 45px; font-weight: 300;" class="lead">

                          {{lang.unhappythankyoumessage}}
                        </p>

                      </div>

                    </div>
                    <div ng-show="qrCodeUrl" class="text-center">

                      <img ng-src="{{qrCodeUrl}}" alt="QR Code" style="width: 200px; height: 200px;" />
                    </div>

                    <div ng-show="showUrlAfterScan" class="text-center">
                      <a ng-href="{{assetUrl}}" target="_blank">{{assetUrl}}</a>
                    </div>
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

  .btn-primary {
    background-color: #686DE0;
    border-color: #686DE0;
    border-radius: 7px;
    color: white;
    padding: 8px 16px;
    font-size: 16px;
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

  .custom-file-uploadi {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 4px;
  }

  .custom-file-uploadi:hover {
    background-color: #e9ecef;
  }

  .btn-xs {
    padding: 0.15rem 0.25rem;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 0.2rem;
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