<?php
session_start();
require_once 'include/DB_Functions.php';
  
$userId =  $_REQUEST['userId'];   

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


$typesql2 = mysqli_query($conn,"SELECT * FROM `users` WHERE  user_id IN ($bussinessIds)");
$no_of_rows = mysqli_num_rows($typesql2);
if ($no_of_rows > 0) 
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array(); 
    while($fetch1 = mysqli_fetch_array($typesql2))
    {
        $fetchlocations = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `listings` where user_id = '".$fetch1['user_id']."'")); 
        $sqlTotalFollower = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `my_favorites` where listing_id = '".$fetch1['user_id']."'")); 
        $sqlTotalFlyer = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `flyer` where user_id = '".$fetch1['user_id']."' and type='F'"));
        $sqlTotalcoupon = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `flyer` where user_id = '".$fetch1['user_id']."' and type='C'"));
        
        $sqlTotalEvents = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `flyer` where user_id = '".$fetch1['user_id']."' and type='E'"));
        $catname = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `categories` WHERE `category_id` = '".$fetch1['category_id']."'"));
        if($fetch1['business_logo'])
        { 
            $bussiness["logo"] =   "https://www.zumily.com/uploadimages/merchantimages/".$fetch1['business_logo'];
        } 
        else 
        {  
            $bussiness["logo"] =  "https://www.zumily.com/images/name.png";
        }  
        
        $bussiness["bussinessId"] = $fetch1['user_id'];
        $bussiness["bussinessName"] = $fetch1['business_name'];  
        $bussiness["address"] = $fetchlocations['address1'].', '.$fetchlocations['city'].' '.$fetchlocations['zipcode'];
        $bussiness["contactPerson"] = $fetchlocations['contact_person_name'];
        $bussiness["email"] = $fetch1['email_id'];
        $bussiness["phone"] = $fetchlocations['contact_person_number'];
        $bussiness["catId"] = $catname['category_id'];
        $bussiness["categoryName"] = $catname['display_name'];
        $queryIsFollowed = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `my_favorites` where user_id = '".$userId."' and listing_id = '".$fetch1['user_id']."'")); 
        if($queryIsFollowed == 1)
        {
            $bussiness["isFollow"] = "1";
        }
        else
        {
            $bussiness["isFollow"] = "0";
        } 
        $bussiness["totalFollower"] = $sqlTotalFollower;
        $bussiness["totalFlyer"] = $sqlTotalFlyer;
        $bussiness["totalCoupon"] = $sqlTotalcoupon;
        $bussiness["totalEvent"] = $sqlTotalEvents; 
        
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