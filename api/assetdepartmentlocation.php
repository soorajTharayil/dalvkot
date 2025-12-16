<?php
	$i=0;
    include('db.php');
	$sql = 'SELECT * FROM `bf_asset_location` WHERE 1 order by title	 asc' ;			
	$result = mysqli_query($con,$sql);	
	$num1 = mysqli_num_rows($result);
	$j = 0;	
	if($num1 > 0){
		while($row = mysqli_fetch_object($result)){	

			$data['locationsite'][$j]['title'] = $row->title;
			$data['locationsite'][$j]['guid'] = $row->guid;
			$data['locationsite'][$j]['bedno'] = explode(',',$row->bed_no);

	
			$i++;
			$j++;
		}
	}


echo json_encode($data);
mysqli_close($con);
	
?>






