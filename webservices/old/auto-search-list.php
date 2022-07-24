<?php
session_start();
require_once 'include/DB_Functions.php';
  
$userId =  $_REQUEST['userId']; 
if($userId != '')
{
    $typesql2 = mysqli_query($conn,"SELECT * FROM searchrecords where user_id ='".$userId."' and searchedtext!=''");
    $no_of_rows = mysqli_num_rows($typesql2);
    if ($no_of_rows > 0) 
    {
        $response["status"] = "200";
        $response["msg"] = "Success"; 
        $response["data"] = array(); 
        while($fetch1 = mysqli_fetch_array($typesql2))
        {  
             
            $bussiness['name'] = $fetch1['searchedtext'];  
    		$bussiness['id'] = $fetch1['id']; 
             
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
}
else
{
    $response["status"] = "401";
    $response["msg"] = "Parameter missing";
    echo json_encode($response);
} 
    
 
?>