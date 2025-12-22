<!-- This page is use to Add Ward -->
<div class="content">

    <div class="row">
        <!--  form area start -->
        <div class="col-sm-12">
            <div class="panel panel-default">
                <!--  ward list button start -->
                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("ward") ?>"> <i
                                class="fa fa-list"></i>&nbsp;List</a>
                    </div>
                </div>
                <!--  ward list button end -->

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('ward/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('guid', $department->guid) ?>
                            <!-- Ward name start -->
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Floor/ Ward Name<i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" maxlength="25" id="name"
                                        placeholder="Enter Floor/ Ward Name" value="<?php echo $department->title ?>">
                                </div>
                            </div>
                            <!-- Ward name end -->

                            <!-- list of bed start -->
                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Rooms/ Bed No.'s</label>
                                <div class="col-xs-9">
                                    <textarea name="description" class="form-control"
                                        placeholder="Add list & separate using comma( Ex: 201A, 201B, 202A )"
                                        rows="7"><?php echo $department->bed_no ?></textarea>
                                </div>
                            </div>
                            <!-- list of bed end -->

                            <!-- Short Codestart -->
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Short Code<i class="text-danger">*</i>
                                    <a href="javascript:void()" data-placement="right" data-toggle="tooltip"
                                        title="These are Short codes used in SMS alerts">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
                                <div class="col-xs-9">
                                    <input name="smallname" maxlength="4" type="text" class="form-control"
                                        id="smallname"
                                        placeholder="Enter Short Codes of Floor/Ward less than 4 characters"
                                        value="<?php echo $department->smallname ?>" required>
                                </div>
                            </div>
                            <!-- Short Codeend -->

                            <!-- reset and save button start -->
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">

                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
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