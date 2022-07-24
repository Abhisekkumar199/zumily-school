<?php
session_start();
require_once 'include/DB_Functions.php';
 
$userId = $_REQUEST['sales_person_id'];   
     
$sql = mysqli_query($conn,"SELECT * FROM `users` WHERE `sales_person_id` = '".$userId."' ORDER By `user_id` desc"); 
  

if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["userId"] = $fetch['user_id'];
        $flyer["firstName"] = $fetch['first_name'];
        $flyer["lastName"] = $fetch['last_name']; 
        $flyer["emailId"] = $fetch['email_id'];
        $flyer["password"] = $fetch['password']; 
        $usertypeid = $fetch['listing_type_id']; 
        $sqlaccounttype = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `Account_types` WHERE `id` = '".$usertypeid."' "));
        $flyer["accountType"] = $sqlaccounttype['display_name'];
         
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