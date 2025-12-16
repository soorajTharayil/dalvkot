<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_2PSQ3a');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);
//  print_r($param);
?>



<div class="content">
    <div class="row">

        <div class="col-lg-12">
          

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;2. PSQ3a - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_2PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Number of reporting errors</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center;">
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr']; ?>" name="initial_assessment_hr"  oninput="restrictToNumerals(event); calculateErrorRate();" type="number" name="reportingErrors" id="reportingErrors" style="padding-top: 2px; padding-left: 6px; margin-top:9px;" />
                                   
                                      
                                        <input class="form-control" style="display:none" name="name" value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid" value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber" value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email" value="<?php echo $param['email']; ?>" />
                                        
                                        <span style="margin-left: 4px; margin-right: 9px;"></span>
                                        <label for="reportingErrors"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of tests performed</b></td>
                            <td>
                                <input class="form-control" type="number" id="testsPerformed" name="total_admission" value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateErrorRate()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate reporting error
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>No. of reporting errors per 1000 investigations</b></td>
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
    document.getElementById('reportingErrors').addEventListener('input', onValuesEdited);
    document.getElementById('testsPerformed').addEventListener('input', onValuesEdited);

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
    document.querySelector('button[onclick="calculateErrorRate()"]').addEventListener('click', calculateErrorRate);

    function calculateErrorRate() {
        var reportingErrors = parseInt(document.getElementById('reportingErrors').value);

        // Get the number of tests performed from the input field
        var testsPerformed = parseInt(document.getElementById('testsPerformed').value);

        document.querySelector('input[name="initial_assessment_hr"]').value = reportingErrors;
        document.querySelector('input[name="total_admission"]').value = testsPerformed;
        

        // Validate inputs for reporting errors and tests performed
        if (isNaN(reportingErrors) || reportingErrors < 0) {
            alert("Please enter the number of reporting errors.");
            return;
        }

        if (isNaN(testsPerformed) || testsPerformed <= 0) {
            alert("Please enter the number of tests performed.");
            return;
        }

        if (reportingErrors > testsPerformed) {
            alert("The no. of reporting errors must be less than the no. of tests performed.");
            return;
        }

        // Calculate the number of reporting errors per 1000 investigations
        var errorsPerThousand = (reportingErrors / testsPerformed) * 1000;

        // Format the result to have two decimal places for better readability
        var formattedResult = errorsPerThousand.toFixed(2);

        document.getElementById('calculatedResult').value = formattedResult;

        console.log("Calculated result:", formattedResult);
        calculationDone = true;

    }
</script>