<div class="content">
    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("qualitybenchmark") ?>"> <i
                                class="fa fa-list"></i> List </a>
                    </div>
                </div>

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('qualitybenchmark/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('guid', $department->guid) ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Add KPI Associated with Benchmark<i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="Enter KPIs" value="<?php echo $department->title ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Set Bench mark time</label>
                                <div class="col-xs-9">
                                    <input type="time" name="description" class="form-control" step="1"
                                        value="<?php echo $department->bed_no ?>"
                                        placeholder="Set benchmark time (hh:mm:ss)">
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

                            <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>