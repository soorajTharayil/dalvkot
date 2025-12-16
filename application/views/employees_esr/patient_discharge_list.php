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
                            <a class="btn btn-success" href="<?php echo base_url("employee/create") ?>"> <i class="fa fa-plus"></i> New Patient </a>
                        </div>
                    </div>
                <?php } ?>

                <!-- add patient button end -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9 col-sm-12 col-lg-12">

                            <table class="datatabledp table table-striped table-bordered" cellspacing="0" width="100%">


                                <thead>
                                    <tr>
                                        <th><?php echo display('serial') ?></th>


                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
                                        <th>Ward</th>
                                        <th>Bed No</th>

                                        <th>Admitted Date</th>
                                        <th>Discharged Date</th>

                                        <!-- <th  style="display: none;"><?php // echo display('action') 
                                                                            ?></th> -->

                                    </tr>
                                </thead>
                                <!-- table head end -->

                                <!-- table body start -->
                                <tbody>
                                    <?php if (!empty($patients)) { ?>
                                        <?php $sl = 1; ?>
                                        <?php foreach ($patients as $patient) { ?>
                                            <?php if ($patient->created_by != NULL && $patient->updated_by != NULL) { ?>
                                                <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $patient->name; ?></td>
                                                    <td><?php echo $patient->patient_id; ?></td>
                                                    <td><?php echo $patient->role; ?></td>
                                                    <td><?php echo $patient->bed_no; ?></td>
                                                    <td><?php echo date('g:i A', strtotime($patient->admited_date)); ?>
                                                        <br>
                                                        <?php echo date('d-m-y', strtotime($patient->admited_date)); ?>
                                                    </td>
                                                    <td><?php echo date('g:i A', strtotime($patient->discharged_date)); ?>
                                                        <br>
                                                        <?php echo date('d-m-y', strtotime($patient->discharged_date)); ?>
                                                    </td>


                                                    <!-- <td class="center" style="display: none;">
                                                        <a href="<?php // echo base_url("employee/edit/$patient->id") 
                                                                    ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                                                    </td> -->

                                                </tr>
                                                <?php $sl++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                                <!-- table body end -->

                            </table> <!-- /.table-responsive -->
                        </div>
                    </div>
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



<?php /* ?>
                                        <th>Hospital ID</th>

                                         <th><?php echo display('action') ?></th> 
                                                  <th>Gender</th>
                                <th>Age</th>
                                        <?php */ ?>
<?php /* ?>
                                                    <td><?php echo $patient->gender; ?></td>
                                                    <td><?php echo $patient->age; ?></td> 
                                                    <td><?php echo $patient->hospital_id; ?></td> 
                                                    <td class="center" style="display: none;">
                                                         <a href="<?php echo base_url("employee/profile/$patient->id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a> 
                                                         <a href="<?php echo base_url("employee/edit/$patient->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> 
                                                         <a href="<?php echo base_url("case_manager/employee/form?pid=$patient->patient_id") ?>" class="btn btn-xs btn-warning" title="Add to Case Manager"><i class="fa fa-plus"></i></a>
                                                         <a href="<?php echo base_url("employee/delete/$patient->id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>')"><i class="fa fa-trash"></i></a> 
                                                    </td>
                                                    <?php */ ?>