
<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_20PSQ3c');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;20. PSQ3c - <?php echo $row->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_20PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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

                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Sum of time taken</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_hr" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <input class="form-control" style="display:none" name="initial_assessment_hr" value="<?php echo $param['initial_assessment_hr']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_min" value="<?php echo $param['initial_assessment_min']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_sec" value="<?php echo $param['initial_assessment_sec']; ?>" />
                                        <input class="form-control" style="display:none" name="name" value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid" value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber" value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email" value="<?php echo $param['email']; ?>" />
                                       
                                        <span style="margin-left: 4px; margin-right: 9px;">hr </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center;  ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_min']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_min" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px; margin-right: 9px;">min </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_sec']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_sec" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px;">sec</span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Total no. of blood and blood components crossmatched</b></td>
                            <td>
                                <input class="form-control" type="text" id="total_admission" name="total_admission" value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTime()">
                                <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate turn around time
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Avg. turn around time for issue of blood and blood components</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult" name="calculatedResult" value="<?php echo $param['calculatedResult']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Benchmark Time</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['benchmark']; ?></span>
                                <input class="form-control" style="display:none" name="benchmark" value="<?php echo $param['benchmark']; ?>" />
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
    document.getElementById('formula_para1_min').addEventListener('input', onValuesEdited);
    document.getElementById('formula_para1_sec').addEventListener('input', onValuesEdited);
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
    document.querySelector('button[onclick="calculateTime()"]').addEventListener('click', calculateTime);

    function calculateTime() {
        var hr = parseInt(document.getElementById('formula_para1_hr').value) || 0;
        var min = parseInt(document.getElementById('formula_para1_min').value) || 0;
        var sec = parseInt(document.getElementById('formula_para1_sec').value) || 0;

        // Update hidden inputs with the new values
        document.querySelector('input[name="initial_assessment_hr"]').value = hr;
        document.querySelector('input[name="initial_assessment_min"]').value = min;
        document.querySelector('input[name="initial_assessment_sec"]').value = sec;



        // Format hr, min, and sec into the desired string format
        var timeString = `${hr}:${('0' + min).slice(-2)}:${('0' + sec).slice(-2)}`;

        // Set the formatted time value to the hidden input field
        document.getElementById('formattedTime').value = timeString;


        var totalAdmissions = parseInt(document.getElementById('total_admission').value);

        var totalSeconds = (hr * 3600) + (min * 60) + sec;

        var averageSeconds = totalSeconds / totalAdmissions;

        var avgHours = Math.floor(averageSeconds / 3600);
        var remainingSeconds = averageSeconds % 3600;
        var avgMinutes = Math.floor(remainingSeconds / 60);
        var avgSeconds = Math.floor(remainingSeconds % 60);

        document.getElementById('calculatedResult').value = `${avgHours}:${('0' + avgMinutes).slice(-2)}:${('0' + avgSeconds).slice(-2)}`;

        calculationDone = true;
        

    }
</script>