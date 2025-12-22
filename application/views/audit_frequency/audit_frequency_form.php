<div class="content">
    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("audit_frequency") ?>"> <i
                                class="fa fa-list"></i> Audit List </a>
                    </div>
                </div>

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('audit_frequency/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('guid', $department->guid) ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Audit Name<i
                                        class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="Enter audit" value="<?php echo $department->title ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="audit_type" class="col-xs-3 col-form-label">Audit Type</label>
                                <div class="col-xs-9">
                                    <select name="audit_type" id="audit_type" class="form-control"
                                        onchange="setAuditType(this.value)">
                                        <option value="">-- Select audit type--</option>
                                        <option value="Random Audit" <?php echo (empty($department->audit_type) || $department->audit_type == 'Random Audit') ? 'selected' : ''; ?>>Random Audit
                                        </option>
                                        <option value="Scheduled Audit" <?php echo ($department->audit_type == 'Scheduled Audit') ? 'selected' : ''; ?>>Scheduled Audit</option>
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="frequency" class="col-xs-3 col-form-label">Set Audit Frequency</label>
                                <div class="col-xs-9">
                                    <select name="frequency" id="frequency" class="form-control"
                                        onchange="setTargetByFrequency(this.value)" style="width: 100%;">
                                        <option value="">-- Select Frequency --</option>
                                        <option value="Daily" <?php echo ($department->frequency == 'Daily') ? 'selected' : ''; ?>>Daily</option>
                                        <option value="Twice a Week" <?php echo ($department->frequency == 'Twice a Week') ? 'selected' : ''; ?>>Twice a Week</option>
                                        <option value="Weekly" <?php echo ($department->frequency == 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
                                        <option value="Fortnightly (Once in Two Weeks)" <?php echo ($department->frequency == 'Fortnightly (Once in Two Weeks)') ? 'selected' : ''; ?>>Fortnightly (Once in Two Weeks)</option>
                                        <option value="Monthly" <?php echo ($department->frequency == 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
                                        <option value="Quarterly" <?php echo ($department->frequency == 'Quarterly') ? 'selected' : ''; ?>>Quarterly</option>
                                        <option value="Half-Yearly" <?php echo ($department->frequency == 'Half-Yearly') ? 'selected' : ''; ?>>Half-Yearly</option>
                                        <option value="Annual" <?php echo ($department->frequency == 'Annual') ? 'selected' : ''; ?>>Annual</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="target" class="col-xs-3 col-form-label">Target Sample Size(minimum per
                                    month)</label>
                                <div class="col-xs-9">
                                    <input type="text" min="0" step="1" name="target" id="target" class="form-control"
                                        placeholder="Auto set by frequency"
                                        value="<?php echo isset($department->target) ? (int) $department->target : ''; ?>">
                                    <small id="freq_help" class="form-text text-muted"
                                        style="display:block;margin-top:6px;"></small>
                                </div>
                            </div>

                            <?php
                            // Define all audit features
                            $audit_features = [];
                            for ($i = 1; $i <= 34; $i++) {
                                $audit_features[] = "AUDIT-FORM" . $i;
                            }

                            // Load all users
                            $users = $this->db->select('user.*, roles.role_id')
                                ->join('roles', 'user.user_role = roles.role_id')
                                ->order_by('roles.role_id', 'asc')
                                ->get('user')
                                ->result();

                            // Prepare custodian map (audit => custodians)
                            $audit_custodians = [];

                            if (!empty($users)) {
                                foreach ($audit_features as $feature) {
                                    $custodian_names = [];
                                    foreach ($users as $user) {
                                        $this->db->from('user_permissions as UP');
                                        $this->db->select('F.feature_name');
                                        $this->db->join('features as F', 'UP.feature_id = F.feature_id');
                                        $this->db->where('UP.user_id', $user->user_id);
                                        $this->db->where('UP.status', 1);
                                        $perms = $this->db->get()->result();

                                        foreach ($perms as $p) {
                                            if (strcasecmp(trim($p->feature_name), $feature) === 0) {
                                                $custodian_names[] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8');
                                                break;
                                            }
                                        }
                                    }
                                    $audit_custodians[$feature] = array_unique($custodian_names);
                                }
                            }

                            //Map department title → feature_name
                            $title_to_feature = [
                                'MRD audit' => 'AUDIT-FORM1',
                                'Radiology safety adherence audit' => 'AUDIT-FORM2',
                                'Laboratory safety adherence audit' => 'AUDIT-FORM34',
                                'OP consultation waiting time audit' => 'AUDIT-FORM3',
                                'Laboratory waiting time audit' => 'AUDIT-FORM4',
                                'X-Ray waiting time audit' => 'AUDIT-FORM5',
                                'USG waiting time audit' => 'AUDIT-FORM6',
                                'CT scan waiting time audit' => 'AUDIT-FORM7',
                                'Operating Room Safety audit' => 'AUDIT-FORM8',
                                'Medication management process audit' => 'AUDIT-FORM9',
                                'Medication administration audit' => 'AUDIT-FORM10',
                                'Handover audit' => 'AUDIT-FORM11',
                                'Prescriptions audit' => 'AUDIT-FORM12',
                                'Hand hygiene audit' => 'AUDIT-FORM13',
                                'TAT for issue of blood & blood components' => 'AUDIT-FORM14',
                                'Nurse-Patients ratio for ICU' => 'AUDIT-FORM15',
                                'Return to ICU within 48 hours' => 'AUDIT-FORM16',
                                'Return to ICU- Data Verification' => 'AUDIT-FORM17',
                                'Return to Emergency within 72 hours' => 'AUDIT-FORM18',
                                'Return to Emergency- Data Verification' => 'AUDIT-FORM19',
                                'Mock drills audit' => 'AUDIT-FORM20',
                                'Code - Originals audit' => 'AUDIT-FORM21',
                                'Facility safety inspection audit' => 'AUDIT-FORM22',
                                'Nurse-Patients ratio for Ward' => 'AUDIT-FORM23',
                                'VAP Prevention checklist' => 'AUDIT-FORM24',
                                'Catheter Insertion checklist' => 'AUDIT-FORM25',
                                'SSI Bundle care policy' => 'AUDIT-FORM26',
                                'Urinary Catheter maintenance checklist' => 'AUDIT-FORM27',
                                'Central Line Insertion checklist' => 'AUDIT-FORM28',
                                'Central Line maintenance checklist' => 'AUDIT-FORM29',
                                'Patient room cleaning checklist' => 'AUDIT-FORM30',
                                'Other area cleaning checklist' => 'AUDIT-FORM31',
                                'Toilet Cleaning Checklist' => 'AUDIT-FORM32',
                                'Canteen Audit Checklist' => 'AUDIT-FORM33',

                            ];


                            $current_feature = isset($title_to_feature[$department->title]) ? $title_to_feature[$department->title] : '';

                            // Show only custodians for the current audit
                            if ($current_feature && isset($audit_custodians[$current_feature])) {
                                $default_custodians = implode(', ', $audit_custodians[$current_feature]);
                            } else {
                                $default_custodians = 'No custodians assigned';
                            }
                            ?>




                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Audit Custodians</label>
                                <div class="col-xs-9">
                                    <input type="text" name="description" id="description" class="form-control"
                                        placeholder="Display a list of audit custodians based on the users assigned permissions for each specific audit"
                                        value="<?php echo $default_custodians; ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo 'Reset'; ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo 'Save'; ?></button>
                                    </div>
                                </div>
                            </div>

                            <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function daysInMonth(y, m) {
        return new Date(y, m + 1, 0).getDate();
    }

    function setTargetByFrequency(freq) {
        var targetEl = document.getElementById('target');
        if (!targetEl) return;

        var now = new Date();
        var f = (freq || '').toLowerCase().trim();
        var t = '';

        if (f === 'daily') {
            t = daysInMonth(now.getFullYear(), now.getMonth());
        } else if (f === 'twice a week') {
            t = 8;
        } else if (f === 'weekly') {
            t = 4;
        } else if (f.indexOf('fortnight') !== -1) {
            t = 2;
        } else if (f === 'monthly') {
            t = 1;
        } else if (f.indexOf('random') !== -1) {
            //t = '';
            targetEl.value = targetEl.value || '';
            targetEl.placeholder = 'Enter sample size';
            return;
        } else if (f === 'quarterly' || f === 'annual' || f.indexOf('half') !== -1) {
            t = '';
        }

        targetEl.value = targetEl.value || '';
        targetEl.placeholder = (t === '') ?
            'Set manually for Quarterly/Half-Yearly/Annual' :
            'Auto set by frequency';
    }

    function setAuditType(type) {
        var freqEl = document.getElementById('frequency');
        var targetEl = document.getElementById('target');
        var targetLbl = document.querySelector('label[for="target"]');
        if (!freqEl || !targetEl) return;

        if (type === 'Random Audit') {
            var optRandom = freqEl.querySelector('option[value="Random Audit"]');
            if (!optRandom) {
                optRandom = document.createElement('option');
                optRandom.value = 'Random Audit';
                optRandom.text = 'Random Audit';
                freqEl.insertBefore(optRandom, freqEl.firstChild);
            }
            freqEl.dataset.prevValue = freqEl.value || '';
            freqEl.value = 'Random Audit';
            freqEl.readOnly = true;

            if (targetLbl) targetLbl.textContent = 'Sample size';
            targetEl.placeholder = 'Enter sample size';
            setTargetByFrequency('Random Audit');
        } else {
            freqEl.disabled = false;
            var optRandom = freqEl.querySelector('option[value="Random Audit"]');
            if (optRandom) optRandom.remove();

            if (targetLbl) targetLbl.textContent = 'Target (minimum per month)';
            targetEl.placeholder = 'Auto set by frequency';
            setTargetByFrequency(freqEl.value);
        }
    }

    (function () {
        var selType = document.getElementById('audit_type');
        var selFreq = document.getElementById('frequency');
        if (selType && selType.value === 'Random Audit') {
            setAuditType('Random Audit');
        } else if (selFreq) {
            setTargetByFrequency(selFreq.value);
        }
    })();
</script>