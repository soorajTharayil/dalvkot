<!DOCTYPE html>
<html lang="en">
<!-- QR SCAN  -->

<head>
  <title>Efeedor Healthcare Experience Management Platform</title>
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

<!-- body part start -->

<body ng-app="ehandorApp" ng-controller="PatientFeedbackCtrl" style="display:none;" id="body">
  <!-- top navbar start -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed">
    <!-- logo of efeedor -->
    <a class="navbar-brand" href="#"><img src="{{setting_data.logo}}" style="    height: 36px;"></a>
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#languageModal" style="margin: 4px; float:right;">
      {{type2}}
      <i class="fa fa-language" aria-hidden="true"></i>
    </button>
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
            <div class="card px-0 pt-2 pb-0">
              <div class="left" style="margin-left: 68vw; max-width: 100%; margin-top: 5px; margin-right: -10px;">

              </div>
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
                      <span style="margin-left: -133px; color: #4b4c4d;">
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

  <?php
  include("../env.php");
  $db['hostname'] = $config_set['DBHOST'];
  $db['username'] = $config_set['DBUSER'];
  $db['password'] = $config_set['DBPASSWORD'];
  $db['database'] = $config_set['DBNAME'];
  $baseurl = $config_set['BASE_URL'];

  /* End of file database.php */
  /* Location: ./application/config/database.php */
  $con = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database'])
    or die('Could not connect to the database server' . mysqli_connect_error());

  $sql = 'SELECT * FROM `setting` WHERE 1';
  $result = mysqli_query($con, $sql);
  $reviewlink = mysqli_fetch_object($result);
  $slink = $reviewlink->google_review_link;
  $hospitalname = $reviewlink->title;



  // $hospitalname= {{setting_data.title}};


  // $welcometext = "Thank you for choosing " . $hospitalname . " for your healthcare needs. We work constantly to improve and meet your expectations.";
  $welcometext = "Thank you for taking your time and effort. Please select the appropriate option to proceed.";


  ?>
  <div class="container" id="grad1">

    <div class="row justify-content-center">

      <div class=" col-lg-12 col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">

        <div class="card px-0 pt-2 pb-0 ">

          <fieldset ng-show="step2 == true">
            <div class="left" style="margin-left: 68vw;max-width: 100%;margin-top: 5px;margin-right: -10px;">
              <a href="../login">
                <img src="./user.png" style="max-width: 100%; height: 45px;" alt="">
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
            <div class="box box-primary profilepage" style=" background: transparent;">
              <div class="box-body box-profile" style="display: inline-block;margin-left: 25px; margin-right: 25px;">
                <a href="../pcrf?src=QR" class="btn btn-danger btn-block" style="padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5);background-color:#DB6B97; border:none;">
                  {{lang.button1}}</a>
                <br>

                <!-- <a href="../opfeedback" class="btn btn-success btn-block" style="padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); border:none;">
                                OutPatient Feedback</a>
                            <br> -->

                <p>&nbsp;</p>
                <a href="../ipfb?src=QR" class="btn btn-primary btn-block" style=" background: #4285F4 ; padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); border:none;">
                  {{lang.button2}}</a>
                <p>&nbsp;</p>
              </div>
              <!-- <p>&nbsp;</p>  -->


              <br> <!-- <p>&nbsp;</p> -->

              <div class="box box-primary profilepage">

                <div style="background: transparent; width: 100%;">
                  <img class="profile-user-img img-responsive" style="width: 150px;" src="log.png" alt="User profile picture">
                  <br>
                  <br>
                  <br>
                  <br>

                </div>
              </div><br>
            </div>
          </fieldset>

        </div>
        <br> <br> <br> <br> <br>
      </div>
    </div>
  </div>

</body>
<!-- css code start  -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.5/typed.min.js" integrity="sha512-1KbKusm/hAtkX5FScVR5G36wodIMnVd/aP04af06iyQTkD17szAMGNmxfNH+tEuFp3Og/P5G32L1qEC47CZbUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  var typed = new Typed(".typing-text", {
    strings: ["<?php echo $welcometext; ?>"],
    loop: false,
    typeSpeed: 50,
    backSpeed: 5,
    backDelay: 1000,
  });
</script>
<style>
  .dropdown-menu {
    /* width: 70px; */
    position: absolute;
    left: auto;
    right: 0px;
    padding: 0px;
    list-style: none;
    width: 100%;

  }

  ul.dropdown-menu.show li a {
    padding: 7px 22px;
    /* background: #007bff; */
    width: 100%;
    display: block;
    /* color:#4b4c4d; */
  }

  .dropdown-toggle {
    font-size: 18px;
    color: #fff;
    margin-top: -16px;
    text-transform: capitalize;
  }
</style>
<!-- css code end  -->


<script>
  setTimeout(function() {

    $('#body').show();

  }, 2000);
</script>

</html>