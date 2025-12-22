<div class="content">
    <div class="row">
        <?php
        $department = $this->db->order_by('subscription_id', 'DESC')->get('subscription')->result();
        $department = $department[0];
        include 'calculate_remaining_days.php';
        ?>



        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default thumbnail">


                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open_multipart('subscription/organization', 'class="form-inner"') ?>

                            <?php
                            if (isfeature_active('ADMINS-OVERALL-PAGE') === false) { ?>
                                <!-- User with role 0 means developer logon  -->

                                <!-- Plan -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_plan'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="plan" placeholder="eg.Free trail " type="text" class="form-control"
                                            id="plan" value="<?php echo $department->plan ?>" required>
                                    </div>
                                </div>
                                <!-- Plan -->
                                <!-- License Start Date:  -->
                                <div class="form-group row">
                                    <label for="delivered_on"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_license_start'); ?><i
                                            class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="delivered_on" class="datepicker form-control" type="text"
                                            autocomplete="off" placeholder="Delivered date" id="delivered_on"
                                            value="<?php echo $department->delivered_on ?>" required>
                                        <input type="hidden" name="delivered_on_hid"
                                            value="<?php echo $department->delivered_on; ?>">

                                    </div>
                                </div>
                                <!-- License Start Date:  -->
                                <!-- License Expiration Date:  -->
                                <div class="form-group row">
                                    <label for="delivered_on"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_license_exp'); ?><i
                                            class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="delivered_end" class="datepicker form-control" type="text"
                                            autocomplete="off" placeholder="Delivered date" id="delivered_end"
                                            value="<?php echo $department->delivered_end ?>" required>
                                        <input type="hidden" name="delivered_end_hid"
                                            value="<?php echo $department->delivered_end; ?>">

                                    </div>
                                </div>
                                <!--License Expiration Date:  -->
                                <!-- Billing Cycle -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_billing_cycle'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="billing_cycle"
                                            placeholder="eg.Free trial/ Monthly/ Quarterly/ Half yearly/ Annual/ Biennial/ Triennial/ Five years"
                                            maxlength="100" type="text" class="form-control" id="billing_cycle"
                                            value="<?php echo $department->billing_cycle ?>" required>
                                    </div>
                                </div>
                                <!-- Billing Cycle -->
                                <!-- Billing Status -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_billing_staus'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="billing_status" placeholder="eg.Paid/ Outstanding" maxlength="100"
                                            type="text" class="form-control" id="	billing_status"
                                            value="<?php echo $department->billing_status ?>" required>
                                    </div>
                                </div>
                                <!-- Billing Status -->
                                <!-- Product -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_product'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="product" placeholder="eg.Patient Experience Management Suite( PXM) "
                                            maxlength="100" type="text" class="form-control" id="product"
                                            value="<?php echo $department->product ?>" required>
                                    </div>
                                </div>
                                <!-- Product -->
                                <!-- Modules Included -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_modules_included'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="module_included" placeholder="eg.Patient modules or Employee modules"
                                            maxlength="100" type="text" class="form-control" id="module_included"
                                            value="<?php echo $department->module_included ?>" required>
                                    </div>
                                </div>
                                <!-- Modules Included -->
                                <!-- Usage Limit -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_usage_limit'); ?>
                                        <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <input name="usage_limit" placeholder="eg.500 Bedded License" maxlength="100"
                                            type="text" class="form-control" id="usage_limit"
                                            value="<?php echo $department->usage_limit ?>" required>
                                    </div>
                                </div>
                                <!-- Usage Limit -->

                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons">
                                            <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                            <div class="or"></div>
                                            <button class="ui positive button"><?php echo display('save') ?></button>
                                        </div>
                                    </div>
                                </div>


                                <?php
                            } else {
                                // User with role other than 0 means super admin logins
                                ?>
                                <!-- Plan and License Information Table -->
                                <div style="padding-left: 35px; padding-bottom: 15px; padding-top: 35px;">
                                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                                        <!-- Plan -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_plan'); ?></th>
                                            <td><?php echo $department->plan ?></td>
                                        </tr>
                                        <!-- Plan -->

                                        <!-- License Start Date -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_license_start'); ?></th>
                                            <td><?php echo $department->delivered_on ?></td>
                                        </tr>
                                        <!-- License Start Date -->

                                        <!-- License Expiration Date -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_license_exp'); ?></th>
                                            <td><?php echo $department->delivered_end ?></td>
                                        </tr>
                                        <!-- License Expiration Date -->

                                        <!-- Remaining Days for Expiry -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_remaining_days'); ?></th>
                                            <td>
                                                <?php
                                                $remainingDays = calculateRemainingDays($department->delivered_end, $department->delivered_on);
                                                echo $remainingDays;
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- Remaining Days for Expiry -->

                                        <!-- Billing Cycle -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_billing_cycle'); ?></th>
                                            <td><?php echo $department->billing_cycle ?></td>
                                        </tr>
                                        <!-- Billing Cycle -->

                                        <!-- Billing Status -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_billing_staus'); ?></th>
                                            <td><?php echo $department->billing_status ?></td>
                                        </tr>
                                        <!-- Billing Status -->

                                        <!-- Product -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_product'); ?></th>
                                            <td><?php echo $department->product ?></td>
                                        </tr>
                                        <!-- Product -->

                                        <!-- Modules Included -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_modules_included'); ?></th>
                                            <td><?php echo $department->module_included ?></td>
                                        </tr>
                                        <!-- Modules Included -->

                                        <!-- Usage Limit -->
                                        <tr>
                                            <th><?php echo lang_loader('global', 'global_usage_limit'); ?></th>
                                            <td><?php echo $department->usage_limit ?></td>
                                        </tr>
                                        <!-- Usage Limit -->
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