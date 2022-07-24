<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $homework_id = $_REQUEST['homework_id']; 
    $sql = mysqli_query($conn,"SELECT  homework_documents_images from homework  WHERE homework_id = '".$homework_id."'");    
    $rows = mysqli_fetch_array($sql); 	 
    $document_array = explode(';',$rows['homework_documents_images']); 
     
    for($i=0;$i<count($document_array);$i++)
    { 
        $string_array = explode('|',$document_array[$i]);   
        @chmod("../assets/uploadimages/homeworkimages/".$string_array[1], 0755);
        @unlink("../assets/uploadimages/homeworkimages/".$string_array[1]); 
    }   
    
    mysqli_query($conn,"delete from  notifications  WHERE payload_id = '".$homework_id."' and payload_type='H'"); 
    mysqli_query($conn,"delete from  homework_completed_documents  WHERE homework_id = '".$homework_id."'"); 
    mysqli_query($conn,"delete from  homework_user_delivery  WHERE homework_id = '".$homework_id."'"); 
    mysqli_query($conn,"delete from  homework  WHERE homework_id = '".$homework_id."'"); 
    
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);
    
?>