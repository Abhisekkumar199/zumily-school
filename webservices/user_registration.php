<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");

$CompanyEmail="info@zumily.com"; 
$fname = $_REQUEST['first_name']; 
$lname = $_REQUEST['last_name'];
$email = $_REQUEST['email_id']; 
$datetime = $_REQUEST['datetime']; 
 
 
$hash=base64_encode($email);
$password = $_REQUEST['password']; 
$country_code = strtoupper($_REQUEST['country_code']);   
$mobile_no = $_REQUEST['mobile_no'];
if($country_code == 'INDIA' or $country_code == 'IN')
{
    if($mobile_no!="")
    {
        if($email != '')
        {
            if (is_user_email_exist($email)) 
            {
                $response["status"] = "400";
                $response["msg"] = "Email address already in use";
                echo json_encode($response);
                exit();
            } 
        }
        
        if (is_user_mobile_exist($mobile_no)) 
        {
            $response["status"] = "400";
            $response["msg"] = "Phone no already in use";
            echo json_encode($response);
            exit();
        } 
         
        else 
        {
            if (is_user_exist($email,$mobile_no)) 
            {
                $user = update_user1($fname,$lname,$email, $password, $mobile_no,$country_code,$datetime);
            }
            else
            {
                $user = store_user($fname,$lname,$email, $password, $mobile_no,$country_code,$datetime);
            }
            
            
            $otp = mt_rand(100000, 999999);
            $sqlfil=mysqli_query($conn,"update `users` set mobile_otp='".$otp."',last_updated='".$datetime."' where  mobile_no='".$mobile_no."'"); 
             
           
            
            
           $message="Welcome to Zumily School! Your OTP is  ".$otp;  
            send_otp($mobile_no,$message);

            if ($user) 
            { 
                $response["status"] = "200";
                $response["msg"] = "Success";
                $response["user"]["user_id"] = $user["user_id"];
                $response["user"]["first_name"] = $user["first_name"];
                $response["user"]["last_name"] = $user["last_name"];
                $response["user"]["email_id"] = $user["email_id"];  
                $response["user"]["mobile_no"] = $user["mobile_no"];  
                echo json_encode($response);
                
                if($email!= '')
                {
                    $hash=base64_encode($email);  
                    if($user["is_teacher"] == 1)
                    {
                        include("signup_teacher_mail.php");  
                    }
                    else
                    {
                        include("signup_parent_mail.php");  
                    } 
        		    send_mail($toc, $subjectc, $messagec, $headers1, $fromc, ''); 
                }
                
            } 
            else 
            {
                $response["status"] = "400";
                $response["msg"] = "Error occurred in Registration";
                echo json_encode($response);
            }
        }
    }
    else
    {
    $response["status"] = "400";
    $response["msg"] = "Please fill all required field";
    echo json_encode($response);
    }
}
else
{
    if($email!="")
    {
        if($email != '')
        {
            if (is_user_email_exist($email)) 
            {
                $response["status"] = "400";
                $response["msg"] = "Email address already in use";
                echo json_encode($response);
                exit();
            } 
        }
        
        if($mobile_no != '')
        {
            if (is_user_mobile_exist($mobile_no)) 
            {
                $response["status"] = "400";
                $response["msg"] = "Phone no already in use";
                echo json_encode($response);
                exit();
            } 
        } 
        
        $user = store_user($fname,$lname,$email, $password, $mobile_no,$country_code,$datetime);
        
        
        
        if ($user) 
        { 
            $response["status"] = "200";
            $response["msg"] = "Success";
            $response["user"]["user_id"] = $user["user_id"];
            $response["user"]["first_name"] = $user["first_name"];
            $response["user"]["last_name"] = $user["last_name"];
            $response["user"]["email_id"] = $user["email_id"];  
            echo json_encode($response); 
            
            if($email!= '')
            {
                $hash=base64_encode($email); 
                $contact_person = $user["first_name"];
                if($user["is_teacher"] == 1)
                {
                    include("signup_teacher_mail.php");  
                }
                else
                {
                    include("signup_parent_mail.php");  
                } 
    		    send_mail($toc, $subjectc, $messagec, $headers1, $fromc, ''); 
            } 
        } 
        else 
        {
            $response["status"] = "400";
            $response["msg"] = "Error occurred in Registration";
            echo json_encode($response);
        }
        
    }
    else
    {
    $response["status"] = "400";
    $response["msg"] = "Please fill all required field";
    echo json_encode($response);
    }
}

