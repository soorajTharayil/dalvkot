<!DOCTYPE html>

<html lang="en">


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
    <!-- <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal" style="margin: 4px; float:right;">
      {{type2}}
      <i class="fa fa-language" aria-hidden="true"></i>
    </button> -->
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



  <div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">

      <div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">
        <img src="{{setting_data.logo}}" style="    height: 50px;">

        <br>
        <div class="card px-0 pt-2 pb-0 mt-2 mb-3">



          <div class="row">

            <div class="col-md-12 mx-0">

              <!-- form start -->
              <form id="msform" ng-if="assetDetails">

                <fieldset class="form-card" ng-show="step0 == true">
                  <h4 style="text-align: center; margin-bottom: 20px;">
                    <strong>If you are an organisation employee,
                      <span style="color:rgb(40, 221, 94); cursor: pointer;" ng-click="goToLogin()">Login</span>
                      to view more details and take actions.
                    </strong>
                  </h4>

                  <h4><strong>ASSET DETAILS</strong></h4>
                  <br>
                  <div class="form-card">

                    <table class="table">
                      <!-- Asset Details -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>Asset Details</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Asset Code</strong></td>
                        <td>{{ assetDetails.patientid || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Name</strong></td>
                        <td>{{ assetDetails.assetname || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Group</strong></td>
                        <td>{{ assetDetails.ward || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Brand</strong></td>
                        <td>{{ assetDetails.brand || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Model</strong></td>
                        <td>{{ assetDetails.model || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Serial No.</strong></td>
                        <td>{{ assetDetails.serial || '-' }}</td>
                      </tr>
                      <!-- <tr>
                        <td><strong>Allocated User</strong></td>
                        <td>{{ assetDetails.assignee || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Allocated Department</strong></td>
                        <td>{{ assetDetails.depart || '-' }}</td>
                      </tr> -->

                      <!-- Asset Location -->
                      <!-- <tr>
                        <th colspan="2" style="text-align: left;"><strong>Asset Location</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Area</strong></td>
                        <td>{{ assetDetails.locationsite || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Site</strong></td>
                        <td>{{ assetDetails.bedno || '-' }}</td>
                      </tr> -->

                      <!-- Purchase & Warranty Info -->
                      <!-- <tr>
                        <th colspan="2" style="text-align: left;"><strong>Purchase & Warranty Info</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Purchase Date</strong></td>
                        <td>{{ assetDetails.purchaseDate || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Warranty Start Date</strong></td>
                        <td>{{ assetDetails.warrenty || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Warranty End Date</strong></td>
                        <td>{{ assetDetails.warrenty_end || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Quantity</strong></td>
                        <td>{{ assetDetails.assetquantity || '-' }}</td>
                      </tr> -->

                      <!-- AMC/CMC Details -->
                      <!-- <tr>
                        <th colspan="2" style="text-align: left;"><strong>AMC/CMC Details</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Contract Type</strong></td>
                        <td>{{ assetDetails.contract || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Start Date</strong></td>
                        <td>{{ assetDetails.contract_start_date || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>End Date</strong></td>
                        <td>{{ assetDetails.contract_end_date || '-' }}</td>
                      </tr> -->


                      <!-- Supplier Info -->
                      <!-- <tr>
                        <th colspan="2" style="text-align: left;"><strong>Supplier Info</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Supplier Name</strong></td>
                        <td>{{ assetDetails.supplierinfo || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Name</strong></td>
                        <td>{{ assetDetails.servicename || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Contact</strong></td>
                        <td>{{ assetDetails.servicecon || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Email</strong></td>
                        <td>{{ assetDetails.servicemail || '-' }}</td>
                      </tr> -->
                    </table>
                  </div>
                </fieldset>

                <fieldset ng-show="step1 == true">
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

                <!-- PATIENT INFORMATION page start -->
                <fieldset class="form-card" ng-show="step2 == true">
                  <h4><strong>ASSET DETAILS</strong></h4>
                  <br>
                  <div class="form-card" style="margin-top: -36px;">
                    <div class="mb-3">
                      <p style="margin-left: -2px; padding: 1px; text-align: left;">
                        Use the dropdown below to Edit asset details, report issues, update Preventive Maintenance(PM), Calibration, Contracts, and add asset components.
                      </p>

                      <div class="d-flex justify-content-start">
                        <div class="dropdown me-auto">
                          <button class="btn btn-primary dropdown-toggle" type="button" id="assetActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Take Actions
                          </button>
                          <div class="dropdown-menu" aria-labelledby="assetActionsDropdown">

                            <a class="dropdown-item" href="/login/?userid={{adminId}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['EDIT-ASSET'] == true">Edit Asset Details</a>
                            <a class="dropdown-item" href="/isrf/?userid={{adminId}}&location={{assetDetails.locationsite}}&site={{assetDetails.bedno}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['ISR-REQUESTS-DASHBOARD'] == true">Report Issue/ Request</a>
                            <a class="dropdown-item" href="/asset_preventive/?userid={{adminId}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['PREVENTIVE-MAINTENANCE-FORM'] == true">Update Preventive Maintenance</a>
                            <a class="dropdown-item" href="/asset_calibration/?userid={{adminId}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['ASSET-CALLIBRATION-FORM'] == true">Update Calibration</a>
                            <a class="dropdown-item" href="/asset_warranty/?userid={{adminId}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['WARRANTY-FORM'] == true">Update Asset Warranty</a>
                            <a class="dropdown-item" href="/asset_amc_cmc/?userid={{adminId}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['AMC-CMC-FORM'] == true">Update Asset AMC/ CMC</a>
                            <a class="dropdown-item" href="/add_subasset/?userid={{adminId}}&assetname={{assetDetails.assetname}}&assetcode={{assetDetails.patientid}}" ng-if="profilen['REGISTER-ASSET-FORM'] == true">Add Component</a>
                          </div>
                        </div>
                      </div>
                    </div>


                    <table class="table">
                      <!-- Asset Details -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>Asset Details</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Asset Code</strong></td>
                        <td>{{ assetDetails.patientid || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Name</strong></td>
                        <td>{{ assetDetails.assetname || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Group</strong></td>
                        <td>{{ assetDetails.ward || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Brand</strong></td>
                        <td>{{ assetDetails.brand || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Model</strong></td>
                        <td>{{ assetDetails.model || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Serial No.</strong></td>
                        <td>{{ assetDetails.serial || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Allocated User</strong></td>
                        <td>{{ assetDetails.assignee || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Allocated Department</strong></td>
                        <td>{{ assetDetails.depart || '-' }}</td>
                      </tr>

                      <!-- Asset Location -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>Asset Location</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Area</strong></td>
                        <td>{{ assetDetails.locationsite || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Site</strong></td>
                        <td>{{ assetDetails.bedno || '-' }}</td>
                      </tr>

                      <!-- Purchase & Warranty Info -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>Purchase & Warranty Info</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Purchase Date</strong></td>
                        <td>{{ assetDetails.purchaseDate || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Warranty Start Date</strong></td>
                        <td>{{ assetDetails.warrenty || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Warranty End Date</strong></td>
                        <td>{{ assetDetails.warrenty_end || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Asset Quantity</strong></td>
                        <td>{{ assetDetails.assetquantity || '-' }}</td>
                      </tr>

                      <!-- AMC/CMC Details -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>AMC/CMC Details</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Contract Type</strong></td>
                        <td>{{ assetDetails.contract || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Start Date</strong></td>
                        <td>{{ assetDetails.contract_start_date || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>End Date</strong></td>
                        <td>{{ assetDetails.contract_end_date || '-' }}</td>
                      </tr>


                      <!-- Supplier Info -->
                      <tr>
                        <th colspan="2" style="text-align: left;"><strong>Supplier Info</strong></th>
                      </tr>
                      <tr>
                        <td><strong>Supplier Name</strong></td>
                        <td>{{ assetDetails.supplierinfo || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Name</strong></td>
                        <td>{{ assetDetails.servicename || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Contact</strong></td>
                        <td>{{ assetDetails.servicecon || '-' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Service Person Email</strong></td>
                        <td>{{ assetDetails.servicemail || '-' }}</td>
                      </tr>
                    </table>
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
  /* General Styling */
  .form-card {
    padding: 20px;

    border-radius: 5px;
    background-color: #f9f9f9;
    margin-bottom: 20px;
  }

  /* Table Styles */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  /* Table Headers */
  th {
    background-color: #f1f1f1;
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    padding: 10px;
    border: 1px solid #ddd;
  }

  /* Table Data Cells */
  td {
    padding: 10px;
    text-align: left;
    font-size: 13px;
    border: 1px solid #ddd;
  }

  /* Section Headings */
  h4,
  h5 {
    margin: 15px 0;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    color: #333;
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