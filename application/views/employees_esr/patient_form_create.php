<div class="content">
    <div class="row">
        <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/utils.js"></script>
        <!--  form area -->
        <div class="col-lg-12">
            <div class="panel panel-default thumbnail">

                <!-- <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("patient") ?>"> <i class="fa fa-list"></i> <?php echo display('patient_list') ?> </a>
                    </div>
                </div> -->

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-lg-12">

                            <?php echo form_open_multipart('employee/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('id', $patient->id); ?>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Employee Name <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Employee's Name" oninput="restrictToAlphabets(event)" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Employee ID <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="patient_id" maxlength="20" type="text"  class="form-control" id="patient_id" placeholder="Enter Employee ID" value="<?php echo $patient->patient_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                                                                                                                                                echo 'readonly';
                                                                                                                                                                                                                                                                                                            } ?> required>
                                </div>
                            </div>
                            <!-- mobile number start -->
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Mobile No.<i class="text-danger">*</i> </label>
                                <div class="col-xs-9">
                                    <input name="mobile" type="text" class="form-control" id="admitedfor" pattern="[0-9]{10}" placeholder="Mobile number" value="<?php echo $patient->mobile ?>" required oninput="sanitizeInput(this)">
                                </div>
                            </div>
                            <!-- mobile number end -->

                            <!-- email start -->
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Email </label>
                                <div class="col-xs-9">
                                    <input name="email" placeholder="Email" required type="email" class="form-control" id="admitedfor" value="<?php echo $patient->email ?>">
                                </div>
                            </div>
                            <!-- email end -->


                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Role <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <!-- <select name="ward" class="form-control" onchange="get_bed_no(this.value)" required> -->
                                    <select name="ward" class="form-control" required>
                                        <option value="" selected>Select Role</option>
                                        <?php $ward = $this->employee_model->wardlist(); ?>
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
<!-- 
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Bed No <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="bed_no" class="form-control" id="getbedno" required>
                                    </select>
                                </div>
                            </div> -->


                            <!-- <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Admitted Date<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="admited_date" class="datepickernotfuter form-control" type="text" placeholder="" id="date_of_birth" value="<?php echo $patient->admited_date ?>" required>
                                </div>
                            </div> -->


                            <!-- discharged date end -->
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo 'Reset' ; ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button" id="submitdata"><?php echo 'Save' ; ?></button>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                        <!-- <?php // if ($patient->id != null) { 
                                ?>
                        <?php  // if ($patient->discharged_date != 0) { 
                        ?>
                            <div class="col-md-12 pull-right "> <button class="ui positive button" onclick="movetoinpatient()">Move to Inpatient</button></div>
                        <?php // } 
                        ?>
                    <?php // } 
                    ?> -->
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

    // function get_bed_no(id, bid = 0) {
    //     $.get("<?php echo base_url(); ?>employee/get_bed_no?id=" + id + "&bid=" + bid, function(data, status) {
    //         $('#getbedno').html(data);
    //     });
    // }

    function movetoinpatient() {
        var r = confirm("Are you sure want to move this Patient to Inpatients!");
        if (r == true) {
            $('#discharged_date').val('0');
            $('#submitdata').click();
        }
        //  $('#submitdata').click();
    }
    // get_bed_no('<?php //echo $patient->ward; 
                    ?>', '<?php //echo $patient->bed_no; 
                                                        ?>');
</script>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>


<?php /* ?>

                            <div class="form-group row " style ="display:none;">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Admitted Date <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="admited_date" class="datetimepicker form-control" type="text" placeholder="" id="date_of_birth" value="<?php echo date('g:i a, d-M-Y', strtotime($patient->admited_date)); ?>" required>
                                </div>
                            </div>

                            
                            <!-- discharged date start -->
                            <?php if ($patient->id != null) { ?>
                                <div class="form-group row" >
                                    <label for="date_of_birth" class="col-xs-3 col-form-label">Discharged Date <i class="text-danger">*</i></label>
                                    <div class="col-xs-9">
                                        <?php if ($patient->discharged_date == 0) { ?>
                                            <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value=""  readonly>
                                        <?php } else { ?>

                                            <input name="discharged_date" class="datetimepicker form-control" type="text" placeholder="" id="discharged_date" value="<?php echo date('g:i a, d-M-Y', strtotime($patient->discharged_date)); ?>" required readonly>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php  } ?>


<div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label">Hospital UID <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="hospital_id" type="number"  min="100000" max="999999"  oninput="setCustomValidity('')" oninvalid="this.setCustomValidity('Hospital ID must be of 6 characters only.')"  class="form-control" id="hospital_id" placeholder="Hospital UID" value="<?php echo $patient->hospital_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                                                                                                                                                                        } ?> required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-3 col-form-label">Gender<i class="text-danger">*</i></label>
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
                                <label for="firstname" class="col-xs-3 col-form-label">Age </label>
                                <div class="col-xs-9">
                                    <input name="age" type="text" class="form-control" id="age" placeholder="Age" value="<?php echo $patient->age ?>">
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
                                                  <input name="consultant" type="text" class="form-control" id="admitedfor" placeholder="Consultant" value="<?php echo $patient->consultant; ?>" >
                                              </div>
                                          </div>
           <?php */ ?>