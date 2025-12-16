<!-- This page is used to show list of inPatient  -->



<div class="content">
    <?php if ($patients) { ?>
        <div class="row">
            <script src="<?php echo base_url(); ?>assets/Chart.bundle.js"></script>
            <script src="<?php echo base_url(); ?>assets/utils.js"></script>
            <!--  table area start-->
            <div class="col-lg-12">
                <div class="panel panel-default ">
                    <!-- add patient button start -->
                    <?php if (ismodule_active('OUTPATIENT SECTION') === true  && isfeature_active('ADD-OUTPATIENT') === true) { ?>
                        <div class="panel-heading ">
                            <div class="btn-group">
                                <a class="btn btn-success" href="<?php echo base_url("patientop/create") ?>"> <i class="fa fa-plus"></i> New Patient </a>
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
                                            <th><?php echo lang_loader('global','global_patients_name'); ?></th>
                                            <th><?php echo lang_loader('global','global_patients_id'); ?></th>
                                            <th>Specialty</th>
                                            <!-- <th><?php echo lang_loader('global','global_bed_no'); ?></th> -->
                                            <th>Date of patient Visit</th>
                                            <!-- <th><?php echo lang_loader('global','global_discharged_date'); ?></th> -->
                                            <!-- <th><?php echo lang_loader('global','global_discharged_by'); ?></th> -->
                                            <?php if (dama('dama') === true) { ?>
                                                <th><?php echo lang_loader('global','global_message_status'); ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <!-- table head end -->

                                    <!-- table body start -->
                                    <tbody>
                                        <?php if (!empty($patients)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($patients as $patient) { ?>
                                                <tr class="<?php echo ($sl & 1) ? "odd gradeX" : "even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $patient->name; ?></td>
                                                    <td><?php echo $patient->patient_id; ?></td>
                                                    <td><?php echo $patient->ward; ?></td>
                                                    <!-- <td><?php echo $patient->bed_no; ?></td> -->
                                                    <td><?php echo date('g:i A', strtotime($patient->admited_date)); ?>
                                                        <br>
                                                        <?php echo date('d-m-y', strtotime($patient->admited_date)); ?>
                                                    </td>
                                                    <!-- <td><?php echo date('g:i A', strtotime($patient->datedischarged)); ?>
                                                        <br>
                                                        <?php echo date('d-m-y', strtotime($patient->datedischarged)); ?>
                                                    </td> -->
                                                    <!-- <td>
                                                        <?php
                                                        $this->db->select('*');
                                                        $this->db->where('user_id', $patient->created_by);
                                                        $query = $this->db->get('user');
                                                        $result2 = $query->result();
                                                        echo $result2[0]->firstname;
                                                        ?>
                                                    </td> -->
                                                    <?php if (dama('dama') === true) { ?>
                                                        <td style="text-align :center;">
                                                            <?php
                                                            if ($patient->messagestatus == '2') {
                                                                echo '<i class="fa fa-close"></i> ';
                                                            } else {
                                                                echo '<i class="fa fa-check"></i>';
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php } ?>
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
                </div>
            </div>
            <!--  table area end-->
        </div>
    <?php } else {   ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3 style="text-align: center; color:tomato;"<?php echo lang_loader('global','global_no_record_found'); ?> >
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