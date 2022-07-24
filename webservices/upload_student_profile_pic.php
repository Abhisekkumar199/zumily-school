<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
 
$student_id = $_REQUEST['student_id'];  
$image = $_FILES['profile_pic']['name']; 
if($student_id!="" and $image != "")
{ 
	$string = $_FILES['profile_pic']['name'];
	$exp=explode(".",$string);
	$fileName = time()."_".$string; 
	$uploaddir = '../assets/uploadimages/studentimages/'.$fileName; 
	move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploaddir);
	$filename = $fileName;  
    $directory = "../assets/uploadimages/studentimages"; 
    $source = '../assets/uploadimages/studentimages/'.$filename;
    
    list($width, $height) = getimagesize($source);
    $src = imagecreatefromjpeg($source);   
    $dst = imagecreatetruecolor('100', '100'); 
    imagecopyresampled($dst, $src, 0, 0, 0, 0, 100, 100, $width, $height); 
    
    imagejpeg($dst, $directory.'/'.$filename); 
	$updatePassword = mysqli_query($conn,"update students set profile_picture = '".$filename."' where student_id='".$student_id."'"); 

	$response["status"] = "200";
	$response["msg"] = "success"; 
	echo json_encode($response);  
     
}
else
{
    $response["status"] = "400";
	$response["msg"] = "parameter missing"; 
	echo json_encode($response);
} 
?>