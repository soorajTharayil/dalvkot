<?php
defined('BASEPATH') or exit('No direct script access allowed');
//get site_align setting
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo lang_loader('global','global_login_efeedor_patient_exp'); ?></title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url('favicon.png'); ?>">

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
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc8CkcqAAAAACv2WebgYioIVJhljcDhqJk5AbAz"></script>


</head>

<body style="background-image: url('<?php echo base_url(); ?>assets/images/loginpage.png')">
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">

            <div class="panel panel-bd">
                <div class="panel-heading">
                    <!-- style=" background: #e0f3cf; " -->
                    <div class="view-header" style="margin: top 10px;">
                        <div class="header-icon">

                        </div>
                        <div class="title" style="text-align:center;align-items:center; ">
                            <img src="<?php echo base_url(); ?>assets/icon/loginlogo1.png" style="height:40px; width:150px;">
                            <h3 style="font-size: 30px; font-weight: bold;"></h3> <br>
                            <!-- <small><strong>Please sign-in to your account </strong></small><br> -->
                            <h5><strong><?php echo lang_loader('global','global_login_to_access_dash'); ?></strong></h5>

                        </div>

                    </div>

                    <div class="">

                        <!-- alert message -->
                        <?php if ($this->session->flashdata('message') != null) {  ?>
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('message'); ?>
                            </div>
                        <?php } ?>

                        <?php if ($this->session->flashdata('exception') != null) {  ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $this->session->flashdata('exception'); ?>
                            </div>
                        <?php } ?>

                        <?php if (validation_errors()) {  ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <br>
                <div class="panel-body" style="text-align: center;align-items:center;">
                    <?php echo form_open('login', 'id="loginForm" novalidate'); ?>
                    <div class="form-group">
                        <!-- <label class="control-label" for="email"><?= display('email') ?></label> -->
                        <input type="text" placeholder="Email Id / Mobile Number" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group" id="show_hide_password">
                        <!-- <label class="control-label" for="password"><?= display('password') ?></label> -->
                        <input type="password" placeholder="Password" name="password" id="password" class="form-control" required>
                        <div class="input-group-addon changepassword">
                            <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="control-label" for="user_role"><?= display('user_role') ?></label>
                        <?php
                        $userRoles = array(
                            // ''  => display('select_user_role'),
                            '1' => display('admin'),
                            '4' => 'Department HOD',
                            //   '2' => display('doctor'),
                            //   '3' => display('accountant'),
                            //   '4' => display('laboratorist'),
                            //   '5' => display('nurse'),
                            //   '6' => display('pharmacist'),
                            //    '7' => display('receptionist'),
                            //   '8' => display('representative'),
                            //   '9' => display('case_manager'),
                            //   '10' => display('patient')
                        );
                        echo form_dropdown('user_role', $userRoles, $user->user_role, 'class="form-control" id="user_role" ');

                        ?>
                    </div>
                    <br>
                    <div style="text-align:center;align-items:center;">
                        <button class="btn btn-success " type="submit" class="btn btn-success"><?php echo lang_loader('global','global_login'); ?></button>
                    </div>
                    <br />

                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
    <style>
        .panel {
            border-radius: 15px;
        }

        .btn {
            border-radius: 15px;
        }

        .form-control {
            border-radius: 15px;
        }

        .changepassword {
            width: 45px;
            position: relative;
            float: right;
            margin-top: -33px;
            padding: 8px;
            background: transparent;
            border: 0px;
        }
    </style>
    
</body>

</html>
