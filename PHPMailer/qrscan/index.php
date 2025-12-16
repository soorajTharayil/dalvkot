<!DOCTYPE html>
<html lang="en">

<head>
    <title>Efeedor Feedback System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
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
        <a class="navbar-brand" href="#"><img src="logo.png" style="    height: 36px;"></a>
        <!-- dropdown for three language start -->
        <span style="margin-top: 25px;    font-size: 17px;    font-weight: bold; float:right;  ">
            <div class="dropdown-toggle" data-toggle="dropdown" style="   font-weight: bold; float:right;"> <i class="fa fa-language "></i> {{typel}}</a>
                <ul class="dropdown-menu" style="width: 70px;">

                    <li>
                        <a href="javascript:void(0)" id="englishid" class="nav-link btn-primary  mr-4" ng-click="language('english')">English</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" id="kanadaid" class="nav-link mr-4" ng-click="language('kanada')">ಕನ್ನಡ</a>

                    </li>
                    <li>
                        <a href="javascript:void(0)" id="malayalamid" class="nav-link mr-4" ng-click="language('malayalam')">malayalam</a>

                    </li>
                    <li>
                        <a href="javascript:void(0)" id="tamilid" class="nav-link mr-4" ng-click="language('tamil')">தமிழ்</a>

                    </li>
                </ul>
            </div>
        </span>
        <!-- dropdown for three language end -->
    </nav>
    <!-- top navbar end -->

    <div class="container" id="grad1">
        <!-- <style>
        .container-fluid{
            background-image: url('loginpage.png');
        }
    </style> -->

        <div class="row justify-content-center">

            <div class=" col-lg-12 col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-2 mb-2">

                <div class="card px-0 pt-2 pb-0 ">
                    <div class="card" style="text-align:left;">
                       <a href="../"><i class="fa fa-user" aria-hidden="true"></i> 
                        <span>Login</span></a>
                    </div>
                    <br>
                    <h3 class="text"><strong>{{lang.title1}}</strong></h3>
                    <h6 class="text">{{lang.title2}}</br>{{lang.title3}}</h6>
                    <hr>
                    <br>
                    <h6 class="text" style="font-size: 18px;"><strong>{{lang.title4}}</strong></h6> <br>
                    <!-- <p>&nbsp;</p> -->
                    <br>
                    <div class="box box-primary profilepage" style=" background: transparent;">
                        <div class="box-body box-profile" style="display: inline-block;">
                            <a href="../interimfeedback/" class="btn btn-danger btn-block" style="padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5);background-color:#DB6B97; border:none;">
                                {{lang.button1}}</a>
                            <br>
                            <br>
                            <!-- <p>&nbsp;</p> -->
                            <!-- <a href="../patientservicerequest/" class="btn btn-success btn-block" style="padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); border:none;">
                                SERVICE REQUEST</a> -->
                            <!-- <p>&nbsp;</p> -->
                            <a href="../ipfeedback/" class="btn btn-primary btn-block" style="padding: 15px;border-radius: 45px; font-size: 16px; box-shadow: 0px 1px 1px rgba(0,0,0,0.5); border:none;">
                                {{lang.button2}}</a>
                            <p>&nbsp;</p>
                        </div>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>

                        <div class="box box-primary profilepage">

                            <div style="background: transparent; width: 100%;">
                                <img class="profile-user-img img-responsive" style="width: 150px;" src="log.png" alt="User profile picture">
                                <br>
                                <br>
                                <br>

                            </div>
                        </div><br>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

</body>
<!-- css code start  -->
<style>
    .dropdown-menu {
        /* width: 70px; */
        position: absolute;
        left: auto;
        right: 0px;
        padding: 0px;
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
</style>
<!-- css code end  -->


<script>
    setTimeout(function() {

        $('#body').show();

    }, 2000);
</script>

</html>