<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("../includes/libraries/mailfunction.php");

 
$email = $_REQUEST['email'];
$hash=base64_encode($email); 
$mobile = '';
if($email!="")
{
    if (isUserExisted($email,$mobile)) 
    {
        if (isUserVerified($email)) 
        {
            $response["status"] = "400";
            $response["linkactive"] = "0";
            $response["msg"] = "This Account  has already been verified!";
            echo json_encode($response);  
            
        }
        else
        {
            $sql1=mysqli_query($conn,"select * from `users` WHERE email_id='".$email."'");
            $user = mysqli_fetch_assoc($sql1); 
    	    $emailid=$user['email_id']; 
            $username = $user['first_name'];
            $hash=base64_encode($emailid); 
            include("verification-mail.php");
            
            send_mail($toc, $subjectc, $messagec, $headers1, $fromc, '');  
            $response["status"] = "200";
            $response["msg"] = "Success"; 
            echo json_encode($response); 
        }
    } 
    else 
    {
        $response["status"] = "400";
        $response["msg"] = "Email Address does not exist!";
        echo json_encode($response); 
    }
}
else
{
$response["status"] = "400";
$response["msg"] = "Parameter missing";
echo json_encode($response);
}