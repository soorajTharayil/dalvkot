<?php
$dates = get_from_to_date();
$fdate = $dates['fdate'];
$tdate = $dates['tdate'];
$pagetitle = $dates['pagetitle'];
$fdate = date('Y-m-d', strtotime($fdate));
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
$days = $dates['days'];

$currentPatients = $this->patient_model->read();
$dischargedpatients = $this->patient_model->readdischarged();

?>

<div class="content">


    <?php if (isfeature_active('VIEW-PATIENT') === true  || isfeature_active('ADD-PATIENT') === true || isfeature_active('DISCHARGE-PATIENT') === true) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body" style="height:120px; max-height:120px;">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                        <div class="panel panel-bd">
                            <div class="panel-body" style="height: 100px;">
                                <div class="statistic-box">
                                    <h2><span class="count-number">
                                            <?php
                                            $a = count($dischargedpatients) + count($currentPatients);;


                                            echo $a; ?>
                                        </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                            </i></span></h2>
                                    <div class="small">Total Patients</div>
                                    <div class="icon">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (ismodule_active('ADMISSION SECTION') === true  && isfeature_active('VIEW-PATIENT') === true) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><span class="count-number">
                                                <?php echo count($currentPatients); ?>
                                            </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                                </i></span></h2>
                                        <div class="small">Admitted Patients</div>
                                        <div class="icon">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <a href="<?php echo base_url() . 'patient'; ?>" style="float: right;    margin-top: -9px;">View List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (ismodule_active('ADMISSION SECTION') === true  && isfeature_active('DISCHARGE-PATIENT') === true) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><span class="count-number">
                                                <?php echo count($dischargedpatients); ?>
                                            </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                                </i></span></h2>
                                        <div class="small">Discharged Patients</div>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <a href="<?php echo base_url() . 'patient/discharged'; ?>" style="float: right;    margin-top: -9px;">View List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- Close Metric Boxes-->
            </div>
        </div>
    <?php } ?>

    <div class="row">

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

                            <?php echo form_open_multipart('patient/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('id', $patient->id); ?>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_patients_name'); ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" maxlength="20" id="name" placeholder="Patient's Name" oninput="restrictToAlphabets(event)" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_patients_id'); ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <!-- <input name="patient_id" type="text" maxlength="10" oninput="sanitizeInput(this)" class="form-control" id="patient_id" placeholder="Enter patient ID" value="<?php echo $patient->patient_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                                                                                echo 'readonly';
                                                                                                                                                                                                                                            } ?> required> -->
                                    <input name="patient_id" type="text" maxlength="20" class="form-control" id="patient_id" placeholder="Enter patient ID" value="<?php echo $patient->patient_id ?>" <?php if ($patient->id) {
                                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                                        } ?> required>
                                </div>
                            </div>
                            <!-- mobile number start -->
                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_mobile_no'); ?><i class="text-danger">*</i> </label>
                                <div class="col-xs-9">
                                    <input name="mobile" type="text" class="form-control" id="admitedfor" pattern="[0-9]{10}" placeholder="Mobile number" value="<?php echo $patient->mobile ?>" required oninput="sanitizeInput(this)">
                                </div>
                            </div>
                            <!-- mobile number end -->

                            <!-- email start -->
                            <?php if (admission_bedno('email') === true) { ?>
                                <div class="form-group row">
                                    <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_email'); ?> </label>
                                    <div class="col-xs-9">
                                        <input name="email" placeholder="Email" type="email" class="form-control" id="admitedfor" value="<?php echo $patient->email ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- email end -->


                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_ward'); ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select name="ward" class="form-control" onchange="get_bed_no(this.value)" required>
                                        <option value="" selected><?php echo lang_loader('global', 'global_select_ward'); ?></option>
                                        <?php $ward = $this->patient_model->wardlist(); ?>
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
                            <?php if (admission_bedno('dropdown') === true) { ?>
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
                                <label for="date_of_birth" class="col-xs-3 col-form-label"><?php echo lang_loader('global', 'global_admitted_date'); ?><i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="admited_date" class="datepickernotfuter form-control" type="text" placeholder="" id="date_of_birth" value="<?php echo $patient->admited_date ?>" required>
                                </div>
                            </div>


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
    get_bed_no('<?php echo $patient->ward; ?>', '<?php echo $patient->bed_no; ?>');
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