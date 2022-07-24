<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
 
$otp = $_REQUEST['otp']; 
$emailId = $_REQUEST['user_id'];
$type = $_REQUEST['type'];
$password = $_REQUEST['password']; 
if($emailId!="" && $password!="" && $otp!="")
{    
        if (checkOtp($otp,$emailId,$type)) 
        { 
            $user = resetPassword($emailId,$password,$type); 
        	if ($user != false) 
        	{
        		$response["status"] = "200";
        		$response["msg"] = "Success";
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
    		$response["msg"] = "Wrong OTP"; 
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

	
	
	

