<?php
session_start();
require_once 'include/DB_Functions.php';
 
$userId = $_REQUEST['userId'];   
$totalfollower=mysqli_num_rows(mysqli_query($conn,"select * from `my_favorites` where listing_id='".$userId."' group by user_id")); 
$response["status"] = "200";
$response["msg"] = "Success"; 
$response["totalfollower"] = $totalfollower; 
     
    echo json_encode($response);
 
 
?>