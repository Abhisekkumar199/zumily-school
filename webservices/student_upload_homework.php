<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 

$datetime = $_REQUEST['datetime'];  
$student_id = $_REQUEST['student_id'];  
$homework_id = $_REQUEST['homework_id'];     
$homeworkdocuments = $_FILES["homework_completed_images"];   


$query_document=mysqli_fetch_assoc(mysqli_query($conn,"select completed_documents_info from `homework_completed_documents` where  homework_id='".$homework_id."' and student_id='$student_id' "));  
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
$documents = $query_document['completed_documents_info'];
if($homework_id != '')  
{   
    if($homeworkdocuments['name'][0]!="")
    { 
        $x = 1;
        foreach($_FILES['homework_completed_images']['name'] as $key => $tmp_name )
    	{
    	    $num1=rand(100000,999999);
            $num2=rand(100000,999999); 
            $finalnum=$num1."".$num2; 
              $name= "hwc_".$student_id."_".$homework_id."_".$finalnum;
            
              $filename = $_FILES['homework_completed_images']['name'][$key];
            $ext = pathinfo($filename, PATHINFO_EXTENSION); 
            $finalname = $name.".".$ext;
    		$file_name = $key.$_FILES['homework_completed_images']['name'][$key];
    		$file_size =$_FILES['homework_completed_images']['size'][$key];
    		$file_tmp =$_FILES['homework_completed_images']['tmp_name'][$key];
    		$file_type=$_FILES['homework_completed_images']['type'][$key]; 
    		 
             
            $desired_dir="../assets/uploadimages/homeworkcompletedimages";  
             
            move_uploaded_file($file_tmp,"$desired_dir/".$finalname); 
            if($ext != 'png')
            { 
                $x++; 
                $file_size =  $_FILES['homework_completed_images']['size'][$key];
                
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
                $directory = "../assets/uploadimages/homeworkcompletedimages"; 
                $source = '../assets/uploadimages/homeworkcompletedimages/'.$finalname;
                $im_php = imagecreatefromjpeg($source); 
                $new_height = imagesy($im_php); 
                imagejpeg($im_php, $directory.'/'.$finalname,$percentage);
            }
            
            if($documents == '')
            {
                $documents .= "1|$finalname|$datetime"; 
                $total_document = 1;
            }
            else
            {
                $doc_array = explode(';',$documents);
                $total_document = count($doc_array) + 1;
                $documents .= ";$total_document|$finalname|$datetime"; 
            }   
    	}
      
    	$query=mysqli_query($conn,"update `homework_completed_documents` set completed_documents_info = '$documents'  where homework_id='".$homework_id."' and student_id='$student_id'");  
    } 
	 
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);  
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "error";
    echo json_encode($response);
}
    
 
?>