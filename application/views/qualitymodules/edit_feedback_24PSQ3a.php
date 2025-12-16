<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_24PSQ4c');
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
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;24. PSQ4c - <?php echo $row->id; ?>(General Patients)</h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_24PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Sum of time taken for discharge</b></td>
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
                            <td><b>Number of patients discharged</b></td>
                            <td>
                                <input class="form-control" type="text" id="total_admission" name="total_admission" value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTime()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate avg. discharge time
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Avg. time taken for discharge</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult" name="calculatedResult" value="<?php echo $param['calculatedResult']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Bench Mark Time</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['benchmark8']; ?></span>
                                <input class="form-control" style="display:none" name="benchmark8" value="<?php echo $param['benchmark8']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td><b>Performance Vs Benchmark</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['excessTimeText']; ?></span>
                                <input class="form-control" style="display:none" id="excessTimeText" name="excessTimeText" value="<?php echo $param['excessTimeText']; ?>" />
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
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
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
        document.getElementById('saveButton').addEventListener('click', function(event) {
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

            // Benchmark comparison logic
            var benchmarkTime = "04:00:00";
            var benchmarkParts = benchmarkTime.split(':');
            var benchmarkSeconds = (+benchmarkParts[0] * 3600) + (+benchmarkParts[1] * 60) + (+benchmarkParts[2]);

            var calculatedParts = document.getElementById('calculatedResult').value.split(':');
            var calculatedSeconds = (+calculatedParts[0] * 3600) + (+calculatedParts[1] * 60) + (+calculatedParts[2]);

            var excessSeconds = calculatedSeconds - benchmarkSeconds;

            var excessTimeText;
            if (excessSeconds <= 0) {
                excessTimeText = "Average time is within benchmark";
                //document.getElementById('excessTimeText').value = excessTimeText;
            } else {
                var excessHours = Math.floor(excessSeconds / 3600);
                var excessRemainingSeconds = excessSeconds % 3600;

                var excessMinutes = Math.floor(excessRemainingSeconds / 60);
                var excessRemainingFinalSeconds = excessRemainingSeconds % 60;

                excessTimeText = "Avg. time exceeded the benchmark";
                //document.getElementById('excessTimeText').value = excessTimeText;
            }

            // Update the hidden input field for excess time text
            document.querySelector('input[name="excessTimeText"]').value = excessTimeText;

            console.log(excessTimeText);

            // Mark calculation as done
            calculationDone = true;
            valuesEdited = false; // Reset editing flag to prevent alert
        }
    </script>
</div>

<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;24. PSQ4c - <?php echo $row->id; ?>(Insurance Patients)</h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_24PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Sum of time taken for discharge</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr2']; ?>" oninput="restrictToNumerals(event); calculateTime2();" type="number" id="formula_para1_hr2" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <input class="form-control" style="display:none" name="initial_assessment_hr2" value="<?php echo $param['initial_assessment_hr2']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_min2" value="<?php echo $param['initial_assessment_min2']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_sec2" value="<?php echo $param['initial_assessment_sec2']; ?>" />
                                        <input class="form-control" style="display:none" name="name" value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid" value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber" value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email" value="<?php echo $param['email']; ?>" />

                                        <span style="margin-left: 4px; margin-right: 9px;">hr </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center;  ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_min2']; ?>" oninput="restrictToNumerals(event); calculateTime2();" type="number" id="formula_para1_min2" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px; margin-right: 9px;">min </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_sec2']; ?>" oninput="restrictToNumerals(event); calculateTime2();" type="number" id="formula_para1_sec2" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px;">sec</span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of patients discharged</b></td>
                            <td>
                                <input class="form-control" type="text" id="total_admission2" name="total_admission2" value="<?php echo $param['total_admission2']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTime2()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate avg. discharge time
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Avg. time taken for discharge</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult2" name="calculatedResult2" value="<?php echo $param['calculatedResult2']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Bench Mark Time</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['benchmark9']; ?></span>
                                <input class="form-control" style="display:none" name="benchmark9" value="<?php echo $param['benchmark9']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td><b>Performance Vs Benchmark</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['excessTimeText2']; ?></span>
                                <input class="form-control" style="display:none" id="excessTimeText2" name="excessTimeText2" value="<?php echo $param['excessTimeText2']; ?>" />
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
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
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
        document.getElementById('formula_para1_hr2').addEventListener('input', onValuesEdited);
        document.getElementById('formula_para1_min2').addEventListener('input', onValuesEdited);
        document.getElementById('formula_para1_sec2').addEventListener('input', onValuesEdited);
        document.getElementById('total_admission2').addEventListener('input', onValuesEdited);

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
        document.getElementById('saveButton').addEventListener('click', function(event) {
            if (checkValuesBeforeSubmit()) {
                // Proceed with save action
                console.log('Data saved successfully.');
                // You can use AJAX or form submission here
            }
        });

        // Add event listener to the calculate button
        document.querySelector('button[onclick="calculateTime2()"]').addEventListener('click', calculateTime2);

        function calculateTime2() {
            var hr = parseInt(document.getElementById('formula_para1_hr2').value) || 0;
            var min = parseInt(document.getElementById('formula_para1_min2').value) || 0;
            var sec = parseInt(document.getElementById('formula_para1_sec2').value) || 0;

            // Update hidden inputs with the new values
            document.querySelector('input[name="initial_assessment_hr2"]').value = hr;
            document.querySelector('input[name="initial_assessment_min2"]').value = min;
            document.querySelector('input[name="initial_assessment_sec2"]').value = sec;

            // Format hr, min, and sec into the desired string format
            var timeString = `${hr}:${('0' + min).slice(-2)}:${('0' + sec).slice(-2)}`;

            // Set the formatted time value to the hidden input field
            document.getElementById('formattedTime').value = timeString;

            var totalAdmissions = parseInt(document.getElementById('total_admission2').value);

            var totalSeconds = (hr * 3600) + (min * 60) + sec;

            var averageSeconds = totalSeconds / totalAdmissions;

            var avgHours = Math.floor(averageSeconds / 3600);
            var remainingSeconds = averageSeconds % 3600;
            var avgMinutes = Math.floor(remainingSeconds / 60);
            var avgSeconds = Math.floor(remainingSeconds % 60);

            document.getElementById('calculatedResult2').value = `${avgHours}:${('0' + avgMinutes).slice(-2)}:${('0' + avgSeconds).slice(-2)}`;

            // Benchmark comparison logic
            var benchmarkTime = "02:00:00";
            var benchmarkParts = benchmarkTime.split(':');
            var benchmarkSeconds = (+benchmarkParts[0] * 3600) + (+benchmarkParts[1] * 60) + (+benchmarkParts[2]);

            var calculatedParts = document.getElementById('calculatedResult2').value.split(':');
            var calculatedSeconds = (+calculatedParts[0] * 3600) + (+calculatedParts[1] * 60) + (+calculatedParts[2]);

            var excessSeconds = calculatedSeconds - benchmarkSeconds;

            var excessTimeText2;
            if (excessSeconds <= 0) {
                excessTimeText2 = "Average time is within benchmark";
                //document.getElementById('excessTimeText2').value = excessTimeText2;
            } else {
                var excessHours = Math.floor(excessSeconds / 3600);
                var excessRemainingSeconds = excessSeconds % 3600;

                var excessMinutes = Math.floor(excessRemainingSeconds / 60);
                var excessRemainingFinalSeconds = excessRemainingSeconds % 60;

                excessTimeText2 = "Avg. time exceeded the benchmark";
                //document.getElementById('excessTimeText2').value = excessTimeText2;
            }
            // Update the hidden input field for excess time text
            document.querySelector('input[name="excessTimeText2"]').value = excessTimeText2;


            console.log(excessTimeText2);

            // Mark calculation as done
            calculationDone = true;
            valuesEdited = false; // Reset editing flag to prevent alert
        }
    </script>
</div>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;24. PSQ4c - <?php echo $row->id; ?>(Coporate Patients)</h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_24PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Sum of time taken for discharge</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr3']; ?>" oninput="restrictToNumerals(event); calculateTime3();" type="number" id="formula_para1_hr3" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <input class="form-control" style="display:none" name="initial_assessment_hr3" value="<?php echo $param['initial_assessment_hr3']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_min3" value="<?php echo $param['initial_assessment_min3']; ?>" />
                                        <input class="form-control" style="display:none" name="initial_assessment_sec3" value="<?php echo $param['initial_assessment_sec3']; ?>" />
                                        <input class="form-control" style="display:none" name="name" value="<?php echo $param['name']; ?>" />
                                        <input class="form-control" style="display:none" name="patientid" value="<?php echo $param['patientid']; ?>" />
                                        <input class="form-control" style="display:none" name="contactnumber" value="<?php echo $param['contactnumber']; ?>" />
                                        <input class="form-control" style="display:none" name="email" value="<?php echo $param['email']; ?>" />

                                        <span style="margin-left: 4px; margin-right: 9px;">hr </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center;  ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_min3']; ?>" oninput="restrictToNumerals(event); calculateTime3();" type="number" id="formula_para1_min3" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px; margin-right: 9px;">min </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_sec3']; ?>" oninput="restrictToNumerals(event); calculateTime3();" type="number" id="formula_para1_sec3" style="padding-top: 2px;padding-left: 6px; border: 1px solid grey;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px;">sec</span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of patients discharged</b></td>
                            <td>
                                <input class="form-control" type="text" id="total_admission3" name="total_admission3" value="<?php echo $param['total_admission3']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTime3()">
                                    <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate avg. discharge time
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Avg. time taken for discharge</b></td>
                            <td>
                                <input class="form-control" type="text" id="calculatedResult3" name="calculatedResult3" value="<?php echo $param['calculatedResult3']; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td><b>Bench Mark Time</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['benchmark7']; ?></span>
                                <input class="form-control" style="display:none" name="benchmark7" value="<?php echo $param['benchmark7']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td><b>Performance Vs Benchmark</b></td>
                            <td><span style="margin: 10px;"><?php echo $param['excessTimeText3']; ?></span>
                                <input class="form-control" style="display:none" id="excessTimeText3" name="excessTimeText3" value="<?php echo $param['excessTimeText3']; ?>" />
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
                            <td><input class="datepickernotfuter form-control" type="text" name="dataCollected" value="<?php echo $row->datetime;  ?>"></td>
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
        document.getElementById('formula_para1_hr3').addEventListener('input', onValuesEdited);
        document.getElementById('formula_para1_min3').addEventListener('input', onValuesEdited);
        document.getElementById('formula_para1_sec3').addEventListener('input', onValuesEdited);
        document.getElementById('total_admission3').addEventListener('input', onValuesEdited);

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
        document.getElementById('saveButton').addEventListener('click', function(event) {
            if (checkValuesBeforeSubmit()) {
                // Proceed with save action
                console.log('Data saved successfully.');
                // You can use AJAX or form submission here
            }
        });

        // Add event listener to the calculate button
        document.querySelector('button[onclick="calculateTime3()"]').addEventListener('click', calculateTime3);

        function calculateTime() {
            var hr = parseInt(document.getElementById('formula_para1_hr3').value) || 0;
            var min = parseInt(document.getElementById('formula_para1_min3').value) || 0;
            var sec = parseInt(document.getElementById('formula_para1_sec3').value) || 0;

            // Update hidden inputs with the new values
            document.querySelector('input[name="initial_assessment_hr3"]').value = hr;
            document.querySelector('input[name="initial_assessment_min3"]').value = min;
            document.querySelector('input[name="initial_assessment_sec3"]').value = sec;

            // Format hr, min, and sec into the desired string format
            var timeString = `${hr}:${('0' + min).slice(-2)}:${('0' + sec).slice(-2)}`;

            // Set the formatted time value to the hidden input field
            document.getElementById('formattedTime').value = timeString;

            var totalAdmissions = parseInt(document.getElementById('total_admission3').value);

            var totalSeconds = (hr * 3600) + (min * 60) + sec;

            var averageSeconds = totalSeconds / totalAdmissions;

            var avgHours = Math.floor(averageSeconds / 3600);
            var remainingSeconds = averageSeconds % 3600;
            var avgMinutes = Math.floor(remainingSeconds / 60);
            var avgSeconds = Math.floor(remainingSeconds % 60);

            document.getElementById('calculatedResult3').value = `${avgHours}:${('0' + avgMinutes).slice(-2)}:${('0' + avgSeconds).slice(-2)}`;

            // Benchmark comparison logic
            var benchmarkTime = "02:00:00";
            var benchmarkParts = benchmarkTime.split(':');
            var benchmarkSeconds = (+benchmarkParts[0] * 3600) + (+benchmarkParts[1] * 60) + (+benchmarkParts[2]);

            var calculatedParts = document.getElementById('calculatedResult3').value.split(':');
            var calculatedSeconds = (+calculatedParts[0] * 3600) + (+calculatedParts[1] * 60) + (+calculatedParts[2]);

            var excessSeconds = calculatedSeconds - benchmarkSeconds;

            var excessTimeText3;
            if (excessSeconds <= 0) {
                excessTimeText3 = "Average time is within benchmark";
                //document.getElementsByName('excessTimeText3').value = excessTimeText3;
            } else {
                var excessHours = Math.floor(excessSeconds / 3600);
                var excessRemainingSeconds = excessSeconds % 3600;

                var excessMinutes = Math.floor(excessRemainingSeconds / 60);
                var excessRemainingFinalSeconds = excessRemainingSeconds % 60;

                excessTimeText3 = "Avg. time exceeded the benchmark";
                //document.getElementsByName('excessTimeText3').value = excessTimeText3;
            }
            // Update the hidden input field for excess time text
            document.querySelector('input[name="excessTimeText3"]').value = excessTimeText3;


            console.log(excessTimeText3);

            // Mark calculation as done
            calculationDone = true;
            valuesEdited = false; // Reset editing flag to prevent alert
        }
    </script>
</div>