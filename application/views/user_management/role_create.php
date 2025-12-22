<!-- This page is use to Add Ward -->
<div class="content">

    <div class="row">
        <!--  form area start -->
        <div class="col-sm-12">
            <div class="panel panel-default">
                <!--  ward list button start -->
                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("UserManagement/roles") ?>"> <i
                                class="fa fa-list"></i>&nbsp;Role List</a>
                    </div>
                </div>
                <!--  ward list button end -->

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('UserManagement/role_create', 'class="form-inner"'); ?>

                            <?php echo form_hidden('role_id', $department->role_id) ?>

                            <!-- Ward name start -->
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Role Name<i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="role_name" type="text" class="form-control" maxlength="25" id="name"
                                        placeholder="Enter Role Name" value="<?php echo $department->role_name; ?>">
                                </div>
                            </div>
                            <!-- Ward name end -->

                            <!-- Ward name start -->
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Description<i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="role_description" type="text" class="form-control" id="name"
                                        placeholder="Describe the role" value="<?php echo $department->description; ?>">
                                </div>
                            </div>
                            <!-- Ward name end -->




                            <!-- reset and save button start -->
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">

                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo 'Save'; ?></button>
                                    </div>
                                </div>
                            </div>
                            <!-- reset and save button end -->
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form area stop -->

    </div>
</div>