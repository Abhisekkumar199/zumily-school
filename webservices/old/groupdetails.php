<?php
session_start();
require_once 'include/DB_Functions.php';
  
$id = $_REQUEST['id']; 
 
$sql = mysqli_query($conn,"SELECT * FROM `groups` WHERE `id` = '".$id."'  ");
$data = mysqli_fetch_array($sql); 
if ($id != '') 
{  
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["details"]["id"] =  $data['id']; 
    $response["details"]["title"] =  $data['title']; 
    $response["details"]["totalmember"] =  $data['totalmember']; 
    $response["details"]["adddate"] =  $data['adddate'];  
    $response['followers'] = array();
    $sqlUser1=mysqli_query($conn,"select * from `users` where user_id IN (".$data['userids'].") order by first_name asc"); 
    while($rowsuser = mysqli_fetch_assoc($sqlUser1))
    {
        $user['userid'] = $rowsuser['user_id'];
        $user['name'] = $rowsuser['first_name']." ".$rowsuser['last_name'];
        array_push($response["followers"], $user);
    }
    
    echo json_encode($response);  
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "error";
    echo json_encode($response);
}
    
 
?>