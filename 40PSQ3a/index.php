<!DOCTYPE html>

<html lang="en">



<!-- head part start -->

<!-- IP FEEDBACK INDEX PAGE -->



<head>

  <title>Quality KPI Management Software - Efeedor Healthcare Experience Management Platform</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  <link rel="stylesheet" href="style.css?<?php echo time(); ?>">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

  <script src="app_10PSQ3a.js?<?php echo time(); ?>"></script>

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

                <fieldset ng-show="step1 == true">

                  <h4 style="font-size:18px"><strong>{{lang.kpi_info}} {{selectedMonths}} {{selectedYears}}</strong></h4>

                  <!--<p>Fill all form field to go to next step</p>-->
                  <br>
                  <div class="form-card">

                    <div class="row">

                      <!-- KPI Name -->

                      <p style="margin-left:20px;font-size: 16px;margin-right:10px;margin-bottom:30px;"><b>{{lang.definition}}</b> {{lang.kpi_def}}</p>

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:5px;">
                        <div class="form-group transparent-placeholder">
                          <span class="addon" style="font-size: 16px; margin-bottom: 15px;"><b>{{lang.formula_para1}}</b><sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" oninput="restrictToNumerals(event)" placeholder="{{lang.formula_para1_placeholder}}" ng-model="feedback.initial_assessment_hr" type="number" id="formula_para1" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 50%;" />
                            <label for="para1"></label>
                          </span>

                        </div>
                      </div>

                      <!-- <p>&nbsp;</p> -->

                      <div class="col-xs-12 col-sm-12 col-md-12" style="margin-left:5px;">
                        <div class="form-group transparent-placeholder">
                          <span class="addon" style="font-size: 16px; margin-bottom: 15px;"><b>{{lang.formula_para2}}</b><sup style="color:red">*</sup></span>
                          <span class="has-float-label">
                            <input class="form-control" oninput="restrictToNumerals(event)" ng-model="feedback.total_admission" placeholder="{{lang.formula_para2_placeholder}}" type="number" id="formula_para2" ng-required="true" autocomplete="off" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 50%;" />
                            <label for="para2"></label>
                          </span>
                        </div>
                      </div>



                      <button type="button" class="btn btn-primary" ng-click="calculateICUSMR()" style="margin-left:20px;">
                        Compute KPI
                      </button>


                    </div>

                  </div>




                  <div ng-if="calculatedResult" style="margin-top: 15px;text-align:left;"><br>

                    <div style="margin-left:15px;">
                      <strong>The percentage of Point-of-Care Testing (POCT) results that led to a clinical intervention is: <span style="color: blue; font-size:16px;">{{calculatedResult}}%</span></strong><br><br>
                      <!-- <strong>Bench Mark Time: 04:00:00</strong> -->
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                      <p style="font-size: 16px; margin-bottom: 6px;"><b>{{lang.data_analysis}}<sup style="color:red">*</sup></b></p>
                      <textarea style="border: 1px ridge grey; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea1" ng-model="feedback.dataAnalysis" rows="5"></textarea>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                      <p style="font-size: 16px; margin-bottom: 6px;"><b>{{lang.corrective_action}}<sup style="color:red">*</sup></b></p>
                      <textarea style="border: 1px ridge grey; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea2" ng-model="feedback.correctiveAction" rows="5"></textarea>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" style="padding-right: 0px; padding-left: 12px; margin-left: 5px; margin-top: 20px;">
                      <p style="font-size: 16px; margin-bottom: 6px;"><b>{{lang.preventive_action}}<sup style="color:red">*</sup></b></p>
                      <textarea style="border: 1px ridge grey; margin-top: 6px; padding: 10px; width: 85%; height: 85px;" class="form-control" id="textarea3" ng-model="feedback.preventiveAction" rows="5"></textarea>
                    </div>

                    <!-- Code for Upload files -->
                    <div style="margin-top: 20px; text-align: left; margin-left:17px;">
                      <label for="fileInput" class="custom-file-upload" style="font-weight: bold;font-size:16px;">
                        Upload Files
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






                  <br><br>

                  <input type="button" name="previous" style="font-size:small;margin-left:10px;" class="previous action-button-previous" ng-click="prev()" value="{{lang.previous}}" />
                  <!-- submit button -->
                  <div ng-if="calculatedResult">

                    <input type="button" ng-show="loader == false" style="background: #4285F4 ; font-size:small; margin-right:10px;" name="make_payment" class="next action-button" ng-click="savefeedback()" value="{{lang.submit}}" />
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

  <!-- KPI Deadline Popup -->
  <div class="modal fade" id="deadlineModal" tabindex="-1" role="dialog" aria-labelledby="deadlineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deadlineModalLabel">KPI Submission Deadline- {{selectedMonths}} {{selectedYears}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" ng-if="deadlineMessage">
          <p style="margin:0; font-size:16px; line-height:1.5;">
            {{deadlineMessage}}
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
  <!-- KPI Deadline Popup -->


</body>

<!-- body part start -->





<!-- css code start  -->

<style>
  #formula_para1,
  #formula_para2 {
    width: 40% !important;
  }

  @media (max-width: 768px) {

    #formula_para1,
    #formula_para2 {
      width: 73% !important;
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
    let currentValue = inputElement.value;

    // Allow only numbers and a single decimal point
    const filteredValue = currentValue
      .replace(/[^0-9.]/g, '') // remove non-numeric except '.'
      .replace(/(\..*)\./g, '$1'); // allow only one '.'

    if (currentValue !== filteredValue) {
      inputElement.value = filteredValue;
    }
  }
</script>

<!-- script code end  -->



</html>