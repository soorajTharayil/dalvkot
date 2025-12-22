<div class="content">
    <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/utils.js"></script>

    <div class="row">

        <div class="col-sm-12" id="PrintMe">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <!-- <button type="button" onclick="printContent('PrintMe')" class="btn btn-success"><i class="fa fa-print"></i></button> -->
                        <a href="<?php echo base_url('dashboard/form/') ?>" class="btn btn-success"><i
                                class="fa fa-edit"></i>&nbsp;Update</a>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12" align="center">
                            <br>
                        </div>

                        <div class="col-md-4 text-center">
                            <img alt="Profile Picture"
                                src="<?php echo (!empty($user->picture) ? base_url($user->picture) : base_url("assets/images/no-img.png")) ?>"
                                class="img-circle img-thumbnail" width="150" height="150">
                            <h3 class="mt-3">
                                <?php echo $this->session->userdata('fullname') ?>
                                <br>
                                <small class="text-muted">
                                    (<?php echo $this->session->userdata('user_role_name'); ?>)
                                </small>
                                <br>
                                <i class="fa fa-universal-access" style="color:#62c52d;"></i>
                            </h3>
                        </div>

                        <!-- Right side: Details in Table Format -->
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped text-center">
                                <tbody>
                                    <?php if (!empty($user->email)) { ?>
                                        <tr>
                                            <th><?php echo 'Email Address'; ?></th>
                                            <td><?php echo $user->email ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->designation)) { ?>
                                        <tr>
                                            <th><?php echo 'Designation'; ?></th>
                                            <td><?php echo $user->designation ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->mobile)) { ?>
                                        <tr>
                                            <th><?php echo 'Mobile Number'; ?></th>
                                            <td><?php echo $user->mobile ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->education_degree)) { ?>
                                        <tr>
                                            <th><?php echo display('education_degree') ?></th>
                                            <td><?php echo $user->education_degree ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->create_date)) { ?>
                                        <tr>
                                            <th><?php echo 'Create Date'; ?></th>
                                            <td><?php echo $user->create_date ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->update_date)) { ?>
                                        <tr>
                                            <th><?php echo display('update_date') ?></th>
                                            <td><?php echo $user->update_date ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if (!empty($user->status)) { ?>
                                        <tr>
                                            <th><?php echo 'Status'; ?></th>
                                            <td>
                                                <span
                                                    class="badge badge-<?php echo ($user->status ? 'success' : 'danger'); ?>">
                                                    <?php echo ($user->status ? 'Active' : 'Inactive'); ?>
                                                </span>

                                            </td>
                                        </tr>
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