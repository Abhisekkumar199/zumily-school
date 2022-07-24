<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$userId = $_REQUEST['userId'];   
$sql = mysqli_query($conn,"SELECT * FROM `listings` WHERE `user_id` = '".$userId."' "); 
if(mysqli_num_rows($sql) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";  
    $response["totalCount"] = mysqli_num_rows($sql); 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sql))
    {
        $flyer["listingId"] = $fetch['listing_id'];
        $flyer["contactPerson"] = $fetch['contact_person_name'];  
	    $flyer["contactPersonNumber"] = $fetch['contact_person_number']; 
        $flyer["address"] = $fetch['address1'];  
        
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