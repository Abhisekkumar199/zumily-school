<?php
session_start();
require_once 'include/DB_Functions.php';
 
$userId = $_REQUEST['userId'];   
$cmpdate =  strtotime($_REQUEST["currentDate"]);  
$status = $_REQUEST['status'];
$order = $_REQUEST['order'];

if($status == "all")
{ 
    $sql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `user_id` = '".$userId."' AND type='E'   ORDER By `end_date` desc");   
}
else if($status == "active")
{ 
    $sql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `user_id` = '".$userId."' AND type='E' AND (start_date<='".$cmpdate."' and `end_date`>='".$cmpdate."') ORDER By `end_date` desc"); 
}
else if($status == "upcoming")
{ 
    $sql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `user_id` = '".$userId."' AND type='E' AND `start_date` > '$cmpdate' ORDER By `end_date` desc"); 
}
else if($status == "expired")
{ 
    $sql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `user_id` = '".$userId."' AND type='E'  AND `end_date` < '$cmpdate' ORDER By `end_date` desc");  
}


if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["eventId"] = $fetch['flyer_id'];
        $flyer["eventName"] = $fetch['flyer_name'];
         
        $flyer["startDate"] = date("D, M d, Y",$fetch['start_date']); 
        $flyer["endDate"] = date("D, M d, Y",$fetch['end_date']);
        $flyer["deliveryDate"] = date("D, M d, Y",$fetch['delivery_date']);
        
        $flyer["totalView"] = $fetch['totalViews'];
        $flyer["totalLike"] = $fetch['totalLikes'];  
        
         
        array_push($response["data"], $flyer);
    }  
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No event found";
    echo json_encode($response);
} 
 
?>