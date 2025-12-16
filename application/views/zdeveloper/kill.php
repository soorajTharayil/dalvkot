<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DANGER</title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/killed.png');  ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
        <!-- THEME RTL -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css" />
    <?php } ?>

    <!-- 7 stroke css -->
    <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />

    <!-- style css -->
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            <div class="panel panel-bd" style="width:100%; text-align:center">

                <img src="<?php echo base_url('assets/images/killed.png'); ?>" style="height:100px; margin-top:10px;">
                <div class="panel-body">

                    <h4>Your are in danger zone!</h4>
                    <p><a href="<?php echo base_url('xyzzyspoon/panzerdep'); ?>"> <button class="btn btn-lg btn-danger">RESET DEPARTMENT</button></a> </p>
                    <p><a href="<?php echo base_url('xyzzyspoon/panzerIP'); ?>"> <button class="btn btn-lg btn-danger">RESET IP</button></a> </p>
                    <p><a href="<?php echo base_url('xyzzyspoon/panzerOP'); ?>"> <button class="btn btn-lg btn-danger">RESET OP</button></a> </p>
                    <p><a href="<?php echo base_url('xyzzyspoon/panzerPC'); ?>"> <button class="btn btn-lg  btn-danger">RESET PC</button></a> </p>
                    <p><a href="<?php echo base_url('xyzzyspoon/panzerESR'); ?>"> <button class="btn btn-lg  btn-danger">RESET ESR</button></a> </p>
                    <p><a href="<?php echo base_url('xyzzyspoon/bigbang'); ?>"> <button class="btn  btn-lg btn-danger">RESET ALL</button></a> </p>


                </div>
                <div class="panel-footer">

                    <a href="logout"> <button class="btn btn-success">Logout</button></a>
                </div>
            </div>
        </div>
    </div>



</body>

</html>