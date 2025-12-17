<?php //echo lang_loader('ip','ip_allfeedbacks_dashboard'); exit; 
require_once 'audit_tables.php';
?>

<div class="content">


    <?php
    $audit_frequency_by_title = [];
    $freq_rows = $this->db->get('bf_audit_frequency')->result_array();
    foreach ($freq_rows as $r) {
        $key = strtolower(trim($r['title'] ?? ''));
        if ($key !== '') {
            $audit_frequency_by_title[$key] = [
                'audit_type' => $r['audit_type'] ?? '-',
                'frequency'  => $r['frequency'] ?? '-',
                'target'  => $r['target'] ?? '-',
                'bed_no'  => $r['bed_no'] ?? '-',


            ];
        }
    }


    function metaFor($displayTitle, $map)
    {
        $k = strtolower(trim($displayTitle));
        return $map[$k] ?? ['audit_type' => '-', 'frequency' => '-', 'target' => '-', 'bed_no' => '-'];
    }

    // 3) Common params
    $fdate = $_SESSION['from_date'];
    $tdate = $_SESSION['to_date'];
    $table_patients = 'bf_patients';
    $sorttime = 'asc';
    $setup = 'setup';
    ?>

    <div class="row" title="<?php echo $initial_assesment_info_tooltip; ?>">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 30%;">Audit Name</th>
                        <!-- <th style="width: 13%;">Audit Type</th>
                        <th>Audit Custdians</th> -->
                        <th style="width: 20%;">Total Conducted</th>
                        <th style="width: 20%;">View</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (isfeature_active('AUDIT-FORM1') === true) {
                        $title = 'MRD audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_mrd_audit', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_mrd_audit; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $initial_assesment_info_tooltip; ?>"><?php echo $title; ?></td>
                            <!-- <td><?php echo $meta['audit_type']; ?></td>
                            <td><?php echo $meta['frequency']; ?></td>
                            <td><?php echo $meta['target']; ?></td>
                            <td><?php echo $meta['bed_no']; ?></td> -->
                            <td><?php echo count($cnt); ?></td>
                            <!-- <td>
                                <?php
                                $targetRaw = $meta['target'];
                                $frequency = strtolower(trim($meta['frequency']));
                                $conducted = count($cnt);
                                $target    = 0;
                                $output    = '-';


                                $targetNum = (int) filter_var($targetRaw, FILTER_SANITIZE_NUMBER_INT);


                                $shortCycle = ['daily', 'weekly', 'twice a week', 'fortnightly (once in two weeks)', 'monthly', 'random audit'];

                                if (in_array($frequency, $shortCycle)) {
                                    $target = $targetNum;
                                    if ($target > 0) {
                                        $percent = round(($conducted / $target) * 100, 2);
                                        $output = $percent . '%';
                                    }
                                } elseif (in_array($frequency, ['quarterly', 'half-yearly', 'annual', 'yearly'])) {
                                    if ($frequency === 'quarterly') {
                                        $target = ceil($targetNum / 4);
                                    } elseif ($frequency === 'half-yearly') {
                                        $target = ceil($targetNum / 2);
                                    } else {
                                        $target = $targetNum;
                                    }

                                    if ($target > 0) {
                                        if ($conducted >= $target) {
                                            $output = '<span style="color:green;font-weight:bold;">Met</span> (' . $conducted . '/' . $target . ')';
                                        } else {
                                            $output = '<span style="color:red;font-weight:bold;">Not Met</span> (' . $conducted . '/' . $target . ')';
                                        }
                                    }
                                }

                                echo $output;
                                ?>
                            </td> -->

                            <td>
                                <a href="<?php echo $feedbacks_report_mrd_audit; ?>"
                                    class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>


                        </tr>
                    <?php } ?>

                    <?php if (isfeature_active('AUDIT-FORM2') === true) {
                        $title = 'Radiology safety adherence audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_ppe_audit', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_ppe_audit; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $report_error_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>

                            <td>
                                <a href="<?php echo $feedbacks_report_ppe_audit; ?>"
                                    class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>

                        </tr>
                    <?php } ?>

                    <?php if (isfeature_active('AUDIT-FORM34') === true) {
                        $title = 'Laboratory safety adherence audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_lab_safety_audit', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_lab_safety_audit; ?>'" style="cursor:pointer;">

                            <td title="<?php echo $report_error_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_lab_safety_audit; ?>"
                                    class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>


                        </tr>
                    <?php } ?>

                    <?php if (isfeature_active('AUDIT-FORM3') === true) {
                        $title = 'OP consultation waiting time audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_consultation_time', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_consultation_time; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $safety_precautions_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_consultation_time; ?>"
                                    class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>

                        </tr>
                    <?php } ?>

                    <?php if (isfeature_active('AUDIT-FORM4') === true) {
                        $title = 'Laboratory waiting time audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_lab_wait_time', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_lab_time; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $medication_errors_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_lab_time; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM5') === true) {
                        $title = 'X-Ray waiting time audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_xray_wait_time', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_xray_time; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $medication_charts_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_xray_time; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM6') === true) {
                        $title = 'USG waiting time audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_usg_wait_time', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_usg_time; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $adverse_drug_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_usg_time; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM7') === true) {
                        $title = 'CT Scan waiting time audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_ctscan_time', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_ctscan_time; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $unplanned_return_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_ctscan_time; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM8') === true) {
                        $title = 'Operating Room Safety audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_surgical_safety', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_surgical_safety; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $wrong_surgery_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_surgical_safety; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM9') === true) {
                        $title = 'Medication management process audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_medicine_dispense', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_medicine_dispense; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $transfusion_reactions_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_medicine_dispense; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM10') === true) {
                        $title = 'Medication administration audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_medication_administration', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_medication_administration; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $mortality_ratio_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_medication_administration; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM11') === true) {
                        $title = 'Handover audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_handover', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_handover; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $theemergency_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_handover; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM12') === true) {
                        $title = 'Prescriptions audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_prescriptions', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_prescriptions; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $ulcers_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_prescriptions; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM13') === true) {
                        $title = 'Hand hygiene audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_hand_hygiene', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_hand_hygiene; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $urinary_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_hand_hygiene; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM14') === true) {
                        $title = 'TAT for issue of blood & blood components';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_tat_blood', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_tat_blood; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $pneumonia_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_tat_blood; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM15') === true) {
                        $title = 'Nurse-Patients ratio for ICU';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_nurse_patients_ratio', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_nurse_patients_ratio; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $blood_infection_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_nurse_patients_ratio; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM16') === true) {
                        $title = 'Return to ICU within 48 hours';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_return_to_i', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_return_to_i; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $site_infection_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_return_to_i; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM17') === true) {
                        $title = 'Return to ICU - Data Verification';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_return_to_icu', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_return_to_icu; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $hand_hygiene_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_return_to_icu; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM18') === true) {
                        $title = 'Return to Emergency within 72 hours';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_return_to_ed', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_return_to_ed; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $prophylactic_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_return_to_ed; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM19') === true) {
                        $title = 'Return to Emergency - Data Verification';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_return_to_emr', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_return_to_emr; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $re_scheduling_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_return_to_emr; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM20') === true) {
                        $title = 'Mock drills audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_mock_drill', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_mock_drill; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $mock_drill_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_mock_drill; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM32') === true) {
                        $title = 'Code - Originals audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_code_originals', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_code_originals; ?>'" style="cursor:pointer;">
                            <td><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_code_originals; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM21') === true) {
                        $title = 'Facility safety inspection audit';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_safety_inspection', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_safety_inspection; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $facility_inspection_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_safety_inspection; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM22') === true) {
                        $title = 'Nurse-Patients ratio for Ward';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_nurse_patients_ratio_ward', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_nurse_patients_ratio_ward; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $ward_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_nurse_patients_ratio_ward; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM23') === true) {
                        $title = 'VAP Prevention checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_vap_prevention', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_vap; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $vap_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_vap; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM24') === true) {
                        $title = 'Catheter Insertion checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_catheter_insert', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_catheter_insert; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $catheter_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_catheter_insert; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM25') === true) {
                        $title = 'SSI Bundle care policy';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_ssi_bundle', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_ssi_bundle; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $ssi_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_ssi_bundle; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM26') === true) {
                        $title = 'Urinary Catheter maintenance checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_urinary_catheter', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_urinary; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $urinary_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_urinary; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM27') === true) {
                        $title = 'Central Line Insertion checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_central_line_insert', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_central_line_insert; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $central_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_central_line_insert; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM28') === true) {
                        $title = 'Central Line maintenance checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_central_maintenance', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_central_maintenance; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $maintenance_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_central_maintenance; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM29') === true) {
                        $title = 'Patient room cleaning checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_room_cleaning', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_room_cleaning; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $room_clean_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_room_cleaning; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM30') === true) {
                        $title = 'Other area cleaning checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_other_area_cleaning', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_other_cleaning; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $area_clean_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_other_cleaning; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                    <?php if (isfeature_active('AUDIT-FORM31') === true) {
                        $title = 'Toilet cleaning checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_toilet_cleaning', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_toilet_cleaning; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $toilet_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_toilet_cleaning; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>




                    <?php if (isfeature_active('AUDIT-FORM33') === true) {
                        $title = 'Canteen audit checklist';
                        $meta  = metaFor($title, $audit_frequency_by_title);
                        $cnt   = $this->audit_model->patient_and_feedback($table_patients, 'bf_feedback_canteen_audit', $sorttime, $setup);
                    ?>
                        <tr onclick="window.location='<?php echo $feedbacks_report_canteen; ?>'" style="cursor:pointer;">
                            <td title="<?php echo $canteen_info_tooltip; ?>"><?php echo $title; ?></td>
                            <td><?php echo count($cnt); ?></td>
                            <td>
                                <a href="<?php echo $feedbacks_report_canteen; ?>" class="btn btn-info btn-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php } ?>


                </tbody>
            </table>
        </div>
    </div>





</div>

<style>
    .icon .fa {
        font-size: 55px;
    }

    .chart-container {
        justify-content: center;
        /* Align the chart horizontally in the center */
        align-items: center;
        /* Align the chart vertically in the center */
        width: 460px !important;
        margin: 0px auto;
        height: 450px;
        width: 200px;
    }

    .coment-cloud {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: auto;
        /* width: 100%;
			height: 50%; */
        margin-bottom: 5px;
        margin-top: 5px;
    }


    .progress {
        margin-bottom: 10px;
    }

    .mybarlength {
        text-align: right;
        margin-right: 18px;
        font-weight: bold;
    }

    .panel-body {
        height: 531px;
    }

    .bar_chart {
        justify-content: center;
        /* Align the chart horizontally in the center */
        align-items: center;
        /* Align the chart vertically in the center */
        /* width: 460px !important; */
        margin: 0px auto;
        height: 500px;
        width: 1024px;
    }


    .line_chart {
        justify-content: center;
        /* Align the chart horizontally in the center */
        align-items: center;
        /* Align the chart vertically in the center */
        /* width: 460px !important; */
        margin: 0px auto;
        height: 270px;
        width: 200px;
    }

    .dropdown-menu>li>a {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 100%;
        display: block;
        /* Ensure the anchor element takes up full width */
    }


    .dropdown-menu>.li {
        width: 100%;
        border: 0px;
        border-bottom: 1px solid #ccc;
        text-align: left;
    }

    @media screen and (max-width: 1024px) {
        #pie_donut {
            overflow-x: scroll;
        }

        #bar {
            overflow-x: scroll;
        }

        #word {
            overflow-x: scroll;
        }

        #line {
            overflow-x: scroll;
            overflow-y: scroll;
        }
    }

    /* Default: hide the icon */
    .icon.large-screen-only {
        display: none;
    }

    /* Show the icon only on large screens */
    @media (min-width: 992px) {
        .icon.large-screen-only {
            display: block;
        }
    }
</style>