<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
 
$user_id = $_REQUEST['user_id'];
$oldpassword = $_REQUEST['old_password'];
$newpassword = $_REQUEST['new_password'];
if($user_id!="" && $oldpassword!="" && $newpassword!="")
{
    if (check_old_password($user_id,$oldpassword)) 
    {
        $user = change_password($user_id,$newpassword);
    
    	if ($user != false) 
    	{
    		$response["status"] = "200";
    		$response["msg"] = "Password changed successfully";
    		echo json_encode($response);
    	} 
    	else 
    	{ 
    		$response["status"] = "400";
    		$response["msg"] = "error"; 
    		echo json_encode($response); 
    	} 
    } 
    else 
    {
        $response["status"] = "400";
        $response["msg"] = "Old password does not match";
        echo json_encode($response);
    	
    }
}
else
{
    $response["status"] = "400";
	$response["msg"] = "parameter missing"; 
	echo json_encode($response);
} 
?>