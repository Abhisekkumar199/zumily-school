<?php

require_once 'include/DB_Functions.php';


$userId = $_REQUEST['userId'];    
$fetch = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id` = '".$userId."' "));
$catname = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `categories` WHERE `category_id` = '".$fetch['category_id']."'")); 


$rowListing=mysqli_fetch_assoc(mysqli_query($conn,"select * from listings where `user_id` = '".$userId."'"));
  


$response["status"] = "200";
$response["msg"] = "Success";   
 
$response["details"]["userId"] = $fetch["user_id"];
$response["details"]["businessName"] = $fetch["business_name"];
$response["details"]["category"] = $catname["display_name"];
$response["details"]["description"] = $fetch["discription"];  

$response["details"]["listingid"] = $rowListing['listing_id'];
$response["details"]["contact_person"] = $rowListing['contact_person_name'];  
$response["details"]["contact_person_number"] = $rowListing['contact_person_number']; 
$response["details"]["address1"] = $rowListing['address1']; 

if($fetch['business_logo'] != '')
{
    $response["details"]["bussinessLogo"]="https://www.zumily.com/uploadimages/merchantimages/".$fetch['business_logo']; 
}
else
{
    $response["details"]["bussinessLogo"]="https://www.zumily.com/images/name.png";
}
         
echo json_encode($response); 
 