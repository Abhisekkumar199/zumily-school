<?php
session_start();
require_once 'include/DB_Functions.php';
   
$user_id = $_REQUEST['userId']; 
  
if ($user_id != '') 
{ 
    $sqlfav = mysqli_query($conn,"select * from `my_favorites` where listing_id = '".$user_id."'");
    while($rows = mysqli_fetch_assoc($sqlfav))
    {
        $userids .= $rows['user_id'].",";
    }
    $finaluserids = substr($userids, 0, -1);      
       
    $sqlUser1=mysqli_query($conn,"select * from `users` where user_id IN (".$finaluserids.") order by first_name asc"); 
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["totalCount"] = mysqli_num_rows($sqlUser1); 
    $response["data"] = array();
    while($rowsuser = mysqli_fetch_assoc($sqlUser1))
    {
        $user['userid'] = $rowsuser['user_id'];
        $user['name'] = $rowsuser['first_name']." ".$rowsuser['last_name'];
        array_push($response["data"], $user);
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