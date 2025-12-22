<?php

$organization_logo_tooltip = "The rectangular logo has been designed for integration into the Efeedor Dashboard, online links, and Mobile Apps. It serves the purpose of whitelabeling the application to seamlessly align with and enhance your brand representation";
$organization_name_tooltip = "This distinctive identifier will be featured in SMS and emails sent to patients and stakeholders, ensuring clear recognition of notifications from our organization.";
$organization_id_tooltip = "This is a unique identification code assigned to each healthcare organization.";


?>
<div class="content">
    <div class="row">
        <?php
        $department = $this->db->where('setting_id', 2)->get('setting')->result();
        $department = $department[0];
        // print_r($department);
        ?>
        <?php $accHID = $department->description; ?>
        <?php $acctype = $department->validity_key; ?>


        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default thumbnail">


                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open_multipart('settings/organization_profile', 'class="form-inner"') ?>

                            <?php
                            if (isfeature_active('ADMINS-OVERALL-PAGE') === false) {
                                // User with role 0
                            ?>

                                <!-- Organization  Logo -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_organization_logo'); ?></label>
                                    <div class="col-xs-9">
                                        <img src="<?php echo base_url(); ?>uploads/<?php echo $department->logo ?>" style="max-width:120px; max-height:40px">
                                        <input name="logo" type="file" class="form-control">
                                        <p>&nbsp;Preferred size 60x130px </p>
                                    </div>
                                </div>
                                <!-- Organization  Name -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_organization_name'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="title" placeholder="Organization Name" maxlength="20" type="text" class="form-control" id="title" value="<?php echo $department->title ?>" required>
                                    </div>
                                </div>
                                <!-- Hospital ID -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_organization_id'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="description" placeholder="Organization ID" type="text" class="form-control" id="description" value="<?php echo $department->description ?>" required>
                                    </div>
                                </div>
                                <!-- Industry  -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_industry'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="industry" placeholder="eg.Healthcare" type="text" class="form-control" id="industry" value="<?php echo $department->industry ?>" required>
                                    </div>
                                </div>
                                <!-- Website  -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_website'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="website" placeholder="eg. www.sagarhospital.com " type="text" class="form-control" id="website" value="<?php echo $department->website ?>" required>
                                    </div>
                                </div>
                                <!-- Location  -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_location'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="location" placeholder="eg. city,state" type="text" class="form-control" id="location" value="<?php echo $department->location ?>" required>
                                    </div>
                                </div>
                                <!-- Address  -->
                                <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_address'); ?> <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="hos_address" placeholder="eg. hospital address" type="text" class="form-control" id="hos_address" value="<?php echo $department->address ?>" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons">
                                            <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                            <div class="or"></div>
                                            <button class="ui positive button"><?php echo 'Save'; ?></button>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            } else {
                                // User with role other than 0
                            ?>


                                <!-- Organization Details Table -->
                                <div style="padding-left: 35px; padding-bottom: 15px; padding-top: 35px;">
                                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                        <!-- Organization Logo Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_organization_logo'); ?>
                                                <span>
                                                    <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $organization_logo_tooltip; ?>" data-placement="right">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    </a>
                                                </span>
                                            </th>
                                            <td>
                                                <img src="<?php echo base_url(); ?>uploads/<?php echo $department->logo ?>" style="max-width:120px; max-height:40px">
                                            </td>
                                        </tr>

                                        <!-- Organization Name Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_organization_name'); ?>
                                                <span>
                                                    <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $organization_name_tooltip; ?>" data-placement="right">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i></i></a>
                                                </span>
                                            </th>
                                            <td><?php echo $department->title ?></td>
                                        </tr>

                                        <!-- Organization ID Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_organization_id'); ?>
                                                <span>
                                                    <a href="javascript:void()" data-toggle="tooltip" title="<?php echo $organization_id_tooltip; ?>" data-placement="right">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i></i>
                                                    </a>
                                                </span>
                                            </th>
                                            <td><?php echo $department->description; ?></td>
                                        </tr>

                                        <!-- Industry Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_industry'); ?></th>
                                            <td><?php echo $department->industry; ?></td>
                                        </tr>

                                        <!-- Website Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_website'); ?></th>
                                            <td><?php echo $department->website; ?></td>
                                        </tr>

                                        <!-- Location Row -->
                                        <tr>
                                            <th style="white-space: nowrap;"><?php echo lang_loader('global', 'global_location'); ?></th>
                                            <td><?php echo $department->location; ?></td>
                                        </tr>

                                        <!-- Address Row -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_address'); ?></th>
                                            <td><?php echo $department->address; ?></td>
                                        </tr>
                                    </table>
                                </div>




                            <?php } ?>

                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//$string_to_encrypt="12-05-2021";
//$password="password";
//$encrypted_string=openssl_encrypt($string_to_encrypt,"AES-128-ECB",$password);
//echo $decrypted_string=openssl_decrypt($encrypted_string,"AES-128-ECB",$password);
?>