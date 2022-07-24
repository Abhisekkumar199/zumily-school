<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
 
 
$school_id = $_REQUEST['school_id']; 
$class_register_student_id = $_REQUEST['class_register_student_id']; 
$class_register_id = $_REQUEST['class_register_id']; 
$student_id = $_REQUEST['student_id'];
$title = $_REQUEST['title'];  
$datetime = $_REQUEST['datetime'];
$filename = $_FILES['document']['name'];
mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
if(!empty($student_id) and !empty($class_register_id))
{
    $class_register_student_info = mysqli_fetch_array(mysqli_query($conn,"SELECT documents_info from class_register_students  WHERE class_register_id = '".$class_register_id."' and  student_id= '".$student_id."'"));   
    $documents =$class_register_student_info['documents_info'];
     
    $num1=rand(100000,999999);
    $num2=rand(100000,999999); 
    $finalnum=$num1."".$num2; 
    $name= $student_id."_".$finalnum; 
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $finalname = $name.".".$ext;
      
	$uploaddir = '../assets/uploadimages/student/documents/'.$finalname; 
	move_uploaded_file($_FILES['document']['tmp_name'], $uploaddir); 
    
    
    
    $file_size =  $_FILES['document']['size'];
        
    if($file_size >= 4000000)
    {
        $percentage = '10%';
    }
    else if($file_size >= 2000000 and $file_size < 4000000)
    { 
        $percentage = '15%';
    }
    else if($file_size >= 400000 and $file_size < 1000000)
    {
        $percentage = '20%';
    }
    else  
    {
        $percentage = '30%';
    }
    
    $directory = "../assets/uploadimages/student/documents"; 
    $source = '../assets/uploadimages/student/documents/'.$finalname;
    $im_php = imagecreatefromjpeg($source); 
    $new_height = imagesy($im_php); 
    imagejpeg($im_php, $directory.'/'.$finalname,$percentage);
	
	if($documents == '')
    {
        $documents .= "1|$title|$finalname|$datetime"; 
        $total_document = 1;
    }
    else
    {
        $doc_array = explode(';',$documents);
        $total_document = count($doc_array) + 1;
        $documents .= ";$total_document|$title|$finalname|$datetime"; 
    } 
	 
	 
	    
   $sql_user=mysqli_query($conn,"select user_id from `student_user_xref`  where student_id = '.$student_id.'");
     
    while($rows = mysqli_fetch_assoc($sql_user))
    {
        
        $query_notification=mysqli_query($conn,"INSERT INTO `notifications`(`school_id`,`payload_id`,`payload_type`,`title`,`description`,`user_id`) VALUES ('".$school_id."','".$class_register_student_id."','D','".$title."','','".$rows['user_id']."')"); 
    }    
	 
	mysqli_query($conn,"update class_register_students set documents_info = '".$documents."',total_documents='$total_document' where class_register_id = '".$class_register_id."' and  student_id= '".$student_id."'"); 
  
 
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);
}    
else
{
    $response["status"] = "400";
    $response["msg"] = "Student id is required";
    echo json_encode($response);
}
?>