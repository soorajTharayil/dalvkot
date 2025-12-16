<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default ">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("Coordinator") ?>"> <i class="fa fa-list"></i>  Coordinator List </a>  
                </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open('Coordinator/create','class="form-inner"') ?>

                            <?php  echo form_hidden('guids',$department->guid) ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Name <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name"  type="text" class="form-control" id="name" placeholder="Name" value="<?php echo $department->name ?>" required>
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Employee ID <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="guid"  type="text" class="form-control" id="name" placeholder="Employee ID" value="<?php echo $department->guid ?>" required>
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Password<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="password"  type="text" class="form-control" id="name" placeholder="Password" value="<?php echo $department->password ?>" requried>
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