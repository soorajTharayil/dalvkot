<?php
$ward = $this->db->order_by('id', 'asc')->get('bf_ward')->result();
$user_id = $this->uri->segment(3);  // Assuming user_id is the third segment in the URL
$role_id = $this->uri->segment(4);  // Assuming user_id is the fourth segment in the URL
$ward = $this->db->order_by('id', 'asc')->get('bf_ward')->result();
$ward_esr = $this->db->order_by('id', 'asc')->get('bf_ward_esr')->result();
$userCheckedItems = $this->db->select('user_id, floor_ward,department')->where('user_id', $user_id)->get('user')->result();
$userCheckedItems_esr = $this->db->select('user_id, floor_ward_esr,department')->where('user_id', $user_id)->get('user')->result();
$welcometext1 = "Welcome to the Roles and Permissions page, your command center for managing user roles and access permissions within Efeedor. This page empowers administrators to create, customize, and define appropriate access to modules, features, and functionalities for the defined roles.";
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


$modules = $this->db->order_by('module_id', 'asc')->get('modules')->result();
$welcometext1 = "Welcome to the Roles and Permissions page, your command center for managing user roles and access permissions within Efeedor. This page empowers administrators to create, customize, and define appropriate access to modules, features, and functionalities for the defined roles.";
$module_components_tooltip = "";
$feature_functionality_tooltip = "";
$manage_access_tooltip = "";
$role_id = $this->uri->segment(3);

$query = $this->db->get_where('roles', array('role_id' => $role_id));
$role_result = $query->result();

$role = $role_result[0]; // Assuming there's only one result

$rolename = $role->role_name;



?>



<div class="content ">
    <div style="margin-bottom: 30px;margin-top: 15px;">


        <div style="margin-bottom: 30px;margin-top: 15px; margin-left:15px;">

            <h4 style="font-size:18px;font-weight:normal;">
                <span style="font-size: 17px; "><?php echo $welcometext1; ?></span>
            </h4>
            <h4 style="font-size:18px;font-weight:normal;">
                <div style="font-size: 17px; padding-bottom:3px; "><b>Role: </b><?php echo $rolename; ?></div>

            </h4>
        </div>

    </div>


    <?php echo form_open(); ?> <!-- Open form here -->

    <div class="panel-group" id="accordion">
        <?php foreach ($groupedPermissions as $module => $moduleRow) { ?>
            <!-- Module Accordion -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo md5($module); ?>" class="d-flex justify-content-between align-items-center">
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
                                if (empty($groupedFeatures[$type])) continue;
                            ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#nestedAccordion<?php echo md5($module); ?>" href="#nestedCollapse<?php echo md5($module . $type); ?>" class="d-flex justify-content-between align-items-center">
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
                                                        <th style="font-size: 16px; text-align: center;">Feature/ Functionality</th>
                                                        <th style="font-size: 16px; text-align: center;">Manage Access</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($groupedFeatures[$type] as $featureRow) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $featureRow['feature_description']; ?>
                                                                <?php if (!empty($featureRow['feature_tooltip'])) { ?>
                                                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="<?php echo $featureRow['feature_tooltip']; ?>"></i>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="material-switch pull-left">
                                                                        <input id="feature<?php echo $featureRow['feature_id']; ?>" name="feature[<?php echo $featureRow['feature_id']; ?>]" type="checkbox" <?php echo $featureRow['status'] ? 'checked' : ''; ?> />
                                                                        <label for="feature<?php echo $featureRow['feature_id']; ?>" class="label-success"></label>
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

            <button type="reset" class="ui button"><?php echo display('reset') ?></button>

            <div class="or"></div>

            <button type="submit" class="ui positive button"><?php echo display('save') ?></button>

        </div>

    </div>

    <?php echo form_close(); ?> <!-- Close form here -->




</div>
</div>

<style>
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
    document.addEventListener("DOMContentLoaded", function() {
        const tabLinks = document.querySelectorAll('.nav-item.nav-link');
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                tabLinks.forEach(function(link) {
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
    document.addEventListener('DOMContentLoaded', function() {
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
    document.addEventListener('DOMContentLoaded', function() {
        var typed = new Typed(".typing-text2", {
            strings: ["<?php echo $welcometext2; ?>"],
            // delay: 10,
            loop: false,
            typeSpeed: 30,
            backSpeed: 5,
            backDelay: 1000,
        });
    });

    $(document).ready(function() {
        $('#accordion .panel-collapse').on('shown.bs.collapse', function() {
            $(this).prev().find('.arrow').html('&#9652;'); // Change to up arrow
        });

        $('#accordion .panel-collapse').on('hidden.bs.collapse', function() {
            $(this).prev().find('.arrow').html('&#9662;'); // Change to down arrow
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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