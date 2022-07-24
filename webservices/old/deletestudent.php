<?php
session_start();
require_once 'include/DB_Functions.php';
    
$id = $_REQUEST['id'];  
if($id != '') 
{   
    $query=mysqli_query($conn,"delete from `student` where id='".$id."'");  
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