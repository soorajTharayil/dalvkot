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

?>



<div class="content">
    <div class="row">

        <div class="col-lg-12">
            <?php

            $asset_id = $this->uri->segment(3);

            $this->db->order_by('id', 'desc');
            $this->db->where('id', $asset_id);
            $query = $this->db->get('bf_feedback_asset_creation');
            $result = $query->row();

            $unitprice = isset($result->unitprice) ? (float)$result->unitprice : 0;

            $depart_transfer = $result->depart_transfer;


            $assignstatus = $result->assignstatus;

            $assetWithAmc = $result->assetWithAmc;
            $assetWithCalibration = $result->assetWithCalibration;
            $assetWithPm = $result->assetWithPm;
            $assetWithWarranty = $result->assetWithWarranty;




            $matchedGrade = 'No Grade';


            $this->db->select('title, bed_no, bed_nom');
            $this->db->from('bf_asset_grade');
            $grades_query = $this->db->get();
            $grades = $grades_query->result();

            if ($unitprice > 0 && !empty($grades)) {
                foreach ($grades as $grade) {
                    $min = isset($grade->bed_no) ? (float)$grade->bed_no : 0;
                    $max = isset($grade->bed_nom) ? (float)$grade->bed_nom : 0;

                    if ($unitprice >= $min && $unitprice <= $max) {
                        $matchedGrade = $grade->title;
                        break;
                    }
                }
            }

            if ($result) {

                $qrCodeImage = $result->qrCodeUrl;
                $pat = json_decode($result->dataset, true);
                // print_r($pat['images']);
                // exit;
            }

            ?>

            <?php $department = $departments[0];
            $preventive_maintenance_date1  =   $result->preventive_maintenance_date;
            $upcoming_preventive_maintenance_date1  =   $result->upcoming_preventive_maintenance_date;
            $reminder_alert_11  =    $result->reminder_alert_1;
            $reminder_alert_21  =    $result->reminder_alert_2;
            $sr_open_time  =    $result->sr_open_time;
            $sr_close_time  =    $result->sr_close_time;


            $asset_calibration_date1  =   $result->asset_calibration_date;
            $upcoming_calibration_date1  =   $result->upcoming_calibration_date;
            $calibration_reminder_alert_11  =    $result->calibration_reminder_alert_1;
            $calibration_reminder_alert_21  =    $result->calibration_reminder_alert_2;

            ?>

            <?php
            $replyMessages = array_reverse($department->replymessage ?? []);
            $transferToDepartment = '';
            $transferToUser = '';

            foreach ($replyMessages as $r) {
                if (!empty($r->depart) && !empty($r->action)) {
                    $transferToDepartment = $r->depart;
                    $transferToUser = $r->action;

                    // Optional: If you only want the most recent valid transfer
                    break;
                }
            }
            ?>

            <?php

            $asset_id = $this->uri->segment(3);

            $this->db->order_by('id', 'desc');
            $this->db->where('id', $asset_id);
            $query = $this->db->get('tickets_asset');
            $resultasset = $query->row();

            ?>






            <?php
            // Check conditions for showing the modal
            $show_modal = false;
            $is_super_admin = in_array($this->session->userdata('user_role'), [2, 3]);
            $current_user_id = $this->session->userdata('user_id');
            $transfer_to_users = $resultasset->transfer_to ? explode(',', $resultasset->transfer_to) : [];
            $is_receiving_user = in_array($current_user_id, $transfer_to_users);

            // Determine if we should show the modal and set appropriate messages
            if ($this->session->userdata('isLogIn') && isfeature_active('ASSET-APPROVAL-EMAIL')) {
                // Case 1
                if ($is_super_admin && $resultasset->transfer_approval_status == 'pending') {
                    $show_modal = true;
                    $modal_title = "Asset Transfer Approval Request";
                    $action_message = "Would you like to approve this asset transfer request?";
                }
                // Case 2:
                elseif ($is_receiving_user && $resultasset->transfer_approval_status == 'approved_by_admin') {
                    $show_modal = true;
                    $modal_title = "Asset Transfer Acceptance";
                    $action_message = "Would you like to accept this transferred asset?";
                }
            }

            if ($show_modal) { ?>
                <!-- Transfer Modal -->
                <div class="modal" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" style="display: block; background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="border-radius: 10px;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transferModalLabel"><?php echo $modal_title; ?></h5>
                                <button type="button" class="close" id="closeModal" aria-label="Close" style="float:right; background: none; border: none; font-size: 1.5rem; font-weight: bold; color: #000;">
                                    <span aria-hidden="true" style="margin-right: -270px;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>A request to transfer the following asset is awaiting your action:</p>

                                <strong>Transfer From:</strong><br>
                                Department: <?php echo $pat['depart']; ?><br>
                                User: <?php echo $pat['assigned']; ?><br><br>

                                <strong>Transfer To:</strong><br>
                                Department: <?php echo htmlspecialchars($transferToDepartment); ?><br>
                                User: <?php echo htmlspecialchars($transferToUser); ?><br><br>

                                <p><?php echo $action_message; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="approveBtn">Approve</button>
                                <button type="button" class="btn btn-danger" id="denyBtn">Deny</button>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    /* Critical CSS to ensure visibility */
                    #transferModal {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        z-index: 99999;
                        overflow-y: auto;
                        background-color: rgba(0, 0, 0, 0.5) !important;
                    }

                    #transferModal .modal-dialog {
                        margin: 30px auto;
                        z-index: 100000;
                        position: relative;
                    }

                    #transferModal .modal-content {
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
                    }

                    #transferModal .modal-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                    }

                    #transferModal .close {
                        cursor: pointer;
                        opacity: 0.7;
                        transition: opacity 0.2s;
                    }

                    #transferModal .close:hover {
                        opacity: 1;
                    }

                    body {
                        padding-right: 0 !important;
                        overflow: auto !important;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get elements
                        var modal = document.getElementById('transferModal');
                        var approveBtn = document.getElementById('approveBtn');
                        var denyBtn = document.getElementById('denyBtn');
                        var closeBtn = document.getElementById('closeModal');

                        // Center modal function
                        function centerModal() {
                            var dialog = modal.querySelector('.modal-dialog');
                            var top = Math.max(0, (window.innerHeight - dialog.offsetHeight) / 2);
                            dialog.style.marginTop = top + 'px';
                        }

                        // Center initially and on resize
                        centerModal();
                        window.addEventListener('resize', centerModal);

                        // Close handlers
                        function closeModal() {
                            modal.style.display = 'none';
                        }

                        approveBtn.onclick = function() {
                            closeModal();
                            window.location.href = '<?php echo site_url("asset/approve_transfer/" . $resultasset->id); ?>';
                        };

                        denyBtn.onclick = function() {
                            closeModal();
                            window.location.href = '<?php echo site_url("asset/deny_transfer/" . $resultasset->id); ?>';
                        };

                        closeBtn.onclick = function() {
                            closeModal();
                        };

                        // Prevent closing when clicking backdrop
                        modal.onclick = function(event) {
                            if (event.target === modal) {
                                return false;
                            }
                        };
                    });
                </script>
            <?php } ?>




            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip" title="ASSET MANAGER- <ASSET ID>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;ASSET DETAILS</h3>
                    <?php

                    ?>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">



                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">
                        <tr>
                            <td><strong>Asset details</strong></td>
                            <td>
                                <?php if (!empty($pat['patientid'])): ?>
                                    <strong>Asset Code: <?php echo $pat['patientid']; ?></strong> <br>
                                <?php endif; ?>

                                <?php if (!empty($pat['assetname'])): ?>
                                    <strong>Asset Name: <?php echo $pat['assetname']; ?> </strong><br>
                                <?php endif; ?>

                                <?php if (!empty($pat['ward']) && $pat['ward'] != 'Select Asset Group/ Category'): ?>
                                    Asset Group: <?php echo $pat['ward']; ?><br>
                                <?php else: ?>
                                    Asset Group: -<br>
                                <?php endif; ?>

                                <?php if (!empty($pat['brand'])): ?>
                                    Asset Brand: <?php echo $pat['brand']; ?><br>
                                <?php endif; ?>

                                <?php if (!empty($pat['model'])): ?>
                                    Asset Model: <?php echo $pat['model']; ?><br>
                                <?php endif; ?>

                                <?php if (!empty($pat['serial'])): ?>
                                    Asset Serial No.: <?php echo $pat['serial']; ?><br>
                                <?php endif; ?>

                                <?php if (!empty($pat['assigned']) && $pat['assigned'] != 'Select Asset User'): ?>
                                    Allocated User: <?php echo $pat['assigned']; ?><br>
                                <?php else: ?>
                                    Allocated User: -<br>
                                <?php endif; ?>

                                <?php if (!empty($pat['depart']) && $pat['depart'] != 'Select Asset Department'): ?>
                                    Allocated Department: <?php echo $pat['depart']; ?><br>
                                <?php else: ?>
                                    Allocated Department: -<br>
                                <?php endif; ?>

                                <?php if (!empty($depart_transfer)): ?>
                                    Current Department: <?php echo $depart_transfer; ?><br>
                                <?php else: ?>
                                    Current Department: -<br>
                                <?php endif; ?>

                                Asset Grade: <span><?php echo htmlspecialchars($matchedGrade); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Asset Location</strong></td>
                            <td>
                                Area: <?php if (!empty($pat['locationsite']) && $pat['locationsite'] != 'Select Floor/ Area') {
                                            echo $pat['locationsite'];
                                        } else {
                                            echo '-';
                                        } ?>
                                <br>
                                Site: <?php if (!empty($pat['bedno']) && $pat['bedno'] != 'Select Site') {
                                            echo $pat['bedno'];
                                        } else {
                                            echo '-';
                                        } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Purchase & Warranty Info</strong></td>
                            <td>
                                Purchase Date:
                                <?php
                                echo (!empty($pat['purchaseDate']) && strtotime($pat['purchaseDate']) !== false)
                                    ? $pat['purchaseDate']
                                    : 'N/A';
                                ?>
                                <br>
                                Install Date:
                                <?php
                                echo (!empty($pat['installDate']) && strtotime($pat['installDate']) !== false)
                                    ? $pat['installDate']
                                    : 'N/A';
                                ?>
                                <br>

                                Warranty Start Date:
                                <?php
                                echo (!empty($pat['warrenty']) && strtotime($pat['warrenty']) !== false)
                                    ? $pat['warrenty']
                                    : 'N/A';
                                ?>
                                <br>

                                Warranty End Date:
                                <?php
                                echo (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false)
                                    ? $pat['warrenty_end']
                                    : 'N/A';
                                ?>

                                <br>
                                Reminder Alert 1:
                                <?php
                                if (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false) {
                                    $warranty_end_date = new DateTime($pat['warrenty_end']);
                                    $reminder_1_date = $warranty_end_date->modify('-15 days')->format('Y-m-d');
                                    echo $reminder_1_date;
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                                <br>
                                Reminder Alert 2:
                                <?php
                                if (!empty($pat['warrenty_end']) && strtotime($pat['warrenty_end']) !== false) {
                                    $warranty_end_date = new DateTime($pat['warrenty_end']);
                                    $reminder_2_date = $warranty_end_date->modify('-2 days')->format('Y-m-d');
                                    echo $reminder_2_date;
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                                <br>

                            </td>
                        </tr>

                        <tr>
                            <td><strong>Financial Information</strong></td>
                            <td>
                                Asset Quantity: <span id="assetQuantity"><?php echo htmlspecialchars($pat['assetquantity'] ?? 'N/A'); ?></span><br>
                                Unit Price: ₹<span id="unitPrice"><?php echo htmlspecialchars($pat['unitprice'] ?? '0'); ?></span><br>
                                Total Price: ₹<span id="totalPrice"><?php echo htmlspecialchars($pat['totalprice'] ?? '0'); ?></span><br>
                                Depreciation Rate: <span id="depreciationRate"><?php echo htmlspecialchars($pat['depreciation'] ?? '0'); ?></span>%<br>

                                <!-- <button onclick="calculateAssetValue()" class="btn btn-primary btn-sm" style="margin-top: 5px;">Calculate Current Asset Value</button><br><br> -->

                                <strong>Total Asset Value: ₹<span id="assetCurrentValue"><?php echo htmlspecialchars($pat['assetCurrentValue'] ?? ''); ?></span></strong>
                                <span id="assignStatus" style="display: none;"><?php echo htmlspecialchars($result->assignstatus ?? ''); ?></span>

                            </td>
                        </tr>


                        <tr>
                            <td><strong>AMC/ CMC Details</strong></td>
                            <td>
                                Contract Type: <?php echo $pat['contract']; ?>
                                <br>
                                Start Date:
                                <?php
                                if ($pat['contract'] === 'AMC') {
                                    echo $pat['amcStartDate'];
                                } elseif ($pat['contract'] === 'CMC') {
                                    echo $pat['cmcStartDate'];
                                }
                                ?>
                                <br>
                                End Date:
                                <?php
                                if ($pat['contract'] === 'AMC') {
                                    echo $pat['amcEndDate'];
                                } elseif ($pat['contract'] === 'CMC') {
                                    echo $pat['cmcEndDate'];
                                }
                                ?>
                                <br>
                                Cost:
                                <?php
                                if ($pat['contract'] === 'AMC') {
                                    echo $pat['amcServiceCharges'];
                                } elseif ($pat['contract'] === 'CMC') {
                                    echo $pat['cmcServiceCharges'];
                                }
                                ?>
                                <br>

                                <?php
                                $endDate = null;
                                if ($pat['contract'] === 'AMC') {
                                    $endDate = $pat['amcEndDate'];
                                } elseif ($pat['contract'] === 'CMC') {
                                    $endDate = $pat['cmcEndDate'];
                                }

                                if ($endDate) {
                                    // Try to parse the date silently
                                    $endDateTime = DateTime::createFromFormat('Y-m-d', $endDate);

                                    // If date is valid, proceed with calculations
                                    if ($endDateTime !== false) {
                                        $originalEndDate = clone $endDateTime;

                                        // Calculate Reminder Alert 1 (30 days before end date)
                                        $reminder1Date = clone $originalEndDate;
                                        $reminder1 = $reminder1Date->modify('-30 days')->format('d-m-Y');

                                        // Calculate Reminder Alert 2 (15 days before end date)
                                        $reminder2Date = clone $originalEndDate;
                                        $reminder2 = $reminder2Date->modify('-15 days')->format('d-m-Y');

                                        echo "Reminder Alert 1: $reminder1<br>";
                                        echo "Reminder Alert 2: $reminder2";
                                    }
                                    // If date is invalid, do nothing (no error shown)
                                }
                                ?>
                            </td>


                        </tr>

                        <tr>
                            <td> <strong>Supplier Information</strong> </td>
                            <td>
                                Supplier Name: <?php echo $pat['supplierinfo']; ?>
                                <br>
                                Service Person Name: <?php echo $pat['servicename']; ?>
                                <br>
                                Service Person Contact: <?php echo $pat['servicecon']; ?>
                                <br>
                                Service Person Email: <?php echo $pat['servicemail']; ?>

                            </td>
                        </tr>

                        <tr>
                            <td><strong>Preventive Maintenance</strong></td>
                            <td>
                                <!-- Last Preventive Maintenance Date -->
                                <div style="display: flex; align-items: center;">
                                    <span>Last Preventive Maintenance Date:</span>
                                    <span><strong><?php echo  $preventive_maintenance_date1; ?></strong></span>
                                </div>
                                <br>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Upcoming Preventive Maintenance Due:</span>
                                    <span><strong><?php echo  $upcoming_preventive_maintenance_date1; ?></strong></span>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 1 (Default: 15 days before) -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Reminder Alert 1:</span>
                                    <span><strong><?php echo  $reminder_alert_11; ?></strong></span>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 2 (Default: 2 days before) -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Reminder Alert 2:</span>
                                    <span><strong><?php echo  $reminder_alert_21; ?></strong></span>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Asset Calibration</strong></td>
                            <td>
                                <!-- Last Preventive Maintenance Date -->
                                <div style="display: flex; align-items: center;">
                                    <span>Last Calibration Date:</span>
                                    <span><strong><?php echo  $asset_calibration_date1; ?></strong></span>
                                </div>
                                <br>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Upcoming Calibration Due:</span>
                                    <span><strong><?php echo  $upcoming_calibration_date1; ?></strong></span>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 1 (Default: 15 days before) -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Reminder Alert 1:</span>
                                    <span><strong><?php echo  $calibration_reminder_alert_11; ?></strong></span>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 2 (Default: 2 days before) -->
                                <div style="display: flex; align-items: center; margin-top: -15px;">
                                    <span>Reminder Alert 2:</span>
                                    <span><strong><?php echo  $calibration_reminder_alert_21; ?></strong></span>
                                </div>
                            </td>
                        </tr>


                        <?php
                        $images = $pat['images'] ?? [];

                        if (!empty($images)) {
                            echo '<tr><td><strong>Asset Images</strong></td><td>';

                            foreach ($images as $index => $encodedImage) {
                                $filename = 'attachment_' . time() . '_' . ($index + 1) . '.jpg';
                                $safeImage = htmlspecialchars($encodedImage, ENT_QUOTES, 'UTF-8');
                                $safeFilename = htmlspecialchars($filename, ENT_QUOTES, 'UTF-8');
                                echo <<<HTML
        <div style="margin-bottom: 10px;">
            <a href="javascript:void(0);" onclick="previewImage('$safeImage', '$safeFilename')">
                $safeFilename
            </a>
        </div>
HTML;
                            }

                            echo '</td></tr>';
                        }
                        ?>

                        <!-- Image Preview Modal -->
                        <div id="imagePreviewModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background-color:white; border:1px solid #ccc; padding:20px; z-index:10000;">
                            <div style="text-align:right;">
                                <button onclick="document.getElementById('imagePreviewModal').style.display='none';">Close</button>
                            </div>
                            <div>
                                <img id="previewImg" src="" alt="Preview" style="max-width:600px; max-height:80vh;" />
                                <p id="previewFilename" style="margin-top: 10px; font-weight:bold;"></p>
                            </div>
                        </div>

                        <script>
                            function previewImage(base64, filename) {
                                const modal = document.getElementById('imagePreviewModal');
                                const img = document.getElementById('previewImg');
                                const label = document.getElementById('previewFilename');
                                img.src = base64;
                                label.textContent = filename;
                                modal.style.display = 'block';
                            }
                        </script>





                        <tr>
                            <td><strong>Attached Documents</strong></td>
                            <td>
                                <?php
                                // Assuming $pat['files_name'] contains the decoded data from your database
                                if (!empty($pat['files_name']) && is_array($pat['files_name'])) {
                                    foreach ($pat['files_name'] as $file) {
                                        if (!empty($file['name']) && !empty($file['url'])) {
                                            echo '<a href="' . htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8') . '" download="' . htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') . '">';
                                            echo htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8');
                                            echo '</a><br>';
                                        }
                                    }
                                } else {
                                    echo 'No files available';
                                }
                                ?>
                            </td>
                        </tr>




                        <?php if (!empty($pat['qrCodeUrl'])) { ?>
                            <tr>
                                <td><strong>Asset QR Code</strong></td>
                                <td>
                                    <?php if (!empty($pat['qrCodeUrl'])) {
                                        $qrCodeImage = $pat['qrCodeUrl']; ?>
                                        <a href="<?php echo $qrCodeImage; ?>" download="QR_Code_Image.png">
                                            <img src="<?php echo $qrCodeImage; ?>"
                                                style="max-width: 400px; max-height: 300px; object-fit: contain; cursor: pointer;"
                                                alt="Rendered QR Code Image">
                                        </a>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>


                        <tr>
                            <td><strong>Current Status</strong></td>
                            <td>
                                <?php echo  $assignstatus; ?>
                            </td>
                        </tr>



                        <tr>
                            <td><strong>Asset Status</strong> </td>
                            <td> <?php if ($this->session->userdata['isLogIn'] == false) { ?>
                                    <?php if ($department->status == 'Closed') { ?>
                                        <span style="color:  #198754;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                        <?php echo 'Closed'; ?>
                                    <?php } ?>
                                    <?php if ($department->status == 'Addressed' || $department->status == 'Reopen' || $department->status == 'Transfered') { ?>
                                        <span style="color:  #f0ad4e;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                        <?php echo 'Inprogress'; ?>
                                    <?php } ?>
                                    <?php if ($department->status == 'Asset in Use') { ?>
                                        <span style="color: #d9534f;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                        <?php echo 'Pending'; ?>
                                    <?php }  ?>
                                    <?php if ($department->status == 'Asset in Use') { ?>
                                        <span style="color: #d9534f;font-weight: bold; display: inline-block;"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                        <?php echo 'Asset in Use'; ?>
                                    <?php }  ?>


                                <?php } ?>
                                <?php if ($this->session->userdata['isLogIn'] == true) { ?>
                                    <?php //if (($this->session->userdata['user_role'] == 4 && $this->session->userdata['email'] == $department->department->email) || $this->session->userdata['user_role'] <= 3) { 

                                    ?>

                                    <select class="form-control" onchange="ticket_options(this.value)" style="max-width: 300px;" required>
                                        <option value="<?php echo $departments->status; ?>" selected><?php echo $departments->status; ?></option>
                                        <?php if ($departments->status != 'Closed') {
                                            $open = true; ?>



                                            <?php if ($department->addressed != 1) { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_assign">Allocate Asset</option>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_transfer">Transfer Asset Department</option>
                                            <?php } ?>
                                            <?php if ($assetWithPm == 'PM applicable') { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_preventive">Update Preventive Maintenance</option>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($assetWithCalibration == 'Calibration applicable') { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_calibration">Update Asset Calibration</option>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($assetWithWarranty == 'Warranty applicable') { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_warranty">Update Asset Warranty</option>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($assetWithAmc == 'AMC/ CMC applicable') { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_amc_cmc">Update Asset AMC/ CMC</option>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_repair">Asset Malfunction</option>
                                            <?php } ?>
                                            <?php if ($department->status == 'Asset Malfunction') { ?>
                                                <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                    <option value="asset_restore">Asset Restore</option>
                                                <?php } ?>
                                            <?php } ?>
                                            <!-- <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_broken">Asset Broken</option>
                                            <?php } ?> -->

                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_revoke">Revoke/ Reassign Asset</option>
                                            <?php } ?>
                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_lost">Asset Lost</option>
                                            <?php } ?>
                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_sold">Asset Sold</option>
                                            <?php } ?>
                                            <?php if (ismodule_active('ASSET') === true  && isfeature_active('ASSET-DASHBOARD') === true) { ?>
                                                <option value="asset_dispose">Dispose Asset</option>
                                            <?php } ?>

                                        <?php } ?>

                                    </select>

                                    <span> <i class="fa fa-hand-o-left" aria-hidden="true" style="font-size: 20px; padding-left: 10px;"></i></span>
                                    <span style="padding-left: 10px;">Take action here</span>
                                <?php } ?>
                                <?php //} 
                                ?>
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>

        <?php if ($this->session->userdata['user_role'] != 4 && ($department->status == 'Closed')) { ?>

        <?php } else {  ?>
            <?php if ($open == true) {  ?>
                <?php if (($department->status != 'Closed')) { ?>
                    <div class="col-sm-12" id="asset_assign" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Allocate the asset</h3>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <br />
                                <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                                <?php echo form_hidden('id', $department->id) ?> <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label">Select Department</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="sel1" name="deparment_name" required aria-required="true" style="width: 98%;">
                                            <option value="">--Select Option--</option>
                                            <?php
                                            // Fetching data
                                            $this->db->order_by('id', 'asc');
                                            $query = $this->db->get('bf_asset_location');
                                            $data = $query->result();

                                            // Iterating through the data to create options
                                            foreach ($data as $row) {
                                                if ($row->title != 'ALL') {  // Check if title is not 'ALL'
                                                    echo '<option value="' . $row->title . '">' . $row->title . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <label for="name" class="col-xs-3 col-form-label" style="margin-top: 25px;">Select User</label>
                                    <div class="col-xs-9" style="margin-top: 22px;margin-left:-13px;">


                                        <input type="text" id="userSearch" class="form-control" placeholder="Search for user.." style="margin-left:10px; width: 98%;">

                                        <div class="checkbox-container" id="userList" style="margin-top: 15px; margin-left: 12px;">
                                            <?php foreach ($users as $user) : ?>
                                                <?php if ($user->firstname !== 'developer') : // Check if the designation is not Developer 
                                                ?>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" name="users[]" value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                                                        <label for="user_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>


                                    </div>
                                </div>

                                <br>
                                <div class="form-group row" style="margin-top: -10px;">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('pcf', 'pcf_comment'); ?></label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" style="width:97%;" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Assign">
                                    </div>
                                </div>
                                <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button> </div>
                                    </div>
                                </div> <?php echo form_close() ?>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>

                    <div class="col-sm-12" id="asset_broken" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Please describe reason for Asset Broken</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">

                                <input type="hidden" name="status" value="Asset Broken">

                                <br>


                                <div class="form-group row">
                                    <div class="col-xs-9" style="width: 90%;">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Broken">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <!-- <button type="reset" class="ui button">
                                        <?php // echo display('reset') 
                                        ?></button>
                                    <div class="or"></div> -->
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" id="asset_repair" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Details for Asset Malfunction</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset Malfunction">

                                <br>


                                <div class="form-group row">
                                    <label for="repairStartDateTime" class="col-xs-3 col-form-label">Malfunction Date & Time:</label>
                                    <div class="col-xs-9">
                                        <input type="datetime-local" class="form-control" id="repairStartDateTime" name="repair_start_date_time"
                                            value=""
                                            <?= isset($sr_open_time) ? 'required' : '' ?> onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>



                                <!-- <div class="form-group row">
                                    <label for="repairCompletionDateTime" class="col-xs-3 col-form-label">Repair Completion Date & Time:</label>
                                    <div class="col-xs-9">
                                        <input type="datetime-local" class="form-control" id="repairCompletionDateTime" name="repair_completion_date_time"
                                            value="<?= isset($sr_close_time) ? date('Y-m-d\TH:i', strtotime($sr_close_time)) : '' ?>"
                                            <?= isset($sr_close_time) ? 'required' : '' ?>>
                                    </div>
                                </div>


                                
                                <div class="form-group row">
                                    <label for="expenseCost" class="col-xs-3 col-form-label">Relative Expense:</label>
                                    <div class="col-xs-9">
                                        <input type="number" class="form-control" id="expense_cost" name="expense_cost" placeholder="Enter your input here" required>
                                    </div>
                                </div> -->


                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3 col-form-label">Comment:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Malfunction">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" id="asset_restore" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Details for restore the asset</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset Restore">

                                <br>


                                <div class="form-group row">
                                    <label for="restoreStartDateTime" class="col-xs-3 col-form-label">Restore Date & Time:</label>
                                    <div class="col-xs-9">
                                        <input type="datetime-local" class="form-control" id="restoreStartDateTime" name="restore_start_date_time"
                                            value=""
                                            <?= isset($sr_open_time) ? 'required' : '' ?> onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>



                                <!-- <div class="form-group row">
                                    <label for="repairCompletionDateTime" class="col-xs-3 col-form-label">Repair Completion Date & Time:</label>
                                    <div class="col-xs-9">
                                        <input type="datetime-local" class="form-control" id="repairCompletionDateTime" name="repair_completion_date_time"
                                            value="<?= isset($sr_close_time) ? date('Y-m-d\TH:i', strtotime($sr_close_time)) : '' ?>"
                                            <?= isset($sr_close_time) ? 'required' : '' ?>>
                                    </div>
                                </div> -->



                                <div class="form-group row">
                                    <label for="expenseCost" class="col-xs-3 col-form-label">Relative Expense:</label>
                                    <div class="col-xs-9">
                                        <input type="number" class="form-control" id="expense_cost" name="expense_cost" placeholder="Enter your input here" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3 col-form-label">Comment:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Restore">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>



                    <div class="col-sm-12" id="asset_sold" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Details for Asset Sold</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset Sold">

                                <br>

                                <!-- Repair Start Date & Time -->
                                <div class="form-group row">
                                    <label for="repairStartDateTime" class="col-xs-3 col-form-label">Sale Date:</label>
                                    <div class="col-xs-9">
                                        <input type="datetime-local" class="form-control" id="saleStartDateTime" name="sold_start_date_time" value="" onclick="this.showPicker && this.showPicker();">

                                    </div>
                                </div>


                                <!-- Repair Completion Date & Time -->
                                <div class="form-group row">
                                    <label for="repairCompletionDateTime" class="col-xs-3 col-form-label">Sale Price:</label>
                                    <div class="col-xs-9">
                                        <input type="number" class="form-control" id="salePrice" name="sale_price" placeholder="Enter your input here" required>
                                    </div>
                                </div>



                                <!-- Comment -->
                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3 col-form-label">Remarks:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Buyer details, Deprecition, Asset Condition, Loss, Terms etc" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Sold">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>


                    <div class="col-sm-12" id="asset_preventive" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Provide details for the Preventive Maintenance</h3>
                            </div>

                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>

                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Preventive Maintenance">

                                <!-- Preventive Maintenance Date -->
                                <div class="form-group row" style="margin-top: 15px;">
                                    <label for="preventive_maintenance_date" class="col-xs-3">Preventive Maintenance Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="preventive_maintenance_date" name="preventive_maintenance_date"
                                            value="<?php echo date('Y-m-d'); ?>"
                                            <?php echo isfeature_active('EDIT-PREVENTIVE-MAINTENANCE') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div class="form-group row" style="margin-top: 5px;">
                                    <label for="upcoming_preventive_maintenance_date" class="col-xs-3">Upcoming Preventive Maintenance Due:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="upcoming_preventive_maintenance_date" name="upcoming_preventive_maintenance_date"
                                            value="<?php echo date('Y-m-d', strtotime('+6 months')); ?>"
                                            <?php echo isfeature_active('EDIT-PREVENTIVE-MAINTENANCE') ? '' : 'readonly'; ?> required
                                            onchange="initializeReminderDates()" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 1 (Default: 15 days before) -->
                                <div class="form-group row" style="margin-top: -15px;">
                                    <label for="reminder_alert_1" class="col-xs-3">Set Reminder Alert 1:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="reminder_alert_1" name="reminder_alert_1"
                                            <?php echo isfeature_active('EDIT-PREVENTIVE-MAINTENANCE') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 2 (Default: 2 days before) -->
                                <div class="form-group row" style="margin-top: -15px;">
                                    <label for="reminder_alert_2" class="col-xs-3">Set Reminder Alert 2:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="reminder_alert_2" name="reminder_alert_2"
                                            <?php echo isfeature_active('EDIT-PREVENTIVE-MAINTENANCE') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>



                                <!-- Textarea for describing the reason -->
                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3">Additional Notes:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <?php echo form_close() ?>
                        </div>
                    </div>

                    <div class="col-sm-12" id="asset_warranty" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Update warranty details for asset</h3>
                            </div>

                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>

                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset Warranty">

                                <!-- Preventive Maintenance Date -->
                                <div class="form-group row" style="margin-top: 15px;">
                                    <label for="warrenty" class="col-xs-3">Warranty Start Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="warrenty" name="warrenty"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-WARRANTY') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div class="form-group row" style="margin-top: 5px;">
                                    <label for="warrenty_end" class="col-xs-3">Warranty End Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="warrenty_end" name="warrenty_end"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-WARRANTY') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>



                                <!-- Textarea for describing the reason -->
                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3">Additional Notes:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <?php echo form_close() ?>
                        </div>
                    </div>

                    <div class="col-sm-12" id="asset_amc_cmc" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Update AMC/ CMC details for asset</h3>
                            </div>

                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>

                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset AMC/CMC">

                                <div class="form-group row" style="margin-top: 15px;">
                                    <label for="contract" class="col-xs-3">Select AMC/ CMC:</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="contract" name="contract" required>
                                            <option value="">--Select Option--</option>
                                            <option value="AMC">AMC</option>
                                            <option value="CMC">CMC</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Preventive Maintenance Date -->
                                <div class="form-group row" style="margin-top: 15px;">
                                    <label for="contract_start_date" class="col-xs-3">Start Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="contract_start_date" name="contract_start_date"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-AMC/CMC') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div class="form-group row" style="margin-top: 5px;">
                                    <label for="contract_end_date" class="col-xs-3">End Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="contract_end_date" name="contract_end_date"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-AMC/CMC') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>

                                <div class="form-group row" style="margin-top: -15px;">
                                    <label for="contract_service_charges" class="col-xs-3">Cost:</label>
                                    <div class="col-xs-9">
                                        <input class="form-control" rows="5" type="number" id="contract_service_charges" name="contract_service_charges" placeholder="Enter your input here">

                                    </div>
                                </div>



                                <!-- Textarea for describing the reason -->
                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3">Additional Notes:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here"></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <?php echo form_close() ?>
                        </div>
                    </div>

                    <div class="col-sm-12" id="asset_calibration" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Provide details for the Asset Calibration</h3>
                            </div>

                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>

                            <div class="col-sm-12" style="overflow:auto;">
                                <input type="hidden" name="status" value="Asset Calibration">

                                <!-- Preventive Maintenance Date -->
                                <div class="form-group row" style="margin-top: 15px;">
                                    <label for="asset_calibration_date" class="col-xs-3">Last Calibration Date:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="asset_calibration_date" name="asset_calibration_date"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-CALIBRATION') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>

                                <!-- Upcoming Preventive Maintenance Due -->
                                <div class="form-group row" style="margin-top: 5px;">
                                    <label for="upcoming_calibration_date" class="col-xs-3">Upcoming Calibration Due:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="upcoming_calibration_date" name="upcoming_calibration_date"
                                            value=""
                                            <?php echo isfeature_active('EDIT-ASSET-CALIBRATION') ? '' : 'readonly'; ?> required
                                            onchange="initializeReminderDates()" onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 1 (Default: 15 days before) -->
                                <div class="form-group row" style="margin-top: -15px;">
                                    <label for="calibration_reminder_alert_1" class="col-xs-3">Set Reminder Alert 1:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="calibration_reminder_alert_1" name="calibration_reminder_alert_1"
                                            <?php echo isfeature_active('EDIT-ASSET-CALIBRATION') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>
                                <br>

                                <!-- Set Reminder Alert 2 (Default: 2 days before) -->
                                <div class="form-group row" style="margin-top: -15px;">
                                    <label for="calibration_reminder_alert_2" class="col-xs-3">Set Reminder Alert 2:</label>
                                    <div class="col-xs-9">
                                        <input type="date" class="form-control" id="calibration_reminder_alert_2" name="calibration_reminder_alert_2"
                                            <?php echo isfeature_active('EDIT-ASSET-CALIBRATION') ? '' : 'readonly'; ?> required onclick="this.showPicker && this.showPicker();">
                                    </div>
                                </div>



                                <!-- Textarea for describing the reason -->
                                <div class="form-group row">
                                    <label for="comment" class="col-xs-3">Additional Notes:</label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo $department->departmentid; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>

                            <?php echo form_close() ?>
                        </div>
                    </div>




                    <div class="col-sm-12" id="asset_revoke" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Reallocate the Asset</h3>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <br />
                                <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                                <?php echo form_hidden('id', $department->id) ?> <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label">Select Department</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="sel1" name="deparment_name" style="width: 98%;" required aria-required="true">
                                            <option value="">--Select Option--</option>
                                            <?php
                                            // Fetching data
                                            $this->db->order_by('id', 'asc');
                                            $query = $this->db->get('bf_asset_location');
                                            $data = $query->result();

                                            // Iterating through the data to create options
                                            foreach ($data as $row) {
                                                if ($row->title != 'ALL') {  // Check if title is not 'ALL'
                                                    echo '<option value="' . $row->title . '">' . $row->title . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>

                                    <label for="name" class="col-xs-3 col-form-label" style="margin-top: 25px;">Select User</label>
                                    <div class="col-xs-9" style="margin-top: 22px;margin-left:-1px;">

                                        <input type="text" id="userSearchReassign" class="form-control" placeholder="Search for user.." style="width: 98%;">

                                        <div class="checkbox-container" id="userList_reassign" style="margin-top: 15px;">
                                            <?php foreach ($users as $user) : ?>
                                                <?php if ($user->firstname !== 'developer') : ?>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="user_reassign_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" name="users_reassign[]" value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                                                        <label for="user_reassign_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group row" style="margin-top: -10px;">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('pcf', 'pcf_comment'); ?></label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" style="width:97%;" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Assign">
                                    </div>
                                </div>
                                <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button> </div>
                                    </div>
                                </div> <?php echo form_close() ?>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" id="asset_transfer" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Transfer the Asset</h3>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <br />
                                <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                                <?php echo form_hidden('id', $department->id) ?> <div class="form-group row">
                                    <label for="name" class="col-xs-3 col-form-label">Select Department</label>
                                    <div class="col-xs-9">
                                        <select class="form-control" id="sel1" name="deparment_name" style="width: 98%;" required aria-required="true">
                                            <option value="">--Select Option--</option>
                                            <?php
                                            // Fetching data
                                            $this->db->order_by('id', 'asc');
                                            $query = $this->db->get('bf_asset_location');
                                            $data = $query->result();

                                            // Iterating through the data to create options
                                            foreach ($data as $row) {
                                                if ($row->title != 'ALL') {  // Check if title is not 'ALL'
                                                    echo '<option value="' . $row->title . '">' . $row->title . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>


                                    <label for="name" class="col-xs-3 col-form-label" style="margin-top: 25px;">Select User</label>
                                    <div class="col-xs-9" style="margin-top: 22px;margin-left:-1px;">

                                        <input type="text" id="userSearchTransfer" class="form-control" placeholder="Search user..." style="margin-bottom: 10px;width: 98%;">

                                        <div class="checkbox-container" id="userList_transfer" style="margin-top: 20px;">
                                            <?php foreach ($users as $user) : ?>
                                                <?php if ($user->firstname !== 'developer') : ?>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="user_transfer_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" name="users_transfer[]" value="<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>" checked>
                                                        <label for="user_transfer_<?php echo htmlspecialchars($user->user_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                            <?php echo htmlspecialchars($user->firstname . ' , ' . $user->designation . ' ( ' . $user->lastname . ' ) ', ENT_QUOTES, 'UTF-8'); ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="form-group row" style="margin-top: -10px;">
                                    <label for="name" class="col-xs-3 col-form-label"><?php echo lang_loader('pcf', 'pcf_comment'); ?></label>
                                    <div class="col-xs-9">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" style="width:97%;" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Transfer">
                                        <input type="hidden" name="id" value="<?php echo  $department->id; ?>">
                                    </div>
                                </div>
                                <!--Radio-->
                                <div class="form-group row">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <div class="ui buttons"> <button class="ui positive button"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button> </div>
                                    </div>
                                </div> <?php echo form_close() ?>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" id="asset_lost" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Please describe reason for Asset Lost</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">

                                <input type="hidden" name="status" value="Asset Lost">

                                <br>
                                <div class="form-group row">
                                    <div class="col-xs-9" style="width: 90%;">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Lost">
                                    </div>
                                </div>


                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <!-- <button type="reset" class="ui button">
                                        <?php // echo display('reset') 
                                        ?></button>
                                    <div class="or"></div> -->
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" id="asset_dispose" style="overflow:auto;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Please describe reason for Asset Disposal</h3>
                            </div>
                            <?php echo form_open('ticketsasset/create', 'class="form-inner"') ?>
                            <?php echo form_hidden('id', $department->id) ?>
                            <div class="col-sm-12" style="overflow:auto;">

                                <input type="hidden" name="status" value="Asset Dispose">
                                <br>


                                <div class="form-group row">
                                    <div class="col-xs-9" style="width: 90%;">
                                        <textarea class="form-control" rows="5" id="comment" name="reply" placeholder="Enter your input here" required></textarea>
                                        <input type="hidden" name="reply_by" value="Admin">
                                        <input type="hidden" name="reply_departmen" value="<?php echo  $department->department->description; ?>">
                                        <input type="hidden" name="reply_department_id" value="<?php echo  $department->departmentid; ?>">
                                        <input type="hidden" name="status" value="Asset Dispose">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <!-- <button type="reset" class="ui button">
                                        <?php // echo display('reset') 
                                        ?></button>
                                    <div class="or"></div> -->
                                        <button class="ui positive button" id="submitButton"><?php echo lang_loader('pcf', 'pcf_submit'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>


                <?php } ?>

            <?php  } ?>
        <?php } ?>


        <hr>
        <?php if ($this->session->userdata('isLogIn') == true) { ?>
            <?php if ($department->status == 'Asset Assign' || $department->status == 'Asset Broken' || $department->status == 'Asset Malfunction' || $department->status == 'Asset Sold' || $department->status == 'Asset Reassign' || $department->status == 'Asset Lost' || $department->status == 'Asset Dispose' || $department->status == 'Preventive Maintenance' || $department->status == 'Asset in Use' || $department->status == 'Asset Restore' || $department->status == 'Asset Transfer' || $department->status == 'Asset Calibration') { ?>

                <?php include 'asset_history_summary.php'; ?>

            <?php } ?>
        <?php } ?>

        <?php if ($this->session->userdata('isLogIn') == true) { ?>
            <?php if ($department->status == 'Asset Assign' || $department->status == 'Asset Broken' || $department->status == 'Asset Malfunction' || $department->status == 'Asset Sold' || $department->status == 'Asset Reassign' || $department->status == 'Asset Lost' || $department->status == 'Asset Dispose' || $department->status == 'Preventive Maintenance' || $department->status == 'Asset in Use' || $department->status == 'Asset Restore' || $department->status == 'Asset Transfer' || $department->status == 'Asset Calibration') { ?>

                <?php include 'ticket_convo.php'; ?>

            <?php } ?>
        <?php } ?>


    </div>

</div>



<style>
    .checkbox-container {
        border: 1px solid #ccc;
        padding: 10px;
        max-height: 200px;
        /* Adjust height as needed */
        max-width: 500px;
        overflow-y: auto;
        background-color: #f9f9f9;
        border-radius: 5px;
    }

    .checkbox {
        margin-bottom: 5px;
    }
</style>

<script>
    document.getElementById('userSearchTransfer').addEventListener('keyup', function() {
        var filter = this.value.toLowerCase();
        var checkboxes = document.getElementById('userList_transfer').getElementsByClassName('checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            var label = checkboxes[i].getElementsByTagName('label')[0];
            var text = label.textContent || label.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = '';
            } else {
                checkboxes[i].style.display = 'none';
            }
        }
    });
</script>

<script>
    document.getElementById('userSearch').addEventListener('keyup', function() {
        var filter = this.value.toLowerCase();
        var checkboxes = document.getElementById('userList').getElementsByClassName('checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            var label = checkboxes[i].getElementsByTagName('label')[0];
            var text = label.textContent || label.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = '';
            } else {
                checkboxes[i].style.display = 'none';
            }
        }
    });
</script>

<script>
    document.getElementById('userSearchReassign').addEventListener('keyup', function() {
        var filter = this.value.toLowerCase();
        var checkboxes = document.getElementById('userList_reassign').getElementsByClassName('checkbox');

        for (var i = 0; i < checkboxes.length; i++) {
            var label = checkboxes[i].getElementsByTagName('label')[0];
            var text = label.textContent || label.innerText;

            if (text.toLowerCase().indexOf(filter) > -1) {
                checkboxes[i].style.display = '';
            } else {
                checkboxes[i].style.display = 'none';
            }
        }
    });
</script>

<script>
    function initializeReminderDates() {
        // Get the upcoming maintenance due date
        const upcomingDate = document.getElementById('upcoming_preventive_maintenance_date').value;
        if (!upcomingDate) return;

        // Parse it as a date object
        const maintenanceDate = new Date(upcomingDate);

        // Calculate default reminder dates
        const reminderDate1 = new Date(maintenanceDate);
        reminderDate1.setDate(maintenanceDate.getDate() - 15); // Default 15 days before
        document.getElementById('reminder_alert_1').value = reminderDate1.toISOString().split('T')[0];

        const reminderDate2 = new Date(maintenanceDate);
        reminderDate2.setDate(maintenanceDate.getDate() - 2); // Default 2 days before
        document.getElementById('reminder_alert_2').value = reminderDate2.toISOString().split('T')[0];
    }

    // Initialize the reminder dates on page load
    window.onload = initializeReminderDates;
</script>

<?php $ticket_id = $this->uri->segment(3); ?>

<script>
    const ticketId = "<?= $ticket_id ?>";

    document.getElementById('approveBtn').addEventListener('click', function() {
        window.location.href = "<?= base_url('asset/approve_transfer/') ?>" + ticketId;
    });

    document.getElementById('denyBtn').addEventListener('click', function() {
        window.location.href = "<?= base_url('asset/deny_transfer/') ?>" + ticketId;
    });
</script>

<script>
    function calculateAssetValue() {

        const status = document.getElementById("assignStatus").textContent.trim();

        if (status === "Asset Sold") {
            alert("Depreciation calculation is not applicable. This asset is already sold.");
            return;
        }

        const unitPrice = parseFloat(document.getElementById("unitPrice").textContent) || 0;
        const depreciationRate = parseFloat(document.getElementById("depreciationRate").textContent) || 0;
        const installDateStr = document.getElementById("installDate").textContent;
        const assetGroup = document.getElementById("assetGroup").textContent.trim();
        const currentDate = new Date();

        if (!installDateStr || isNaN(unitPrice) || isNaN(depreciationRate) || !assetGroup) {
            document.getElementById("assetCurrentValue").textContent = "Invalid Data";
            return;
        }

        const installDate = new Date(installDateStr);
        const installYear = installDate.getFullYear();
        const currentYear = currentDate.getFullYear();
        const installMonth = installDate.getMonth();
        const currentMonth = currentDate.getMonth();
        const installDay = installDate.getDate();
        const currentDay = currentDate.getDate();

        let yearsDiff = currentYear - installYear;
        if (currentMonth < installMonth || (currentMonth === installMonth && currentDay < installDay)) {
            yearsDiff--;
        }

        const depreciationMethodMap = {
            "Biomedical": "SLM",
            "Civil Maintenance": "WDV",
            "Electrical": "WDV",
            "Furniture & Fixtures": "WDV",
            "Housekeeping": "SLM",
            "IT": "WDV",
            "Maintenance": "SLM",
            "Medical Equipment": "WDV",
            "Patient Care Equipment": "WDV",
            "Plumbing": "SLM",
            "Transport & Mobility": "WDV"
        };

        const method = depreciationMethodMap[assetGroup] || "SLM";
        let assetCurrentValue = unitPrice;

        if (method === "SLM") {
            const depreciation = unitPrice * (depreciationRate / 100) * yearsDiff;
            assetCurrentValue = unitPrice - depreciation;
        } else if (method === "WDV") {
            for (let i = 0; i < yearsDiff; i++) {
                assetCurrentValue *= (1 - depreciationRate / 100);
            }
        }

        assetCurrentValue = Math.max(assetCurrentValue, 1);

        assetCurrentValue = assetCurrentValue.toFixed(2);
        document.getElementById("assetCurrentValue").textContent = assetCurrentValue;
    }
</script>