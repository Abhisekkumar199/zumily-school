<?php
session_start();
require_once 'include/DB_Functions.php';
 
$id = $_REQUEST['id'];   
$sql = mysqli_query($conn,"SELECT * FROM `student` WHERE `id` = '".$id."' ORDER By `id` desc");
if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success";  
    $fetch = mysqli_fetch_array($sql);
        $response["details"]["id"] = $fetch['id'];
        $response["details"]["first_name"] = $fetch['first_name'];
        $response["details"]["middle_name"] = $fetch['middle_name'];
        $response["details"]["last_name"] = $fetch['last_name']; 
        $response["details"]["student_id"] = $fetch['student_id'];
        $response["details"]["class"] = $fetch['class'];
        $response["details"]["school_year"] = $fetch['school_year'];
        $response["details"]["mobileno"] = $fetch['mobileno'];
        $response["details"]["emailid"] = $fetch['emailid']; 
        $response["details"]["fathername"] = $fetch['fathername'];
        $response["details"]["fatheremail"] = $fetch['fatheremail'];
        $response["details"]["fmobileno"] = $fetch['fmobileno'];  
        $response["details"]["mmobileno"] = $fetch['mmobileno'];  
        
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Record found";
    echo json_encode($response);
} 
 
?>