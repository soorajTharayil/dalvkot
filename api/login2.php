<?php
include('db.php');
$time = time();
$data = json_decode(file_get_contents('php://input'),true);

$username = $data['userid'];
print_r($username);exit;
$password = $data['password'];
$query = 'SELECT * FROM  user WHERE email="'.$username.'" AND password="'.md5($password).'"';
$object = mysqli_query($con,$query);
$result = mysqli_fetch_object($object);
if($result){

 $response['status'] = 'success';
				$response['userid'] = $result->user_id;
				$response['email'] = $result->email;
				$response['picture'] = $result->picture;
				
				$response['data'] = json_decode($result->departmentpermission);
}else{
$response['status'] = 'fail';
$response['message'] = 'Invalid Username & password';
}
echo $pk = json_encode($response);
				exit;
?>
