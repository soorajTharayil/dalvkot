<!-- This page is used to show list of inPatient  -->

<?php
$dates = get_from_to_date();
$fdate = $dates['fdate'];
$tdate = $dates['tdate'];
$pagetitle = $dates['pagetitle'];
$fdate = date('Y-m-d', strtotime($fdate));
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
$days = $dates['days'];

$currentPatients = $this->patientop_model->read();
$dischargedpatients = $this->patientop_model->readdischarged();

?>
<div class="content">

    <?php if (isfeature_active('EDIT-OUTPATIENT') === true || isfeature_active('VIEW-OUTPATIENT') === true  || isfeature_active('ADD-OUTPATIENT') === true || isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body" style="height:120px; max-height:120px;">
                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('ADD-OUTPATIENT') === true) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><br></h2>
                                        <div class="small"><?php echo lang_loader('global', 'global_add_patient_op'); ?></div>
                                        <div class="icon">
                                            <i class="fa fa-user-plus"></i>
                                        </div>
                                        <a href="<?php echo base_url() . 'patientop/create'; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_add_patient_op'); ?></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('VIEW-OUTPATIENT') === true) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><span class="count-number">
                                                <?php echo count($currentPatients); ?>
                                            </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                                </i></span></h2>
                                        <div class="small"><?php echo lang_loader('global', 'global_admitted_patients_op'); ?></div>
                                        <div class="icon">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <a href="<?php echo base_url() . 'patientop'; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><span class="count-number">
                                                <?php echo count($dischargedpatients); ?>
                                            </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                                </i></span></h2>
                                        <div class="small"><?php echo lang_loader('global', 'global_discharged_patients_op'); ?></div>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <a href="<?php echo base_url() . 'patientop/discharged'; ?>" style="float: right;    margin-top: -9px;"><?php echo lang_loader('global', 'global_view_list'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="panel panel-bd">
                                <div class="panel-body" style="height: 100px;">
                                    <div class="statistic-box">
                                        <h2><span class="count-number">
                                                <?php
                                                $a = count($dischargedpatients) + count($currentPatients);


                                                echo $a; ?>
                                            </span> <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning">
                                                </i></span></h2>
                                        <div class="small"><?php echo lang_loader('global', 'global_total_patients_op'); ?></div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <!-- Close Metric Boxes-->
            </div>
        </div>
    <?php } ?>
    <?php if ($patients) { ?>

        <div class="row">
            <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
            <script src="<?php echo base_url(); ?>assets/utils.js"></script>
            <!--  table area start-->
            <div class="col-lg-12">
                <div class="panel panel-default ">
                    <!-- add patient button start -->
                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('ADD-OUTPATIENT') === true) { ?>
                        <div class="panel-heading " style="display: none;">

                            <div class="btn-group">
                                <a class="btn btn-success" href="<?php echo base_url("patientop/create") ?>"> <i class="fa fa-plus"></i> <?php echo lang_loader('global', 'global_new_patient'); ?> </a>
                                <a class="btn btn-success" href="https://excel.import.efeedor.com?ins=experiment&type=patient_admitted"> <i class="fa fa-plus"></i> <?php echo lang_loader('global', 'global_import_patient'); ?> </a>
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
                                            <th><?php echo lang_loader('global', 'global_patients_name'); ?></th>
                                            <th><?php echo lang_loader('global', 'global_patients_id'); ?></th>
                                            <th><?php echo lang_loader('global', 'global_phone'); ?></th>
                                            <th>Department</th>
                                       
                                            <th><?php echo lang_loader('global', 'global_date'); ?></th>
                                            <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('EDIT-OUTPATIENT') === true) { ?>
                                                <th class="center">
                                                    <?php echo lang_loader('global', 'global_edit'); ?>
                                                </th>
                                            <?php } ?>
                                            <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>
                                                <!-- <th class="center">
                                                    <?php echo lang_loader('global', 'global_discharge'); ?> <br><?php echo lang_loader('global', 'global_with_msg'); ?>
                                                </th> -->
                                             
                                                    <th class="center">
                                                        <?php echo lang_loader('global', 'global_discharge'); ?> <br>without message
                                                    </th>
                                            
                                            <?php } ?>


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

                                                    <td><?php echo $patient->ward; ?></td>
                                               

                                                    <td><?php echo date('g:i A', strtotime($patient->created_on)); ?>
                                                        <br>
                                                        <?php echo date('d-m-y', strtotime($patient->created_on)); ?>
                                                    </td>

                                                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('EDIT-OUTPATIENT') === true) { ?>

                                                        <!-- edit case -->
                                                        <td style="text-align :center;">

                                                            <a href="<?php echo base_url("patientop/edit/$patient->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
                                                        </td>

                                                    <?php } ?>
                                                   <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('DISCHARGE-OUTPATIENT') === true) { ?>

                                                      <?php  $confirm = $patient->name; ?>
                                                        <!-- <td style="text-align :center;">

                                                            <a href="<?php echo base_url("patientop/patient_discharge/$patient->patient_id") ?>" class="btn btn-xs btn-success" onclick="return confirm('<?php echo 'Discharge ' . $confirm . '? and send message' ?>')"><i class="fa fa-check"></i></a>
                                                        </td> -->
                                                     
                                                            <td style="text-align :center;">

                                                                <a href="<?php echo base_url("patientop/patient_damar/$patient->patient_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo 'Discharge ' . $confirm . '?  without message' ?>')"><i class="fa fa-close"></i></a>
                                                            </td>

                                                      
                                                    <?php } ?>
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
    <?php } else {   ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3 style="text-align: center; color:tomato;"><?php echo lang_loader('global', 'global_no_record_found'); ?>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>
<style>
    .panel-body {
        height: auto;
    }
</style>
