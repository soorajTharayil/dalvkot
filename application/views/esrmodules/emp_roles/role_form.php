<!-- This page is use to Add role -->
<div class="content">

    <div class="row">
        <!--  form area start -->
        <div class="col-sm-12">
            <div class="panel panel-default">
                <!--  role list button start -->
                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("role") ?>"> <i
                                class="fa fa-list"></i>&nbsp;List</a>
                    </div>
                </div>
                <!--  role list button end -->

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('role/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('guid', $department->guid) ?>
                            <!-- role name start -->
                            <div class="form-group row">
                                <label for="name"
                                    class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_role_title'); ?><i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" maxlength="40" id="name"
                                        placeholder="Enter Role Title" value="<?php echo $department->title ?>">
                                </div>
                            </div>
                            <!-- role name end -->
                            <div style="display: none;">
                                <!-- list of bed start -->
                                <div class="form-group row">
                                    <label for="description"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_rooms_bed_no'); ?></label>
                                    <div class="col-xs-9">
                                        <textarea name="description" class="form-control"
                                            placeholder="Add list & separate using comma( Ex: 201A, 201B, 202A )"
                                            rows="7"><?php echo $department->bed_no ?></textarea>
                                    </div>
                                </div>
                                <!-- list of bed end -->

                                <!-- Short Codestart -->
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_short_code'); ?><i
                                            class="text-danger">*</i>
                                        <a href="javascript:void()" data-placement="right" data-toggle="tooltip"
                                            title="These are Short codes used in SMS alerts">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
                                    <div class="col-xs-9">
                                        <input name="smallname" maxlength="4" type="text" class="form-control"
                                            id="smallname"
                                            placeholder="Enter Short Codes of Floor/role less than 4 characters"
                                            value="<?php echo $department->title ?>">
                                    </div>
                                </div>
                                <!-- Short Codeend -->
                            </div>
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
                            <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form area stop -->

    </div>
</div>