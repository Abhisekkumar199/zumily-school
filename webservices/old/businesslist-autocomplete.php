<?php
session_start();
require_once 'include/DB_Functions.php';
 

$userId =  $_REQUEST['userId'];  
$sqlUser = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users where user_id ='".$userId."'"));
$setlat = $sqlUser['latitude'];
$setlog = $sqlUser['longitude'];

$sqlbussiness = mysqli_query($conn,"SELECT distinct(listing_id), ( 3959 * ACOS( COS( RADIANS($setlat) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS($setlog) ) + SIN( RADIANS($setlat) ) * SIN( RADIANS( latitude ) ) ) ) AS distance FROM listings where latitude!='' HAVING distance <= '50' ORDER BY distance ASC LIMIT 0,60");
if(mysqli_num_rows($sqlbussiness) > 0)
{
    $a = 1;
    while($rowsuserId = mysqli_fetch_assoc($sqlbussiness)) 
    {
        if($a == 1)
        {
            $useridlocation .= $rowsuserId['listing_id'];
        }
        else
        {
            $useridlocation .= ", ".$rowsuserId['listing_id'];
        } 
         $a++;
    } 
    $useridlocation = "and l.listing_id IN (".$useridlocation.")";
}
$sqlBussiness = mysqli_query($conn,"select u.business_logo,u.user_id,u.business_name,l.bussinessnamewithaddress,l.address1 from users u RIGHT JOIN listings l ON u.user_id = l.user_id where u.displayflag ='1'  {$useridlocation}");
$num = mysqli_num_rows($sqlBussiness);
$k=1; 
if ($num > 0) 
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array(); 
    while($rows=mysqli_fetch_array($sqlBussiness)) 
    {   
          
        if($rows['business_logo'] != '')
    	{   
    	    $bussiness['logo'] = "https://www.zumily.com/uploadimages/merchantimages/".$rows['business_logo'];
    	}
    	else
    	{
    	    $bussiness['logo'] = "https://www.zumily.com/uploadimages/merchantimages/name.png";
    	} 
    	$bussiness['bussinessId'] = $rows['user_id']; 
        $bussiness['name'] = $rows['bussinessnamewithaddress']; 
        $bussiness['address'] = "";
        $bussiness['texttoSave'] = $rows['bussinessnamewithaddress'];
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
    
 
?>