<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$id = $_REQUEST['listingId'];   
$sql = mysqli_query($conn,"SELECT * FROM `listings` WHERE `listing_id` = '".$id."' "); 
if(mysqli_num_rows($sql) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";  
    
    $fetch = mysqli_fetch_array($sql);
    
    $response["contactPerson"] = $fetch['contact_person_name'];  
    $response["contactPersonNumber"] = $fetch['contact_person_number']; 
    $response["address"] = $fetch['address1']; 
    $response["data"] = array();
    
	    $flyer["day"] = 'MON'; 
        $flyer["starttime"] = $fetch['monopen_time'];  
        $flyer["endtime"] = $fetch['monclose_time'];  
        $flyer["starttime1"] = $fetch['monopen_time1']; 
        $flyer["endtime1"] = $fetch['monclose_time1'];  
        array_push($response["data"], $flyer);
        
        $flyer["day"] = 'TUE'; 
        $flyer["starttime"] = $fetch['tueopen_time'];  
        $flyer["endtime"] = $fetch['tueclose_time'];  
        $flyer["starttime1"] = $fetch['tueopen_time1'];  
        $flyer["endtime1"] = $fetch['tueclose_time1'];  
        array_push($response["data"], $flyer);
        
        $flyer["day"] = 'WED';  
        $flyer["starttime"] = $fetch['wedopen_time'];  
        $flyer["endtime"] = $fetch['wedclose_time'];  
        $flyer["starttime1"] = $fetch['wedopen_time1'];  
        $flyer["endtime1"] = $fetch['wedclose_time1']; 
        array_push($response["data"], $flyer);
        
        $flyer["day"] = 'THU'; 
        $flyer["starttime"] = $fetch['thuopen_time'];  
        $flyer["endtime"] = $fetch['thuclose_time'];  
        $flyer["starttime1"] = $fetch['thuopen_time1'];  
        $flyer["endtime1"] = $fetch['thuclose_time1'];   
        array_push($response["data"], $flyer);
        
        
        $flyer["day"] = 'FRI'; 
        $flyer["starttime"] = $fetch['friopen_time'];  
        $flyer["endtime"] = $fetch['friclose_time'];  
        $flyer["starttime1"] = $fetch['friopen_time1'];  
        $flyer["endtime1"] = $fetch['friclose_time1'];  
        array_push($response["data"], $flyer);
        
        $flyer["day"] = 'SAT'; 
        $flyer["starttime"] = $fetch['satopen_time'];  
        $flyer["endtime"] = $fetch['satclose_time'];  
        $flyer["starttime1"] = $fetch['satopen_time1'];  
        $flyer["endtime1"] = $fetch['satclose_time1'];
        array_push($response["data"], $flyer);
        
        $flyer["day"] = 'SUN'; 
        $flyer["starttime"] = $fetch['sunopen_time'];  
        $flyer["endtime"] = $fetch['sunclose_time'];  
        $flyer["starttime1"] = $fetch['sunopen_time1'];  
        $flyer["endtime1"] = $fetch['sunclose_time1'];
        
        array_push($response["data"], $flyer);
      
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Record found";
    echo json_encode($response);
}
 
?>