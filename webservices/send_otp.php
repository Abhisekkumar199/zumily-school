<?php
require_once 'include/DB_Functions.php'; 

$CompanyEmail="info@zumily.com"; 

$mobile_no=$_REQUEST['mobile_no']; 
$datetime = $_REQUEST['datetime']; 
$otp = mt_rand(100000, 999999);



$sqlfil=mysqli_query($conn,"update `users` set mobile_otp='".$otp."',last_updated='".$datetime."' where  mobile_no='".$mobile_no."'"); 
 
$message="Welcome to Zumily School! Your OTP is  ".$otp;  
send_otp($mobile_no,$message);


$response["status"] = "200";
$response["msg"] = "OTP has been sent";
echo json_encode($response);
 