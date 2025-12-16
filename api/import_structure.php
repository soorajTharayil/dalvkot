<?php
$importStructure = array();
$importStructure['patient_admitted'] = array(
   'name' => 'Name',
   'patient_id' => 'Patient ID',
   'mobile' => 'Mobile Number',
   'bed_no' => 'Bed No',
   'ward' => 'Ward'
);

$importStructure['healthcare_employees'] = array(
   'name' => 'Name',
   'patient_id' => 'Employee ID',
   'mobile' => 'Mobile Number',
   'role' => 'Job Role'
);



echo json_encode($importStructure);
?>