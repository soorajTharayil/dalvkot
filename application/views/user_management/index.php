<?php





$users = $this->db->select('user.*, roles.role_id')
    ->join('roles', 'user.user_role = roles.role_id')
    ->order_by('roles.role_id', 'asc')
    ->get('user')
    ->result();

?>



<div class="content ">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("UserManagement/create") ?>"> <i class="fa fa-user-plus" style="padding-right: 5px;"></i> Add User</a>
                </div>
                <div class="btn-group" style="float: right;">
                    <a class="btn btn-success" href="<?php echo base_url("UserManagement/roles") ?>"> <i class="fa fa-users" style="padding-right: 5px;"></i> Manage User Roles</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-12 col-lg-12 ">
                        <div class="table-responsive">
                            <table class="userlisttable table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="font-size: 16px; text-align: center;">Sl No</th>
                                        <th style="font-size: 16px; text-align: center;">Name</th>
                                        <th style="font-size: 16px; text-align: center;">Login Username</th>
                                        <th style="font-size: 16px; text-align: center;">Role</th>
                                        <!-- <th style="font-size: 16px; text-align: center;">Department Access</th> -->
                                        <th style="font-size: 16px; text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $count = 1;
                                    function getDescription($type, $setkey, $department_descriptions)
                                    {
                                        return isset($department_descriptions[$type][$setkey]) ? $department_descriptions[$type][$setkey] : '';
                                    }

                                    ?>

                                    <?php foreach ($users as $user) : ?>
                                        <?php if ($user->lastname != 'DEVELOPER') : ?>
                                            <tr>
                                                <td style="vertical-align: middle; font-size: 15px;"><?php echo $count; ?></td>
                                                <td style="vertical-align: middle; font-size: 15px;"><?php echo $user->firstname; ?><br><?php echo $user->designation; ?></td>
                                                <td style="vertical-align: middle; font-size: 15px;"><?php echo $user->email; ?><br><?php echo $user->mobile; ?></td>
                                                <td style="vertical-align: middle; font-size: 15px;">
                                                    <b><?php echo $user->lastname; ?></b><br>
                                                    <?php
                                                    if ($user->lastname == 'ADMIN' || $user->lastname == 'SUPER ADMIN') {

                                                        // Fetch permissions for the user
                                                        $this->db->from('user_permissions as UP');
                                                        $this->db->select('F.feature_name, F.feature_description, F.feature_tooltip, UP.status, S.section_name, M.description as module_description, M.module_id');
                                                        $this->db->join('features as F', 'UP.feature_id = F.feature_id');
                                                        $this->db->join('sections as S', 'F.section_id = S.section_id');
                                                        $this->db->join('modules as M', 'S.module_id = M.module_id');
                                                        $this->db->where('UP.user_id', $user->user_id); // Use current user's ID
                                                        $this->db->where('UP.status', 1); // Only active features
                                                        $this->db->order_by('M.showid');  // Order by module_id

                                                        $query = $this->db->get();
                                                        $permissionList = $query->result();

                                                        // Output the result as an HTML list
                                                        echo '<ul style="padding-left: 20px;">';
                                                        foreach ($permissionList as $permission) {
                                                            switch ($permission->feature_name) {
                                                                case 'IP-FEEDBACKS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">IP DISCHARGE FEEDBACK</strong></li>';
                                                                    break;
                                                                case 'OP-FEEDBACKS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">OP DISCHARGE FEEDBACK</strong></li>';
                                                                    break;
                                                                case 'PC-COMPLAINTS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">PATIENT COMPLAINTS</strong></li>';
                                                                    break;
                                                                case 'POST-FEEDBACKS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">POST DISCHARGE FEEDBACK</strong></li>';
                                                                    break;
                                                                case 'ISR-REQUESTS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">INTERNAL SERVICE REQUEST</strong></li>';
                                                                    break;
                                                                case 'INC-INCIDENTS-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">INCIDENTS MODULE</strong></li>';
                                                                    break;
                                                                case 'SG-STAFF-GRIEVANCES-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">GRIEVANCES MODULE</strong></li>';
                                                                    break;
                                                                case 'ASSET-DASHBOARD':
                                                                    echo '<li><strong style="font-size: 13px;">ASSET MANAGEMENT MODULE</strong></li>';
                                                                    break;
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    } else {
                                                        $departments = json_decode($user->department, true);
                                                        if ($departments) {
                                                            echo '<ul style="padding-left: 20px;">';
                                                            foreach ($departments as $dept => $sets) {
                                                                $deptName = '';
                                                                if (ismodule_active('IP') && $dept == 'inpatient') {
                                                                    $deptName = 'IP DISCHARGE FEEDBACK';
                                                                } elseif (ismodule_active('OP') && $dept == 'outpatient') {
                                                                    $deptName = 'OP DISCHARGE FEEDBACK';
                                                                } elseif (ismodule_active('PCF') && $dept == 'interim') {
                                                                    $deptName = 'PATIENT COMPLAINTS';
                                                                } elseif (ismodule_active('PDF') && $dept == 'pdf') {
                                                                    $deptName = 'POST DISCHARGE FEEDBACK';
                                                                } elseif (ismodule_active('ISR') && $dept == 'esr') {
                                                                    $deptName = 'INTERNAL SERVICE REQUEST';
                                                                } elseif (ismodule_active('INCIDENT') && $dept == 'incident') {
                                                                    $deptName = 'INCIDENTS MODULE';
                                                                } elseif (ismodule_active('GRIEVANCE') && $dept == 'grievance') {
                                                                    $deptName = 'GRIEVANCES MODULE';
                                                                }

                                                                if ($deptName) {
                                                                    echo '<li><strong style="font-size: 13px;">' . $deptName . '</strong><ul>';
                                                                    foreach ($sets as $setKey => $setValues) {
                                                                        $description = getDescription($dept, $setKey, $department_descriptions);
                                                                        if ($description) {
                                                                            echo '<li>' . $description . '</li>';
                                                                        }
                                                                    }

                                                                    echo '</ul></li>';
                                                                }
                                                            }

                                                            $floor_assets = json_decode($user->floor_asset ?? '[]', true);
                                                            if (!empty($floor_assets)) {
                                                                echo '<li><strong style="font-size: 13px;">ASSET MANAGEMENT MODULE</strong><ul>';
                                                                foreach ($floor_assets as $asset) {
                                                                    echo '<li>' . htmlspecialchars($asset, ENT_QUOTES, 'UTF-8') . '</li>';
                                                                }
                                                                echo '</ul></li>';
                                                            }
                                                            echo '</ul>';
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td class="text-end" style="text-align: center;">
                                                    <div class="btn-group">
                                                        <a href="<?php echo base_url("UserManagement/user_permission/{$user->user_id}/{$user->user_role}/user_permission") ?>" class="btn btn-outline-secondary btn-rounded" data-toggle="tooltip" title="Edit Permissions"><i class="fa fa-unlock-alt" style="font-size:19px;"></i></a>
                                                        <a href="<?php echo base_url("UserManagement/edit/{$user->user_id}") ?>" class="btn btn-outline-info btn-rounded" style="color: #008080;" data-toggle="tooltip" title="Edit User"><i class="fa fa-pencil" style="font-size:19px;"></i></a>
                                                        <a class="btn btn-outline-danger btn-rounded" style="color: #FFA500;"
                                                            data-toggle="modal" data-target="#actionModal-<?php echo $user->user_id; ?>"
                                                            title="Send User creation mail">
                                                            <i class="fa fa-commenting-o" style="font-size:19px;"></i>
                                                        </a>

                                                        <a href="<?php echo base_url("UserManagement/delete/{$user->user_id}") ?>" class="btn btn-outline-danger btn-rounded" style="color: red;" data-toggle="tooltip" title="Delete User" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash" style="font-size:19px;"></i></a>
                                                    </div>
                                                    <!-- Modal -->
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="actionModal-<?php echo $user->user_id; ?>" tabindex="-1" role="dialog"
                                                        aria-labelledby="actionModalLabel-<?php echo $user->user_id; ?>" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="actionModalLabel-<?php echo $user->user_id; ?>">Send Notification</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <!-- SMS Button -->
                                                                    <a class="btn btn-rounded"
                                                                        href="<?php echo base_url("UserManagement/sms/{$user->user_id}") ?>"
                                                                        style="background-color: #007bff; color: white;">
                                                                        <i class="fa fa-comment"></i> Send SMS
                                                                    </a>
                                                                    <!-- Email Button -->
                                                                    <a class="btn btn-rounded"
                                                                        href="<?php echo base_url("UserManagement/email/{$user->user_id}") ?>"
                                                                        style="background-color: #FFA500; color: white;">
                                                                        <i class="fa fa-envelope"></i> Send Email
                                                                    </a>
                                                                    <!-- WhatsApp Button -->
                                                                    <a class="btn btn-rounded"
                                                                        href="<?php echo base_url("UserManagement/whatsapp/{$user->user_id}") ?>"
                                                                        style="background-color: #25D366; color: white;">
                                                                        <i class="fa fa-whatsapp"></i> Send WhatsApp Message
                                                                    </a>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $count++; ?>
                                        <?php endif; ?>

                                    <?php endforeach; ?>




                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>