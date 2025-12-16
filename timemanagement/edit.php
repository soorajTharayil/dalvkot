<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$id = mysqli_real_escape_string($con, $_POST['id']);
	
	{	
		$result = mysqli_query($con, "SELECT * FROM shedule_notification WHERE id=$id");
		$res = mysqli_fetch_array($result);
		if($res['datevalue'] == 0){ 
			$result = mysqli_query($con, "UPDATE shedule_notification SET time='".$_POST['time']."',day='".$_POST['day']."' WHERE id=$id");
		}else{
			$result = mysqli_query($con, "UPDATE shedule_notification SET time='".$_POST['time']."',datevalue='".$_POST['datevalue']."' WHERE id=$id");
		}
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT * FROM shedule_notification WHERE id=$id");

$res = mysqli_fetch_array($result);
//print_r($res);
?>

<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
	<div class="col-md-6">
	<a href="index.php" class="btn btn-primary pull-right">Home</a>
	<br/><br/>
	
		<form name="form1" method="post" action="edit.php">
			<table border="0" style="width:100%" class="table table-bordered">
				<tr> 
					<td>Name</td>
					<td><?php echo $res['name'];?></td>
				</tr>
				<tr> 
					<td>Time</td>
					<td><input type="time" name="time" value="<?php echo $res['time'];?>"></td>
				</tr>
				<?php if($res['day'] != NULL){ ?>
				<tr> 
					<td>Day</td>
					<td>
						<select type="text" name="day" >
							<option value="Monday" <?php if($res['day'] == 'Monday'){ echo 'selected'; } ?>>MONDAY</option>
							<option value="Tuesday" <?php if($res['day'] == 'Tuesday'){ echo 'selected'; } ?>>TUESDAY	</option>
							<option value="Wednesday" <?php if($res['day'] == 'Wednesday'){ echo 'selected'; } ?>>WEDNESDAY</option>
							<option value="Thrusday" <?php if($res['day'] == 'Thrusday'){ echo 'selected'; } ?>>THURSDAY</option>
							<option value="Friday" <?php if($res['day'] == 'Friday'){ echo 'selected'; } ?>>FRIDAY</option>
							<option value="Saturday" <?php if($res['day'] == 'Saturday'){ echo 'selected'; } ?>>SATURDAY</option>
							<option value="Sunday" <?php if($res['day'] == 'Sunday'){ echo 'selected'; } ?>>SUNDAY</option>
						
							
						</select>
					</td>
				</tr>
				<?php } ?>
				<?php if($res['datevalue'] != 0){ ?>
				<tr> 
					<td>Date Number (in Month)</td>
					<td>
						<input type="number" name="datevalue" value="<?php echo $res['datevalue'];?>">
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
					<td><input type="submit" name="update" value="Update"></td>
				</tr>
			</table>
		</form>
	</div>
	</div>
</body>
</html>
