<!-- This page is used to show Discharged Employee -->
<div class="content">
    <div class="row">
        <!--  table area start-->
        <div class="col-lg-12">
            <div class="panel panel-default thumbnail">
            <?php if ($this->session->userdata['access7'] == 'admissionsection') {  ?>
                    <div class="panel-heading ">

                        <div class="btn-group">
                            <a class="btn btn-success" href="<?php echo base_url("employee/create") ?>"> <i class="fa fa-plus"></i> New Patient </a>
                        </div>
                    </div>
                <?php } ?>

                <div class="panel-body">
                    <table width="100%" class="datatableip table table-striped table-bordered table-hover">
                        <!-- table head start -->
                        <thead>
                            <tr>
                                <th><?php echo display('serial') ?></th>


                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <!-- <th>Hospital ID</th> -->
                                <th>Ward</th>
                                <th>Bed No</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Admitted Date</th>
                                <th>Discharged Date</th>
                                <th><?php echo display('action') ?></th>

                            </tr>
                        </thead>
                        <!-- table head end -->

                        <!-- table body start -->
                        <tbody>

                            <?php if (!empty($patients) && $patient->created_by != null) { ?>
                                <?php $sl = 1; ?>
                                <?php foreach ($patients as $patient) { ?>
                                    <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $patient->name; ?></td>

                                        <td><?php echo $patient->patient_id; ?></td>
                                        <!-- <td><?php echo $patient->hospital_id; ?></td> -->
                                        <td><?php echo $patient->ward; ?></td>
                                        <td><?php echo $patient->bed_no; ?></td>
                                        <td><?php echo $patient->gender; ?></td>
                                        <td><?php echo $patient->age; ?></td>
                                        <td><?php echo  date('d-m-Y H:i', strtotime($patient->admited_date)); ?></td>
                                        <td><?php echo  date('d-m-Y H:i', strtotime($patient->discharged_date)); ?></td>

                                        <td class="center">
                                            <!-- <a href="<?php echo base_url("employee/profile/$patient->id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a> -->
                                            <a href="<?php echo base_url("employee/edit/$patient->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>

                                            <!-- <a href="<?php echo base_url("case_manager/employee/form?pid=$patient->patient_id") ?>" class="btn btn-xs btn-warning" title="Add to Case Manager"><i class="fa fa-plus"></i></a> -->

                                            <!-- <a href="<?php echo base_url("employee/delete/$patient->id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>')"><i class="fa fa-trash"></i></a> -->
                                        </td>

                                    </tr>
                                    <?php $sl++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <!-- table body end -->

                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
        <!--  table area end-->
    </div>
</div>
<style>
    .panel-body {
        height: auto;
    }
</style>