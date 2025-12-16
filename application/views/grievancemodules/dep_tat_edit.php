<!-- This page shows the list of departments -->
<div class="content">
    <?php
    $email = $this
        ->session
        ->userdata["email"];
    // $this->db->where('department.type', 'inpatient');
    // $this->db->group_by('type,description');
    $this
        ->db
        ->select("*");
    $this
        ->db
        ->where("department.type", "grievance");
    $query = $this
        ->db
        ->get("department");
    $departments = $query->result();
    ?>
    <div class="row">
        <!--  table area start-->
        <div class="col-lg-12">
            <div class="panel panel-default thumbnail">


                <div class="panel-body">
                    <?php echo form_open(); ?>
                    <table class=" table table-striped table-bordered" cellspacing="0" width="100%">
                        <!-- table head start -->
                        <thead>
                            <tr>
                                <th>
                                    <?php echo display("serial"); ?>
                                </th>
                                <th><?php echo lang_loader('sg', 'sg_department'); ?></th>
                                <th><?php echo lang_loader('sg', 'sg_parameter'); ?></th>
                                <th><?php echo lang_loader('sg', 'dept_level_escalation'); ?></th>
                                <th><?php echo lang_loader('sg', 'sg_tat_l1_escalation'); ?></th>
                                <th><?php echo lang_loader('sg', 'sg_tat_l2_escalation'); ?></th>
                            </tr>
                        </thead>
                        <!-- table head end -->

                        <!-- table body start -->
                        <tbody>
                            <?php if (!empty($departments)) { ?>
                                <?php
                                $sl = 1;
                                $i = 0;
                                ?>
                                <?php foreach ($departments as $department) { ?>

                                    <?php

                                    $seconds_total = $department->dept_level_escalation;
                                    $days_dept_level = floor($seconds_total / 86400); // 86400 seconds in a day
                                    $hours_days_dept_level = floor(($seconds_total % 86400) / 3600); // 3600 seconds in an hour
                                    $minutes_days_dept_level = floor(($seconds_total % 3600) / 60);

                                    $seconds_total = $department->close_time;
                                    $days_l1 = floor($seconds_total / 86400); // 86400 seconds in a day
                                    $hours_l1 = floor(($seconds_total % 86400) / 3600); // 3600 seconds in an hour
                                    $minutes_l1 = floor(($seconds_total % 3600) / 60);


                                    $seconds_total_l2 = $department->close_time_l2;
                                    $days_l2 = floor($seconds_total_l2 / 86400); // 86400 seconds in a day
                                    $hours_l2 = floor(($seconds_total_l2 % 86400) / 3600); // 3600 seconds in an hour
                                    $minutes_l2 = floor(($seconds_total_l2 % 3600) / 60);
                                    ?>
                                    <tr class="<?php echo $sl & 1 ? "odd gradeX" : "even gradeC"; ?>" id="dep_row<?php echo $department->dprt_id; ?>">
                                        <td>
                                            <?php echo $sl; ?>
                                        </td>

                                        <td>
                                            <?php echo $department->description; ?>
                                        </td>
                                        <td>
                                            <?php echo $department->name; ?>
                                        </td>
                                        <!-- dept level escalation -->
                                        <td>
                                            <div class="dhm-picker">
                                                <input type="hidden" value="<?php echo $department->dept_level_escalation; ?>" id="dept_level<?php echo $department->dprt_id; ?>" name="tat[dept_level_escalation][<?php echo $department->dprt_id; ?>]">
                                                <select id="daydept_level<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'dept_level')">

                                                    <?php for ($i = 0; $i <= 7; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($days_dept_level == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Day</span>

                                                <select id="hourdept_level<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'dept_level')">
                                                    <?php for ($i = 0; $i <= 23; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($hours_days_dept_level == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Hour</span>
                                                <select id="minutedept_level<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'dept_level')">


                                                    <?php for ($i = 0; $i <= 55; $i += 5) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($minutes_days_dept_level == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>
                                                        </option>
                                                    <?php
                                                    } ?>
                                                </select>
                                                <span class="separator">Min</span>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="dhm-picker">
                                                <input type="hidden" value="<?php echo $department->close_time; ?>" id="l1<?php echo $department->dprt_id; ?>" name="tat[close_time_l1][<?php echo $department->dprt_id; ?>]">
                                                <select id="dayl1<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l1')">

                                                    <?php for ($i = 0; $i <= 7; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($days_l1 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Day</span>

                                                <select id="hourl1<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l1')">
                                                    <?php for ($i = 0; $i <= 23; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($hours_l1 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Hour</span>
                                                <select id="minutel1<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l1')">


                                                    <?php for ($i = 0; $i <= 55; $i += 5) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($minutes_l1 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>
                                                        </option>
                                                    <?php
                                                    } ?>
                                                </select>
                                                <span class="separator">Min</span>

                                            </div>
                                        </td>
                                        <td>

                                            <div class="dhm-picker">
                                                <input type="hidden" value="<?php echo $department->close_time_l2; ?>" id="l2<?php echo $department->dprt_id; ?>" name='tat[close_time_l2][<?php echo $department->dprt_id; ?>]'>
                                                <select id="dayl2<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l2')">

                                                    <?php for ($i = 0; $i <= 7; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($days_l2 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Day</span>

                                                <select id="hourl2<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l2')">
                                                    <?php for ($i = 0; $i <= 23; $i++) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($hours_l2 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php
                                                    } ?>

                                                </select>
                                                <span class="separator">Hour</span>
                                                <select id="minutel2<?php echo $department->dprt_id; ?>" onchange="setValueField(<?php echo $department->dprt_id; ?>,'l2')">


                                                    <?php for ($i = 0; $i <= 55; $i += 5) { ?>
                                                        <option value="<?php echo $i; ?>" <?php if ($minutes_l2 == $i) {
                                                                                                echo 'selected';
                                                                                            } ?>>
                                                            <?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>
                                                        </option>
                                                    <?php
                                                    } ?>
                                                </select>
                                                <span class="separator">Min</span>

                                            </div>
                                        </td>



                                    </tr>
                                    <?php
                                    $sl++;
                                    $i++;
                                    ?>
                                <?php
                                } ?>
                            <?php
                            } ?>
                        </tbody>
                        <!-- table body end -->


                    </table> <!-- /.table-responsive -->
                    <input value="Submit" onclick="validateForm()" class="btn btn-primary">
                    <input type="submit" value="Sumit" id="submitform" style="display:none;" class="btn btn-primary">
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <!--  table area end-->
    </div>
</div>
<style>
    .dt-buttons.btn-group {
        display: none;
    }

    .dhm-picker {
        display: flex;
        align-items: center;
        background-color: #f7f7f7;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dhm-picker select {
        appearance: none;
        border: none;
        background-color: transparent;
        padding: 5px 10px;
        font-size: 16px;
        cursor: pointer;
        outline: none;
    }

    .dhm-picker .separator {
        margin: 0 5px;
        color: #888;
    }
</style>
<script>
    function modifyRowColor(id) {
        $("#dep_row" + id).css("color", "red");
    }

    function setValueField(id, level) {
        $("#dep_row" + id).css("color", "orange");

        var day = parseInt($("#day" + level + id).val());
        var hour = parseInt($("#hour" + level + id).val());
        var minute = parseInt($("#minute" + level + id).val());

        var totalSeconds = (day * 24 * 60 * 60) + (hour * 60 * 60) + (minute * 60);

        $('#' + level + id).val(totalSeconds);
    }

    function validateForm() {
        var departments = <?php echo json_encode($departments); ?>;

        for (var i = 0; i < departments.length; i++) {
            var department = departments[i];
            var l1Value = parseInt(document.getElementById('l1' + department.dprt_id).value);
            var l2Value = parseInt(document.getElementById('l2' + department.dprt_id).value);
            var deptValue = parseInt(document.getElementById('dept_level' + department.dprt_id).value);

            if (l2Value < deptValue) {
                alert('Admin level escalation should be greater than Department level escalation for department: ' + department.description);
                $("#dep_row" + department.dprt_id).css("color", "red");
                return false; // This will prevent the form from submitting
            }
        }
        $('#submitform').click();
        return true; // This will allow the form to submit
    }
</script>