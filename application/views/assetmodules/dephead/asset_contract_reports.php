<div class="content">
    <?php
    // individual patient feedback link

    // Example Usage:

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

    if (!empty($results)) {
    ?>


        <div class="row">
            <?php
            $totalNoContract = 0;
            $totalExpired30Days = 0;
            $totalExpired = 0;
            $totalExpiresThisMonth = 0;
            $totalExpiringSoon = 0;
            $totalContractActive = 0;

            // Loop through the results to calculate counts
            if (!empty($results)) {
                foreach ($results as $department) {
                    $contractEndDate = $department->contract_end_date;
                    $assetWithAmc = trim($department->assetWithAmc);
                    $currentDate = new DateTime();

                    if ($assetWithAmc === 'AMC/ CMC not applicable' || empty($assetWithAmc)) {
                        $totalNoContract++; // Not applicable or missing → Count as No Contract
                    } elseif ($assetWithAmc === 'AMC/ CMC applicable') {
                        if (empty($contractEndDate)) {
                            $totalContractActive++; // AMC exists but no end date → Consider Active
                        } else {
                            $contractEndDateObj = new DateTime($contractEndDate);
                            $interval = $currentDate->diff($contractEndDateObj);
                            $daysRemaining = (int)$interval->format('%r%a'); // Negative if expired

                            if ($daysRemaining < -30) {
                                $totalExpired30Days++;
                            } elseif ($daysRemaining < 0) {
                                $totalExpired++;
                            } elseif ($currentDate->format('Y-m') == $contractEndDateObj->format('Y-m')) {
                                $totalExpiresThisMonth++;
                            } elseif ($daysRemaining >= 1 && $daysRemaining <= 90) {
                                $totalExpiringSoon++;
                            } else {
                                $totalContractActive++;
                            }
                        }
                    } else {
                        // If AMC status is unknown, treat as No Contract
                        $totalNoContract++;
                    }
                }
            }


            $applicableContractCount = $totalContractActive + $totalExpired + $totalExpired30Days + $totalExpiresThisMonth + $totalExpiringSoon;

            ?>

            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="panel panel-bd">
                        <div class="panel-body" style="height: 100px;" data-placement="top" data-toggle="tooltip">

                            <div class="statistic-box" title="Represents the total no. of assets for which contract is applicable.">
                                <h2><span class="count-number">
                                        <?php echo $applicableContractCount; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Contract Applicable Assets</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets for which contract not applicable.">
                                <h2><span class="count-number">
                                        <?php echo $totalNoContract; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">No Contract</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets with active contracts.">
                                <h2><span class="count-number">
                                        <?php echo $totalContractActive; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Contract Active</div>
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

                            <div class="statistic-box" title="Represents the total number of assets with warranties expiring this month">
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

                            <div class="statistic-box" title="Represents total no. of assets with expired contracts.">
                                <h2><span class="count-number">
                                        <?php echo $totalExpired; ?>
                                    </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                        </i></span></h2>
                                <div class="small">Contract Expired</div>
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

                            <div class="statistic-box" title="Represents the total no. of assets with contracts expired by more than 30 days.">
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
                                <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="Update AMC/ CMC details"
                                    href="<?= base_url($this->uri . '/asset_amc_cmc?user_id=' . $this->session->userdata['user_id']) ?>"
                                    target="_blank">
                                    <i class="fa fa-pencil"></i> Update AMC/ CMC details
                                </a>

                            </div>

                        </div>
                    </div>

                    <?php
                    // Get the 'status' parameter from the URL
                    $selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
                    ?>

                    <?php
                    // Get the 'status' parameter from the URL
                    $selectedCStatus = isset($_GET['amc_status']) ? $_GET['amc_status'] : 'all';
                    ?>



                    <div class="panel-body">
                        <?php if ($this->session->userdata('user_role') != 4) { ?>
                            <form method="get" action="<?php echo site_url('asset/asset_contract_reports'); ?>">
                                <b>AMC/ CMC Status:</b> <select name="status" class="form-control" onchange="this.form.submit()" style="width: 20%;">
                                    <option value="all" <?php echo $selectedStatus === 'all' ? 'selected' : ''; ?>>All</option>
                                    <option value="No Contract" <?php echo $selectedStatus === 'No Contract' ? 'selected' : ''; ?>>No Contract</option>
                                    <option value="Expired 30+ Days" <?php echo $selectedStatus === 'Expired 30+ Days' ? 'selected' : ''; ?>>Expired 30+ Days</option>
                                    <option value="Expired" <?php echo $selectedStatus === 'Expired' ? 'selected' : ''; ?>>Expired</option>
                                    <option value="Expires This Month" <?php echo $selectedStatus === 'Expires This Month' ? 'selected' : ''; ?>>Expires This Month</option>
                                    <option value="Expiring Soon" <?php echo $selectedStatus === 'Expiring Soon' ? 'selected' : ''; ?>>Expiring Soon</option>
                                    <option value="Contract Active" <?php echo $selectedStatus === 'Contract Active' ? 'selected' : ''; ?>>Contract Active</option>
                                </select>
                                <b style="margin-left: 10px;">Contract Type:</b> <select name="amc_status" class="form-control" onchange="this.form.submit()" style="width: 20%;">
                                    <option value="all" <?php echo $selectedCStatus === 'all' ? 'selected' : ''; ?>>All</option>
                                    <option value="AMC" <?php echo $selectedCStatus === 'AMC' ? 'selected' : ''; ?>>AMC</option>
                                    <option value="CMC" <?php echo $selectedCStatus === 'CMC' ? 'selected' : ''; ?>>CMC</option>
                                </select>

                            </form>
                            <br />
                        <?php } ?>


                        <table class="assetcontract table table-striped table-bordered table-hover" cellspacing="0" width="100%" style=" white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th>Sl. <br> No</th>
                                    <th>Asset Details</th>

                                    <th>Asset Location</th>

                                    <th>AMC/ CMC Details</th>

                                    <th>Days Until <br> Expiration</th>

                                    <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                        <th style="text-align: center;">AMC/ CMC Status</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($results)) { ?>
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

                                        // Define variables used in conditions
                                        $rowmessage = isset($department->message) ? $department->message : '';
                                        $tooltipText = "";
                                        $tooltipDetail = "";
                                        $color = "";

                                        // Calculate contract status based on contract end date
                                        // Calculate contract status based on contract end date
                                        $contractEndDateRaw = $department->contract_end_date;
                                        $assetWithAmc = trim($department->assetWithAmc); // Trim to avoid whitespace issues

                                        $currentDate = new DateTime();

                                        if ($assetWithAmc === 'AMC/ CMC not applicable' || empty($assetWithAmc)) {
                                            // Not applicable or missing — No contract
                                            $tooltipText = "No Contract";
                                            $tooltipDetail = "Asset does not require a contract or it is not applicable.";
                                            $color = "btn-primary";
                                        } elseif ($assetWithAmc === 'AMC/ CMC applicable') {
                                            if (empty($contractEndDateRaw)) {
                                                // AMC exists but no end date — treat as Active
                                                $tooltipText = "Contract Active";
                                                $tooltipDetail = "Contract is still valid.";
                                                $color = "btn-success";
                                            } else {
                                                $contractEndDate = new DateTime($contractEndDateRaw);
                                                $interval = $currentDate->diff($contractEndDate);
                                                $daysRemaining = (int)$interval->format('%r%a'); // includes sign

                                                if ($daysRemaining < -30) {
                                                    $tooltipText = "Expired 30+ Days";
                                                    $tooltipDetail = "Contract expired over 30 days ago.";
                                                    $color = "btn-danger";
                                                } elseif ($daysRemaining < 0) {
                                                    $tooltipText = "Expired";
                                                    $tooltipDetail = "Contract has expired.";
                                                    $color = "btn-danger";
                                                } elseif ($currentDate->format('Y-m') === $contractEndDate->format('Y-m')) {
                                                    $tooltipText = "Expires This Month";
                                                    $tooltipDetail = "Contract expires within the current month.";
                                                    $color = "btn-orange";
                                                } elseif ($daysRemaining >= 1 && $daysRemaining <= 90) {
                                                    $tooltipText = "Expiring Soon";
                                                    $tooltipDetail = "Contract is due to expire within 90 days.";
                                                    $color = "btn-yellow";
                                                } else {
                                                    $tooltipText = "Contract Active";
                                                    $tooltipDetail = "Contract is still valid.";
                                                    $color = "btn-success";
                                                }
                                            }
                                        } else {
                                            // Unexpected or unclassified status
                                            $tooltipText = "No Contract";
                                            $tooltipDetail = "Asset does not have an active contract.";
                                            $color = "btn-primary";
                                        }


                                        // Status filter matches
                                        $statuses = [
                                            "No Contract",
                                            "Expired 30+ Days",
                                            "Expired",
                                            "Expires This Month",
                                            "Expiring Soon",
                                            "Contract Active"
                                        ];

                                        $matches = ($selectedStatus === 'all') || ($tooltipText === $selectedStatus);
                                        $matchesStatus = ($selectedCStatus === 'all') || ($selectedCStatus === $department->contract);

                                        if ($matches && $matchesStatus) {
                                    ?>
                                            <tr class="<?php echo ($sl & 1) ? 'odd gradeX' : 'even gradeC'; ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo htmlspecialchars($tooltipDetail, ENT_QUOTES, 'UTF-8'); ?>" style="cursor: pointer;">
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
                                                    Area: <?php echo $department->locationsite; ?> <br>
                                                    Site: <?php echo $department->bedno; ?> <br>
                                                    Dept.: <?php echo $department->depart; ?> <br>
                                                    User: <?php echo $department->assignee; ?>
                                                </td>

                                                <td>
                                                    <?php echo $department->assetWithAmc; ?> <br>
                                                    Contract Type: <?php echo $department->contract; ?> <br>
                                                    Start Date: <?php echo $department->contract_start_date; ?> <br>
                                                    End date: <?php echo $department->contract_end_date; ?> <br>
                                                    Cost: <?php echo $department->contract_service_charges; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $contractEndDate = $department->contract_end_date;
                                                    $assetWithAmc = trim($department->assetWithAmc); // Trim whitespace
                                                    $currentDate = new DateTime();

                                                    if ($assetWithAmc === 'AMC/ CMC not applicable' || empty($assetWithAmc)) {
                                                        // AMC/CMC not applicable or empty → No Contract
                                                        echo '<span style="color: gray;">⚪️ No Contracts</span>';
                                                    } elseif ($assetWithAmc === 'AMC/ CMC applicable') {
                                                        if (empty($contractEndDate)) {
                                                            // AMC/CMC applicable but no end date → consider active
                                                            echo '<span style="color: green;">✅ Contracts Active</span>';
                                                        } else {
                                                            $contractEndDateObj = new DateTime($contractEndDate);

                                                            if ($currentDate > $contractEndDateObj) {
                                                                $interval = $currentDate->diff($contractEndDateObj);
                                                                echo '<span style="color: red;">🔴 Expired ' . $interval->days . ' days ago</span>';
                                                            } else {
                                                                $interval = $currentDate->diff($contractEndDateObj);
                                                                echo '<span style="color: orange;">🟠 Expires in ' . $interval->days . ' days</span>';
                                                            }
                                                        }
                                                    } else {
                                                        // Unknown AMC/CMC status, treat as No Contract
                                                        echo '<span style="color: gray;">⚪️ No Contracts</span>';
                                                    }
                                                    ?>
                                                </td>


                                                <td style="text-align: center; vertical-align: middle; padding: 10px;">
                                                    <span data-placement="bottom" data-toggle="tooltip" title="<?php echo $tooltipDetail; ?>" class="btn btn-sm btn-block <?php echo $color; ?>" style="font-size: 14px; padding: 3px 8px; width: 130px; margin: 5px auto;"><?php echo $tooltipText; ?></span>
                                                </td>
                                            </tr>
                                            <?php $sl++; ?>
                                    <?php }
                                    } ?>
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

    function gotonextdepartment2(type) {
        var url = "<?php echo base_url($this->uri->segment(1) . "/alltickets?depsec=") ?>" + type;
        window.location.href = url;
    }
</script>

<script>
    function filterComplaintsByStatus(status) {
        // Redirect to the same page with the selected status
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('status', status);
        window.location.search = urlParams.toString();
    }
</script>

<script>
    function filterTable() {
        var urlParams = new URLSearchParams(window.location.search);
        var selectedStatus = urlParams.get('status') || 'all'; // Get 'status' from URL, default to 'all'

        var rows = document.querySelectorAll('.assetcontract tbody tr');

        rows.forEach(function(row) {
            var contractType = row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase(); // AMC/CMC Details column
            var contractText = contractType; // Either 'amc' or 'cmc'

            // If URL status is 'all', show all rows
            // If URL status matches the contract type, show that row
            if ((selectedStatus === 'all') || (selectedStatus.toLowerCase() === contractText)) {
                row.style.display = ''; // Show the row
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });
    }
</script>