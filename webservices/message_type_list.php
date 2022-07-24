<?php
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
  
 
$sql = mysqli_query($conn,"SELECT * FROM  `message_types` ORDER BY message_type_id asc");  
 
if (mysqli_num_rows($sql) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";   
    $response["data"] = array();
    while($rows = mysqli_fetch_array($sql))
    {    
        $message_type["message_type_id"] = $rows['message_type_id'];  
        $message_type["display_name"] = $rows['display_name'];  
        array_push($response["data"], $message_type);
    }  
    echo json_encode($response);
} 
else
{ 
    if($startIndex > $totalcount)
    {
        $response["status"] = "300";
        $response["msg"] = "";
        echo json_encode($response);
    }
    else
    {
        $response["status"] = "400";
        $response["msg"] = "No record found";
        echo json_encode($response);
    }
     
}
?>