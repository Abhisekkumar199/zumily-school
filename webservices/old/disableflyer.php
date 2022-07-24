<?php
require_once 'include/DB_Functions.php';
  
$flyerId = $_REQUEST['flyerId'];
$status = $_REQUEST['status'];
if($flyerId!="" && $status!="")
{
    if($status == 1)
    { 
        $sqlUpdate=mysqli_query($conn,"update flyer set displayflag='1'  where flyer_id='".$flyerId."'");  
		$response["status"] = "200";
		$response["msg"] = "Enabled successfully"; 
		echo json_encode($response);
      
    }
    else if($status == 0)
    { 
        $sqlUpdate=mysqli_query($conn,"update flyer set displayflag='0'  where flyer_id='".$flyerId."'"); 
		$response["status"] = "200";
		$response["msg"] = "Disabled successfully"; 
		echo json_encode($response); 
    } 
}
else
{
    $response["status"] = "400";
	$response["msg"] = "parameter missing"; 
	echo json_encode($response);
} 
?>