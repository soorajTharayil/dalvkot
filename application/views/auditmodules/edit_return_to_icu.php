<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_return_to_i');
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
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Return to ICU within 48 hours - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_feedback_return_to_i_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td>
                                <b>Patient UHID</b>
                            </td>
                            <td>
                            <input class="form-control" type="text" name="patientid" value="<?php echo $param['patientid']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Initial admission date</b></td>
                            <td>
                                <input class="form-control" type="text" name="initial_assessment_hr1" value="<?php echo $param['initial_assessment_hr1']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Complaint at the time of admission</b></td>
                            <td>
                                <input class="form-control" type="text" name="complaintAdmit" value="<?php echo $param['complaintAdmit']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Treatment given at the time of admission</b></td>
                            <td>
                                <input class="form-control" type="text" name="treatment_name" value="<?php echo $param['treatment_name']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Initial discharge date</b></td>
                            <td><input class="form-control" type="text" id="formula_para1_hr" name="initial_assessment_hr2" value="<?php echo $param['initial_assessment_hr2']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Re-admission date</b></td>
                            <td><input class="form-control" type="text" id="formula_para1_min" name="initial_assessment_hr3" value="<?php echo $param['initial_assessment_hr3']; ?>">
                            <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTimeFormat()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate time duration
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Time duration between initial discharge and re-admission</b></td>
                            <td><input class="form-control" type="text" name="calculatedResultTime" value="<?php echo $param['calculatedResultTime']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Complaint at the time of re-admission</b></td>
                            <td><input class="form-control" type="text" name="complaint" value="<?php echo $param['complaint']; ?>"></td>
                        </tr>
                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis" value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>
                        
                        <tr>
                            <td><b>Data collected by</b></td>
                            <td><input class="form-control" type="text" name="name" value="<?php echo $param['name']; ?>"></td>
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
    document.getElementById('formula_para1_min').addEventListener('input', onValuesEdited);
    


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
    document.querySelector('button[onclick="calculateTimeFormat()"]').addEventListener('click', calculateTimeFormat);

    function calculateTimeFormat() {
        // Retrieve the admission and assessment times from the input fields
        var admissionTime = document.querySelector('input[name="initial_assessment_hr2"]').value;
        var assessmentTime = document.querySelector('input[name="initial_assessment_hr3"]').value;

        // Convert the time strings to Date objects
        var admissionDate = new Date(admissionTime);
        var assessmentDate = new Date(assessmentTime);

        // Validation checks
        if (isNaN(admissionDate.getTime())) {
            alert("Please enter initial discharge date/time.");
            return;
        }

        if (isNaN(assessmentDate.getTime())) {
            alert("Please enter re-admission date/time.");
            return;
        }

        if (assessmentDate <= admissionDate) {
            alert("Re-admission time must be greater than initial discharge time.");
            return;
        }

        // Calculate the time difference in milliseconds
        var timeDifferenceMs = assessmentDate - admissionDate;

        // Convert the time difference to hours, minutes, and seconds
        var totalSeconds = Math.floor(timeDifferenceMs / 1000);
        var hours = Math.floor(totalSeconds / 3600);
        var minutes = Math.floor((totalSeconds % 3600) / 60);
        var seconds = totalSeconds % 60;

        // Format the calculated time as a string
        var formattedTime = `${hours}:${('0' + minutes).slice(-2)}:${('0' + seconds).slice(-2)}`;

        // Set the formatted time to the hidden input field
        document.getElementById('formattedTime').value = formattedTime;

        // Display the calculated result in the corresponding input field
        document.querySelector('input[name="calculatedResultTime"]').value = formattedTime;

        console.log("Admitted Time:", admissionTime);
        console.log("Initial Assessment Time:", assessmentTime);
        console.log("Time Taken for Initial Assessment:", formattedTime);
        calculationDone = true;
    }
</script>