<?php
require_once 'include/DB_Functions.php'; 
 
 
$mobileno=$_REQUEST['mobile_no']; 
$password=$_REQUEST['password']; 
$otp = $_REQUEST['otp']; 
$datetime = $_REQUEST['datetime']; 
$fcm_key= $_REQUEST['fcm_key']; 
 
$sql=mysqli_query($conn,"select * from `users` where mobile_no='".$mobileno."' and mobile_otp='".$otp."'");

if($rows=mysqli_fetch_assoc($sql))
{		
    if($password !=NULL)
    {
        $sqlfil=mysqli_query($conn,"update `users` set is_mobile_verified=1,is_verified='1',last_updated='".$datetime."',fcm_key='".$fcm_key."',password='".md5($password)."'  where  mobile_no='".$mobileno."' and mobile_otp='".$otp."'");  
    }
    else
    {
        $sqlfil=mysqli_query($conn,"update `users` set is_mobile_verified=1,is_verified='1',last_updated='".$datetime."',fcm_key='".$fcm_key."' where  mobile_no='".$mobileno."' and mobile_otp='".$otp."'");  
    }
	$response["status"] = "200";
    $response["msg"] = "Success";
    $response["user_id"] = $rows['user_id']; 
    $response["session_id"] = "1";
    
    
    
    $teacher_types = $rows['teacher_types'];
    if(strpos($teacher_types, 'CT') !== false) 
    {
        $response["teacher_type"] = 'CT';
    }
    else if(strpos($teacher_types, 'ST') !== false) 
    {
        $response["teacher_type"] = 'ST';
    }
    else
    {
        $response["teacher_type"] = '';
    }
     
    $user_types = $rows['user_types'];
    if(strpos($user_types, 'T') !== false  and (strpos($user_types, 'P') !== false  or strpos($user_types, 'S') !== false)) 
    {  
        $response["user_type"] = 'B';
        $sql_teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `teacher_user_xref`  WHERE user_id = '".$rows["user_id"]."' and is_active='1' ")); 
        $response["teacher_id"] = $sql_teacher['teacher_id'];
        $response["school_id"] = $sql_teacher['school_id'];
    }
    else if(strpos($user_types, 'T') !== false ) 
    { 
        $sql_teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `teacher_user_xref`  WHERE user_id = '".$rows["user_id"]."' and is_active='1' "));
        $response["user_type"] = 'T';
        $response["teacher_id"] = $sql_teacher['teacher_id'];
        $response["school_id"] = $sql_teacher['school_id'];
    }
    else if(strpos($user_types, 'P') !== false  or strpos($user_types, 'S') !== false) 
    { 
        
        $sql_student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `student_user_xref`  WHERE user_id = '".$rows["user_id"]."' and is_active='1' "));
        $response["user_type"] = 'P';
        $response["school_id"] = $sql_student['school_id'];
        $response["teacher_id"] = '';
    }
    else
    {
        
        $sql_student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM  `student_user_xref`  WHERE user_id = '".$rows["user_id"]."' and is_active='1' "));
        $response["user_type"] = 'N';
        $response["school_id"] = $sql_student['school_id'];
        $response["teacher_id"] = '';
    } 
     
    
    echo json_encode($response);	
}
else
{ 
	$response["status"] = "400";
    $response["msg"] = "Invalid OTP!";
    echo json_encode($response);
}



 