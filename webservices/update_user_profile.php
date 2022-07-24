<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
 
$user_id = $_REQUEST['user_id']; 
$fname = ucwords($_REQUEST['fname']);
$lname = ucwords($_REQUEST['lname']);
$phone = $_REQUEST['phone'];
$emailid = $_REQUEST['emailid'];
$gender = $_REQUEST['gender']; 
$dob = $_REQUEST['dob']; 
$datetime = $_REQUEST['datetime']; 
$image = $_FILES['profilePic']['name']; 
if($user_id!="")
{
    if (check_user($user_id)) 
    {   
        $user = update_user($fname,$lname,$gender,$dob,$user_id,$datetime);  
        if($image) 
    	{
    		$string = $_FILES['profilePic']['name'];
    		$exp=explode(".",$string);
    		$fileName = time()."_".$string; 
    		$uploaddir = '../assets/uploadimages/userimages/'.$fileName; 
    		move_uploaded_file($_FILES['profilePic']['tmp_name'], $uploaddir);
    		$filename = $fileName;   
            
            $directory = "../assets/uploadimages/userimages"; 
            $source = '../assets/uploadimages/userimages/'.$filename;
            
            list($width, $height) = getimagesize($source);
            $src = imagecreatefromjpeg($source);   
            $dst = imagecreatetruecolor('100', '100'); 
            imagecopyresampled($dst, $src, 0, 0, 0, 0, 100, 100, $width, $height); 
            
            imagejpeg($dst, $directory.'/'.$filename);
    		
    		
    		$updatePassword = mysqli_query($conn,"update users set user_image = '".$filename."' where user_id='".$user_id."'"); 
    	} 
    	if ($user != false) 
    	{
    		$response["status"] = "200";
    		$response["msg"] = "User updated successfully";
    		$user_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from users where user_id='".$user_id."'")); 
    		$response["user"]["user_id"] = $user_details["user_id"]; 
            $response["user"]["first_name"] = $user_details["first_name"];
            $response["user"]["last_name"] = $user_details["last_name"]; 
            $response["user"]["email_id"] = $user_details["email_id"]; 
            $response["user"]["mobile_no"] = $user_details["mobile_no"];
            $response["user"]["user_gender"] = $user_details["user_gender"];
            $response["user"]["user_dob"] = $user_details["user_dob"];
            
            
             
            if($user_details['user_image'] != '')
            {
                $response["user"]["profilePic"]="https://localhost/project/zumilyschool/assets/uploadimages/userimages/".$user_details['user_image']; 
            }
            else
            {
                $response["user"]["profilePic"]="https://localhost/project/zumilyschool/assets/images/name.png";
            }
    		
    		
    		
    		echo json_encode($response);
    	} 
    	else 
    	{ 
    		$response["status"] = "400";
    		$response["msg"] = "error"; 
    		echo json_encode($response); 
    	} 
    	     
    } 
    else 
    {
        $response["msg"] = "user doesnot exist";
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