<div class="content">
    <div class="row">
        <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/utils.js"></script>
        <div class="panel panel-default">

            <div class="panel-heading" style="display: none;">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("question") ?>"> <i class="fa fa-list"></i> <?php echo display('patient_list') ?> </a>
                </div>
            </div>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-lg-12">

                        <?php echo form_open_multipart('questions/create', 'class="form-inner"') ?>

                        <?php echo form_hidden('id', $question->id); 
                        
                        print_r($patient);
                        
                        ?>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="Titile" value="<?php echo $question->title ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">English <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="English Question" value="<?php echo $question->question ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="Titile Language 2" value="<?php echo $question->titlek ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Language 2<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="Language 2 Question" value="<?php echo $question->questionk ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Title <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="Titile Language 3" value="<?php echo $question->titlem ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Language 3 <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" maxlength="20" placeholder="Language 3 Question" value="<?php echo $question->questionm ?>" required>
                            </div>


                            
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Shortname<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="patient_id" type="text" class="form-control" maxlength="15" id="patient_id" placeholder="Patients ID" value="<?php echo $question->shortname ?>"  required>
                            </div>
                        </div>
                        <?php /* ?>

                        <!-- mobile number start -->
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('adf','adf_mobile_no'); ?><i class="text-danger">*</i> </label>
                            <div class="col-xs-9">
                                <input name="mobile" type="text" type="text" pattern="\d*" maxlength="10" class="form-control" id="admitedfor" placeholder="Mobile number" value="<?php echo $question->mobile ?>" required>
                            </div>
                        </div>
                        <!-- mobile number end -->


                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('adf','adf_ward'); ?><i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <select name="ward" class="form-control" onchange="get_bed_no(this.value)" required>
                                    <option value="" selected><?php echo lang_loader('adf','adf_select_ward'); ?></option>
                                    <?php $ward = $this->patient_model->wardlist(); ?>
                                    <?php foreach ($ward as $row) { ?>
                                        <?php if ($row->title != 'ALL') { ?>
                                            <?php if ($row->title == $question->ward) { ?>
                                                <option value="<?php echo $row->title; ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row->title; ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Bed No <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <select name="bed_no" class="form-control" id="getbedno" required>


                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label">Admitted Date <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="admited_date" class="datetimepicker form-control" type="text" placeholder="" id="date_of_birth" value="<?php echo date('d-m-Y H:i', strtotime($question->admited_date)); ?>" required readonly>
                            </div>
                        </div>
                        <?php if ($question->id != null) { ?>
                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Discharged Date <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date"  value="<?php echo date('d-m-Y H:i', strtotime($question->discharged_date)); ?>" required>
                                </div>
                            </div>
                        <?php } ?>

                        <br>
<?php */ ?>

                        <div class="form-group row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="ui buttons">
                                    <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                    <div class="or"></div>
                                    <button class="ui positive button" id="submitdata"><?php echo display('save') ?></button>
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
<script>
    function get_bed_no(id, bid = 0) {
        $.get("<?php echo base_url(); ?>patient/get_bed_no?id=" + id + "&bid=" + bid, function(data, status) {
            $('#getbedno').html(data);
        });
    }

    function movetoinpatient() {
        var r = confirm("Are you sure want to move this Patient to Inpatients!");
        if (r == true) {
            $('#discharged_date').val('0');
            $('#submitdata').click();
        }
        //  $('#submitdata').click();
    }
    get_bed_no('<?php echo $question->ward; ?>', '<?php echo $question->bed_no; ?>');
</script>


<?php /* if ($question->id != null) { ?>
                            <div class="form-group row" style="display:none;">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Discharged Date <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value="<?php echo $question->discharged_date ?>">
                                </div>
                            </div>
                                            <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value="<?php echo date('g:i a, d-M-Y', strtotime($question->discharged_date)); ?>" required readonly>

                        <?php } 
                        
                                                <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Hospital UID <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="hospital_id" type="text" class="form-control" id="hospital_id" placeholder="Hospital UID" value="<?php echo $question->hospital_id ?>" <?php if ($question->id) {
                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                        } ?> required>
                                </div>
                            </div>
                        
                          <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Age </label>
                            <div class="col-xs-9">
                                <input name="age" type="text" class="form-control" id="age" placeholder="Age" value="<?php echo $question->age ?>">
                            </div>
                        </div>
                                                <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('adf','adf_email_id'); ?></label>
                            <div class="col-xs-9">
                                <input name="email" type="email" class="form-control" id="admitedfor" value="<?php echo $question->email ?>">
                            </div>
                        </div>



                                                <div class="form-group row">
                            <label class="col-sm-3"><?php echo display('sex') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <div class="form-check">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Male" <?php if ($question->gender == "Male") echo 'checked'; ?>><?php echo display('male') ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Female" <?php if ($question->gender == "Female") echo 'checked'; ?>><?php echo display('female') ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Other" <?php if ($question->gender == "Other") echo 'checked'; ?>><?php echo display('other') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                                                <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Alternet Contact No. </label>
                                <div class="col-xs-9">
                                    <input name="mobile2" type="text" class="form-control" id="admitedfor"  value="<?php echo $question->mobile2 ?>" >
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Diagnosed for </label>
                                <div class="col-xs-9">
                                    <input name="admitedfor" type="text" class="form-control" id="admitedfor" placeholder="Diagnosed for" value="<?php echo $question->admitedfor ?>" >
                                </div>
                            </div>
                        
                                                    <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Consultant </label>
                            <div class="col-xs-9">
                                <input name="consultant" type="text" class="form-control" id="admitedfor" placeholder="Consultant" value="<?php echo $question->consultant; ?>">
                            </div>
                        </div>
                        
                        */






?>