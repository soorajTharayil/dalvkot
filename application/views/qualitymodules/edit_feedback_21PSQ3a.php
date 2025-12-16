
<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_21PSQ3c');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);
?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">
           

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;21. PSQ3c - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_21PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                        <tr>
                            <td><strong><?php echo lang_loader('ip', 'emp'); ?></strong></td>
                            <td>
                                <b> <?php echo $param['name']; ?></b>
                                (<?php echo $param['patientid']; ?>)

                                <br>
                                <?php if ($param['contactnumber'] != '') { ?>
                                    <i class="fa fa-phone"></i> <?php echo $param['contactnumber']; ?>


                                <?php } ?>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Number of nursing staff</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center;">
                                    <span class="has-float-label">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr']; ?>" oninput="restrictToNumerals(event); calculateNursePatientRatio();" type="number" id="formula_para1_hr" style="padding-top: 2px; padding-left: 6px; margin-top: 9px; width: 90%;" />
                                        <input class="form-control" style="display:none" name="initial_assessment_hr" value="<?php echo $param['initial_assessment_hr']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_min" value="<?php echo $param['initial_assessment_min']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_sec" value="<?php echo $param['initial_assessment_sec']; ?>" />
                                        <input class="form-control" style="display:none" name="name" value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid" value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber" value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email" value="<?php echo $param['email']; ?>" />
                                        <span style="margin-left: 4px; margin-right: 9px;"></span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of occupied beds</b></td>
                            <td>
                                <input class="form-control" type="number" id="total_admission" name="total_admission" value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateNursePatientRatio()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate nurse-patient ratio
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Nurse-patient ratio</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult" name="calculatedResult" value="<?php echo $param['calculatedResult']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Data analysis</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis" value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Corrective action</b></td>
                            <td><input class="form-control" type="text" name="correctiveAction" value="<?php echo $param['correctiveAction']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Preventive action</b></td>
                            <td><input class="form-control" type="text" name="preventiveAction" value="<?php echo $param['preventiveAction']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Data collected on</b></td>
                            <td><input  class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button">
                                            <?php echo display('reset') ?>
                                        </button>
                                        <div class="or"></div>
                                        <button type="submit" id="saveButton" class="ui positive button" style="text-align: left;">
                                            <?php echo display('save') ?>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize flags to track if values have been edited and if calculation is done
    var valuesEdited = false;
    var calculationDone = false;

    // Function to call when values are edited
    function onValuesEdited() {
        valuesEdited = true;
        calculationDone = false; // Reset calculation flag when values are edited
    }

    // Add event listeners to input elements to call the onValuesEdited function
    document.getElementById('formula_para1_hr').addEventListener('input', onValuesEdited);
    document.getElementById('total_admission').addEventListener('input', onValuesEdited);

    // Function to check if values have been edited before form submission
    function checkValuesBeforeSubmit() {
        if (valuesEdited && !calculationDone) {
            alert('Please calculate before saving');
            event.preventDefault();
            return false;
        }
        return true;
    }

    // Add an event listener to the save button
    document.getElementById('saveButton').addEventListener('click', function() {

        if (checkValuesBeforeSubmit()) {
            // Proceed with save action
            console.log('Data saved successfully.');
            // You can use AJAX or form submission here
        }
    });

    // Add event listener to the calculate button
    document.querySelector('button[onclick="calculateNursePatientRatio()"]').addEventListener('click', calculateNursePatientRatio);

    function calculateNursePatientRatio() {
        var nursingStaff = parseInt(document.getElementById('formula_para1_hr').value);
        var occupiedBeds = parseInt(document.getElementById('total_admission').value);

        document.querySelector('input[name="initial_assessment_hr"]').value = nursingStaff;
        document.querySelector('input[name="total_admission"]').value = occupiedBeds;


        if (isNaN(nursingStaff) || nursingStaff <= 0) {
            alert("Enter the number of nursing staff.");
            return;
        }

        if (isNaN(occupiedBeds) || occupiedBeds <= 0) {
            alert("Enter the number of occupied beds.");
            return;
        }

        var ratio, roundedRatio, ratioString, explanation;

        // Check if nursingStaff is less than occupiedBeds
        if (nursingStaff < occupiedBeds) {
            ratio = occupiedBeds / nursingStaff;
            roundedRatio = Math.round(ratio);

            // Calculate the ratio string in 1:x format
            ratioString = "1:" + roundedRatio;
            explanation = " means 1 nurse is assigned to " + roundedRatio + " patients.";
        } else {
            ratio = nursingStaff / occupiedBeds;
            roundedRatio = Math.round(ratio);

            // Calculate the ratio string in x:1 format
            ratioString = roundedRatio + ":1";
            explanation = "means " + roundedRatio + " nurses are assigned to 1 patient.";
        }

        var calculatedResult = ratioString;
        document.getElementById('calculatedResult').value = calculatedResult;

        console.log("Calculated result:", calculatedResult);
        calculationDone = true;

    }
</script>