<div class="content ">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo base_url("UserManagement/role_create"); ?>"> <i class="fa fa-user-plus"></i> Role</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-12 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="font-size: 16px; text-align: center;">Role</th>
                                        <th style="font-size: 16px; text-align: center;">Description</th>
                                        <th style="font-size: 16px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($role_list as $role) { ?>
                                        <?php if ($role->role_name !== 'DEVELOPER') : ?>
                                            <tr>
                                                <td style="display: none;"><?php echo $role->role_id; ?></td>
                                                <td style="font-size: 15px;"><?php echo $role->role_name; ?></td>
                                                <td style="font-size: 15px;"><?php echo $role->description; ?></td>
                                                <td>
                                                    <div style="display: flex; align-items: center; justify-content: center;">
                                                        <a href="<?php echo base_url("UserManagement/role_permission/{$role->role_id}") ?>" class="btn btn-outline-secondary btn-rounded"><i class="fa fa-unlock-alt" style="font-size:19px;" data-toggle="tooltip" title="Edit Permissions"></i></a>
                                                        <div style="margin: 0 10px;"></div> <!-- Adjust the gap between icons here -->
                                                        <a href="<?php echo base_url("UserManagement/role_edit/{$role->role_id}") ?>" class="btn btn-outline-info btn-rounded" data-toggle="tooltip" style="color: #008080;" title="Edit Role" style="padding: 0px;"><i class="fa fa-pencil" style="font-size:19px;"></i></a>
                                                        <div style="margin: 0 10px;"></div> <!-- Adjust the gap between icons here -->
                                                        <a href="<?php echo base_url("UserManagement/role_delete/{$role->role_id}") ?>" class="btn btn-outline-danger btn-rounded" style="color: red;" data-toggle="tooltip" title="Delete Role" onclick="return confirm('Are you sure you want to delete this role?');"><i class="fa fa-trash" style="font-size:19px;"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>