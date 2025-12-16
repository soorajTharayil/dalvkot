<div class="content">
    <?php
    // individual patient feedback link


    // Simulated session data (partial for demonstration)
    $floor_asset = $this->session->userdata['floor_asset'];

    // Define a dynamic condition (example: include keys that start with 'set1')
    $condition = function ($key, $value) {
        return strpos($key, 'set1') === 0; // Only include keys that start with 'set1'
    };

    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');
    // $this->db->select("*");
    // $this->db->from('bf_feedback_asset_creation');
    // $this->db->order_by('id', 'ASC');

    // $query = $this->db->get();
    // $results  = $query->result();
    // foreach ($reasons as $row) {
    //     $keys[$row->shortkey] = $row->shortkey;
    //     $res[$row->shortkey] = $row->shortname;
    //     $titles[$row->shortkey] = $row->title;
    // }

    $results = $departments;
    // print_r($results);
    // exit;


    if (!empty($results)) {
    ?>


        <div class="row">

            <?php
            $totalNoWarranty = 0;
            $totalExpired30Days = 0;
            $totalExpired = 0;
            $totalExpiresThisMonth = 0;
            $totalExpiringSoon = 0;
            $totalWarrantyActive = 0;

            if (!empty($results)) {
                foreach ($results as $department) {
                    $warrantyEndDate = $department->warrenty_end;
                    $assetWithWarranty = trim($department->assetWithWarranty); // remove whitespace
                    $currentDate = new DateTime();

                    if ($assetWithWarranty === 'Warranty not applicable' || empty($assetWithWarranty)) {
                        $totalNoWarranty++; // Not applicable or not under warranty
                    } elseif ($assetWithWarranty === 'Warranty applicable') {
                        if (empty($warrantyEndDate)) {
                            // Warranty applicable but no end date → treat as active
                            $totalWarrantyActive++;
                        } else {
                            $warrantyEndDateObj = new DateTime($warrantyEndDate);
                            $interval = $currentDate->diff($warrantyEndDateObj);
                            $daysRemaining = (int)$interval->format('%r%a'); // signed days

                            if ($daysRemaining < -30) {
                                $totalExpired30Days++;
                            } elseif ($daysRemaining < 0) {
                                $totalExpired++;
                            } elseif ($currentDate->format('Y-m') === $warrantyEndDateObj->format('Y-m')) {
                                $totalExpiresThisMonth++;
                            } elseif ($daysRemaining >= 1 && $daysRemaining <= 90) {
                                $totalExpiringSoon++;
                            } else {
                                $totalWarrantyActive++;
                            }
                        }
                    } else {
                        // Unrecognized status — treat as no warranty
                        $totalNoWarranty++;
                    }
                }
            }


            $applicableWarrantyCount = $totalWarrantyActive + $totalExpired + $totalExpired30Days + $totalExpiresThisMonth + $totalExpiringSoon;

            ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Represents the total no. of assets for which warranty is applicable.">
                                <h2><span class="count-number">
                                        <?php echo $applicableWarrantyCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Warranty Applicable Assets</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets for which warranty not applicable.">
                                <h2><span class="count-number">
                                        <?php echo $totalNoWarranty; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">No Warranty</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets with active warranties.">
                                <h2><span class="count-number">
                                        <?php echo $totalWarrantyActive; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Warranty Active</div>
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

                            <div class="statistic-box" title="Represents the total number of assets with warranties expiring this month.">
                                <h2><span class="count-number">
                                        <?php echo $totalExpiresThisMonth; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Expires this Month</div>
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

                            <div class="statistic-box" title="Represents total no. of assets with warranties expiring within 90 days.">
                                <h2><span class="count-number">
                                        <?php echo $totalExpiringSoon; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Expiring within 90 days</div>
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

                            <div class="statistic-box" title="Represents total no. of assets with expired warranties.">
                                <h2><span class="count-number">
                                        <?php echo $totalExpired; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Warranty Expired</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets with warranties expired by more than 30 days.">
                                <h2><span class="count-number">
                                        <?php echo $totalExpired30Days; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Expired 30+ Days</div>
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
                            <div class="btn-group">
                                <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Update Warranty details"
                                    href="<?= base_url($this->uri . '/asset_warranty?user_id=' . $this->session->userdata['user_id']) ?>"
                                    target="_blank">
                                    <i class="fa fa-pencil"></i> Update Warranty details
                                </a>

                            </div>

                        </div>
                    </div>

                    <?php
                    // Get the 'status' parameter from the URL
                    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
                    ?>


                    <div class="panel-body">
                        <?php if ($this->session->userdata('user_role') != 4) { ?>
                            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">

                                <form method="get" action="<?php echo site_url('asset/asset_warranty_reports'); ?>">
                                    <b>Warranty Status:</b> <select name="status" class="form-control" onchange="this.form.submit()" style="width: 150px;">
                                        <option value="all" <?php echo $statusFilter === 'all' ? 'selected' : ''; ?>>All</option>
                                        <option value="No Warranty" <?php echo $statusFilter === 'No Warranty' ? 'selected' : ''; ?>>No Warranty</option>
                                        <option value="Expired 30+ Days" <?php echo $statusFilter === 'Expired 30+ Days' ? 'selected' : ''; ?>>Expired 30+ Days</option>
                                        <option value="Expired" <?php echo $statusFilter === 'Expired' ? 'selected' : ''; ?>>Expired</option>
                                        <option value="Expires This Month" <?php echo $statusFilter === 'Expires This Month' ? 'selected' : ''; ?>>Expires This Month</option>
                                        <option value="Expiring Soon" <?php echo $statusFilter === 'Expiring Soon' ? 'selected' : ''; ?>>Expiring Soon</option>
                                        <option value="Warranty Active" <?php echo $statusFilter === 'Warranty Active' ? 'selected' : ''; ?>>Warranty Active</option>
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


                        <table class="assetwarranty table table-striped table-bordered table-hover" cellspacing="0" width="100%" style=" white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Sl. <br> No</th>
                                    <th>Asset Details</th>

                                    <th>Asset Location</th>

                                    <th>Warranty Info</th>

                                    <th>Days Until <br> Expiration</th>
                                    <!-- <th>Asset Image</th> -->
                                    <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                        <th style="text-align: center;">Warranty Status</th>
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

                                        // Displaying asset based on user role
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

                                        $assetWithWarranty = trim($department->assetWithWarranty); // clean whitespace
                                        $warrantyEnd = $department->warrenty_end;
                                        $currentDate = new DateTime();

                                        if ($assetWithWarranty === 'Warranty not applicable' || empty($assetWithWarranty)) {
                                            // Warranty not applicable or empty → No Warranty
                                            $tooltipText = "No Warranty";
                                            $tooltipDetail = "Asset does not have a warranty.";
                                            $color = "btn-primary";
                                            $totalNoWarranty++;
                                        } elseif ($assetWithWarranty === 'Warranty applicable') {
                                            // Warranty applicable → check end date
                                            if (empty($warrantyEnd)) {
                                                // Warranty applicable but no end date → treat as active
                                                $tooltipText = "Warranty Active";
                                                $tooltipDetail = "Warranty is still valid.";
                                                $color = "btn-success";
                                                $totalWarrantyActive++;
                                            } else {
                                                $warrantyEndDate = new DateTime($warrantyEnd);
                                                $interval = $currentDate->diff($warrantyEndDate);
                                                $daysRemaining = (int)$interval->format('%r%a');

                                                if ($daysRemaining < -30) {
                                                    $tooltipText = "Expired 30+ Days";
                                                    $tooltipDetail = "Warranty expired over 30 days ago.";
                                                    $color = "btn-danger";
                                                    $totalExpired30Days++;
                                                } elseif ($daysRemaining < 0) {
                                                    $tooltipText = "Expired";
                                                    $tooltipDetail = "Warranty has expired.";
                                                    $color = "btn-danger";
                                                    $totalExpired++;
                                                } elseif ($daysRemaining <= 30 && $currentDate->format('Y-m') == $warrantyEndDate->format('Y-m')) {
                                                    $tooltipText = "Expires This Month";
                                                    $tooltipDetail = "Warranty expires within the current month.";
                                                    $color = "btn-orange";
                                                    $totalExpiresThisMonth++;
                                                } elseif ($daysRemaining > 30 && $daysRemaining <= 90) {
                                                    $tooltipText = "Expiring Soon";
                                                    $tooltipDetail = "Warranty is due to expire within 90 days.";
                                                    $color = "btn-yellow";
                                                    $totalExpiringSoon++;
                                                } else {
                                                    $tooltipText = "Warranty Active";
                                                    $tooltipDetail = "Warranty is still valid.";
                                                    $color = "btn-success";
                                                    $totalWarrantyActive++;
                                                }
                                            }
                                        } else {
                                            // Unknown warranty status — treat as No Warranty
                                            $tooltipText = "No Warranty";
                                            $tooltipDetail = "Asset does not have a warranty.";
                                            $color = "btn-primary";
                                        }

                                        $statuses = [
                                            "No Warranty",
                                            "Expired 30+ Days",
                                            "Expired",
                                            "Expires This Month",
                                            "Expiring Soon",
                                            "Warranty Active"
                                        ];

                                        $matches = ($statusFilter === 'all') || ($tooltipText === $statusFilter);
                                        ?>



                                        <?php if ($matches) { ?>
                                            <tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo htmlspecialchars($rowmessage, ENT_QUOTES, 'UTF-8'); ?>" style="cursor: pointer;">
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

                                                    Asset group: <?php echo $department->ward; ?><br>
                                                    
                                                </td>

                                                <td>
                                                    Area: <?php echo $department->locationsite; ?><br>
                                                    Site: <?php echo $department->bedno; ?><br>
                                                    Dept.: <?php echo $department->depart; ?><br>
                                                    User: <?php echo $department->assignee; ?>
                                                </td>

                                                <td>
                                                    <?php echo $department->assetWithWarranty; ?><br>
                                                    Start Date: <?php echo $department->warrenty; ?><br>
                                                    End Date: <?php echo $department->warrenty_end; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $warrantyDate = $department->warrenty_end;
                                                    $assetWithWarranty = trim($department->assetWithWarranty); // Trim whitespace
                                                    $currentDate = new DateTime();

                                                    if ($assetWithWarranty === 'Warranty not applicable' || empty($assetWithWarranty)) {
                                                        // Warranty not applicable or empty → No Warranty
                                                        echo '<span style="color: gray;">⚪️ No Warranty</span>';
                                                    } elseif ($assetWithWarranty === 'Warranty applicable') {
                                                        if (empty($warrantyDate)) {
                                                            // Warranty applicable but no end date → consider active
                                                            echo '<span style="color: green;">✅ Warranty Active</span>';
                                                        } else {
                                                            $warrantyDateObj = new DateTime($warrantyDate);

                                                            if ($currentDate > $warrantyDateObj) {
                                                                $interval = $currentDate->diff($warrantyDateObj);
                                                                echo '<span style="color: red;">🔴 Expired ' . $interval->days . ' days ago</span>';
                                                            } else {
                                                                $interval = $currentDate->diff($warrantyDateObj);
                                                                echo '<span style="color: orange;">🟠 Expires in ' . $interval->days . ' days</span>';
                                                            }
                                                        }
                                                    } else {
                                                        // Unknown warranty status, treat as No Warranty
                                                        echo '<span style="color: gray;">⚪️ No Warranty</span>';
                                                    }
                                                    ?>
                                                </td>



                                                <td style="text-align: center; vertical-align: middle; padding: 10px;">
                                                    <span data-placement="bottom" data-toggle="tooltip" title="<?php echo $tooltipDetail; ?>" class="btn btn-sm btn-block <?php echo $color; ?>" style="font-size: 14px; padding: 3px 8px; width: 130px; margin: 5px auto;"><?php echo $tooltipText; ?></span>
                                                </td>
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

    // function gotonextdepartment2(type) {
    //     var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec=") ?>" + type;
    //     window.location.href = url;
    // }

    function gotonextdepartment2(groupType) {
        var deptType = document.getElementById('subsecid2').value;
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_warranty_reports?depsec=') ?>" + groupType;

        if (deptType != '1') {
            url += "&dep=" + deptType;
        } else {
            url += "&dep=1";
        }

        window.location.href = url;
    }

    function gotonextdepartment3(departmentType) {
        var groupType = document.getElementById('subsecid').value;
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_warranty_reports?dep=') ?>" + departmentType;

        if (groupType != '1') {
            url += "&depsec=" + groupType;
        } else {
            url += "&depsec=1";
        }

        window.location.href = url;
    }
</script>