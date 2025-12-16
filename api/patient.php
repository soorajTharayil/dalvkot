<?php
 include('db.php');
$ward = $_REQUEST['ward_id'];
$sql = 'SELECT * FROM `bf_ward` WHERE guid="'.$ward.'"' ;
$result = mysqli_query($con,$sql);
$datas = mysqli_fetch_object($result);
$i=0;

	$sql = 'SELECT * FROM `bf_patients` WHERE ward="'.$datas->title.'" AND (discharged_date="0" OR discharged_date="") order by id desc' ;
	$result = mysqli_query($con,$sql);
	$num1 = mysqli_num_rows($result);
	$j = 0;
	if($num1 > 0){
		while($row = mysqli_fetch_object($result)){

			
			//$data['paitent'][$i]['desies'] = 'Pain';
			
			$sqls = 'SELECT * FROM `bf_feedback` WHERE patientid = "'.$row->patient_id.'"' ;
			$res = mysqli_query($con,$sqls);
			$num1s = mysqli_num_rows($res);
			
			if(count($num1s) > 0 && $num1s != NULL){
				//$data['paitent'][$i]['feedback'] = 'done';
			}else{
				
				$sqls = 'SELECT * FROM `bf_feedback` WHERE patientid = "'.$row->patient_id.'"' ;
				$res = mysqli_query($con,$sqls);
				$num1s = mysqli_num_rows($res);
				if(count($num1s) > 0 && $num1s != NULL){
					//$data['paitent'][$i]['feedback'] = 'done';
				}else{
					$data['paitent'][$i]['guid'] = $row->guid;
					$data['paitent'][$i]['name'] = $row->name;
					$data['paitent'][$i]['patent_id'] =$row->patient_id;
					$data['paitent'][$i]['bed_no'] = $row->bed_no;
					$data['paitent'][$i]['age'] = $row->age;
					$data['paitent'][$i]['gender'] = $row->gender; 
					$data['paitent'][$i]['consultant'] = $row->consultant; 
					$data['paitent'][$i]['desies'] = $row->admitedfor;  
					$data['paitent'][$i]['mobile'] = $row->mobile;  
					$data['paitent'][$i]['email'] =  $row->email; 
					$data['paitent'][$i]['feedback'] = 'pending';					
					$i++;
					$j++;
				}

	
			}
		}
	}else{
		$data = array();
	}
	if($i == 0){
		$data = array();
	}

echo json_encode($data);
mysqli_close($con);


?>
