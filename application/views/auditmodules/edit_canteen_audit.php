<?php
$id = $this->uri->segment(3);
$this->db->where('id', $id);
$query = $this->db->get('bf_feedback_canteen_audit');
$results = $query->result();
// print_r($results);
$row = $results[0];
$param = json_decode($row->dataset, true);

?>


<div class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="javascript:void()" data-toggle="tooltip"
                            title="<?php echo lang_loader('ip', 'audit_id_tooltip'); ?>">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>&nbsp;Canteen audit checklist -
                        <?php echo $row->id; ?>
                    </h3>
                    <!-- <a class="btn btn-primary" style="background-color: #45c203;float: right;    margin-top: -30px;" href="<?php echo base_url("tickets") ?>">
                        <i class="fa fa-list"></i> Tickets Details </a> -->
                </div>
                <div class="panel-body" style="background: #fff;">


                    <?php echo form_open_multipart('audit/edit_canteen_audit_byid/' . $this->uri->segment(3), 'class="form-inner"') ?>
                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                    </table>

                    <table class="table table-striped table-bordered  no-footer dtr-inline collapsed">

                        <tr>
                            <td>
                                <b>Audit Details</b>
                            </td>
                            <td style="overflow: clip;">
                                Audit Name: <?php echo $param['audit_type']; ?>
                                <br>
                                Date & Time of Audit: <?php echo date('Y-m-d H:i', strtotime($row->datetime)); ?>
                                <br>
                                Audit by: <?php echo $param['audit_by']; ?>

                                <!-- Hidden inputs -->
                                <input class="form-control" type="hidden" name="audit_type"
                                    value="<?php echo $param['audit_type']; ?>" />
                                <input class="form-control" type="hidden" name="datetime"
                                    value="<?php echo $row->datetime; ?>" />
                                <input class="form-control" type="hidden" name="audit_by"
                                    value="<?php echo $param['audit_by']; ?>" />
                            </td>
                        </tr>


                    </table>

                    <table class="table table-striped table-bordered no-footer dtr-inline collapsed">
                        <tr>
                            <td><b>Area</b></td>
                            <td>
                                <select class="form-control" name="location">
                                    <option value="">Select Area</option>
                                    <?php
                                    $areas = $this->db->get('bf_audit_area')->result_array();
                                    foreach ($areas as $a) {
                                        $selected = ($param['location'] == $a['title']) ? 'selected' : '';
                                        echo "<option value='{$a['title']}' $selected>{$a['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>



                        <tr>
                            <th colspan="2" style="background:#f0f0f0;"><b>PERSONAL HYGIENE</b></th>
                        </tr>

                        <tr>
                            <td><b>Are hair caps worn by all food handlers?</b></td>
                            <td>
                                <input class="form-control" type="text" name="identification_details"
                                    value="<?php echo $param['identification_details']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="identification_details_text"
                                        value="<?php echo $param['identification_details_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are fingernails of food handlers short and clean?</b></td>
                            <td>
                                <input class="form-control" type="text" name="vital_signs"
                                    value="<?php echo $param['vital_signs']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="vital_signs_text"
                                        value="<?php echo $param['vital_signs_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are gloves worn by food handlers during the preparation of raw and cooked food?</b>
                            </td>
                            <td>
                                <input class="form-control" type="text" name="surgery"
                                    value="<?php echo $param['surgery']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="surgery_text"
                                        value="<?php echo $param['surgery_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are any open infections, cuts, or bandages on hands properly covered while handling
                                    food?</b></td>
                            <td>
                                <input class="form-control" type="text" name="complaints_communicated"
                                    value="<?php echo $param['complaints_communicated']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="complaints_communicated_text"
                                        value="<?php echo $param['complaints_communicated_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are adequate handwashing and drying facilities available?</b></td>
                            <td>
                                <input class="form-control" type="text" name="intake"
                                    value="<?php echo $param['intake']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="intake_text"
                                        value="<?php echo $param['intake_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Do catering staff understand when and how to wash their hands?</b></td>
                            <td>
                                <input class="form-control" type="text" name="output"
                                    value="<?php echo $param['output']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="output_text"
                                        value="<?php echo $param['output_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is smoking prohibited in the kitchen area?</b></td>
                            <td>
                                <input class="form-control" type="text" name="allergies"
                                    value="<?php echo $param['allergies']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="allergies_text"
                                        value="<?php echo $param['allergies_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is Personal Hygiene training regularly provided to new and existing staff?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medication"
                                    value="<?php echo $param['medication']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="medication_text"
                                        value="<?php echo $param['medication_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>


                        <!-- UTENSILS AND EQUIPMENT -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>UTENSILS AND EQUIPMENT</b></td>
                        </tr>

                        <tr>
                            <td><b>Are all small equipment and utensils, including cutting boards, thoroughly cleaned
                                    between uses?</b></td>
                            <td>
                                <input class="form-control" type="text" name="diagnostic"
                                    value="<?php echo $param['diagnostic']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="diagnostic_text"
                                        value="<?php echo $param['diagnostic_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are all utensils clean and dry?</b></td>
                            <td>
                                <input class="form-control" type="text" name="lab_results"
                                    value="<?php echo $param['lab_results']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="lab_results_text"
                                        value="<?php echo $param['lab_results_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are work surfaces clean?</b></td>
                            <td>
                                <input class="form-control" type="text" name="pending_investigation"
                                    value="<?php echo $param['pending_investigation']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="pending_investigation_text"
                                        value="<?php echo $param['pending_investigation_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are drawers and racks clean?</b></td>
                            <td>
                                <input class="form-control" type="text" name="medicine_order"
                                    value="<?php echo $param['medicine_order']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="medicine_order_text"
                                        value="<?php echo $param['medicine_order_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- CLEANING -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>CLEANING</b></td>
                        </tr>

                        <tr>
                            <td><b>Is there periodic cleaning schedule in place for utensils, equipment, and canteen
                                    areas?</b></td>
                            <td>
                                <input class="form-control" type="text" name="facility_communicated"
                                    value="<?php echo $param['facility_communicated']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="facility_communicated_text"
                                        value="<?php echo $param['facility_communicated_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is cleaning equipment stored appropriately?</b></td>
                            <td>
                                <input class="form-control" type="text" name="health_education"
                                    value="<?php echo $param['health_education']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="health_education_text"
                                        value="<?php echo $param['health_education_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the dining area clean and sanitized?</b></td>
                            <td>
                                <input class="form-control" type="text" name="risk_assessment"
                                    value="<?php echo $param['risk_assessment']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="risk_assessment_text"
                                        value="<?php echo $param['risk_assessment_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are cleaning solutions properly labelled and stored?</b></td>
                            <td>
                                <input class="form-control" type="text" name="urethral"
                                    value="<?php echo $param['urethral']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="urethral_text"
                                        value="<?php echo $param['urethral_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are Material Safety Data Sheets (MSDS) for chemicals available?</b></td>
                            <td>
                                <input class="form-control" type="text" name="urine_sample"
                                    value="<?php echo $param['urine_sample']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="urine_sample_text"
                                        value="<?php echo $param['urine_sample_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- GARBAGE DISPOSAL -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>GARBAGE DISPOSAL</b></td>
                        </tr>

                        <tr>
                            <td><b>Are garbage containers regularly washed and well maintained?</b></td>
                            <td>
                                <input class="form-control" type="text" name="bystander"
                                    value="<?php echo $param['bystander']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="bystander_text"
                                        value="<?php echo $param['bystander_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is the garbage/waste storage area protected from insects, pests, or rodent
                                    infestation?</b></td>
                            <td>
                                <input class="form-control" type="text" name="instruments"
                                    value="<?php echo $param['instruments']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="instruments_text"
                                        value="<?php echo $param['instruments_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Is garbage removed from the canteen in a timely manner?</b></td>
                            <td>
                                <input class="form-control" type="text" name="sterile"
                                    value="<?php echo $param['sterile']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="sterile_text"
                                        value="<?php echo $param['sterile_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are records of food waste disposal maintained?</b></td>
                            <td>
                                <input class="form-control" type="text" name="antibiotics"
                                    value="<?php echo $param['antibiotics']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="antibiotics_text"
                                        value="<?php echo $param['antibiotics_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Are records of oil waste disposal maintained?</b></td>
                            <td>
                                <input class="form-control" type="text" name="surgical_site"
                                    value="<?php echo $param['surgical_site']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="surgical_site_text"
                                        value="<?php echo $param['surgical_site_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <!-- PEST CONTROL -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>PEST CONTROL</b></td>
                        </tr>
                        <tr>
                            <td><b>Is a regular pest control program in place, and are records of the same
                                    available?</b></td>
                            <td>
                                <input class="form-control" type="text" name="wound"
                                    value="<?php echo $param['wound']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="wound_text"
                                        value="<?php echo $param['wound_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- RECEIVING -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>RECEIVING</b></td>
                        </tr>
                        <tr>
                            <td><b>Are products supplied by approved suppliers?</b></td>
                            <td>
                                <input class="form-control" type="text" name="documented"
                                    value="<?php echo $param['documented']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="documented_text"
                                        value="<?php echo $param['documented_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are incoming food and supplies promptly inspected upon receipt?</b></td>
                            <td>
                                <input class="form-control" type="text" name="adequate_facilities"
                                    value="<?php echo $param['adequate_facilities']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="adequate_facilities_text"
                                        value="<?php echo $param['adequate_facilities_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are all food items, materials, and supplies immediately moved to appropriate storage
                                    areas?</b></td>
                            <td>
                                <input class="form-control" type="text" name="sufficient_lighting"
                                    value="<?php echo $param['sufficient_lighting']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="sufficient_lighting_text"
                                        value="<?php echo $param['sufficient_lighting_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is all food labelled with the name and delivery/expiry date?</b></td>
                            <td>
                                <input class="form-control" type="text" name="storage_facility_for_food"
                                    value="<?php echo $param['storage_facility_for_food']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text"
                                        name="storage_facility_for_food_text"
                                        value="<?php echo $param['storage_facility_for_food_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is food protected from contamination during the receiving process?</b></td>
                            <td>
                                <input class="form-control" type="text" name="personnel_hygiene_facilities"
                                    value="<?php echo $param['personnel_hygiene_facilities']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text"
                                        name="personnel_hygiene_facilities_text"
                                        value="<?php echo $param['personnel_hygiene_facilities_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- STORAGE -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>STORAGE</b></td>
                        </tr>
                        <tr>
                            <td><b>Is there proper separation between food and chemicals in storage areas?</b></td>
                            <td>
                                <input class="form-control" type="text" name="food_material_testing"
                                    value="<?php echo $param['food_material_testing']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="food_material_testing_text"
                                        value="<?php echo $param['food_material_testing_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is air-conditioned storage available where required?</b></td>
                            <td>
                                <input class="form-control" type="text" name="incoming_material"
                                    value="<?php echo $param['incoming_material']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="incoming_material_text"
                                        value="<?php echo $param['incoming_material_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is all food stored off the floor?</b></td>
                            <td>
                                <input class="form-control" type="text" name="raw_materials_inspection"
                                    value="<?php echo $param['raw_materials_inspection']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text"
                                        name="raw_materials_inspection_text"
                                        value="<?php echo $param['raw_materials_inspection_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is the storage unit clean?</b></td>
                            <td>
                                <input class="form-control" type="text" name="storage_of_materials"
                                    value="<?php echo $param['storage_of_materials']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="storage_of_materials_text"
                                        value="<?php echo $param['storage_of_materials_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- TRANSPORT -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>TRANSPORT</b></td>
                        </tr>
                        <tr>
                            <td><b>Are transport containers and carts regularly cleaned?</b></td>
                            <td>
                                <input class="form-control" type="text" name="raw_materials_cleaning"
                                    value="<?php echo $param['raw_materials_cleaning']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="raw_materials_cleaning_text"
                                        value="<?php echo $param['raw_materials_cleaning_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are proper temperatures maintained during transport for hot foods?</b></td>
                            <td>
                                <input class="form-control" type="text" name="equipment_sanitization"
                                    value="<?php echo $param['equipment_sanitization']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="equipment_sanitization_text"
                                        value="<?php echo $param['equipment_sanitization_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Are transport trolleys clean?</b></td>
                            <td>
                                <input class="form-control" type="text" name="frozen_food_thawing"
                                    value="<?php echo $param['frozen_food_thawing']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="frozen_food_thawing_text"
                                        value="<?php echo $param['frozen_food_thawing_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- HEALTH -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>HEALTH</b></td>
                        </tr>
                        <tr>
                            <td><b>Are food handlers' medical checkup records up to date?</b></td>
                            <td>
                                <input class="form-control" type="text" name="vegetarian_and_non_vegetarian"
                                    value="<?php echo $param['vegetarian_and_non_vegetarian']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text"
                                        name="vegetarian_and_non_vegetarian_text"
                                        value="<?php echo $param['vegetarian_and_non_vegetarian_text']; ?>"
                                        placeholder="Remarks">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Is Food Safety training regularly provided?</b></td>
                            <td>
                                <input class="form-control" type="text" name="cooked_food_cooling"
                                    value="<?php echo $param['cooked_food_cooling']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="cooked_food_cooling_text"
                                        value="<?php echo $param['cooked_food_cooling_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>

                        <!-- QUALITY -->
                        <tr>
                            <td colspan="2" style="background:#f2f2f2;"><b>QUALITY</b></td>
                        </tr>
                        <tr>
                            <td><b>Are food samples preserved for 24 hours?</b></td>
                            <td>
                                <input class="form-control" type="text" name="food_portioning"
                                    value="<?php echo $param['food_portioning']; ?>">
                                <div style="margin-top:5px;">
                                    Remarks: <input class="form-control" type="text" name="food_portioning_text"
                                        value="<?php echo $param['food_portioning_text']; ?>" placeholder="Remarks">
                                </div>
                            </td>
                        </tr>





                        <tr>
                            <td><b>Additional comments</b></td>
                            <td><input class="form-control" type="text" name="dataAnalysis"
                                    value="<?php echo $param['dataAnalysis']; ?>"></td>
                        </tr>



                        <tr>
                            <td><b>Uploaded Files</b></td>
                            <td>
                                <?php
                                // $param = json_decode($record->dataset, true);
                                $existingFiles = !empty($param['files_name']) ? $param['files_name'] : [];
                                ?>

                                <!-- 🗂 Existing Files Section -->
                                <div id="existing-files">
                                    <?php if (!empty($existingFiles)) { ?>
                                        <!-- <label><b>Current Files:</b></label> -->
                                        <ul id="file-list" style="list-style-type:none; padding-left:0;">
                                            <?php foreach ($existingFiles as $index => $file) { ?>
                                                <li data-index="<?php echo $index; ?>"
                                                    style="margin-bottom:6px; background:#f8f9fa; padding:6px 10px; border-radius:6px; display:flex; align-items:center; justify-content:space-between;">
                                                    <a href="<?php echo htmlspecialchars($file['url']); ?>" target="_blank"
                                                        style="text-decoration:none; color:#007bff;">
                                                        <?php echo htmlspecialchars($file['name']); ?>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger remove-file"
                                                        style="margin-left:10px; padding:2px 6px; font-size:12px;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>
                                        <p id="no-files">No files uploaded</p>
                                    <?php } ?>
                                </div>

                                <!-- 📤 Dynamic Upload Inputs -->
                                <div class="form-group" id="upload-container" style="margin-top:10px;">
                                    <label><b>Add New Files:</b></label>
                                    <div class="upload-row"
                                        style="display:flex; align-items:center; margin-bottom:6px;">
                                        <input type="file" name="uploaded_files[]" class="form-control upload-input"
                                            style="flex:1; margin-right:10px;">
                                        <button type="button" class="btn btn-danger btn-sm remove-upload"
                                            style="display:none;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- ➕ Add More Files Button -->
                                <button type="button" id="add-more-files" class="btn btn-sm btn-success"
                                    style="margin-top:5px;">
                                    <i class="fa fa-plus"></i> Add More Files
                                </button>

                                <!-- Hidden input for removed old files -->
                                <input type="hidden" name="remove_files_json" id="remove_files_json" value="">
                            </td>
                        </tr>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {

                                // 🗑️ Handle removing existing old files
                                const removeInput = document.getElementById("remove_files_json");
                                let removedIndexes = [];

                                document.querySelectorAll(".remove-file").forEach(btn => {
                                    btn.addEventListener("click", function () {
                                        const li = this.closest("li");
                                        const index = li.getAttribute("data-index");
                                        removedIndexes.push(index);
                                        removeInput.value = JSON.stringify(removedIndexes);
                                        li.remove();
                                        if (document.querySelectorAll("#file-list li").length === 0) {
                                            document.getElementById("existing-files").innerHTML = "<p id='no-files'>No files uploaded</p>";
                                        }
                                    });
                                });

                                // ➕ Dynamic "Add More Files"
                                const addMoreBtn = document.getElementById("add-more-files");
                                const uploadContainer = document.getElementById("upload-container");

                                addMoreBtn.addEventListener("click", function () {
                                    const newRow = document.createElement("div");
                                    newRow.className = "upload-row";
                                    newRow.style.cssText = "display:flex; align-items:center; margin-bottom:6px;";

                                    const input = document.createElement("input");
                                    input.type = "file";
                                    input.name = "uploaded_files[]";
                                    input.className = "form-control upload-input";
                                    input.style.cssText = "flex:1; margin-right:10px;";

                                    const removeBtn = document.createElement("button");
                                    removeBtn.type = "button";
                                    removeBtn.className = "btn btn-danger btn-sm remove-upload";
                                    removeBtn.innerHTML = '<i class="fa fa-times"></i>';
                                    removeBtn.addEventListener("click", function () {
                                        newRow.remove();
                                    });
                                    removeBtn.style.display = "inline-block";

                                    newRow.appendChild(input);
                                    newRow.appendChild(removeBtn);
                                    uploadContainer.appendChild(newRow);
                                });
                            });
                        </script>


                        <tr>
                            <td colspan="2">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button">
                                            <?php echo 'Reset'; ?>
                                        </button>
                                        <div class="or"></div>
                                        <button type="submit" class="ui positive button" style="text-align: left;">
                                            <?php echo 'Save'; ?>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function calculateAdherenceRate() {
        var adheringStaff = parseInt(document.getElementById('initial_assessment_hr').value);
        var auditedStaff = parseInt(document.getElementById('total_admission').value);

        if (isNaN(adheringStaff) || adheringStaff < 0) {
            alert("Enter the number of staff adhering to safety precautions.");
            return;
        }

        if (isNaN(auditedStaff) || auditedStaff <= 0) {
            alert("Enter the number of staff audited.");
            return;
        }

        if (adheringStaff > auditedStaff) {
            alert("The number of staff adhering to safety precautions must be less than the number of staff audited.");
            return;
        }

        var adherencePercentage = (adheringStaff / auditedStaff) * 100;
        var calculatedResult = adherencePercentage % 1 === 0 ? adherencePercentage.toString() : adherencePercentage.toFixed(2);

        document.getElementById('calculatedResult').value = calculatedResult;

        console.log("Calculated result:", calculatedResult);
    }
</script>