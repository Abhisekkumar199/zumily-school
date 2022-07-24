<?php 
require_once 'include/DB_Functions.php';
include("../includes/libraries/mailfunction.php");



$start = $_POST['days'];
$daysids = $_POST['daysids'];

  $userId = $_REQUEST["userId"];
$listingId = $_REQUEST["id"];
$cname = mysqli_real_escape_string($conn,ucwords($_REQUEST["name"]));
$cnumber = $_REQUEST["phone"];
$latitude = mysqli_real_escape_string($conn,$_REQUEST["latitude"]);
$longitude = mysqli_real_escape_string($conn,$_REQUEST["longitude"]); 

$addr_1 = mysqli_real_escape_string($conn,ucwords($_REQUEST["address"])); 
$day = $_REQUEST["day"];
$starttime = $_REQUEST["starttime"]; 
$endtime = $_REQUEST["endtime"]; 
$starttime1 = $_REQUEST["starttime1"]; 
$endtime1 = $_REQUEST["endtime1"]; 

if($day == 'MON')
{
   $str =  ",`day1`='mon', `monopen_time`='".$starttime."',`monclose_time`='".$endtime."',`monopen_time1`='".$starttime1."',`monclose_time1`='".$endtime1."'";
}
else if($day == 'TUE')
{
    $str = ", `day2`='tue', `tueopen_time`='".$starttime."',`tueclose_time`='".$endtime."',`tueopen_time1`='".$starttime1."',`tueclose_time1`='".$endtime1."'";
}
else if($day == 'WED')
{
    $str = ", `day3`='wed', `wedopen_time`='".$starttime."',`wedclose_time`='".$endtime."',`wedopen_time1`='".$starttime1."',`wedclose_time1`='".$endtime1."'";
}
else if($day == 'THU')
{
    $str = ", `day4`='thu',`thuopen_time`='".$starttime."',`thuclose_time`='".$endtime."',`thuopen_time1`='".$starttime1."',`thuclose_time1`='".$endtime1."'";
} 
else if($day == 'FRI')
{
    $str = ", `day5`='fri', `friopen_time`='".$starttime."',`friclose_time`='".$endtime."',`friopen_time1`='".$starttime1."',`friclose_time1`='".$endtime1."'";
}
else if($day == 'SAT')
{
    $str = ", `day6`='sat', `satopen_time`='".$starttime."',`satclose_time`='".$endtime."',`satopen_time1`='".$starttime1."',`satclose_time1`='".$endtime1."'";
}
else if($day == 'SUN')
{
    $str = ", `day7`='sun', `sunopen_time`='".$starttime."',`sunclose_time`='".$endtime."',`sunopen_time1`='".$starttime1."',`sunclose_time1`='".$endtime1."'";
}
 

if($listingId == '')
{
	$userDetails = mysqli_fetch_assoc(mysqli_query($conn,"select * from `users`  WHERE user_id='".$userId."'"));	
    $bussinessname=mysqli_real_escape_string($conn,$userDetails['business_name']).", ".$addr_1;
    
   // echo "insert into `listings` SET  `bussinessnamewithaddress`='".$bussinessname."',`contact_person_name`='".$cname."',`contact_person_number`='".$cnumber."',`user_id`='".$userId."',`address1`='".$addr_1."',`latitude`='".$latitude."',`longitude`='".$longitude."' {$str}";
 
	mysqli_query($conn,"insert into `listings` SET  `bussinessnamewithaddress`='".$bussinessname."',`contact_person_name`='".$cname."',`contact_person_number`='".$cnumber."',`user_id`='".$userId."',`address1`='".$addr_1."',`latitude`='".$latitude."',`longitude`='".$longitude."' {$str}"); 
	$id = mysql_insert_id();
	$user = mysqli_query($conn,"UPDATE `users` SET  `store_count`= store_count + 1  WHERE user_id='".$userId."'");  
	
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["locationId"] = $id; 
    $response["name"] = $cname; 
    $response["phone"] = $cnumber; 
    $response["address"] = $addr_1; 
    echo json_encode($response); 
}
else
{ 
    $userDetails = mysqli_fetch_assoc(mysqli_query($conn,"select * from `users`  WHERE user_id='".$userId."'"));	
    $bussinessname=$userDetails['business_name'].", ".$addr_1;
    
    
    mysqli_query($conn,"UPDATE `listings` SET  `bussinessnamewithaddress`='".$bussinessname."',`contact_person_name`='".$cname."',`contact_person_number`='".$cnumber."',`user_id`='".$userId."',`address1`='".$addr_1."',`latitude`='".$latitude."',`longitude`='".$longitude."' {$str} WHERE `listing_id`='".$listingId."' "); 
    
 
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["locationId"] = $listingId; 
    $response["name"] = $cname; 
    $response["phone"] = $cnumber; 
    $response["address"] = $addr_1; 
    echo json_encode($response);  
 
    
    
}
?>