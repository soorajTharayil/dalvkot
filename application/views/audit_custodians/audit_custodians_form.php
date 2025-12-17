<div class="content">
    <div class="row">
        <!--  form area -->
        <div class="col-sm-12">
            <div class="panel panel-default">

                <div class="panel-heading no-print">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo base_url("audit_custodians") ?>"> <i class="fa fa-list"></i> Audit List </a>
                    </div>
                </div>

                <div class="panel-body panel-form">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">

                            <?php echo form_open('audit_custodians/create', 'class="form-inner"') ?>

                            <?php echo form_hidden('guid', $department->guid) ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Audit Name<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter audit" value="<?php echo $department->title ?>" readonly>
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="audit_type" class="col-xs-3 col-form-label">Audit Type</label>
                                <div class="col-xs-9">
                                    <select name="audit_type" id="audit_type" class="form-control" onchange="setAuditType(this.value)">
                                        <option value="">-- Select audit type--</option>
                                        <option value="Random Audit" <?php echo (empty($department->audit_type) || $department->audit_type == 'Random Audit') ? 'selected' : ''; ?>>Random Audit</option>
                                        <option value="Scheduled Audit" <?php echo ($department->audit_type == 'Scheduled Audit') ? 'selected' : ''; ?>>Scheduled Audit</option>
                                    </select>

                                </div>
                            </div> -->


                            <div class="form-group row">
                                <label for="frequency" class="col-xs-3 col-form-label">Set Audit Frequency</label>
                                <div class="col-xs-9">
                                    <select name="frequency" id="frequency" class="form-control" onchange="setTargetByFrequency(this.value)" style="width: 100%;">
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
                                <label for="target" class="col-xs-3 col-form-label">Target Sample Size(minimum per month)</label>
                                <div class="col-xs-9">
                                    <input type="text" min="0" step="1" name="target" id="target" class="form-control"
                                        placeholder="Auto set by frequency"
                                        value="<?php echo isset($department->target) ? (int)$department->target : ''; ?>">
                                    <small id="freq_help" class="form-text text-muted" style="display:block;margin-top:6px;"></small>
                                </div>
                            </div>

                            <?php
                            // Define all audit features
                            $audit_features = [];
                            for ($i = 1; $i <= 100; $i++) {
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

                            // Map department title → feature_name
                            $title_to_feature = [
                                'Active Cases MRD Audit-IP' => 'AUDIT-FORM1',
                                'Discharged Patients MRD Audit' => 'AUDIT-FORM2',
                                'Nursing (IP Closed Cases)' => 'AUDIT-FORM3',
                                'Nursing (IP Open Cases)' => 'AUDIT-FORM4',
                                'Nursing (OP Closed Cases)' => 'AUDIT-FORM5',
                                'Clinical Dietetics (Active)' => 'AUDIT-FORM6',
                                'Clinical Dietetics (Closed Cases)' => 'AUDIT-FORM7',
                                'Clinical Pharmacy-(Closed)' => 'AUDIT-FORM8',
                                'Clinical Pharmacy-(OP)' => 'AUDIT-FORM9',
                                'Clinical Pharmacy-(Open)' => 'AUDIT-FORM10',
                                'Clinicians-Anesthesia(Active)' => 'AUDIT-FORM11',
                                'Clinicians-Anesthesia(Closed)' => 'AUDIT-FORM12',
                                'Clinicians-ED (Active)' => 'AUDIT-FORM13',
                                'Clinicians-ED (Closed)' => 'AUDIT-FORM14',
                                'Clinicians-ICU (Active)' => 'AUDIT-FORM15',
                                'Clinicians-ICU (Closed)' => 'AUDIT-FORM16',
                                'Clinicians-Primary Care Provider (Active)' => 'AUDIT-FORM17',
                                'Clinicians-Primary Care Provider (Closed)' => 'AUDIT-FORM18',
                                'Clinicians-Sedation (Active)' => 'AUDIT-FORM19',
                                'Clinicians-Sedation (Closed)' => 'AUDIT-FORM20',
                                'Clinicians-Surgeons (Active)' => 'AUDIT-FORM21',
                                'Clinicians-Surgeons (Closed)' => 'AUDIT-FORM22',
                                'Diet Consultation (OP)' => 'AUDIT-FORM23',
                                'Physiotherapy- (Closed)' => 'AUDIT-FORM24',
                                'Physiotherapy- (OP)' => 'AUDIT-FORM25',
                                'Physiotherapy- (Open)' => 'AUDIT-FORM26',
                                'MRD Audit- ED' => 'AUDIT-FORM27',
                                'MRD Audit- LAMA' => 'AUDIT-FORM28',
                                'MRD Audit- OP' => 'AUDIT-FORM29',
                                // 'Nursing & IPSG'
                                'Accidental Delining Audit' => 'AUDIT-FORM30',
                                'Admission Holding Area Audit' => 'AUDIT-FORM31',
                                'CPR Analysis Record' => 'AUDIT-FORM32',
                                'Extravasation Audit' => 'AUDIT-FORM33',
                                'Hospital Acquired Pressure Ulcers (HAPU) Audit' => 'AUDIT-FORM34',
                                'Initial Assessment Accident and Emergency (A&E)' => 'AUDIT-FORM35',
                                'Initial Assessment IPD' => 'AUDIT-FORM36',
                                'Initial Assessment OPD' => 'AUDIT-FORM37',
                                'IPSG-1' => 'AUDIT-FORM38',
                                'IPSG2- A&E' => 'AUDIT-FORM39',
                                'IPSG2- IPD' => 'AUDIT-FORM40',
                                'IPSG4-Timeout- Outside OT Audit' => 'AUDIT-FORM41',
                                'IPSG6- IP' => 'AUDIT-FORM42',
                                'IPSG6- OPD' => 'AUDIT-FORM43',
                                'Point Prevalence Audit' => 'AUDIT-FORM44',

                                // --- Clinical Outcome ---
                                'ACL' => 'AUDIT-FORM45',
                                'Allogenic Bone-marrow Transplantation' => 'AUDIT-FORM46',
                                'Aortic Valve Replacement (AVR)' => 'AUDIT-FORM47',
                                'Autologous Bone-marrow transplantation' => 'AUDIT-FORM48',
                                'Brain Tumour Surgery' => 'AUDIT-FORM49',
                                'CABG' => 'AUDIT-FORM50',
                                'Carotid Stenting' => 'AUDIT-FORM51',
                                'Chemotherapy (Medical oncology)' => 'AUDIT-FORM52',
                                'Colo-Rectal Surgeries' => 'AUDIT-FORM53',
                                'Endoscopy' => 'AUDIT-FORM54',
                                'Epilepsy' => 'AUDIT-FORM55',
                                'Herniorrhaphy' => 'AUDIT-FORM56',
                                'HoLEP' => 'AUDIT-FORM57',
                                'Laparoscopic Appendicectomy' => 'AUDIT-FORM58',
                                'Mechanical Thrombectomy' => 'AUDIT-FORM59',
                                'MVR (Mitral Valve replacement)' => 'AUDIT-FORM60',
                                'PTCA' => 'AUDIT-FORM61',
                                'Renal Transplantation' => 'AUDIT-FORM62',
                                'Scoliosis correction surgery' => 'AUDIT-FORM63',
                                'Spinal Dysraphism' => 'AUDIT-FORM64',
                                'Spine and Disc Surgery-Fusion procedures' => 'AUDIT-FORM65',
                                'Thoracotomy' => 'AUDIT-FORM66',
                                'TKR' => 'AUDIT-FORM67',
                                'Uro-oncology procedures' => 'AUDIT-FORM68',
                                'Whipples Surgery' => 'AUDIT-FORM69',
                                'Laparoscopic Cholecystectomy' => 'AUDIT-FORM70',

                                // --- Clinical KPI ---
                                'Bronchodilators Audit' => 'AUDIT-FORM71',
                                'COPD Protocol Audit' => 'AUDIT-FORM72',

                                // --- Infection Control & PCI ---
                                'Biomedical Waste Management Audit' => 'AUDIT-FORM73',
                                'Canteen Audit checklist' => 'AUDIT-FORM74',
                                'CSSD audit checklist' => 'AUDIT-FORM75',
                                'Hand Hygiene Audit' => 'AUDIT-FORM76',
                                'Infection control bundle audit' => 'AUDIT-FORM77',
                                'Infection Control OT audit checklist' => 'AUDIT-FORM78',
                                'Linen Audit' => 'AUDIT-FORM79',
                                'Ambulance PCI Audit' => 'AUDIT-FORM80',
                                'CoffeeShop PCI Audit' => 'AUDIT-FORM81',
                                'Laboratory PCI Audit' => 'AUDIT-FORM82',
                                'Mortuary PCI Audit' => 'AUDIT-FORM83',
                                'Radiology PCI Audit' => 'AUDIT-FORM84',
                                'SSI Surveillance checklist' => 'AUDIT-FORM85',
                                'IV cannula audit' => 'AUDIT-FORM86',
                                'Personal Protective Equipment Usage audit' => 'AUDIT-FORM87',
                                'Safe Injection and Infusion Audit' => 'AUDIT-FORM88',
                                'Surface cleaning and disinfection effectiveness monitoring record' => 'AUDIT-FORM89',

                                // --- Clinical Pathways ---
                                'Arthroscopic Anterior Cruciate Ligament Reconstruction Surgery' => 'AUDIT-FORM90',
                                'Breast Lump Consensus Guidelines' => 'AUDIT-FORM91',
                                'Cardiac Arrest' => 'AUDIT-FORM92',
                                'Donor Hepatectomy' => 'AUDIT-FORM93',
                                'Febrile Seizure' => 'AUDIT-FORM94',
                                'Heart Transplant Recipient' => 'AUDIT-FORM95',
                                'Laparoscopic Donor Nephrectomy' => 'AUDIT-FORM96',
                                'PICC LINE Insertion' => 'AUDIT-FORM97',
                                'Stroke' => 'AUDIT-FORM98',
                                'Urodynamics' => 'AUDIT-FORM99',
                                'STEMI-Primary PCI Clinical Pathway' => 'AUDIT-FORM100',
                            ];


                            $current_feature = isset($title_to_feature[$department->title]) ? $title_to_feature[$department->title] : '';

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
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
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

    (function() {
        var selType = document.getElementById('audit_type');
        var selFreq = document.getElementById('frequency');
        if (selType && selType.value === 'Random Audit') {
            setAuditType('Random Audit');
        } else if (selFreq) {
            setTargetByFrequency(selFreq.value);
        }
    })();
</script>