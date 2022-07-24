<?php
require_once 'include/DB_Functions.php';
 
$user_id = $_REQUEST['userId'];
$flyerId = $_REQUEST['flyerId'];
$islike = $_REQUEST['islike']; 
if($user_id!="" && $islike!="" && $flyerId!="")
{ 
    if($islike == '0')
    {
        $sqlfil=mysqli_query($conn,"INSERT INTO `my_likes`(`user_id`, `flyer_id`) VALUES ('".$user_id."','".$flyerId."')"); 
        $sqlUpdate=mysqli_query($conn,"update flyer set totalLikes= totalLikes + 1  where flyer_id='".$flyerId."'");
        $response["status"] = "200";
		$response["msg"] = "Liked";
		echo json_encode($response);
    }
    else
    {
        $sqlfil=mysqli_query($conn,"DELETE FROM `my_likes` WHERE user_id='".$user_id."' and flyer_id='".$flyerId."'");
        $sqlUpdate=mysqli_query($conn,"update flyer set totalLikes= totalLikes - 1  where flyer_id='".$flyerId."'");
        $response["status"] = "200";
		$response["msg"] = "Unliked";
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