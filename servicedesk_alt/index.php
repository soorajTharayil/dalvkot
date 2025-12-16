<!DOCTYPE html>
<html lang="en">

<head>
  <title>Efeedor Healthcare Experience Platform</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <script src="app.js?<?php echo time(); ?>"></script>

</head>

<body ng-app="ehandorApp" ng-controller="PatientFeedbackCtrl">

  <fieldset ng-show="step0 == true">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed">
      <!-- logo of efeedor -->
      <a class="navbar-brand" href="#"><img src="{{setting_data.logo}}" style="height: 36px;"></a>
      <div class="ml-auto"> <!-- Use Bootstrap's 'ml-auto' class to push the button to the right -->
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal" style="margin: 4px;">
          {{type2}}
          <i class="fa fa-language" aria-hidden="true"></i>
        </button>
      </div>
    </nav>
    <!-- top navbar end -->
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
                <div class="left" style="margin-left: 68vw; max-width: 100%; margin-top: 5px; margin-right: -10px;">

                </div>
                <div style="text-align: left; align-items: left; margin-left: 25px; margin-right: 25px;"></div>
                <div class="box box-primary profilepage" style="background: transparent;">
                  <div class="box-body box-profile" style="display: inline-block;">

                    <div class="" style=" border: 2px solid #000;">
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

                    <div class="" style=" border: 2px solid #000;">
                      <div class="card-body" ng-click="language('lang2')" style="padding: 5px; height:100px; width:200px; " data-dismiss="modal">
                        <span style="margin-left: -133px; color: #4b4c4d;">
                          ಕನ್ನಡ
                        </span><br>
                        <span style="font-size: 34px; color: #4b4c4d; font-weight: bold;">
                          ಕ
                        </span>
                      </div>
                    </div>
                    <br>

                    <div class="" style=" border: 2px solid #000;">
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

    <div class="container" id="grad1">

      <div class="row justify-content-center">

        <div class=" col-lg-12 col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">

          <div class=" px-0 pt-2 pb-0 ">

            <div class="left" style="margin-left: 68vw;max-width: 100%;margin-top: 5px;margin-right: -10px;">
              <a href="../form_login">
                <img src="./logout.png" style="max-width: 100%; height: 45px;" alt="">
              </a>
            </div>


            <div style=" text-align:left; align-items:left; margin-left: 25px; margin-right: 25px;">
              <?php
              date_default_timezone_set('Asia/Kolkata');
              $hour = date('H');

              if ($hour < 12) {
                echo '<h4>{{lang.goodmorning}}</h4>';
              } elseif ($hour < 18) {
                echo '<h4>{{lang.goodafternoon}}</h4>';
              } else {
                echo '<h4>{{lang.goodevening}}</h4>';
              }
              ?>

              <p><span>{{lang.title3}}</span></p>

              <hr>
            </div>

            <br>
            <h6 class="text" style="font-size: 18px;  text-align:center;  margin-left: 25px; margin-right: 25px;"><strong>{{lang.title4}}</strong></h6>
            <!-- <p>&nbsp;</p> -->
            <br> <br>
            <div class="box box-primary profilepage" style="background: transparent;">
              <div class="box-body box-profile" style="display: inline-block; margin-left: 25px; margin-right: 25px;">

               
                <div >
                  <a href="../isrr_alt?src=Link" class="btn btn-danger btn-block" style="background: #4285F4; padding: 15px; border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); border:none;">{{lang.button4}}</a>
                  <br>
                </div>

                <div >
                  <a href="../inn_alt?src=Link" class="btn btn-primary btn-block" style="padding: 15px; border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); background-color:#DB6B97; border:none;">{{lang.button5}}</a>
                  <br>
                </div>

               
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </fieldset>

  <script>
    function togglePassword() {
      var passwordField = document.getElementById("password");
      var passwordToggle = document.querySelector(".password-toggle");

      if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordToggle.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>'; // Change HTML to eye icon
      } else {
        passwordField.type = "password";
        passwordToggle.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>'; // Change HTML to eye slash icon
      }
    }
  </script>

  <style>
    .input-field {
      padding: 12px;
      font-size: 16px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      /* Add border */
      border-radius: 25px;
      /* Add border radius */
      margin-bottom: 15px;
      width: 100%;
      box-sizing: border-box;
      color: #000;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      /* Add box shadow */
    }

    .password-container {
      position: relative;
    }

    .password-input {
      width: calc(100% - 40px);
      /* Adjust width to accommodate the show/hide button */
    }

    .password-toggle {
      position: absolute;
      right: 10px;
      top: 39%;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
</body>

</html>