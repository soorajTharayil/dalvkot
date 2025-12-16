<?php
//including the database connection file
include_once("config.php");

//fetching data in descending order (lastest entry first)
//$result = mysql_query("SELECT * FROM users ORDER BY id DESC"); // mysql_query is deprecated
$result = mysqli_query($con, "SELECT * FROM shedule_notification ORDER BY id"); // using mysqli_query instead
?>



<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<table width='100%' class="table table-bordered">

	<tr bgcolor='#CCCCCC'>
		<td>Type</td>
		<td>Section</td>
		<td>Name</td>
		<td>TIME</td>
		<td>DAY</td>
		<td>DATE-NUM</td>
		<td>Action</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['type']."</td>";
		echo "<td>".$res['section']."</td>";
		echo "<td>".$res['name']."</td>";
		echo "<td>".$res['time']."</td>";
		echo "<td>".$res['day']."</td>";	
		echo "<td>".$res['datevalue']."</td>";	
		echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> </td>";		
	}
	?>
	</table>
	</div>
</body>
</html>
