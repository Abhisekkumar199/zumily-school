<?php

require_once 'include/DB_Functions.php';


$userId = $_REQUEST['userId'];    
$fetch = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id` = '".$userId."' "));
$catname = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `categories` WHERE `category_id` = '".$fetch['category_id']."'")); 
$response["status"] = "200";
$response["msg"] = "Success";   
 
$response["userId"] = $fetch["user_id"];
$response["businessName"] = $fetch["business_name"];
$response["category"] = $catname["display_name"];
$response["description"] = $fetch["discription"];  
if($fetch['business_logo'] != '')
{
    $response["bussinessLogo"]="https://www.zumily.com/uploadimages/merchantimages/".$fetch['business_logo']; 
}
else
{
    $response["bussinessLogo"]="https://www.zumily.com/images/name.png";
}
         
echo json_encode($response); 
 