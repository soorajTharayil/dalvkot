<!-- This page is used to show list of inPatient  -->
<div class="content">
    <div class="row">
        <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
        <script src="<?php echo base_url(); ?>assets/utils.js"></script>
        <!--  table area start-->
        <div class="col-lg-12">
            <div class="panel panel-default ">
                <!-- add patient button start -->
                <?php if ($this->session->userdata['access7'] == 'admissionsection') {  ?>
                    <div class="panel-heading ">

                        <div class="btn-group">
                            <a class="btn btn-success" href="<?php echo base_url("employee/create") ?>"> <i class="fa fa-plus"></i> Add Employee </a>
                            <a class="btn btn-success" href="https://excel.import.efeedor.com?ins=experiment&type=healthcare_employees"> <i class="fa fa-plus"></i> Import Employee </a>
                        </div>
                    </div>
                <?php } ?>

                <!-- add patient button end -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-lg-12">

                            <table class="datatabledp table table-striped table-bordered" cellspacing="0" width="100%">

                                <!-- <table width="100%" class="datatableip table table-striped table-bordered table-hover"> -->
                                <!-- table head start -->
                                <thead>
                                    <tr>
                                        <th><?php echo display('serial') ?></th>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th>Date</th>
                                        <th>Login Pin</th>
                                        <?php
                                        if ($this->session->userdata['access7'] != 'coordinator') { ?>
                                            <th class="center">
                                                Edit
                                            </th>
                                        <?php } ?>
                                        <th class="center">
                                            Delete
                                        </th>


                                    </tr>
                                </thead>
                                <!-- table head end -->

                                <!-- table body start -->
                                <tbody>
                                    <?php if (!empty($patients)) { ?>

                                        <?php $sl = 1; ?>
                                        <?php foreach ($patients as $patient) { ?>
                                            <?php // if ($patient->updated_by == NULL  && $patient->created_by != NULL) { 
                                            ?>
                                            <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                                <td><?php echo $sl; ?></td>
                                                <td><?php echo $patient->name; ?></td>

                                                <td><?php echo $patient->patient_id; ?></td>
                                                <td><?php echo $patient->mobile; ?></td>

                                                <td><?php echo $patient->role; ?></td>

                                                <td><?php echo date('g:i A', strtotime($patient->created_on)); ?>
                                                    <br>
                                                    <?php echo date('d-m-y', strtotime($patient->created_on)); ?>
                                                </td>
                                                <?php if ($patient->pin != NULL) { ?>
                                                    <td><?php echo $patient->pin; ?></td>
                                                <?php } else { ?>
                                                    <td><?php echo 'Updating PIN..'; ?></td>
                                                <?php }  ?>


                                                <?php
                                                if ($this->session->userdata['access7'] != 'coordinator') { ?>
                                                    <td class="center">
                                                        <?php $confirm = $patient->name; ?>
                                                        <a href="<?php echo base_url("employee/edit/$patient->id") ?>" class="btn btn-sm btn-primary"><span style="font-size: smaller; text-align:center;">Edit <i class="fa fa-pencil"></i></span></a>
                                                    </td>
                                                <?php }  ?>
                                                <td class="center">
                                                    <a href="<?php echo base_url("employee/delete/$patient->id") ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?php echo 'Delete ' . $confirm . '? ' ?>')"><span style="font-size: smaller; text-align:center;">Delete <i class="fa fa-trash"></i></span></a>
                                                </td>
                                            </tr>
                                            <?php $sl++; ?>
                                        <?php } ?>
                                        <?php // } 
                                        ?>
                                    <?php } ?>
                                </tbody>
                                <!-- table body end -->

                            </table> <!-- /.table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table area end -->
    </div>
</div>
<style>
    .panel-body {
        height: auto;
    }
</style>
<?php 
/*
                                                <!-- <td><?php echo $patient->gender; ?></td>
                                        <td><?php echo $patient->age; ?></td> -->
                                                                                 <!--<td><?php echo $patient->hospital_id; ?></td>-->