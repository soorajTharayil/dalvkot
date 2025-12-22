<br>
<div class="content">
    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("dashboard/profile") ?>"> <i
                                class="fa fa-list"></i> <?php echo display('profile') ?> </a>
                    </div>
                </div>


                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open_multipart('dashboard/form/', 'class="form-inner"') ?>

                            <?php //print_r($doctor); ?>
                            <?php echo form_hidden('user_id', $doctor->user_id) ?>


                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Name <i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="firstname" type="text" class="form-control" maxlength="25"
                                        id="firstname" placeholder="<?php echo display('first_name') ?>"
                                        value="<?php echo $doctor->firstname ?>">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="email" class="col-xs-3 col-form-label"><?php echo display('email') ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="email" class="form-control" type="text"
                                        placeholder="<?php echo display('email') ?>" id="email"
                                        value="<?php echo $doctor->email ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row" id="show_hide_password">
                                <label for="password" class="col-xs-3 col-form-label"><?php echo display('password') ?>
                                    <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="password" class="form-control" type="password"
                                        placeholder="<?php echo display('password') ?>" id="password">
                                    <div class="input-group-addon changepassword">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label"><?php echo display('mobile') ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="mobile" type="text" pattern="\d*" maxlength="10" class="form-control"
                                        type="text" placeholder="<?php echo display('mobile') ?>" id="mobile"
                                        value="<?php echo $doctor->mobile ?>">
                                </div>
                            </div>


                            <div class="form-group row" style="display:none;">
                                <label class="col-sm-3"><?php echo display('sex') ?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" value="Male" <?php echo set_radio('sex', 'Male', TRUE); ?><?php if ($doctor->sex == 'Male') {
                                                      echo 'checked';
                                                  } ?>><?php echo display('male') ?>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" value="Female" <?php echo set_radio('sex', 'Female'); ?> <?php if ($doctor->sex == 'Female') {
                                                      echo 'checked';
                                                  } ?>><?php echo display('female') ?>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" value="Other" <?php echo set_radio('sex', 'Other'); ?> <?php if ($doctor->sex == 'Other') {
                                                      echo 'checked';
                                                  } ?>><?php echo display('other') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- if employee picture is already uploaded -->
                            <?php if (!empty($doctor->picture)) { ?>
                                <div class="form-group row">
                                    <label for="picturePreview" class="col-xs-3 col-form-label"></label>
                                    <div class="col-xs-9">
                                        <img src="<?php echo base_url($doctor->picture) ?>" alt="Picture"
                                            class="img-thumbnail" />
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="picture"
                                    class="col-xs-3 col-form-label"><?php echo display('picture') ?></label>
                                <div class="col-xs-9">
                                    <input type="file" name="picture" id="picture"
                                        value="<?php echo $doctor->picture ?>">
                                    <input type="hidden" name="old_picture" value="<?php echo $doctor->picture ?>">
                                </div>
                            </div>

                            <div class="form-group row" style="display:none;">
                                <label for="address" class="col-xs-3 col-form-label"><?php echo display('address') ?> <i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <textarea name="address" class="form-control" id="address"
                                        placeholder="<?php echo display('address') ?>" maxlength="140"
                                        rows="7"><?php echo $doctor->address ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" style="display:none;">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo display('active') ?>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo display('inactive') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo 'Save' ; ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>