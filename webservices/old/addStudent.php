<?php
session_start();
require_once 'include/DB_Functions.php';
  
$user_id = $_REQUEST['userId'];
$studentId = $_REQUEST['studentId']; 
$fname = ucwords($_REQUEST['fname']); 
$mname = ucwords($_REQUEST['mname']); 
$lname = ucwords($_REQUEST['lname']); 
$class = $_REQUEST['class'];
$schoolyear = $_REQUEST['schoolyear'];
$mobileno = $_REQUEST['mobileno'];
$emailid = $_REQUEST['emailid'];
$fathername = ucwords($_REQUEST['fathername']);
$fatheremail = $_REQUEST['fatheremail'];
$fmobileno = $_REQUEST['fmobileno']; 
$mmobileno = $_REQUEST['mmobileno'];   

if ($user_id != '' && $studentId != '' && $fname != '') 
{ 
    if($_REQUEST['id'] == '')
    {
        
        $sqluserIdCheck = mysqli_query($conn,"select * from users where email_id='".$emailid."'");
		if(mysqli_num_rows($sqluserIdCheck) > 0)
		{
		    $sqlstudentUserId = mysqli_fetch_assoc($sqluserIdCheck);
		    $studentUserId = $sqlstudentUserId['user_id'];
		    $studentLoginStatus = $sqlstudentUserId['displayflag'];
		}
		else
		{
		    mysqli_query($conn,"insert into users set  email_id='".$_REQUEST['emailid']."',displayflag='0',progress_status='system_created',is_verified='0'");
		    $studentUserId = mysql_insert_id();
		    $studentLoginStatus = '0';
		}
		
		
		$sqluserIdCheck1 = mysqli_query($conn,"select * from users where email_id='".$fatheremail."'");
		if(mysqli_num_rows($sqluserIdCheck1) > 0)
		{
		    $sqlstudentUserId1 = mysqli_fetch_assoc($sqluserIdCheck1);
		    $fatherUserId = $sqlstudentUserId1['user_id'];
		    $fatherLoginStatus = $sqlstudentUserId1['displayflag'];
		}
		else
		{
		    mysqli_query($conn,"insert into users set  email_id='".$_REQUEST['emailid']."',displayflag='0',progress_status='system_created',is_verified='0'");
		    $fatherUserId = mysqli_insert_id($conn); 
		    $fatherLoginStatus = 0;
		}  
        
        $upd_query=mysqli_query($conn,"insert into `student` SET `student_user_id`='".$studentUserId."',`fatherUserId`='".$fatherUserId."',`student_login_status`='".$studentLoginStatus."',`father_login_status`='".$fatherLoginStatus."',`school_id`='".$user_id."',`student_id`='".$studentId."',`first_name`='".$fname."', `middle_name`='".$mname."', `last_name`='".$lname."', `class`='".$class."', `school_year`='".$schoolyear."', `mobileno`='".$mobileno."', `emailid`='".$emailid."',`fathername`='".$fathername."',`fatheremail`='".$fatheremail."',`fmobileno`='".$fmobileno."',`mmobileno`='".$mmobileno."',`adddate`='".date("Y-m-d")."'");  
      
    }
    else
    {
      $upd_query=mysqli_query($conn,"UPDATE `student` SET `student_id`='".$studentId."',`first_name`='".$fname."', `middle_name`='".$mname."', `last_name`='".$lname."', `class`='".$class."', `school_year`='".$schoolyear."', `mobileno`='".$mobileno."', `emailid`='".$emailid."',`fathername`='".$fathername."',`fatheremail`='".$fatheremail."',`fmobileno`='".$fmobileno."',`mmobileno`='".$mmobileno."',`editdate`='".date("Y-m-d")."' WHERE `id` = '".$_REQUEST['id']."'"); 
    } 
    
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
    
 
?>