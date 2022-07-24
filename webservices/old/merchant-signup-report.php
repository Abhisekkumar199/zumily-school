<?php
session_start();
require_once 'include/DB_Functions.php';
   
$userId =  $_REQUEST['userId'];   

$sql = mysqli_query($conn,"SELECT * FROM `users` WHERE `sales_person_id` = '".$userId."' ORDER By `user_id` desc"); 
$sql2 = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `sales_person_id` = '".$userId."' and MONTH(date_created) = MONTH(CURRENT_DATE()) AND YEAR(date_created) = YEAR(CURRENT_DATE()) ORDER By `user_id` desc"));
$sql3 = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `users` WHERE `sales_person_id` = '".$userId."' and YEARWEEK(`date_created`, 1) = YEARWEEK(CURDATE(), 1) ORDER By `user_id` desc"));  
  
if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["totalLifetime"] = mysqli_num_rows($sql);
    $response["totalthismonth"] = $sql2;
    $response["totalthiweek"] = $sql3; 
    $response["data"] = array(); 
    while($fetch = mysqli_fetch_array($sql))
    { 
        $bussiness["bussinessId"] = $fetch['user_id'];
        $bussiness["bussinessName"] = $fetch['business_name'];
        $bussiness["name"] = $fetch['first_name']." ".$fetch['last_name']; 
        $bussiness["email"] = $fetch['email_id'];
        $bussiness["phone"] = $fetch['phone'];
        $bussiness["totalFollowers"] = $fetch['total_followers'];  
        
        array_push($response["data"], $bussiness);
      }   
    echo json_encode($response);  
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Bussiness found";
    echo json_encode($response);
}
    
 
?>