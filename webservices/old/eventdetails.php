<?php
session_start();
require_once 'include/DB_Functions.php';
 
$id = $_REQUEST['id'];  
  
$sql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `flyer_id` = '".$id."'"); 
    
    
 

if(mysqli_num_rows($sql) > 0)
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    while($fetch = mysqli_fetch_array($sql))
    {
        $response["flyer"]["flyerId"] = $fetch['flyer_id'];
        $response["flyer"]["eventName"] = $fetch['flyer_name'];
        $response["flyer"]["eventDesc"] =  $fetch['flyer_desc'];
        $response["flyer"]["startDate"] = date("D, M d, Y",$fetch['start_date']);
        $response["flyer"]["startTime"] =  $fetch['starttime'];
        
        $response["flyer"]["endDate"] = date("D, M d, Y",$fetch['end_date']);
        $response["flyer"]["endTime"] =  $fetch['endtime'];
        $response["flyer"]["deliveryDate"] = date("D, M d, Y",$fetch['delivery_date']);
        
        $response['images'] = array();
        
        $queryimage=mysqli_query($conn,"select * from `flyer_images` where `flyer_id` ='".$id."' order by display_order asc");
        while($rowimage = mysqli_fetch_assoc($queryimage))
        {
            $imageUrl = 'https://www.zumily.com/uploadimages/eventimage/'.$rowimage['flyer_image_name'];
            $flyerimage["imageId"] = $rowimage['flyer_image_id'];
            $flyerimage["imagetype"] = "2";
            $flyerimage["imageurl"] = $imageUrl; 
            array_push($response["images"], $flyerimage);
        }
        
          
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