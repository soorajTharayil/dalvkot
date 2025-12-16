<div class="content">
    <?php


    //Retrieve floor_asset to display asset based permission
    $floor_asset = $this->session->userdata['floor_asset'];

    // Define a dynamic condition (example: include keys that start with 'set1')
    $condition = function ($key, $value) {
        return strpos($key, 'set1') === 0; // Only include keys that start with 'set1'
    };


    $ip_link_patient_feedback = base_url($this->uri->segment(1) . '/patient_complaint?patientid=');
    // $this->db->select("*");
    // $this->db->from('bf_feedback_asset_creation');
    // $this->db->where('assignstatus', 'Asset Broken');
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

            <!--  table area -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: right;">
                        <div class="btn-group">
                            <!-- <a class="btn btn-success" data-placement="bottom" data-toggle="tooltip" title="<?php echo lang_loader('pcf', 'pcf_download_all_complaint_report'); ?>" href="<?php echo base_url($this->uri->segment(1)) . '/download_' . ($this->uri->segment(2)) ?>">
                                <i class="fa fa-file-text"></i>
                            </a> -->
                        </div>
                    </div>


                    <div class="panel-body">
                        <?php if ($this->session->userdata('user_role') != 4) { ?>
                            <form>
                                <p> <!-- <span style="font-size:15px; font-weight:bold;">Sort Complaints By : </span> -->
                                    <select name="dep" class="form-control" id="subsecid" onchange="gotonextdepartment2(this.value)" style="width:200px; margin:0px 20px 0px 0px;">
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
                            <br />
                        <?php } ?>


                        <table class="assetbroken table table-striped table-bordered table-hover" cellspacing="0" width="100%" style=" white-space: nowrap; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sl. <br> No</th>
                                    <th>Asset <br> Details</th>

                                    <th>Asset Location</th>

                                    <th>Preventive Maintenance</th>


                                    <th>Quantity/<br>Unit Price/<br>Total Price</th>
                                    <!-- <th>Asset Image</th> -->
                                    <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                        <th style="text-align: center;">Status/ Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selected_dep = $this->input->get('depsec');
                                $selected_asset_dep = $this->input->get('dep');

                                if (!empty($results)) {        ?>
                                    <?php $sl = 1; ?>
                                    <?php foreach ($results as $department) {
                                        $dataSet = json_decode($department->dataset);
                                        // print_r($department);
                                        // exit;
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

                                        if ($department->status == 'Addressed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Addressed');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $addressed_comm = $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . '  addressed the ticket with , ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Transfered') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Transfered');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $trans_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . ' Transfered because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Reopen') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Reopen');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();
                                            $reopen_comm =  $ticket[0]->reply;
                                            $rowmessage = $ticket[0]->message . 'Reopened because, ' . $ticket[0]->reply;
                                        } elseif ($department->status == 'Closed') {
                                            $this->db->where('ticketid', $department->id)->where('ticket_status', 'Closed');
                                            $query = $this->db->get('ticket_int_message');
                                            $ticket = $query->result();

                                            $rowmessage = $ticket[0]->message . ' Closed the ticket,  Root Cause: ' . $ticket[0]->rootcause . '. CAPA: ' . $ticket[0]->corrective . '  ';
                                        } else {
                                            //$rowmessage = 'THIS TICKET IS OPEN';
                                        }
                                        if (strlen($rowmessage) > 60) {
                                            $rowmessage = substr($rowmessage, 0, 60) . '  ' . ' ... click status to view';
                                        }

                                    ?>
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
                                                    <a href="<?php echo base_url($this->uri->segment(1) . '/patient_complaint?patientid=' . $department->patientid); ?>" target="_blank">
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
                                                Last PM date: <?php echo $department->preventive_maintenance_date; ?> <br>
                                                Upcoming PM Due: <?php echo $department->upcoming_preventive_maintenance_date; ?>
                                            </td>

                                            <td>
                                                Qty: <?php echo $department->assetquantity; ?> <br>
                                                UP: <?php echo $department->unitprice; ?> <br>
                                                TP: <?php echo $department->totalprice; ?>
                                            </td>
                                            <!-- <td>
                                                <?php if ($department->image != '' && $department->image != NULL) {
                                                    $encodedImage = $department->image; ?>
                                                    <img src="<?php echo $encodedImage; ?>"
                                                        style="width: 200px; height: 300px; "
                                                        alt="Rendered Image"
                                                        onclick="openImageInNewTab('<?php echo $encodedImage; ?>')">
                                                <?php } else { ?>
                                                    -
                                                <?php } ?>
                                            </td> -->



                                            <!-- <td style="overflow: clip; word-break: break-all;">

                                                <?php
                                                if ($department->departmentid_trasfered != 0) {
                                                    $show = false;
                                                    if ($department->status == 'Addressed') {
                                                        echo 'Ticket was transferred';
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Transfered') {
                                                        echo $trans_comm;
                                                        $show = true;
                                                    }
                                                    if ($department->status == 'Reopen') {
                                                        echo $reopen_comm;
                                                        $show = true;
                                                    }

                                                    if ($show == false && $department->status == 'Closed') {
                                                        echo 'Ticket was transferred';
                                                    }
                                                } else {

                                                    foreach ($department->feed->reason as $key => $value) {


                                                        if ($key) {
                                                            if ($titles[$key] == $department->department->description) {
                                                                if (in_array($key, $keys)) {
                                                                    echo $res[$key];
                                                                    echo '<br>';
                                                                    $show = $res[$key];
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                // print_r($show);
                                                ?>
                                            </td> -->
                                            <?php if ($this->session->userdata('user_role') != 4) { ?>
                                                <!-- <td><?php echo $department->department->description; ?>
                                                    <br>
                                                    <?php echo $department->department->pname; ?>
                                                </td> -->
                                            <?php } ?>

                                            <?php
                                            if ($department->assignstatus == 'Asset Assign' || $department->assignstatus == 'Asset Reassign' || $department->assignstatus == 'Asset Restore' || $department->assignstatus == 'Asset Transfer' || $department->assignstatus == 'Pending Transfer') {
                                                $department->assignstatus = 'Asset in Use';
                                                $color = 'btn-primary';
                                            } elseif ($department->assignstatus == 'Asset Broken') {
                                                $color = 'btn-danger';
                                            } elseif ($department->assignstatus == 'Asset Sold') {
                                                $color = 'btn-success';
                                            } elseif ($department->assignstatus == 'Asset Malfunction' || $department->assignstatus == 'Asset in Repair') {
                                                $department->assignstatus = 'Asset Malfunction';
                                                $color = 'btn-warning';
                                            } elseif ($department->assignstatus == 'Asset Lost') {
                                                $color = 'btn-blue';
                                            } elseif ($department->assignstatus == 'Asset Dispose') {
                                                $department->assignstatus = 'Asset Disposed';
                                                $color = 'btn-grey';
                                            } else {
                                                $color = 'btn-primary';
                                            }
                                            ?>

                                            <?php if (ismodule_active('ASSET') === true && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <td style="text-align: center; vertical-align: middle; padding: 10px;">

                                                    <a href="<?php echo base_url($this->uri->segment(1) . "/track/$department->id") ?>"
                                                        data-placement="bottom"
                                                        data-toggle="tooltip"
                                                        title="<?php echo $tool; ?>"
                                                        class="btn btn-sm btn-block <?php echo $color; ?>"
                                                        style=" font-size: 14px; padding: 3px 8px; width: 130px; margin: 5px auto;">
                                                        <?php echo $department->assignstatus; ?>
                                                        <i style="font-size:16px;" class="fa fa-edit"></i>
                                                    </a>


                                                    <a class="btn btn-sm "
                                                        href="<?= base_url($this->uri . '/add_subasset?user_id=' . $this->session->userdata['user_id'] . '&assetname=' . urlencode($department->assetname) . '&assetcode=' . urlencode($department->patientid)) ?>"
                                                        title="Add a new component asset" style="background-color: #20c997; color: #fff; font-size: 12px; padding: 3px 8px; width: 50px;">
                                                        <i style="font-size:16px;" class="fa fa-plus"></i>
                                                    </a>


                                                    <?php if (isfeature_active('EDIT-ASSET') === true) { ?>
                                                        <a class="btn btn-sm btn-primary"
                                                            href="<?php echo base_url($this->uri->segment(1) . "/edit_asset/" . $department->id); ?>"
                                                            title="Edit the asset" style="font-size: 12px; padding: 3px 8px; width: 50px;">
                                                            <i style="font-size:16px;" class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php if (isfeature_active('DELETE-ASSET') === true) { ?>
                                                        <a class="btn btn-sm btn-danger"
                                                            href="<?php echo base_url($this->uri->segment(1) . "/delete_asset/" . $department->id); ?>"
                                                            onclick="return confirm('Are you sure you want to delete this asset?');"
                                                            title="Delete the asset" style="font-size: 12px; padding: 3px 8px; width: 50px;">
                                                            <i style="font-size:16px;" class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>

                                            <?php } ?>

                                        </tr>

                                        <?php $sl++; ?>
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
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_broken_tickets?depsec=') ?>" + groupType;

        if (deptType != '1') {
            url += "&dep=" + deptType;
        } else {
            url += "&dep=1";
        }

        window.location.href = url;
    }

    function gotonextdepartment3(departmentType) {
        var groupType = document.getElementById('subsecid').value;
        var url = "<?php echo base_url($this->uri->segment(1) . '/asset_broken_tickets?dep=') ?>" + departmentType;

        if (groupType != '1') {
            url += "&depsec=" + groupType;
        } else {
            url += "&depsec=1";
        }

        window.location.href = url;
    }
</script>