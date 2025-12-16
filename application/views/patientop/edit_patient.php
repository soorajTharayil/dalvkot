<div class="content">
    <div class="row">
        <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/utils.js"></script>
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("patientop") ?>"> <i class="fa fa-list"></i> <?php echo display('patient_list') ?> </a>
                </div>
            </div>

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-lg-12">

                        <?php echo form_open_multipart('patientop/create', 'class="form-inner"') ?>

                        <?php echo form_hidden('id', $patient->id); ?>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_patients_name'); ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" type="text" class="form-control" id="name" oninput="restrictToAlphabets(event)" maxlength="20" placeholder="Patients Name" value="<?php echo $patient->name ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_patients_id'); ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="patient_id" type="text" class="form-control" maxlength="20" id="patient_id" placeholder="Patients ID" value="<?php echo $patient->patient_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                } ?> required>
                            </div>
                        </div>

                        <!-- mobile number start -->
                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">
                                <?php echo lang_loader('global', 'global_mobile_no'); ?>
                                <i class="text-danger">*</i>
                            </label>
                            <div class="col-xs-9">
                                <input type="number" name="mobile" class="form-control" id="mobile"
                                    oninput="sanitizeInput(this)" maxlength="10" placeholder="Mobile Number"
                                    value="<?php echo $patient->mobile; ?>" required>
                                <small class="text-danger" id="mobile-error" style="display: none;">Mobile number must be exactly 10 digits.</small>
                            </div>
                        </div>
                        <!-- mobile number end -->
                        <?php if (admission_bedno('email') === true) { ?>
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_email'); ?> </label>
                                <div class="col-xs-9">
                                    <input name="email" placeholder="Email" type="email" class="form-control" id="admitedfor" value="<?php echo $patient->email ?>">
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_ward'); ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <select name="ward" class="form-control" onchange="get_bed_no(this.value)" required>
                                    <option value="" selected><?php echo lang_loader('global', 'global_select_ward'); ?></option>
                                    <?php $ward = $this->patientop_model->wardlist(); ?>
                                    <?php foreach ($ward as $row) { ?>
                                        <?php if ($row->title != 'ALL') { ?>
                                            <?php if ($row->title == $patient->ward) { ?>
                                                <option value="<?php echo $row->title; ?>" selected><?php echo $row->title; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row->title; ?>"><?php echo $row->title; ?></option>
                                            <?php } ?>

                                        <?php } ?>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <!-- <?php if (admission_bedno('dropdown') === true) { ?>
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_bed_no'); ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="bed_no" class="form-control" id="getbedno" required>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_bed_no'); ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="bed_no" type="text" class="form-control" maxlength="10" id="getbedno" placeholder="Enter Bed Number" required>

                                </div>
                            </div>

                        <?php } ?>

                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_admitted_date'); ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="admited_date" class="datetimepicker form-control" type="text" placeholder="" id="date_of_birth" value="<?php echo date('d-m-Y H:i', strtotime($patient->admited_date)); ?>" required readonly>
                            </div>
                        </div>
                        <input name="discharged_date" class="datetimepicker form-control" type="hidden" placeholder="" id="date_of_birth" value="0"> -->



                        <br>

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
    function sanitizeInput(inputElement) {
        var inputValue = inputElement.value;
        var digitsOnly = inputValue.replace(/\D/g, ""); // Remove non-digit characters

        if (digitsOnly.length > 10) {
            digitsOnly = digitsOnly.slice(0, 10); // Limit to 10 digits
        }

        inputElement.value = digitsOnly; // Set the sanitized value back to the input
    }

    function restrictToAlphabets(event) {
        const inputElement = event.target;
        const currentValue = inputElement.value;
        const filteredValue = currentValue.replace(/[^A-Za-z ]/g, ''); // Remove all characters except A-Z, a-z, and spaces
        if (currentValue !== filteredValue) {
            inputElement.value = filteredValue;
        }
    }

    function get_bed_no(id, bid = 0) {
        $.get("<?php echo base_url(); ?>patientop/get_bed_no?id=" + id + "&bid=" + bid, function(data, status) {

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

    get_bed_no('<?php echo $patient->ward; ?>', '<?php echo $patient->bed_no; ?>');
</script>
<script>
    function sanitizeInput(input) {
        // Remove non-digit characters
        input.value = input.value.replace(/[^0-9]/g, '');

        // Restrict to 10 digits
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }

    document.querySelector('form').addEventListener('submit', function(event) {
        const mobileInput = document.getElementById('mobile');
        const errorDisplay = document.getElementById('mobile-error');

        // Validate if the mobile number has exactly 10 digits
        if (mobileInput.value.length !== 10) {
            event.preventDefault(); // Prevent form submission
            errorDisplay.style.display = 'block';
        } else {
            errorDisplay.style.display = 'none';
        }
    });
</script>


<?php /* if ($patient->id != null) { ?>
                            <div class="form-group row" style="display:none;">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Discharged Date <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value="<?php echo $patient->discharged_date ?>">
                                </div>
                            </div>
                                            <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value="<?php echo date('g:i a, d-M-Y', strtotime($patient->discharged_date)); ?>" required readonly>

                        <?php } 
                        
                                                <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Hospital UID <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="hospital_id" type="text" class="form-control" id="hospital_id" placeholder="Hospital UID" value="<?php echo $patient->hospital_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                        } ?> required>
                                </div>
                            </div>
                        
                          <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Age </label>
                            <div class="col-xs-9">
                                <input name="age" type="text" class="form-control" id="age" placeholder="Age" value="<?php echo $patient->age ?>">
                            </div>
                        </div>
                                                <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Email </label>
                            <div class="col-xs-9">
                                <input name="email" type="email" class="form-control" id="admitedfor" value="<?php echo $patient->email ?>">
                            </div>
                        </div>



                                                <div class="form-group row">
                            <label class="col-sm-3"><?php echo display('sex') ?> <i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <div class="form-check">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Male" <?php if ($patient->gender == "Male") echo 'checked'; ?>><?php echo display('male') ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Female" <?php if ($patient->gender == "Female") echo 'checked'; ?>><?php echo display('female') ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Other" <?php if ($patient->gender == "Other") echo 'checked'; ?>><?php echo display('other') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                                                <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Alternet Contact No. </label>
                                <div class="col-xs-9">
                                    <input name="mobile2" type="text" class="form-control" id="admitedfor"  value="<?php echo $patient->mobile2 ?>" >
                                </div>
                            </div>
							
							<div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Diagnosed for </label>
                                <div class="col-xs-9">
                                    <input name="admitedfor" type="text" class="form-control" id="admitedfor" placeholder="Diagnosed for" value="<?php echo $patient->admitedfor ?>" >
                                </div>
                            </div>
                        
                                                    <div class="form-group row">
                            <label for="firstname" class="col-xs-3 col-form-label">Consultant </label>
                            <div class="col-xs-9">
                                <input name="consultant" type="text" class="form-control" id="admitedfor" placeholder="Consultant" value="<?php echo $patient->consultant; ?>">
                            </div>
                        </div>
                        
                        */






?>