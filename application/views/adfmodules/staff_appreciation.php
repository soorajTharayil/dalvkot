<div class="content">
    <!-- alert message -->
    <!-- content -->
    <?php
    include 'info_buttons_ip.php';
    require 'ip_table_variables.php';
    $all_feedback = $this->admissionfeedback_model->patient_and_feedback($table_patients, $table_feedback, $desc, $setup);


    // $ip_psat = $this->admissionfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $desc);

    // print_r($ip_psat);
    // exit;
    $feedback = $all_feedback;

    if ($all_feedback) { 

    ?>
    <div class="row">
        <!-- Total Product Sales area -->

        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <table class="ipstaffrec table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <th>No.</th>
                            <th><?php echo lang_loader('adf','adf_date'); ?></th>
                            <th><?php echo lang_loader('adf','adf_patient_details'); ?>
</th>
                            <th><?php echo lang_loader('adf','adf_department'); ?></th>
                            <th><?php echo lang_loader('adf','adf_staff_name'); ?></th>
                        </thead>
                        <?php $sl = 1;
                        $i = 0; ?>
                        <tbody>
                            <?php foreach ($feedback as $row) {
                                $param = json_decode($row->dataset);
                                if ($param->staffname) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $sl; ?>
                                        </td>
                                        <td>
                                            <?php if ($param->datetime) { ?>
                                                <?php echo date('g:i A', date(($param->datetime) / 1000)); ?>
                                                <br>
                                                <?php echo date('d-m-y', date(($param->datetime) / 1000)); ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo $param->name; ?> (<a href="<?php echo $ip_link_patient_feedback . $row->id; ?>"><?php echo $param->patientid; ?></a>)
                                            <br>
                                            <?php echo $param->ward; ?>
                                            <?php if ($param->bedno) { ?>
                                                <br>
                                                <?php echo 'in ' . $param->bedno; ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo $param->contactnumber; ?>
                                            <?php if ($param->email) { ?>
                                                <br>
                                                <?php echo $param->email; ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo ($param->staffname); ?>
                                        </td>
                                        <?php $sl = $sl + 1; ?>
                                        <?php $i++; ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } else {   ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">

						<h3 style="text-align: center; color:tomato;"><?php echo lang_loader('adf','adf_no_record_found'); ?>
					</div>
				</div>
			</div>
		</div>

	<?php } ?>
</div>
<style>
    .panel-body {
        height: auto;
        overflow: auto;
    }
</style>