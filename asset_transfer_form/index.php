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
        <img src="{{setting_data.logo}}" style="    height: 50px;">

        <br>
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

                        <div class="form-group" style="margin-top: -17px;">

                          <span class="addon" style="font-size: 16px;">{{lang.patientid}}<sup style="color:red">*</sup></span>

                          <span class="has-float-label">

                            <input class="form-control" placeholder="{{lang.input}}" maxlength="20" ng-change="fetchAssetDetails()" type="text" id="contactnumber" ng-required="true" ng-model="feedback.patientid" autocomplete="off" style="padding-top:0px;" />

                            <label for="contactnumber"></label>

                          </span>

                        </div>

                      </div>

                      <div class="row" ng-if="assetDetails.length > 0" style="margin-top: -18px; margin-left:-22px; width: 98%;">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                          <fieldset style="padding: 10px; margin-bottom: 20px;width: 95%; margin-left: 15px;">
                            <h3 style="font-size: 1.2em; font-weight: bold;text-align: left;">Asset Details</h3>
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                              <tr ng-repeat="asset in assetDetails">
                                <td class="details-label" style="border: 1px solid #dddddd; padding: 10px; text-align: left;">Asset Code</td>
                                <td style="border: 1px solid #dddddd; padding: 10px; text-align: left;">{{ asset.patientid }}</td>
                              </tr>
                              <tr ng-repeat="asset in assetDetails">
                                <td class="details-label" style="border: 1px solid #dddddd; padding: 10px; text-align: left;">Asset Name</td>
                                <td style="border: 1px solid #dddddd; padding: 10px; text-align: left;">{{ asset.assetname }}</td>
                              </tr>
                              <tr ng-repeat="asset in assetDetails">
                                <td class="details-label" style="border: 1px solid #dddddd; padding: 10px; text-align: left;">Allocated Department</td>
                                <td style="border: 1px solid #dddddd; padding: 10px; text-align: left;">{{ asset.depart }}</td>
                              </tr>
                              <tr ng-repeat="asset in assetDetails">
                                <td class="details-label" style="border: 1px solid #dddddd; padding: 10px; text-align: left;">Allocated User</td>
                                <td style="border: 1px solid #dddddd; padding: 10px; text-align: left;">{{ asset.assignee }}</td>
                              </tr>
                              <tr ng-repeat="asset in assetDetails">
                                <td class="details-label" style="border: 1px solid #dddddd; padding: 10px; text-align: left;" rowspan="1">Location</td>
                                <td colspan="2" style="border: 1px solid #dddddd; padding: 10px; text-align: left;">
                                  Area: {{ asset.locationsite }}<br>
                                  Site: {{ asset.bedno }}
                                </td>
                              </tr>

                            </table>
                          </fieldset>

                        </div>
                      </div>

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
                            <select class="form-control" id="assigned" ng-required="true" ng-model="feedback.assigned" autocomplete="off" ng-change="updateAssetStatus()" style="padding-top:0px;margin-top: 5px;padding-left:0px;width:100%">
                              <option value="Select Asset User">Select Asset User</option>

                              <option ng-repeat="x in userlist.user" ng-show="x.firstname != 'developer'" ng-disabled="feedback.assigned_user_id && x.user_id != feedback.assigned_user_id" value="{{x.firstname}}" required>{{x.firstname}}</option>
                            </select>
                            <label for="bednumber"></label>
                          </span>
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

                        <!-- <h2 class="fs-title text-center" style="font-weight: 300;">{{lang.thankyou}}</h2><br> -->

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