<?php

$users = $this->db->select('user.*')
    ->get('user')
    ->result();

$department_users = array();
foreach ($users as $user) {
    $parameter = json_decode($user->department);


    foreach ($parameter as $key => $rows) {
        foreach ($rows as $k => $row) {

            $slugs = explode(',', $row);

            foreach ($slugs as $r) {
                $department_users[$key][$k][$r][] = $user->firstname;
            }
        }
    }
}
//     echo '<pre>';
//  print_r($department_users);


$this->db->select("*");
$this->db->from('setup');
//$this->db->where('parent', 0);
$query = $this->db->get();
$reasons  = $query->result();
foreach ($reasons as $row) {

    $keys[$row->shortkey] = $row->shortkey;
    //print_r($keys[$row->shortkey]);

    $res[$row->shortkey] = $row->shortname;
    $titles[$row->shortkey] = $row->title;
    $zz[$row->type] = $row->title;
}
?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">
            <?php

            // print_r($departments);
            $this->db->where('id', $departments[0]->feedbackid);
            $query = $this->db->get('bf_feedback_23PSQ4c');
            $result = $query->result();
            $feedback = $result[0];
            $param = json_decode($feedback->dataset, true);
            $this->db->order_by('id');
            // print_r($param);
            $this->db->where('title', $departments[0]->department->description);
            $query = $this->db->get('setup');

            $sresult = $query->result();
            $setarray = array();
            $questioarray = array();
            // print_r($sresult);
            foreach ($sresult as $r) {
                $setarray[$r->type] = $r->title;
            }

            foreach ($sresult as $r) {
                $questioarray[$r->type][$r->shortkey] = $r->shortname;
            }
            $arraydata = array();
            foreach ($questioarray as $setr) {
                foreach ($setr as $k => $v) {
                    $arraydata[$k] = $v;
                }
            }

            ?>


            <?php
            $department = $departments[0];
            //  echo '<pre>';
            //  print_r($department);


            // print_r($department->department->slug);


            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="<?php echo lang_loader('ip', 'ip_discharge_feedback_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;23. PSQ4c - <?php echo $department->id; ?></h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('quality/edit_feedback_1PSQ3a_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
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
                            <td><b>Sum of total patient reporting time</b></td>
                            <td>
                                <div style="display: flex; flex-direction: row; align-items: center; width: 100%;">
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_hr']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_hr" style="padding-top: 2px;padding-left: 6px;margin-top:9px;width: 90%;" />
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
                                        <input class="form-control" value="<?php echo $param['initial_assessment_min']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_min" style="padding-top: 2px;padding-left: 6px;margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px; margin-right: 9px;">min </span>
                                        <label for="para1"></label>
                                    </span>
                                    <span class="has-float-label" style="display: flex; align-items: center; ">
                                        <input class="form-control" value="<?php echo $param['initial_assessment_sec']; ?>" oninput="restrictToNumerals(event); calculateTime();" type="number" id="formula_para1_sec" style="padding-top: 2px;padding-left: 6px; margin-top:9px;width: 90%;" />
                                        <span style="margin-left: 4px;">sec</span>
                                        <label for="para1"></label>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Number of patients reported in diagnostics</b></td>
                            <td>
                                <input class="form-control" type="text" id="total_admission" name="total_admission" value="<?php echo $param['total_admission']; ?>">
                                <br>
                                <button type="button" class="btn btn-primary" onclick="calculateTime()">
                                <input type="hidden" id="formattedTime" name="formattedTime" value="">
                                    Calculate diagnostics wait time
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Avg. waiting time for diagnostics</b></td>
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
                                        <button type="submit" class="ui positive button" style="text-align: left;">
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
    function calculateTime() {
        var hr = parseInt(document.getElementById('formula_para1_hr').value) || 0;
        var min = parseInt(document.getElementById('formula_para1_min').value) || 0;
        var sec = parseInt(document.getElementById('formula_para1_sec').value) || 0;


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



    }
</script>