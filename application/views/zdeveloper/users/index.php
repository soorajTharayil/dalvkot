<?php if ($this->session->userdata('user_role') <  3) { ?>
    <div class="content">
        <div class="row">
            <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
            <script src="<?php echo base_url(); ?>assets/utils.js"></script>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("users/create") ?>"> <i class="fa fa-plus"></i> Add User</a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-lg-12">
                            <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                                <!-- table head start  -->
                                <thead>
                                    <tr>
                                        <th><?php echo display('serial') ?></th>
                                        <th>User Name</th>
                                        <th>Contact Details</th>
                                        <th>User Role & Access</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <!-- table head end  -->
                                <!-- table body start  -->
                                <tbody>
                                    <?php if (!empty($departments)) { ?>
                                        <?php $sl = 1; ?>
                                        <?php foreach ($departments as $department) { ?>
                                            <?php $permission = json_decode($department->departmentpermission, true);    
                                            // print_r($permission);
                                            // exit; 
                                            ?>
                                          
                                            <?php if ($department->user_id >= 2) { ?>
                                                <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td style="overflow:auto"><?php echo $department->firstname; ?></td>
                                                    <td><?php echo $department->email; ?><br><?php echo $department->mobile; ?></td>
                                                    <td><b> <?php echo $permission['userrole']; ?></b> <br>
                                                        <?php
                                                        if ($department->user_role == 3) {
                                                            if (ismodule_active('ADF') === true && $permission['adfpermission']) {
                                                                echo 'ADMISSION MODULES';
                                                                echo '<br>';
                                                            }
                                                            if (ismodule_active('IP') === true && $permission['ippermission']) {
                                                                echo 'IP MODULES';
                                                                echo '<br>';
                                                            }
                                                            if (ismodule_active('PCF') === true && $permission['inpermission']) {
                                                                echo 'PC MODULES';
                                                                echo '<br>';
                                                            }
                                                            if (ismodule_active('OP') === true && $permission['oppermission']) {
                                                                echo 'OP MODULES';
                                                                echo '<br>';
                                                            }

                                                            if (ismodule_active('ISR') === true && $permission['esrpermission']) {
                                                                echo 'ISR MODULES';
                                                                echo '<br>';
                                                            }
                                                            if (ismodule_active('INCIDENT') === true && $permission['incidentpermission']) {
                                                                echo 'INCIDENT MODULES';
                                                                echo '<br>';
                                                            }
                                                        } 
                                                        elseif ($department->user_role == 4) {
                                                            if (ismodule_active('ADF') === true) {
                                                                foreach ($permission['depadf'] as $adff => $inci1) {
                                                                    $this->db->where('dprt_id', $adff);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('adf');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->description;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }
                                                            if (ismodule_active('IP') === true) {
                                                                foreach ($permission['depip'] as $inpatient => $ip) {
                                                                    $this->db->where('dprt_id', $inpatient);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('ip');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->name;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }
                                                            if (ismodule_active('OP') === true) {

                                                                foreach ($permission['depop'] as $outpatient => $op) {
                                                                    $this->db->where('dprt_id', $outpatient);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('op');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->name;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }
                                                            if (ismodule_active('PCF') === true) {

                                                                foreach ($permission['depin'] as $interim => $int) {
                                                                    $this->db->where('dprt_id', $interim);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('pc');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->description;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }
                                                            if (ismodule_active('ISR') === true) {

                                                                foreach ($permission['depesr'] as $esr => $esr) {
                                                                    $this->db->where('dprt_id', $esr);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('isr');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->description;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }
                                                            if (ismodule_active('INCIDENT') === true) {

                                                                foreach ($permission['depinci'] as $incident => $inci) {
                                                                    $this->db->where('dprt_id', $incident);
                                                                    $query = $this->db->get('department');
                                                                    $result = $query->result();
                                                                    foreach ($result as $row) {
                                                                        // echo strtoupper($row->type);
                                                                        echo strtoupper('incident');
                                                                        echo ' MODULES';
                                                                        echo ' - ';
                                                                        echo $row->description;
                                                                        echo '<br>';
                                                                    }
                                                                }
                                                            }

                                                            // echo $ip;

                                                        } elseif ($department->user_role == 5) {
                                                            if ($permission['coordinator']) {
                                                                echo 'PATIENT DISCHARGE';
                                                                echo '<br>';
                                                            }
                                                            if ($permission['frontoffice']) {
                                                                echo 'PATIENT ADMISSION';
                                                                echo '<br>';
                                                            }
                                                            if ($permission['admissionsection']) {
                                                                echo 'ADMISSION SECTION';
                                                                echo '<br>';
                                                            }
                                                            // print_r($permission);
                                                        } elseif ($department->user_role == 2) {
                                                            echo 'ALL ACCESS';
                                                        }
                                                       
                                                        ?>
                                                    </td>



                                                    <td class="center">
                                                        <a href="<?php echo base_url("users/edit/$department->user_id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a>

                                                        <?php if ($department->user_role > 2) { ?>
                                                            <a href="<?php echo  base_url("users/delete/$department->user_id") ?>" onclick="return confirm('<?php echo display('are_you_sure') ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
                                                        <?php } ?>
                                                    </td>




                                                </tr>
                                                <?php $sl++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                                <!-- table body end  -->

                            </table> <!-- /.table-responsive -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--  table area end-->
<?php } ?>

<style>
    .panel-body {
        height: auto;
    }
</style>