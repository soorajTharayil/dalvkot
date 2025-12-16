<?php
	$i=0;
    include('db.php');
	$sql = 'SELECT * FROM `bf_coordinator` WHERE 1 	' ;			
	$result = mysqli_query($con,$sql);	
	$num1 = mysqli_num_rows($result);
	$j = 0;	
	if($num1 > 0){
		while($row = mysqli_fetch_object($result)){	
			$data['cordinators'][$j] = $row;
			$data['cordinators'][$j]->username = $row->name;
			$i++;
			$j++;
		}
	}
  
echo json_encode($data);
mysqli_close($con);
?>






