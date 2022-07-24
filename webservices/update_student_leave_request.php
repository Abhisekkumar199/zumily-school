<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
  
//$approved_by = $_REQUEST['approved_by']; 
$request_status = $_REQUEST['request_status']; 
$comments = $_REQUEST['comments']; 
$student_leave_request_id = $_REQUEST['student_leave_request_id']; 
$datetime = $_REQUEST['datetime']; 
 

 mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
if ($student_leave_request_id != '') 
{	
    
    $sql_check = mysqli_fetch_assoc(mysqli_query($conn,"select  read_by from student_leave_requests where student_leave_request_id='".$student_leave_request_id."'"));
    $read_by = $sql_check['read_by'];
    if($read_by == '')
    {
         mysqli_query($conn,"update student_leave_requests set approved_by='T',comment='".$comments."',request_status='".$request_status."',last_updated='".$datetime."',read_by='T',read_datetime='".$datetime."' where student_leave_request_id='".$student_leave_request_id."'"); 
    }
    else
    {
         mysqli_query($conn,"update student_leave_requests set approved_by='T',comment='".$comments."',request_status='".$request_status."',last_updated='".$datetime."' where student_leave_request_id='".$student_leave_request_id."'");
    
    }
    
    $response["status"] = "200";
    $response["msg"] = "Success";   
    echo json_encode($response);
} 
else
{  
    $response["status"] = "400";
    $response["msg"] = "Parameter missing";
    echo json_encode($response); 
}
?>