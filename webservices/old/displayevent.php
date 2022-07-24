<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$userId = $_REQUEST['userId'];  
$startIndex1 = $_REQUEST['startIndex'];
$endIndex = 30 ; 
$startIndex = $startIndex1 * $endIndex ;

$sqlUserl = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` WHERE user_id='".$userId."'"));
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
    $userId1 =  "and f.user_id IN ($userid)";
}  
$businessid= $_REQUEST['businessid'];  
if($businessid != '')
{
   $bussiness =  "and f.user_id='".$businessid."'";
}  
    
    $totalcount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `flyer` f right join listings l on f.user_id = l.user_id WHERE f.`end_date`>='".$cmpdate."' and f.type='E'   {$userId1} {$bussiness} "));
    $totalindex = $totalcount / $endIndex ;
    $sql = mysqli_query($conn,"SELECT * FROM `flyer` f right join listings l on f.user_id = l.user_id WHERE f.`end_date`>='".$cmpdate."' and f.type='E'  {$userId1} {$bussiness} ORDER BY f.`end_date` asc limit $startIndex, $endIndex");
    $no_of_rows = mysqli_num_rows($sql);
    if ($no_of_rows > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success"; 
        $response["totalCount"] = $totalcount; 
        $response["data"] = array();
        while($catRows = mysqli_fetch_array($sql))
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
            $flyer["flyerId"] = $catRows['flyer_id'];
            $flyer["flyerName"] = $catRows['flyer_name'];
            $flyer["flyerDesc"] = $catRows['flyer_desc'];
            $flyer["totalLike"] = $catRows['totalLikes'];
            $flyer["totalView"] = $catRows['totalViews'];
            $queryIsLiked = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `my_likes` where user_id = '".$userId."' and flyer_id = '".$catRows['flyer_id']."'")); 
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
            $proimagesql = mysqli_query($conn,"SELECT * FROM `flyer_images` where `flyer_id`='".$catRows['flyer_id']."'");
            $numimg = mysqli_num_rows($proimagesql);	
            $flyer["startDate"] = date("D, M d",$catRows['start_date']);
            $flyer["end_date"] = date("D, M d",$catRows['end_date']); 
            $flyer["starttime"] = $catRows['starttime'];
            $flyer["endtime"] = $catRows['endtime'];
            
            $flyer['images'] = array();
            
            if($numimg>0) 
            { 
                $i=1;
                while($proimagerows = mysqli_fetch_array($proimagesql)) 
                { 
                    $imageUrl = 'https://www.zumily.com/uploadimages/eventimage/'.$proimagerows['flyer_image_name']; 
                     $flyerimage["imageName"] = $imageUrl; 
                    array_push($flyer["images"], $flyerimage);
                } 
            }  
            array_push($response["data"], $flyer);
        }  
        echo json_encode($response);
    } 
    else
    {
        if($startIndex > $totalcount)
        {
            $response["status"] = "300";
            $response["msg"] = "";
            echo json_encode($response);
        }
        else
        {
            $response["status"] = "400";
            $response["msg"] = "No Event found";
            echo json_encode($response);
        }
    }
 
?>