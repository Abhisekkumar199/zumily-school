<?php
session_start();
require_once 'include/DB_Functions.php';
  
  
$order = $_REQUEST['order'];
$sql = mysqli_query($conn,"SELECT * FROM `hours` where hour_id != '1'");
if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["time"] = $fetch['timing'];
        $flyer["format"] = $fetch['format'];  
        array_push($response["data"], $flyer);
    }  
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No flyer found";
    echo json_encode($response);
} 
 
?>