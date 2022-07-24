<?php
session_start();
require_once 'include/DB_Functions.php';
 
$userId = $_REQUEST['userId'];   
$sql = mysqli_query($conn,"SELECT * FROM `student` WHERE `school_id` = '".$userId."' ORDER By `id` desc");
if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["id"] = $fetch['id'];
        $flyer["name"] = $fetch['first_name']." ".$fetch['middle_name']." ".$fetch['last_name'];
        $flyer["mobileno"] = $fetch['mobileno'];
        $flyer["emailid"] = $fetch['emailid'];
        $flyer["class"] = $fetch['class'];
        $flyer["fathername"] = $fetch['fathername'];
        $flyer["fatheremail"] = $fetch['fatheremail'];
        $flyer["fmobileno"] = $fetch['fmobileno']; 
        array_push($response["data"], $flyer);
    }  
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Record found";
    echo json_encode($response);
} 
 
?>