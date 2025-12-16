<div class="content">
    <?php


    // Simulated session data (partial for demonstration)
    $floor_asset = $this->session->userdata['floor_asset'];

    // Define a dynamic condition (example: include keys that start with 'set1')
    $condition = function ($key, $value) {
        return strpos($key, 'set1') === 0; // Only include keys that start with 'set1'
    };


    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');
    // $this->db->select("*");
    // $this->db->from('bf_feedback_asset_creation');
    // //$this->db->where('assignstatus', 'Preventive Maintenance');
    // $this->db->order_by('id', 'ASC');
    // $query = $this->db->get();
    // $results  = $query->result();
    // foreach ($reasons as $row) {
    //     $keys[$row->shortkey] = $row->shortkey;
    //     $res[$row->shortkey] = $row->shortname;
    //     $titles[$row->shortkey] = $row->title;
    // }
    $results = $departments;

    if (!empty($results)) {
    ?>


        <div class="row">

            <?php
            $scheduleCount = 0;
            $notApplicableCount = 0;
            $overdueCount = 0;
            $dueIn45DaysCount = 0;
            $overDue30DaysCount = 0;
            $dueThisMonthCount = 0;

            // Loop through the results to calculate counts
            if (!empty($results)) {
                foreach ($results as $department) {
                    $upcomingDate = $department->upcoming_preventive_maintenance_date;
                    $assetWithPm = trim($department->assetWithPm);
                    $currentDate = new DateTime();

                    if ($assetWithPm === 'PM not applicable') {
                        $notApplicableCount++;
                    } elseif ($assetWithPm === 'PM applicable') {
                        if (empty($upcomingDate)) {
                            // PM applicable but no upcoming date → Scheduled
                            $scheduleCount++;
                        } else {
                            $upcomingDateObj = new DateTime($upcomingDate);
                            $interval = $currentDate->diff($upcomingDateObj);
                            $daysRemaining = $interval->format('%r%a');

                            if ($daysRemaining < -30) {
                                $overDue30DaysCount++;
                            } elseif ($daysRemaining < 0) {
                                $overdueCount++;
                            } elseif ($currentDate->format('Y-m') === $upcomingDateObj->format('Y-m')) {
                                $dueThisMonthCount++;
                            } elseif ($daysRemaining >= 1 && $daysRemaining <= 45) {
                                $dueIn45DaysCount++;
                            } else {
                                $scheduleCount++;
                            }
                        }
                    } else {
                        // If assetWithPm is empty or unrecognized → mark as Not Applicable (fallback)
                        $notApplicableCount++;
                    }
                }
            }


            $applicableCount = $scheduleCount + $overdueCount + $dueIn45DaysCount + $dueThisMonthCount + $overDue30DaysCount;
            ?>





            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Represents the total count of assets with Preventive Maintenance.">
                                <h2><span class="count-number">
                                        <?php echo $applicableCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">PM Applicable Assets</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Maintenance is not required for this asset.">
                                <h2><span class="count-number">
                                        <?php echo $notApplicableCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">PM Not Applicable</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Upcoming maintenance is planned and scheduled.">
                                <h2><span class="count-number">
                                        <?php echo $scheduleCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Maintenance Scheduled</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Maintenance is due by the end of this month.">
                                <h2><span class="count-number">
                                        <?php echo $dueThisMonthCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Due this Month</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Maintenance is due within 45 days and should be performed soon.">
                                <h2><span class="count-number">
                                        <?php echo $dueIn45DaysCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Due in 45 Days</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Maintenance is overdue and should be performed soon.">
                                <h2><span class="count-number">
                                        <?php echo $overdueCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Maintenance Overdue</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Maintenance is overdue by over 30 days and should be performed soon.">
                                <h2><span class="count-number">
                                        <?php echo $overDue30DaysCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Overdue by 30+ Days</div>
                                <div class="icon">
                                    <i class="fa fa-calendar-times-o"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!--  table area -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Update PM details"
                                href="<?= base_url($this->uri . '/asset_preventive?user_id=' . $this->session->userdata['user_id']) ?>"
                                target="_blank">
                                <i class="fa fa-pencil"></i> Update PM details
                            </a>

                        </div>

                    </div>

                    <?php
                    // Get the 'status' parameter from the URL
                    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
                    ?>


                    <div class="panel-body">
                        <?php if ($this->session->userdata('user_role') != 4) { ?>
                            <div style="display: flex; align-items: center; gap: 17px; flex-wrap: wrap;">
                                <form method="get" action="<?php echo site_url('asset/asset_preventive_tickets'); ?>">
                                    <b>PM Status:</b> <select name="status" class="form-control" onchange="this.form.submit()" style="width: 150px;">
                                        <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All</option>
                                        <option value="Maintenance Overdue" <?php echo $statusFilter === 'Maintenance Overdue' ? 'selected' : ''; ?>>Maintenance Overdue</option>
                                        <option value="Overdue by 30+ d" <?php echo $statusFilter === 'Overdue by 30+ d' ? 'selected' : ''; ?>>Overdue by 30+ d</option>
                                        <option value="Due this Month" <?php echo $statusFilter === 'Due this Month' ? 'selected' : ''; ?>>Due this Month</option>
                                        <option value="Due in 45 Days" <?php echo $statusFilter === 'Due in 45 Days' ? 'selected' : ''; ?>>Due in 45 Days</option>
                                        <option value="Scheduled" <?php echo $statusFilter === 'Scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                                        <option value="Not Applicable" <?php echo $statusFilter === 'Not Applicable' ? 'selected' : ''; ?>>Not Applicable</option>
                                    </select>
                                </form>

                                <form>
                                    <p> <!-- <span style="font-size:15px; font-weight:bold;">Sort Complaints By : </span> -->

                                        <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:230px; margin:0px 20px 0px 0px;">
                                            <option value="1" selected>Select Asset Group/ Category</option>
                                            <?php
                                            $this->db->select('title');
                                            $query = $this->db->get('bf_departmentasset');
                                            $result = $query->result();

                                            foreach ($result as $row) {
                                                // Check if the title is not 'ALL' or any other unwanted value
                                                if ($row->title != 'ALL') {
                                            ?>
                                                    <option value="<?php echo str_replace('&', '%26', $row->title); ?>"
                                                        <?php if ($this->input->get('depsec') == $row->title) echo 'selected'; ?>>
                                                        <?php echo $row->title; ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        &nbsp;
                                        <select name="dep" class="form-control" id="subsecid2" onchange="gotonextdepartment3(this.value)" style="width:200px;">
                                            <option value="1" selected>Select Asset Department</option>
                                            <?php
                                            $this->db->select('title');
                                            $query = $this->db->get('bf_asset_location');
                                            $result = $query->result();

                                            foreach ($result as $row) {
                                                // Check if the title is not 'ALL' or any other unwanted value
                                                if ($row->title != 'ALL') {
                                            ?>
                                                    <option value="<?php echo str_replace('&', '%26', $row->title); ?>"
                                                        <?php if ($this->input->get('dep') == $row->title) echo 'selected'; ?>>
                                                        <?php echo $row->title; ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>


                                    </p>
                                </form>
                            </div>
                            <br />
                        <?php } ?>


                        <table class="assetpm table table-striped table-bordered table-hover" cellspacing="0" width="100%" style=" white-space: nowrap; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl. <br> No</th>
                                    <th>Asset Details</th>

                                    <th>Asset Location</th>

                                    <th style="width: 15%;">Preventive <br>Maintenance</th>


                                    <th style="width: 5%;">Days Until Due</th>
                                    <!-- <th>Asset Image</th> -->
                                    <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                        <th style="text-align: center;">PM Status</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $selected_dep = $this->input->get('depsec');
                                $selected_asset_dep = $this->input->get('dep');

                                if (!empty($results)) { ?>

                                    <?php $sl = 1; ?>
                                    <?php foreach ($results as $department) {
                                        $dataSet = json_decode($department->dataset);
                                        $depart = $department->depart;
                                        //print_r($floor_asset);
                                        //echo $dataSet->depart;

                                        //Displaying asset based on user role
                                        if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
                                            continue;
                                        }


                                        //asset group drop down
                                        if ($selected_dep && $selected_dep != '1' && $department->ward != $selected_dep) {
                                            continue; // Skip non-matching departments
                                        }

                                        //asset department drop down
                                        if ($selected_asset_dep && $selected_asset_dep != '1' && $department->depart != $selected_asset_dep) {
                                            continue; // Skip non-matching departments
                                        }
                                    ?>
                                        <?php
                                        // Define variables used in conditions
                                        $rowmessage = isset($department->message) ? $department->message : '';
                                        $tooltipText = "";
                                        $tooltipDetail = "";
                                        $color = "";

                                        // Calculate maintenance status
                                        $upcomingDate = $department->upcoming_preventive_maintenance_date;
                                        $assetWithPm = trim($department->assetWithPm); // trim to avoid whitespace issues
                                        $currentDate = new DateTime();

                                        if ($assetWithPm === 'PM not applicable') {
                                            // PM not applicable
                                            $tooltipText = "Not Applicable";
                                            $tooltipDetail = "Maintenance is not required for this asset.";
                                            $color = "btn-primary";
                                        } elseif ($assetWithPm === 'PM applicable') {
                                            if (empty($upcomingDate)) {
                                                // PM applicable but date is missing → Scheduled
                                                $tooltipText = "Scheduled";
                                                $tooltipDetail = "Upcoming maintenance is planned and scheduled.";
                                                $color = "btn-success";
                                            } else {
                                                // Calculate based on upcoming date
                                                $upcomingDate = new DateTime($upcomingDate);
                                                $interval = $currentDate->diff($upcomingDate);
                                                $daysRemaining = $interval->format('%r%a');

                                                if ($daysRemaining < 0) {
                                                    if ($daysRemaining <= -30) {
                                                        $tooltipText = "Overdue by 30+ d";
                                                        $tooltipDetail = "Maintenance is overdue by over 30 days and should be performed soon.";
                                                        $color = "btn-danger";
                                                    } else {
                                                        $tooltipText = "Overdue";
                                                        $tooltipDetail = "Maintenance is due and should be performed soon.";
                                                        $color = "btn-danger";
                                                    }
                                                } elseif ($currentDate->format('Y-m') == $upcomingDate->format('Y-m')) {
                                                    $tooltipText = "Due this Month";
                                                    $tooltipDetail = "Maintenance is due by the end of this month.";
                                                    $color = "btn-orange";
                                                } elseif ($daysRemaining >= 1 && $daysRemaining <= 45) {
                                                    $tooltipText = "Due in 45 Days";
                                                    $tooltipDetail = "Maintenance is due within 45 days and should be performed soon.";
                                                    $color = "btn-warning";
                                                } else {
                                                    $tooltipText = "Scheduled";
                                                    $tooltipDetail = "Upcoming maintenance is planned and scheduled.";
                                                    $color = "btn-success";
                                                }
                                            }
                                        } else {
                                            // Fallback for unknown status → Not Applicable
                                            $tooltipText = "Not Applicable";
                                            $tooltipDetail = "Maintenance applicability status is unclear.";
                                            $color = "btn-primary";
                                        }

                                        // Check if the row matches the selected status
                                        $statuses = [
                                            "Not Applicable",
                                            "Overdue by 30+ d",
                                            "Overdue",
                                            "Due this Month",
                                            "Due in 45 Days",
                                            "Scheduled"
                                        ];

                                        $matches = ($statusFilter === 'all') || ($tooltipText === $statusFilter);
                                        ?>



                                        <?php if ($matches) { ?>
                                            <tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>"
                                                data-placement="bottom"
                                                data-toggle="tooltip"
                                                title="<?php echo htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8'); ?>"
                                                style="cursor: pointer;">

                                                <td><?php echo $sl; ?></td>
                                                <td style="max-width: 250px; word-wrap: break-word; white-space: normal;">
                                                    <?php
                                                    $assetname = $department->assetname;
                                                    $wrappedAssetName = (strlen($assetname) > 50) ? wordwrap($assetname, 50, "\n") : $assetname;
                                                    ?>
                                                    <div>
                                                        <strong>Primary Asset Name:</strong>
                                                        <span style="display: inline; max-width: 250px; word-break: break-word;">
                                                            <?php echo htmlspecialchars($wrappedAssetName); ?>
                                                        </span>
                                                    </div>


                                                    <?php
                                                    // Word wrap logic for subassetname
                                                    if (!empty($department->subassetname)) :
                                                        $subassetname = $department->subassetname;
                                                        $wrappedSubAssetName = (strlen($subassetname) > 50) ? wordwrap($subassetname, 50, "\n") : $subassetname;
                                                    ?>
                                                        <div>
                                                            <strong>Component Asset Name:</strong>
                                                            <span style="display: inline; max-width: 250px; word-break: break-word;">
                                                                <?php echo htmlspecialchars($wrappedSubAssetName); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php
                                                    // Word wrap logic for patientid
                                                    $patientid = $department->patientid;
                                                    $wrappedPatientId = (strlen($patientid) > 50) ? wordwrap($patientid, 50, "\n") : $patientid;
                                                    ?>
                                                    <div>
                                                        <strong>Asset Code:</strong>
                                                        <a href="<?php echo base_url("{$this->uri->segment(1)}/track/{$department->id}"); ?>" target="_blank">
                                                            <?php echo htmlspecialchars($wrappedPatientId); ?>
                                                        </a><br>
                                                    </div>

                                                    Asset group: <?php echo $department->ward; ?> <br>
                                                    

                                                </td>

                                                <td>
                                                    <?php if (!empty($department->locationsite)): ?>
                                                        Area: <?php echo $department->locationsite; ?> <br>
                                                    <?php endif; ?>

                                                    <?php if (!empty($department->bedno)): ?>
                                                        Site: <?php echo $department->bedno; ?> <br>
                                                    <?php endif; ?>

                                                    <?php if (!empty($department->depart)): ?>
                                                        Dept.: <?php echo $department->depart; ?> <br>
                                                    <?php endif; ?>

                                                    <?php if (!empty($department->assignee)): ?>
                                                        User: <?php echo $department->assignee; ?>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php echo $department->assetWithPm; ?> <br>
                                                    Last PM date: <?php echo $department->preventive_maintenance_date; ?> <br>
                                                    Upcoming PM Due: <?php echo $department->upcoming_preventive_maintenance_date; ?>

                                                </td>

                                                <td style="width: 5%;">
                                                    <?php
                                                    $upcomingDate = $department->upcoming_preventive_maintenance_date;
                                                    $assetWithPm = trim($department->assetWithPm); // remove whitespace
                                                    $currentDate = new DateTime();

                                                    if ($assetWithPm === 'PM not applicable' || empty($assetWithPm)) {
                                                        echo '<span style="color: gray;">⚪️ Not Applicable</span>';
                                                    } elseif ($assetWithPm === 'PM applicable') {
                                                        if (empty($upcomingDate)) {
                                                            echo '<span style="color: green;">✅ Scheduled</span>';
                                                        } else {
                                                            $upcomingDateObj = new DateTime($upcomingDate);

                                                            if ($currentDate > $upcomingDateObj) {
                                                                echo '<span style="color: red;">🔴 Maintenance Overdue</span>';
                                                            } else {
                                                                $interval = $currentDate->diff($upcomingDateObj);
                                                                echo '<span style="color: orange;">🟠 Due in ' . $interval->days . ' days</span>';
                                                            }
                                                        }
                                                    } else {
                                                        // Unknown PM status
                                                        echo '<span style="color: gray;">⚪️ Not Applicable</span>';
                                                    }
                                                    ?>
                                                </td>



                                                <?php if (ismodule_active('ASSET') && isfeature_active('ASSET-DASHBOARD')) { ?>
                                                    <td style="text-align: center; vertical-align: middle; padding: 10px;">
                                                        <span data-placement="bottom" data-toggle="tooltip"
                                                            title="<?php echo $tooltipDetail; ?>"
                                                            class="btn btn-sm btn-block <?php echo $color; ?>"
                                                            style="font-size: 14px; padding: 3px 8px; width: 130px; margin: 5px auto;">
                                                            <?php echo $tooltipText; ?>
                                                        </span>
                                                    </td>
                                                <?php } ?>

                                            </tr>
                                            <?php $sl++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>


                        </table>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    <?php } else {   ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('pcf', 'pcf_no_record_found'); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>
<style>
    table.assetticketsall img {
        max-width: 100px;
        /* Adjust max size as necessary */
        max-height: 100px;
        width: auto;
        height: auto;
    }

    table.assetticketsall td,
    table.assetticketsall th {
        padding: 8px;
        /* Adjust as necessary */
        margin: 0;
    }

    @media (max-width: 600px) {
        table.assetticketsall {
            font-size: 12px;
            /* Adjust for smaller screens */
        }

        table.assetticketsall img {
            max-width: 50px;
            /* Smaller images for small screens */
            max-height: 50px;
        }
    }
</style>
<style>
    .btn-orange {
        background-color: #f09a22;
        color: white;
        font-size: 14px;
    }

    .btn-yellow {
        background-color: #FFDE4D;
        color: white;
        font-size: 14px;
    }
</style>

<script>
    function gotonextdepartment(type) {
        var subsecid = $('#subsecid').val();
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?type=") ?>" + type + "&depsec=" + subsecid;
        window.location.href = url;
    }

    function gotonextdepartment2(groupType) {
        var deptType = document.getElementById('subsecid2').value;
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_preventive_tickets?depsec=') ?>" + groupType;

        if (deptType != '1') {
            url += "&dep=" + deptType;
        } else {
            url += "&dep=1";
        }

        window.location.href = url;
    }

    function gotonextdepartment3(departmentType) {
        var groupType = document.getElementById('subsecid').value;
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_preventive_tickets?dep=') ?>" + departmentType;

        if (groupType != '1') {
            url += "&depsec=" + groupType;
        } else {
            url += "&depsec=1";
        }

        window.location.href = url;
    }

    function pm_status(type) {
        const url = "<?php echo base_url($this->uri->segment(1) . '/asset_preventive_tickets') ?>?pm_status=" + encodeURIComponent(type);
        window.location.href = url;
    }
</script>