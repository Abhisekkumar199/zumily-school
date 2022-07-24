<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$userId = $_REQUEST['userId']; 
$sqlUserl = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `users` WHERE `user_id`='".$userId."'"));
$setlat = $sqlUserl['latitude'];
$setlog = $sqlUserl['longitude'];
$a = 1;
$sqlbussiness = mysqli_query($conn,"SELECT distinct(user_id), ( 3959 * ACOS( COS( RADIANS($setlat) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS($setlog) ) + SIN( RADIANS($setlat) ) * SIN( RADIANS( latitude ) ) ) ) AS distance FROM listings where latitude!='' HAVING distance <= '20' ORDER BY distance ASC LIMIT 0,60");
while($rowsuserId = mysqli_fetch_assoc($sqlbussiness)) 
{
    if($a == 1)
    {
        $userid .= $rowsuserId['user_id'];
    }
    else
    {
        $userid .= ", ".$rowsuserId['user_id'];
    } 
     $a++;
     $userId1 =  "and user_id IN ($userid)";
}

    $categorySql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE type='FS' and `flashdate`>='".$cmpdate."' {$userId1} ORDER BY `flashdate` asc") or die(mysql_error());
    $no_of_rows = mysqli_num_rows($categorySql);
    if ($no_of_rows > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success"; 
        $response["data"] = array();
        while($catRows = mysqli_fetch_array($categorySql))
        { 
            $user = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `users` WHERE  `user_id` = '".$catRows['user_id']."'")); 
            $catname = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `categories` WHERE `category_id` = '".$user['category_id']."'"));
             
            $flyer["bussinessName"] = $user['business_name'];
            $flyer["bussinessId"] = $user['user_id'];
            if($user['business_logo'])
            { 
                $flyer["logo"] =   "https://www.zumily.com/uploadimages/merchantimages/".$user['business_logo'];
            } 
            else 
            {  
	            $flyer["logo"] =  "https://www.zumily.com/images/name.png";
		    }  
		    $flyer["catId"] = $user['category_id'];
            $flyer["categoryName"] = $catname['display_name'];
            $flyer["flyerId"] = $catRows['id'];
            $flyer["couponName"] = $catRows['flyer_name']; 
            $flyer["totalLike"] = $catRows['totalLikes'];
            $flyer["totalView"] = $catRows['totalViews'];
            $queryIsLiked = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `my_likes` where user_id = '".$userId."' and flyer_id = '".$catRows['id']."'")); 
            if($queryIsLiked > 0)
            {
                $flyer["isLiked"] = "1";
            }
            else
            {
                $flyer["isLiked"] = "0";
            } 
            $queryIsFollowed = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `my_favorites` where user_id = '".$userId."' and listing_id = '".$user['user_id']."'")); 
            if($queryIsFollowed == 1)
            {
                $flyer["isFollow"] = "1";
            }
            else
            {
                $flyer["isFollow"] = "0";
            } 
            
            $flyer["flashdate"] = date("D, M d",$catRows['flashdate']);
            $flyer["flashtime"] = $catRows['flashtime'];  
             
            $flyer['images'] = 'https://www.zumily.com/uploadimages/flashsales/'.$catRows['image'];
             
            array_push($response["data"], $flyer);
        }  
        echo json_encode($response);
    } 
    else
    {
        $response["status"] = "400";
        $response["msg"] = "No flyer found";
        echo json_encode($response);
    }
 
?>