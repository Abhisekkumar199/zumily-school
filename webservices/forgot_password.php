<?php 
require_once 'include/DB_Functions.php';
 
@include("include/mailfunction.php");
$user_id = $_REQUEST['user_id'];
$CompanyEmail="info@zumily.com"; 

$result = mysqli_query($conn,"SELECT * FROM users WHERE email_id = '$user_id'") or die(mysql_error());  
$result2 = mysqli_query($conn,"SELECT * FROM users WHERE mobile_no = '$user_id' and mobile_no !='0'") or die(mysql_error()); 
// check for result  
$no_of_rows = mysqli_num_rows($result); 
$otp = mt_rand(100000, 999999);

if ($no_of_rows > 0) 
{ 
    $result1 = mysqli_fetch_array($result);  
    $resultsdf = mysqli_query($conn,"update users set mobile_otp='$otp' WHERE email_id = '".$user_id."'") or die(mysql_error());  
    
    $emailid = $user_id;
	$username = $result1['first_name'];
	include("forgot_password_mail.php");
	send_mail($toc, $subjectc, $messagec, $headers1, $fromc, ''); 
    $response["status"] = "200";
    $response["type"] = "email"; 
    $response["user_id"] = $user_id;
    $response["msg"] = "Email has been sent successfully ! Please check your mail.";  
    echo json_encode($response); 
}
else if(mysqli_num_rows($result2) > 0)
{
    
    $sqlfil=mysqli_query($conn,"update `users` set mobile_otp='".$otp."' where  mobile_no='".$user_id."'"); 
     
    $message="Welcome to Zumily School! Your OTP is  ".$otp;  
    send_otp($user_id,$message);
    
    
    $response["status"] = "200";
    $response["type"] = "mobile";
    $response["user_id"] = $user_id;
    $response["msg"] = "OTP has been sent on your registered mobile no";
    echo json_encode($response);
}
else 
{ 
    $response["status"] = "400"; 
	$response["msg"] = "Email/Mobile no does't exist!"; 
	echo json_encode($response); 
} 

?>	
	

