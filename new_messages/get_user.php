<?php 


function get_user_by_sms_activity($type,$con){
    $user_list = array();
     $query = "SELECT * FROM features where feature_name='".$type."'";
    $feature_result =  mysqli_fetch_object(mysqli_query($con, $query));
    if (!$feature_result) {
        //echo "Error: " . mysqli_error($con);
    }
    $feauture = $feature_result->feature_id;
     $user_permission_query = 'SELECT * FROM `user_permissions` where status = 1 AND `feature_id` ='.$feauture;
    $permission_result =  mysqli_query($con, $user_permission_query);
    while($user_permission = mysqli_fetch_object($permission_result)){
       $user_id = $user_permission->user_id;
         $user_query = 'SELECT * FROM `user` where`user_id` ='.$user_id;
        $user_result =  mysqli_query($con, $user_query);
        while($user = mysqli_fetch_object($user_result)){
            $user_list[] = $user;
            
        }
    }

 
   
    return $user_list;
 
}


function get_user_by_access($type,$con,$userId,$roleId){
    $user_list = array();
    $query = "SELECT * FROM features where feature_name='".$type."'";
    $feature_result =  mysqli_fetch_object(mysqli_query($con, $query));
    if (!$feature_result) {
        //echo "Error: " . mysqli_error($con);
    }
    $feature = $feature_result->feature_id;
    $user_permission_query = 'SELECT * FROM `user_permissions` where user_id="'.$userId.'" AND `feature_id` ='.$feature;
    $permission_result =  mysqli_query($con, $user_permission_query);
    //print_r($permission_result); exit;
    if($permission_result->num_rows == 0){
        $user_permission_query = 'SELECT * FROM `role_permissions` where `role_id` = '.$roleId.' AND `feature_id` ='.$feature;
        $permission_result =  mysqli_query($con, $user_permission_query);
    }
    

    
   
    $role_permission = mysqli_fetch_object($permission_result);
    if($role_permission->status == 1){
        return true;
    }else{
        return false;
    }
   
 
}



function get_user_by_question($question_key,$con){
   
    $user_list = array();
    $final_user_list = array();
    $query = "SELECT * FROM user where 1";
    $users_result =  mysqli_query($con, $query);
    if (!$users_result) {
        //echo "Error: " . mysqli_error($con);
    }
    while ($user = mysqli_fetch_object($users_result)) {
        $department = json_decode($user->department);
        
        foreach($department as $row){
            foreach($row as $r){
              $keyvalue = explode(',',$r);
              foreach($keyvalue as $k){
                if($k === $question_key){
                    $final_user_list[] = $user;
                }
              }
            }

        }
    }
    return $final_user_list;
 
}


 