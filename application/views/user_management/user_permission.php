<?php
$ward = $this->db->order_by('id', 'asc')->get('bf_ward')->result();
$user_id = $this->uri->segment(3);  // Assuming user_id is the third segment in the URL
$role_id = $this->uri->segment(4);  // Assuming user_id is the fourth segment in the URL
$ward = $this->db->order_by('id', 'asc')->get('bf_ward')->result();
$ward_esr = $this->db->order_by('id', 'asc')->get('bf_ward_esr')->result();
$asset_dep = $this->db->order_by('id', 'asc')->get('bf_asset_location')->result();

$userCheckedItems = $this->db->select('user_id, floor_ward,department')->where('user_id', $user_id)->get('user')->result();
$userCheckedItems_esr = $this->db->select('user_id, floor_ward_esr,department')->where('user_id', $user_id)->get('user')->result();
$userCheckedItems_asset = $this->db->select('user_id, floor_asset,department')->where('user_id', $user_id)->get('user')->result();

$welcometext1 = "Welcome to the User Permissions page, your centralized interface for managing access rights within Efeedor. This page empowers administrators to finely control who can access what features and functionalities within the system, ensuring data security and user privacy.";
$welcometext2 = "This page facilitates user tagging to specific departments, enabling department-level permissions, data access, and the configuration of department-level alerts.";
$welcometext3 = "This section enables us to provide floor-level controls to specific users, allowing them access to data and receive alerts specific to the tagged floors.";
$module_components_tooltip = "";
$feature_functionality_tooltip = "";
$manage_access_tooltip = "";

$query = $this->db->get_where('user', array('user_id' => $user_id));
$user_result = $query->result();

$user = $user_result[0]; // Assuming there's only one result

$firstname = $user->firstname;
$lastname = $user->lastname;
$email = $user->email;
$designation = $user->designation;
$mobile = $user->mobile;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Button to route to the user list page -->
            <a href="<?php echo base_url('UserManagement/index'); ?>" class="btn btn-primary"
                style="background: green; border: none; margin-bottom: 20px;">
                <i class="fa fa-users" style="padding-right: 5px;"></i>User List
            </a>
        </div>
    </div>
</div>

<section id="tabs" class="project-tab ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link  <?php if ($this->uri->segment(5) == 'user_permission') {
                            echo 'active';
                        } ?>" id="nav-home-tab"
                            href="<?php echo base_url('UserManagement/user_permission/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/user_permission'); ?>"
                            role="tab" aria-controls="nav-home" aria-selected="true" style="margin-right:20px ;"><i
                                class="fa fa-unlock-alt" style="font-size:18px; padding-right: 15px;"></i>User
                            Permissions</a>
                        <?php if ($this->uri->segment(4) >= 4) { ?>
                            <a class="nav-item nav-link <?php if ($this->uri->segment(5) == 'department') {
                                echo 'active';
                            } ?>" id="nav-contact-tab"
                                href="<?php echo base_url('UserManagement/user_permission/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/department'); ?>"
                                role="tab" style=" margin-right:20px;" aria-controls="nav-contact" aria-selected="false"><i
                                    class="fa fa-user-plus" style="font-size:18px; padding-right: 15px;"></i>Tag
                                Department</a>
                        <?php } ?>
                        <a class="nav-item nav-link <?php if ($this->uri->segment(5) == 'floor') {
                            echo 'active';
                        } ?>" id="nav-profile-tab"
                            href="<?php echo base_url('UserManagement/user_permission/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/floor'); ?>"
                            role="tab" style="margin-right:20px;" aria-controls="nav-profile" aria-selected="false"><i
                                class="fa fa-hospital-o" style="font-size:18px; padding-right: 15px;"></i>Tag this User
                            to Inpatient Floor/Wards</a>
                        <?php if (ismodule_active('ISR') === true) { ?>
                            <a class="nav-item nav-link <?php if ($this->uri->segment(5) == 'floor_esr') {
                                echo 'active';
                            } ?>" id="nav-profile-tab"
                                href="<?php echo base_url('UserManagement/user_permission/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/floor_esr'); ?>"
                                role="tab" style="" aria-controls="nav-profile" aria-selected="false"><i
                                    class="fa fa-hospital-o" style="font-size:18px; padding-right: 15px;"></i>Tag this user
                                to Hospital Zones</a>
                        <?php } ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>
<br>
<?php if ($this->uri->segment(5) == 'floor') { ?>

    <div class="content ">
        <div style="margin-bottom: 30px;margin-top: 15px;">

            <h4 style="font-size:18px;font-weight:normal;">
                <span style="font-size: 17px; "><?php echo $welcometext3; ?></span>
            </h4>

            <table style="width: 100%; font-size: 17px; border-collapse: separate; border-spacing: 5px;">
                <!-- Use border-collapse: separate for spacing -->
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Name:</b></td>
                    <!-- Change to #7a7e85 for gray border -->
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $firstname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Email:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Role:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $lastname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Designation:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $designation; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Mobile No:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $mobile; ?></td>
                </tr>
            </table>


        </div>
        <div class="panel-body panel panel-default">
            <div class="row">
                <div class="col-md-9 col-sm-12 col-lg-12">
                    <?php echo form_open(); ?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="font-size: 17px;">Inpatient floor wise controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ward as $row) {
                                if ($row->title != 'ALL') { ?>

                                    <tr>

                                        <td>
                                            <div class="checkboxreport">
                                                <label style="font-weight: normal;">
                                                    <?php foreach ($userCheckedItems as $userItem) {
                                                        $userId = $userItem->user_id;
                                                        $floorWard = json_decode($userItem->floor_ward, true);
                                                        ?>
                                                        <input type="checkbox" name="floor_ward[]" value="<?php echo $row->title; ?>"
                                                            <?php echo in_array($row->title, $floorWard) ? 'checked' : ''; ?>>
                                                        &nbsp;
                                                        <?php echo $row->title; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="ui buttons">
                            <button type="reset" class="ui button">
                                <?php echo 'Reset'; ?>
                            </button>
                            <div class="or"></div>
                            <button type="submit" name="floor" class="ui positive button">
                                <?php echo 'Save'; ?>

                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($this->uri->segment(5) == 'floor_esr') { ?>

    <div class="content ">
        <div style="margin-bottom: 30px;margin-top: 15px;">

            <h4 style="font-size:18px;font-weight:normal;">
                <span style="font-size: 17px; "><?php echo $welcometext3; ?></span>
            </h4>

            <table style="width: 100%; font-size: 17px; border-collapse: separate; border-spacing: 5px;">
                <!-- Use border-collapse: separate for spacing -->
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Name:</b></td>
                    <!-- Change to #7a7e85 for gray border -->
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $firstname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Email:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Role:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $lastname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Designation:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $designation; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Mobile No:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $mobile; ?></td>
                </tr>
            </table>


        </div>
        <div class="panel-body panel panel-default">
            <div class="row">
                <div class="col-md-9 col-sm-12 col-lg-12">
                    <?php echo form_open(); ?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th style="font-size: 17px;">Isr floor wise controls</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ward_esr as $row) {
                                if ($row->title != 'ALL') { ?>

                                    <tr>

                                        <td>
                                            <div class="checkboxreport">
                                                <label style="font-weight: normal;">
                                                    <?php foreach ($userCheckedItems_esr as $userItem) {
                                                        $userId = $userItem->user_id;
                                                        $floorWard_esr = json_decode($userItem->floor_ward_esr, true);
                                                        ?>
                                                        <input type="checkbox" name="floor_ward_esr[]"
                                                            value="<?php echo $row->title; ?>" <?php echo in_array($row->title, $floorWard_esr) ? 'checked' : ''; ?>>
                                                        &nbsp;
                                                        <?php echo $row->title; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="ui buttons">
                            <button type="reset" class="ui button">
                                <?php echo 'Reset'; ?>
                            </button>
                            <div class="or"></div>
                            <button type="submit" name="floor" class="ui positive button">
                                <?php echo 'Save'; ?>

                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($this->uri->segment(5) == 'user_permission') { ?>
    <div class="content ">
        <div style="margin-bottom: 30px;margin-top: 15px;">
            <h4 style="font-size:18px;font-weight:normal;">
                <span style="font-size: 17px;"><?php echo $welcometext1; ?></span>
            </h4>

            <table style="width: 100%; font-size: 17px; border-collapse: separate; border-spacing: 5px;">
                <!-- Use border-collapse: separate for spacing -->
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Name:</b></td>
                    <!-- Change to #7a7e85 for gray border -->
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $firstname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Email:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Role:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $lastname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Designation:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $designation; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Mobile No:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $mobile; ?></td>
                </tr>
            </table>

        </div>


        <?php echo form_open(); ?> <!-- Open form here -->

        <div class="panel-group" id="accordion">
            <?php foreach ($groupedPermissions as $module => $moduleRow) { ?>
                <!-- Module Accordion -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo md5($module); ?>"
                                class="d-flex justify-content-between align-items-center">
                                <?php echo $module; ?>
                                <span>
                                    <i class="fa fa-chevron-down rotate-icon"></i> <!-- Arrow icon -->
                                </span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo md5($module); ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <!-- Nested Accordion for Section Types -->
                            <div class="panel-group" id="nestedAccordion<?php echo md5($module); ?>">
                                <?php
                                // Initialize an array to group features by section_type for this module
                                $sectionTypes = [
                                    'FEATURE' => 'Feature Access Controls',
                                    'MESSAGE' => 'SMS Alerts',
                                    'EMAIL' => 'Email Alerts',
                                    'WHATSAPP' => 'Whatsapp Alerts'
                                ];
                                $groupedFeatures = ['FEATURE' => [], 'MESSAGE' => [], 'EMAIL' => []];

                                foreach ($moduleRow as $sectionId => $sectionRow) {
                                    foreach ($sectionRow as $featureRow) {
                                        $groupedFeatures[$featureRow['section_type']][] = $featureRow;
                                    }
                                }

                                // Loop through each section type and create a nested accordion
                                foreach ($sectionTypes as $type => $label) {
                                    if (empty($groupedFeatures[$type]))
                                        continue;
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#nestedAccordion<?php echo md5($module); ?>"
                                                    href="#nestedCollapse<?php echo md5($module . $type); ?>"
                                                    class="d-flex justify-content-between align-items-center">
                                                    <?php echo $label; ?>
                                                    <span>
                                                        <i class="fa fa-chevron-down rotate-icon"></i> <!-- Arrow icon -->
                                                    </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="nestedCollapse<?php echo md5($module . $type); ?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 16px; text-align: center;">Feature/ Functionality
                                                            </th>
                                                            <th style="font-size: 16px; text-align: center;">Manage Access</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($groupedFeatures[$type] as $featureRow) { ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $featureRow['feature_description']; ?>
                                                                    <?php if (!empty($featureRow['feature_tooltip'])) { ?>
                                                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                                                            data-placement="right"
                                                                            title="<?php echo $featureRow['feature_tooltip']; ?>"></i>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <div class="material-switch pull-left">
                                                                            <input id="feature<?php echo $featureRow['feature_id']; ?>"
                                                                                name="feature[<?php echo $featureRow['feature_id']; ?>]"
                                                                                type="checkbox" <?php echo $featureRow['status'] ? 'checked' : ''; ?> />
                                                                            <label for="feature<?php echo $featureRow['feature_id']; ?>"
                                                                                class="label-success"></label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>




        <!-- Save and Reset buttons outside the loop -->
        <div class="col-sm-offset-3 col-sm-6">
            <div class="ui buttons">
                <button type="reset" class="ui button">
                    <?php echo 'Reset'; ?>
                </button>
                <div class="or"></div>
                <button type="submit" name="floor" class="ui positive button">
                    <?php echo 'Save'; ?>

                </button>
            </div>
        </div>

        <?php echo form_close(); ?> <!-- Close form here -->




    </div>
    </div>
<?php } ?>
<?php if ($this->uri->segment(5) == 'department') { ?>
    <?php $department = json_decode($userCheckedItems[0]->department, true);


    ?>
    <div class="content ">
        <div style="margin-bottom: 30px;margin-top: 15px;">

            <h4 style="font-size:18px;font-weight:normal;">
                <span style="font-size: 17px; "><?php echo $welcometext2; ?></span>
            </h4>

            <table style="width: 100%; font-size: 17px; border-collapse: separate; border-spacing: 5px;">
                <!-- Use border-collapse: separate for spacing -->
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Name:</b></td>
                    <!-- Change to #7a7e85 for gray border -->
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $firstname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Email:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Role:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $lastname; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Designation:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $designation; ?></td>
                </tr>
                <tr>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><b>Mobile No:</b></td>
                    <td style="padding: 5px 10px; border: 1px solid #7a7e85;"><?php echo $mobile; ?></td>
                </tr>
            </table>

        </div>
        <?php
        // Fetch user data
        $query = $this->db->select('firstname, department')->from('user')->get();
        $userData = $query->result();

        // Group users by department and set
        $groupedUsers = [];
        foreach ($userData as $user) {
            //  print_r($user);
    
            $departmentData = json_decode($user->department, true);
            // print_r($departmentData); // Decode department column
            foreach ($departmentData as $type => $sets) {
                // print_r($type);
                // print_r($sets);
    
                foreach ($sets as $setkey => $setValues) {
                    $groupedUsers[$type][$setkey][] = $user->firstname; // Group users
                }
            }
        }
        ?>
        <div class="panel-body panel panel-default">
            <div class="row">
                <div class="col-md-9 col-sm-12 col-lg-12">
                    <?php echo form_open(); ?>
                    <?php $grouped = [];
                    $slugLists = [];
                    foreach ($departmentList as $object) {
                        // print_r($departmentList);
                        // exit;
                        $type = $object->type;
                        $setkey = $object->setkey;

                        // Initialize the array for this type if it doesn't exist
                        if (!isset($grouped[$type])) {
                            $grouped[$type] = [];
                        }

                        // Initialize the array for this setkey within the type if it doesn't exist
                        if (!isset($grouped[$type][$setkey])) {
                            $grouped[$type][$setkey] = [];
                            $slugLists[$type][$setkey] = []; // Initialize the slug list for this setkey
                        }

                        // Append the object to the correct type and setkey group
                        $grouped[$type][$setkey][] = $object;

                        // Append slug to the slug list for this setkey
                        $slugLists[$type][$setkey][] = $object->slug;

                        // Update the first object's slug property with the comma-separated list of slugs for this setkey
                        // This assumes there's at least one object in each setkey group
                        $grouped[$type][$setkey][0]->slugs = implode(',', $slugLists[$type][$setkey]);
                    }

                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 16px; text-align: center;">Module</th>
                                <th style="font-size: 16px; text-align: center;">Department / Category</th>
                                <th style="font-size: 16px; text-align: center;">Users Tagged</th>
                                <th style="font-size: 16px; text-align: center;">Enable</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($grouped as $key => $type) {
                            ?>
                            <tr>
                                <td rowspan="<?php echo count($type); ?>">

                                    <?php
                                    // Replace echo $key with the desired statements, wrapped in <strong> for bold text
                                    switch ($key) {
                                        case 'inpatient':
                                            echo "<strong>INPATIENT DISCHARGE FEEDBACK</strong>";
                                            break;
                                        case 'outpatient':
                                            echo "<strong>OUTPATIENT FEEDBACK MODULE</strong>";
                                            break;
                                        case 'interim':
                                            echo "<strong>PATIENT COMPLAINT & REQUEST</strong>";
                                            break;
                                        case 'esr':
                                            echo "<strong>INTERNAL SERVICE REQUEST</strong>";
                                            break;
                                        case 'incident':
                                            echo "<strong>HEALTHCARE INCIDENT MANAGEMENT</strong>";
                                            break;
                                        case 'grievance':
                                            echo "<strong>STAFF GRIEVANCE MANAGEMENT</strong>";
                                            break;
                                        case 'pdf':
                                            echo "<strong>POST DISCHARGE FEEDBACK</strong>";
                                            break;
                                        case 'social':
                                            echo "<strong>SOCIAL MEDIA TICKETS</strong>";
                                            break;
                                        case 'adf':
                                            echo "<strong>ADMISSION FEEDBACK MODULE</strong>";
                                            break;
                                        case 'doctor':
                                            echo "<strong>OT DOCTOR FEEDBACK MODULE</strong>";
                                            break;
                                        case 'doctoropd':
                                            echo "<strong>OPD DOCTOR FEEDBACK MODULE</strong>";
                                            break;
                                        default:
                                            echo "<strong>$key</strong>"; // Default to $key if not matched
                                            break;
                                    }
                                    ?>

                                </td>
                                <?php
                                foreach ($type as $k => $setKey) {
                                    ?>
                                    <td>
                                        <?php echo $setKey[0]->description; ?>
                                    </td>
                                    <td>
                                        <!-- Display the names of users -->
                                        <?php
                                        if (isset($groupedUsers[$key][$k])) {
                                            echo implode(', ', $groupedUsers[$key][$k]); // Display users
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="material-switch pull-left">
                                            <input id="department<?php echo $key . $k; ?>"
                                                name="department[<?php echo $key; ?>][<?php echo $k; ?>]"
                                                value="<?php echo $setKey[0]->slugs; ?>" type="checkbox" <?php echo $department[$key][$k] ? 'checked' : ''; ?> />
                                            <label for="department<?php echo $key . $k; ?>" class="label-success"></label>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>


                        <!-- Add the row for Asset Management -->
                        <tr>
                            <td>ASSET MANAGEMENT</td>
                            <td>
                                <?php
                                // Fetch asset department from bf_asset_location table
                                $assetDepartments = $this->db->get('bf_asset_location')->result(); // Adjust query as needed
                                foreach ($assetDepartments as $asset) {
                                    if ($asset->title !== 'ALL') {
                                        echo '<div class="asset-department-title">' . $asset->title . '</div>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <style>
                                    .checkbox-container {
                                        margin-top: 8px;
                                        margin-bottom: 5px;

                                    }

                                    .checkbox-container:not(:nth-last-child(1)):not(:nth-last-child(2)) {
                                        border-bottom: 1px solid #ddd;
                                    }
                                </style>
                                <?php

                                foreach ($assetDepartments as $asset) {
                                    if ($asset->title !== 'ALL') {
                                        // Generate a unique checkbox for each department
                                        $checkboxId = 'assetDepartmentCheckbox' . $asset->id;
                                        ?>
                                        <?php foreach ($userCheckedItems_asset as $userItem) {
                                            $userId = $userItem->user_id;
                                            $floorWard_asset = json_decode($userItem->floor_asset, true);
                                            ?>
                                            <div class="checkbox-container">
                                                <div class="material-switch pull-left">
                                                    <input id="<?php echo $checkboxId; ?>" name="assetDepartment[]"
                                                        value="<?php echo $asset->title; ?>" type="checkbox" <?php echo in_array($asset->title, $floorWard_asset) ? 'checked' : ''; ?> />
                                                    <label for="<?php echo $checkboxId; ?>" class="label-success"></label>
                                                </div>
                                            </div>
                                            <br>
                                        <?php }
                                    }
                                } ?>
                            </td>
                        </tr>


                    </table>

                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="ui buttons">
                            <button type="reset" class="ui button">
                                <?php echo 'Reset'; ?>
                            </button>
                            <div class="or"></div>
                            <button type="submit" name="floor" class="ui positive button">
                                <?php echo 'Save'; ?>

                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<style>
    .asset-department-title {
        margin-top: 3px;
        padding: 4px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 5px;
        width: 100%;
    }

    .asset-department-title:last-child {
        border-bottom: none;
    }

    .accordion {

        background-color: #eee;

        color: #444;

        cursor: pointer;

        padding: 18px;

        width: 100%;

        border: none;

        text-align: left;

        outline: none;

        font-size: 15px;

        transition: 0.4s;

        font-weight: bold;

        border-bottom: 1px solid #7a7e85;

    }



    .active,

    .accordion:hover {

        background-color: #7a7e85;

    }



    .accordion:after {

        content: '\002B';

        color: #777;

        font-weight: bold;

        float: right;

        margin-left: 5px;

    }



    .active:after {

        content: "\2212";

    }



    .paneld {

        padding: 10px 18px;

        border: 1px solid #7a7e85;

        border-radius: 0px !important;

        min-height: 166px;

        overflow: hidden;

        display: none;

        transition: height 0.2s ease-out;



    }

    .material-switch>input[type="checkbox"] {
        display: none;
    }

    .material-switch>label {
        cursor: pointer;
        height: 0px;
        position: relative;
        width: 40px;
    }

    .material-switch>label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position: absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }

    .material-switch>label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }

    .material-switch>input[type="checkbox"]:checked+label::before {
        background: inherit;
        opacity: 0.5;
    }

    .material-switch>input[type="checkbox"]:checked+label::after {
        background: inherit;
        left: 20px;
    }


    .project-tab #tabs {
        background: #007b5e;
        color: #eee;
    }

    .project-tab #tabs h6.section-title {
        color: #eee;
    }

    .project-tab #tabs .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: #0062cc;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        border-bottom: 3px solid !important;
        font-size: 16px;
        font-weight: bold;
    }

    .project-tab .nav-link {

        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        color: #0062cc;
        font-size: 16px;
        font-weight: 400;
        padding: 3px;
        border: 1px solid;
        padding: 5px 15px;
    }

    .project-tab .nav-link:hover {
        border: none;
    }

    .project-tab thead {
        background: #f3f3f3;
        color: #333;
    }

    .project-tab a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabLinks = document.querySelectorAll('.nav-item.nav-link');
        tabLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                tabLinks.forEach(function (link) {
                    link.classList.remove('active');
                    link.style.color = 'grey'; // Reset all tab link colors to grey
                });
                this.classList.add('active');
                this.style.color = 'green'; // Change color of active tab link to green
            });
        });
    });
</script>
<style>
    .nav-item.nav-link {
        color: #474745;
        /* Set default color to grey */
    }

    .nav-item.nav-link.active {
        color: green;
    }
</style>
<style>
    .active:after {
        content: none;
        /* Remove the dash */
    }

    /* Rotate the icon when the accordion is expanded */
    .rotate-icon {
        transition: transform 0.3s ease;
    }

    .panel-collapse.collapsing .rotate-icon {
        transform: rotate(0deg);
    }

    .panel-collapse.show .rotate-icon {
        transform: rotate(180deg);
        /* Arrow pointing up when expanded */
    }

    .panel-title a {
        width: 100%;
        display: flex;
        justify-content: space-between;
        /* Ensure content is spaced evenly */
        align-items: center;
        /* Center items vertically */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var typed = new Typed(".typing-text1", {
            strings: ["<?php echo $welcometext1; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var typed = new Typed(".typing-text2", {
            strings: ["<?php echo $welcometext2; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });

    $(document).ready(function () {
        $('#accordion .panel-collapse').on('shown.bs.collapse', function () {
            $(this).prev().find('.arrow').html('&#9652;'); // Change to up arrow
        });

        $('#accordion .panel-collapse').on('hidden.bs.collapse', function () {
            $(this).prev().find('.arrow').html('&#9662;'); // Change to down arrow
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var typed = new Typed(".typing-text3", {
            strings: ["<?php echo $welcometext3; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });
</script>