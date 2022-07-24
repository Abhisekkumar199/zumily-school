<?php
session_start();
require_once 'include/DB_Functions.php';
   
$userId =  $_REQUEST['userId']; 
$currenttime = $_REQUEST['currenttime']; 
$dayOfWeek = $_REQUEST['dayOfWeek'];
$text = $_REQUEST['text'];

if ($userId != '' && $text != '' && $text != ' ') 
{ 
    $mysqlNumRows =  mysqli_num_rows(mysqli_query($conn,"select * from `searchrecords` where searchedtext='".$text."' and user_id='".$userId."'"));
    if($mysqlNumRows < 1)
    {
        mysqli_query($conn,"insert into `searchrecords` set searchedtext='".$text."',searcheddate='".date("Y-m-d h-i-sa")."',user_id='".$userId."'");  
    }
    else
    {
        mysqli_query($conn,"update `searchrecords` set searchedtext='".$text."',searcheddate='".date("Y-m-d h-i-sa")."' where searchedtext='".$text."' and user_id='".$userId."'");  
    } 
} 

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
$searchcon = "and l.bussinessnamewithaddress LIKE '%".$text."%'";
if($_REQUEST['cat_id'] != '')
    {
        $catid = "and u.category_id = '".$_REQUEST['cat_id']."'";
    }  
 $typesql2 = mysqli_query($conn,"SELECT * FROM listings l inner join users u on l.user_id = u.user_id  where l.listing_id != '' {$catid} {$searchcon} {$useridlocation} ");
 

$no_of_rows = mysqli_num_rows($typesql2);
if ($no_of_rows > 0) 
{
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    $response["data"] = array(); 
    while($fetch1 = mysqli_fetch_array($typesql2))
    { 
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
        $bussiness["address"] = $fetch1['address1'];
        $bussiness["contactPerson"] = $fetch1['contact_person_name'];
        $bussiness["email"] = $fetch1['email_id'];
        $bussiness["phone"] = $fetch1['contact_person_number'];
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
        $bussiness["totalFollower"] = $fetch1['total_followers'];
        $bussiness["totalFlyer"] = $fetch1['total_flyers'];
        $bussiness["totalCoupon"] = $fetch1['total_deals'];
        $bussiness["totalEvent"] = $fetch1['total_events'];
        $bussiness["totalMessage"] = $fetch1['total_messages'];
        
        
        
        
        $sqlUserAddress = mysqli_fetch_array(mysqli_query($conn,"select * from listings where user_id ='".$fetch1['user_id']."' order by listing_id asc limit 1"));
         
        if($dayOfWeek == 1)
        {
            $starttime = $sqlUserAddress['monopen_time'];
            $closetime = $sqlUserAddress['monclose_time'];
            $starttime1 = $sqlUserAddress['monopen_time1'];
            $closetime1 = $sqlUserAddress['monclose_time1'];
            
            $nextstartdaytime = $sqlUserAddress['tueopen_time'];
        }
        else if($dayOfWeek == 2)
        {
            $starttime = $sqlUserAddress['tueopen_time'];
            $closetime = $sqlUserAddress['tueclose_time'];
            $starttime1 = $sqlUserAddress['tueopen_time1'];
            $closetime1 = $sqlUserAddress['tueclose_time1'];
            $nextstartdaytime = $sqlUserAddress['wedopen_time'];
        }
        else if($dayOfWeek == 3)
        {
            $starttime = $sqlUserAddress['wedopen_time'];
            $closetime = $sqlUserAddress['wedclose_time'];
            $starttime1 = $sqlUserAddress['wedopen_time1'];
            $closetime1 = $sqlUserAddress['wedclose_time1'];
            $nextstartdaytime = $sqlUserAddress['thuopen_time'];
        }
        else if($dayOfWeek == 4)
        {
            $starttime = $sqlUserAddress['thuopen_time'];
            $closetime = $sqlUserAddress['thuclose_time'];
            $starttime1 = $sqlUserAddress['thuopen_time1'];
            $closetime1 = $sqlUserAddress['thuclose_time1'];
            $nextstartdaytime = $sqlUserAddress['friopen_time'];
        }
        else if($dayOfWeek == 5)
        {
            $starttime = $sqlUserAddress['friopen_time'];
            $closetime = $sqlUserAddress['friclose_time'];
            $starttime1 = $sqlUserAddress['friopen_time1'];
            $closetime1 = $sqlUserAddress['friclose_time1'];
            $nextstartdaytime = $sqlUserAddress['satopen_time'];
        }
        else if($dayOfWeek == 6)
        {
         $starttime = $sqlUserAddress['satopen_time'];
         $closetime = $sqlUserAddress['satclose_time'];
         $starttime1 = $sqlUserAddress['satopen_time1'];
         $closetime1 = $sqlUserAddress['satclose_time1'];
         $nextstartdaytime = $sqlUserAddress['sunopen_time'];
        }
        else if($dayOfWeek == 7)
        {
             $starttime = $sqlUserAddress['sunopen_time'];
             $closetime = $sqlUserAddress['sunclose_time'];
             $starttime1 = $sqlUserAddress['sunopen_time1'];
             $closetime1 = $sqlUserAddress['sunclose_time1'];
             $nextstartdaytime = $sqlUserAddress['monopen_time'];
        }
        if($starttime1 == '')
        {
            if($currenttime <= $starttime)
            {
                  
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1];
                
                $starttime2 = explode(":", $starttime);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1; 
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                    if($newminute > 60)
                    {
                        $newtime = $newtime + 1;
                        $newminute = $newminute - 60;
                    } 
                }
                else
                {
                  $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                }
                  
                $timetoshow = $newtime.":".$newminute;
                if($newtime < 2)
                {
                  $bussiness["timeStatus"] = "Opens in ".$timetoshow." hour"; 
                }
                else
                { 
                  $bussiness["timeStatus"] = "Opens at ".date('h:i a', strtotime($starttime)).""; 
                } 
            }
            else if($currenttime > $starttime and $currenttime < $closetime)
            {
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1]; 
                
                $starttime2 = explode(":", $closetime);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1;
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                if($newminute > 60)
                {
                    $newtime = $newtime + 1;
                    $newminute = $newminute - 60;
                }
                }
                else
                { 
                    $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                } 
                $timetoshow = $newtime.":".$newminute;
                
                if($newtime < 2)
                {
                    $bussiness["timeStatus"] = "Closes soon in ".$timetoshow." hour";
                }
                else
                {
                    $bussiness["timeStatus"] = "Closes at ".date('h:i a', strtotime($closetime)).""; 
                }
            }
            else if($currenttime >= $closetime)
            {      
                $bussiness["timeStatus"] = "Closed opens at ".date('h:i a', strtotime($nextstartdaytime))." tomorrow";  
            }
        }
        else
        { 
            if($currenttime <= $starttime)
            { 
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1];
                
                $starttime2 = explode(":", $starttime);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1; 
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                    if($newminute > 60)
                    {
                        $newtime = $newtime + 1;
                        $newminute = $newminute - 60;
                    } 
                }
                else
                {
                  $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                }
                  
                $timetoshow = $newtime.":".$newminute;
                if($newtime < 2)
                {
                  $bussiness["timeStatus"] = "Opens in ".$timetoshow." hour"; 
                }
                else
                { 
                  $bussiness["timeStatus"] = "Opens at ".date('h:i a', strtotime($starttime)).""; 
                } 
            }
            else if($currenttime > $starttime and $currenttime < $closetime)
            { 
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1]; 
                
                $starttime2 = explode(":", $closetime);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1;
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                if($newminute > 60)
                {
                    $newtime = $newtime + 1;
                    $newminute = $newminute - 60;
                }
                }
                else
                { 
                    $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                } 
                $timetoshow = $newtime.":".$newminute;
                
                if($newtime < 2)
                {
                    $bussiness["timeStatus"] = "Closeing soon in ".$timetoshow." hour";
                }
                else
                {
                    $bussiness["timeStatus"] = "Closes at ".date('h:i a', strtotime($closetime)).""; 
                }
            }
            else if($currenttime >= $closetime and $currenttime <= $starttime1 )
            {
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1];
                
                $starttime2 = explode(":", $starttime1);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1; 
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                    if($newminute > 60)
                    {
                        $newtime = $newtime + 1;
                        $newminute = $newminute - 60;
                    } 
                }
                else
                {
                  $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                }
                  
                $timetoshow = $newtime.":".$newminute;
                if($newtime < 2)
                {
                  $bussiness["timeStatus"] = "Opens in ".$timetoshow." hour"; 
                }
                else
                { 
                  $bussiness["timeStatus"] = "Opens at ".date('h:i a', strtotime($starttime1)).""; 
                } 
            }
            else if($currenttime > $starttime1 and $currenttime < $closetime1)
            {
                $currenttime1 = explode(":", $currenttime);
                $hour = $currenttime1[0];
                $minutes = $currenttime1[1]; 
                
                $starttime2 = explode(":", $closetime1);
                $hour1 = $starttime2[0];
                $minutes1 = $starttime2[1];
                
                $newtime = $hour1 - $hour;
                if($minutes > $minutes1 )
                {
                    $newtime = $newtime - 1;
                    $newminute = 60 - $minutes ;
                    $newminute = $newminute + $minutes1;
                if($newminute > 60)
                {
                    $newtime = $newtime + 1;
                    $newminute = $newminute - 60;
                }
                }
                else
                { 
                    $newminute = $minutes1-$minutes;
                }
                if($newminute < 10)
                {
                    $newminute = "0".$newminute;
                } 
                $timetoshow = $newtime.":".$newminute;
                
                if($newtime < 2)
                {
                    $bussiness["timeStatus"] = "Closeing soon in ".$timetoshow." hour";
                }
                else
                {
                    $bussiness["timeStatus"] = "Closes at ".date('h:i a', strtotime($closetime1)).""; 
                }
            }
            else if($currenttime >= $closetime1)
            { 
                $bussiness["timeStatus"] = "Closed opens at ".date('h:i a', strtotime($nextstartdaytime))." tomorrow"; 
            }
             
         }  
        
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