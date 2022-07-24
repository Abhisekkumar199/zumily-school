<?php
session_start();
require_once 'include/DB_Functions.php';
   
$user_id = $_REQUEST['userId']; 
$id = $_REQUEST['id']; 
$title = mysqli_real_escape_string($conn,ucwords($_REQUEST['title'])); 
$memberids1 = $_REQUEST['memberids'];
$xxx = explode(',',$memberids1); 
  $totalmember =  sizeof($xxx); 
 
if ($user_id != '' && $title != '' && $memberids1 != '') 
{ 
     
    if($id!= '')
    { 
        $query=mysqli_query($conn,"update `groups` set  `title`='".$title."',`totalmember` = '".$totalmember."', `userids` = '".$memberids1."', `editdate`='".date("Y-m-d")."' where id='".$id."'"); 
    }
    else
    {
        $query=mysqli_query($conn,"insert into `groups` set  `user_id`='".$user_id."',`title`='".$title."',`totalmember` = '".$totalmember."', `userids` = '".$memberids1."', `adddate`='".date("Y-m-d")."'"); 
       
    }
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