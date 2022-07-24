<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  

$sql = mysqli_query($conn,"SELECT * FROM `hours`"); 

$no_of_rows = mysqli_num_rows($sql);
if ($no_of_rows > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";   
    $response["data"] = array();
    while($rows = mysqli_fetch_array($sql))
    {   
        $flyer["value"] = $rows['timing']; 
        $flyer["format"] = $rows['format'];  
        array_push($response["data"], $flyer);
    }  
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Message found";
    echo json_encode($response);
}
 
?>