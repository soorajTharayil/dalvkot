<br>
<div class="content">
    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default thumbnail">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-primary" href="<?php echo base_url("department") ?>"> <i class="fa fa-list"></i> Department List </a>
                    </div>
                </div>

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('department/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('dprt_id', $department->dprt_id) ?>
                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Department</label>
                                <div class="col-xs-9">

                                    <input name="description" type="text" class="form-control" id="name" placeholder="Department" value="<?php echo $department->description ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row" style="display:none;">
                                <label for="name" class="col-xs-3 col-form-label">Department Parameter <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="<?php echo display('department_name') ?>" value="<?php echo $department->name ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Department HOD <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="pname" type="text" class="form-control" id="name" placeholder="<?php echo display('pname') ?>" value="<?php echo $department->pname ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Mobile <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="mobile" type="text" class="form-control" id="name" placeholder="" value="<?php echo $department->mobile ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Email <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="email" type="email" class="form-control" id="name" value="<?php echo $department->email ?>">
                                </div>
                            </div>
                            <div class="form-group row" id="show_hide_password">
                                <label for="name" class="col-xs-3 col-form-label">Password <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="password" type="password" class="form-control" id="name" value="<?php echo $department->password ?>">
                                    <div class="input-group-addon changepassword">
                                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>



                            <!--Radio-->
                            <div class="form-group row">
                                <label class="col-sm-3"><?php echo display('status') ?></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                        <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
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