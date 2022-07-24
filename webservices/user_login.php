<?php 
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 

$email = $_REQUEST['user_id']; 
$password = $_REQUEST['password'];  
$fcm_key = $_REQUEST['fcm_key']; 

$sql1=mysqli_query($conn,"select * from `users` WHERE (email_id='".$email."' or mobile_no='".$email."')");
$rows = mysqli_fetch_assoc($sql1);
$country_code = $rows['country_code'];  
$phone = $rows['mobile_no'];  
$emailid1 = $rows['email_id']; 
$is_verified = $rows['is_verified']; 
 
if($email == $phone)
{ 
    $type1= "mobile";  
}
else if($email == $emailid1)
{  
    $type1= "email"; 
} 

$type= "Email/Mobile no.";  
if(check_if_user_exists($email)) 
{ 
    if (check_if_password_exist($email)) 
    {
        if (check_if_password_is_correct($email,$password)) 
        {
            if (check_if_user_verified($email)) 
            { 
                
                 
                $user = get_user_detail($email);
                if ($user != false) 
                { 
                    $user1 = mysqli_query($conn,"UPDATE `users` SET  `latitude`= '$latitude',`longitude`= '$longitude',`fcm_key`= '$fcm_key' WHERE user_id='".$user['user_id']."'");
                    $response["status"] = "200";
                    $response["linkactive"] = "1";
                    $response["msg"] = "Success";
                    $response["type"] = $type1;
                    

                    $response["user"]["user_id"] = $user["user_id"];  
                    $response["user"]["first_name"] = $user["first_name"];
                    $response["user"]["last_name"] = $user["last_name"]; 
                    $response["user"]["email_id"] = $user["email_id"]; 
                    $response["user"]["mobile_no"] = $user["mobile_no"];
                    $response["user"]["user_gender"] = $user["user_gender"];
                    $response["user"]["user_dob"] = $user["user_dob"]; 
                    $response["user"]["session_id"] = "0";
                    
                    
                    
                    $teacher_types = $user['teacher_types'];
                    if(strpos($teacher_types, 'CT') !== false) 
                    {
                        $response["user"]["teacher_type"] = 'CT';
                    }
                    else if(strpos($teacher_types, 'ST') !== false) 
                    {
                        $response["user"]["teacher_type"] = 'ST';
                    }
                    else
                    {
                        $response["user"]["teacher_type"] = '';
                    }
                     
                    $user_types = $user['user_types'];
                    if(strpos($user_types, 'T') !== false  and (strpos($user_types, 'P') !== false  or strpos($user_types, 'S') !== false)) 
                    {  
                        $response["user"]["user_type"] = 'B';
                        $sql_teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `teacher_user_xref`  WHERE user_id = '".$user["user_id"]."' and is_active='1' ")); 
                        $response["user"]["teacher_id"] = $sql_teacher['teacher_id'];
                        $response["user"]["school_id"] = $sql_teacher['school_id'];
                    }
                    else if(strpos($user_types, 'T') !== false ) 
                    { 
                        $sql_teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `teacher_user_xref`  WHERE user_id = '".$user["user_id"]."' and is_active='1' "));
                        $response["user"]["user_type"] = 'T';
                        $response["user"]["teacher_id"] = $sql_teacher['teacher_id'];
                        $response["user"]["school_id"] = $sql_teacher['school_id'];
                    }
                    else if(strpos($user_types, 'P') !== false  or strpos($user_types, 'S') !== false) 
                    { 
                        
                        $sql_student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `student_user_xref`  WHERE user_id = '".$user["user_id"]."' and is_active='1' "));
                        $response["user"]["user_type"] = 'P';
                        $response["user"]["school_id"] = $sql_student['school_id'];
                    }
                    else
                    {
                        
                        $sql_student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `student_user_xref`  WHERE user_id = '".$user["user_id"]."' and is_active='1' "));
                        $response["user"]["user_type"] = 'N';
                        $response["user"]["school_id"] = $sql_student['school_id'];
                    }
                     
                    if($user['user_image'] != '')
                    {
                        $response["user"]["profilePic"]="https://localhost/project/zumilyschool/assets/uploadimages/userimages/".$user['user_image']; 
                    }
                    else
                    {
                        $response["user"]["profilePic"]="https://localhost/project/zumilyschool/assets/images/name.png";
                    }
                    
                    echo json_encode($response); 
                }  
                 
            }
            else
            {
                
                $sql1=mysqli_query($conn,"select * from `users` WHERE (email_id='".$email."' or mobile_no='".$email."')");
                $rows = mysqli_fetch_assoc($sql1);  
                $phone = $rows['mobile_no'];  
                $emailid1 = $rows['email_id']; 
                $is_verified = $rows['is_verified']; 
                
                $response["status"] = "200";
                $response["linkactive"] = "0";
                $response["type"] = $type1;
                $response["loginid"] = $email; 
                $response["is_password"] = 1;  
                $response["msg"] = "Account is not verified";
                echo json_encode($response); 
            } 
        }
        else
        {
            $response["status"] = "400";  
            $response["linkactive"] = "1";
            $response["type"] = $type1;
            $response["loginid"] = $email; 
            $response["is_password"] = 1; 
            $response["msg"] = "Invalid Userid/Password!";
            echo json_encode($response); 
        }
    }
    else
    {
        $response["status"] = "200";
        $sql1=mysqli_query($conn,"select * from `users` WHERE (email_id='".$email."' or mobile_no='".$email."')");
        $rows = mysqli_fetch_assoc($sql1);  
        $phone = $rows['mobile_no'];  
        $emailid1 = $rows['email_id']; 
        
        $response["linkactive"] = "0";
        $response["type"] = $type1;
        $response["loginid"] = $email; 
        $response["is_password"] = 0;   
        $response["msg"] = "Your account has been created by school. Please enter the OTP, we have sent on your Mobile Number.";
        echo json_encode($response); 
    }
}
else
{
    $response["status"] = "400";  
    $response["linkactive"] = "1";
    $response["type"] = $type1;
    $response["loginid"] = $email;
    $response["is_password"] = 1; 
    $response["msg"] = "$type does not exist!";
    echo json_encode($response); 
}

 