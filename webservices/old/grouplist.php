<?php
session_start();
require_once 'include/DB_Functions.php';
 
$userId = $_REQUEST['userId'];   
$sql = mysqli_query($conn,"SELECT * FROM `groups` WHERE `user_id` = '".$userId."' ORDER By `id` desc");
if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["id"] = $fetch['id']; 
        $flyer["title"] = $fetch['title'];
        $flyer["totalmember"] = $fetch['totalmember'];
        $flyer["adddate"] = $fetch['adddate']; 
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