<?php
session_start();
require_once 'include/DB_Functions.php';  
    $student_id = $_REQUEST['student_id']; 
    $homework_id = $_REQUEST['homework_id']; 
    $teacher_comments = $_REQUEST['teacher_comments']; 
    $teacher_status = $_REQUEST['teacher_status']; 
    $last_comment_date = $_REQUEST['date']; 
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    if($homework_id != '' and $student_id != '')
    {
        $sql = mysqli_query($conn,"UPDATE homework_completed_documents set teacher_comments = '".$teacher_comments."',teacher_status = '".$teacher_status."',last_comment_date = '".$last_comment_date."' WHERE student_id = '".$student_id."' and homework_id = '".$homework_id."'"); 
        $response["status"] = "200";
        $response["msg"] = "Success";  
        echo json_encode($response);
    }
    else
    {
        $response["status"] = "400";
        $response["msg"] = "Error";
        echo json_encode($response);
    }
      
  
?>