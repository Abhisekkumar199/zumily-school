<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$userId = $_REQUEST['userId']; 
$bussinessId= $_REQUEST['bussinessId'];  
  
    $categorySql = mysqli_query($conn,"SELECT * FROM `flyer` WHERE `end_date`>='".$cmpdate."' and user_id = '".$bussinessId."'  ORDER BY `end_date` asc");
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
            $flyer["flyerId"] = $catRows['flyer_id'];
            $flyer["couponName"] = $catRows['flyer_name'];
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
            
            $flyer["startDate"] = date("D, M d",$catRows['start_date']);
            $flyer["end_date"] = date("D, M d",$catRows['end_date']);  
            
            
            if($catRows['type'] == 'flyer') 
            {
                $flyer["type"] = "flyer";
                $flyer['images'] = array();
                $proimagesql = mysqli_query($conn,"SELECT * FROM `flyer_images` where `flyer_id`='".$catRows['flyer_id']."'");
                $numimg = mysqli_num_rows($proimagesql);	
                if($numimg>0) 
                { 
                    $i=1;
                    while($proimagerows = mysqli_fetch_array($proimagesql)) 
                    { 
                        $imageUrl = 'https://www.zumily.com/uploadimages/mediaimage/'.$proimagerows['flyer_image_name']; 
                        $flyerimage["imageName"] = $imageUrl; 
                        array_push($flyer["images"], $flyerimage);
                    } 
                } 
            } 
            else
            {
                $flyer["type"] = "coupon";
                $flyer['images'] = array();
                $imageUrl = 'https://www.zumily.com/uploadimages/couponimage/'.$catRows['image']; 
                $flyerimage["imageName"] = $imageUrl; 
                array_push($flyer["images"], $flyerimage);
            }
             
            
             
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