<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$userId = $_REQUEST['userId'];   
$sqlFavorite = mysqli_query($conn,"SELECT * FROM `my_favorites` WHERE `user_id` = '".$userId."' group by listing_id");
$j = 1;
while($displayBusiness = mysqli_fetch_array($sqlFavorite))
{
	if($j > 1)
	{
		$bussinessIds .= ",".$displayBusiness['listing_id'];
	}
	else
	{
		$bussinessIds .= $displayBusiness['listing_id'];
	}	
	$j++;
} 


$sql = "SELECT * FROM `flyer` f inner join flyer_message_student fm on f.flyer_id = fm.messageId WHERE f.type='M'   and fm.studentId='".$userId."' and fm.readstatus='0'";   
$sql2 = "SELECT * FROM `flyer` f inner join flyer_message_student fm on f.flyer_id = fm.messageId WHERE f.type='M' and fm.studentId='".$userId."'";   

$sqlpro = mysqli_query($conn,$sql2);
$sqlpro1 = mysqli_query($conn,$sql);
$numpro = mysqli_num_rows($sqlpro);  
$numpro1 = mysqli_num_rows($sqlpro1); 
if ($numpro > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";  
    $response["totalCount"] = $numpro1; 
    $response["data"] = array();
    while($fetch = mysqli_fetch_array($sqlpro))
    {
        $flyer["statusId"] = $fetch['id'];
        $flyer["readstatus"] = $fetch['readstatus']; 
        $flyer["messageId"] = $fetch['flyer_id'];  
	    $flyer["title"] = $fetch['flyer_name']; 
        
        array_push($response["data"], $flyer);
    }  
    echo json_encode($response);
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "No Message found";
    echo json_encode($response);
}
 
?>