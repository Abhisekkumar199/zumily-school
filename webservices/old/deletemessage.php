<?php
session_start();
require_once 'include/DB_Functions.php';
    
$id = $_REQUEST['id']; 
 
if($id != '') 
{  
    mysqli_query($conn,"delete from flyer_message_student where messageId='".$id."'");
    $query=mysqli_query($conn,"delete from `flyer` where flyer_id='".$id."'");  
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);  
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "error";
    echo json_encode($response);
}
    
 
?>