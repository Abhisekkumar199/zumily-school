<?php
session_start();
require_once 'include/DB_Functions.php';  
    $student_id = $_REQUEST['student_id']; 
    $homework_id = $_REQUEST['homework_id']; 
   
    $sql = mysqli_query($conn,"SELECT hcd.completed_documents_info,hcd.student_id, hcd.teacher_status, hcd.teacher_comments, hcd.student_read_status,hcd.last_comment_date   FROM `homework_completed_documents` hcd  WHERE hcd.student_id = '".$student_id."' and hcd.homework_id = '".$homework_id."'");   
 
    if (@mysqli_num_rows($sql) > 0) 
    {	
        $homework["status"] = "200";
        $homework["msg"] = "Success";  
        $rows = mysqli_fetch_array($sql);
            
        $homework["teacher_status"] = $rows['teacher_status'];  
        $homework["teacher_comment"] = $rows['teacher_comments'];  
        $homework["student_read_status"] = $rows['student_read_status']; 
        $homework["last_comment_date"] = $rows['last_comment_date']; 
        
       
        $homework['homework_completed_documents'] = array();   
        if($rows['completed_documents_info'] != NULL)
        {
            $document_array = explode(';',$rows['completed_documents_info']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]); 
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/homeworkcompletedimages/'.$string_array[1];
                $documentimage["id"] = $string_array[0]; 
                $documentimage["url"] = $imageUrl;   
                $documentimage["date"] = $string_array[2]; 
                array_push($homework["homework_completed_documents"], $documentimage); 
            }
        }
          
        echo json_encode($homework);
    } 
    else
    {
        if($startIndex > $total)
        {
            $response["status"] = "300";
            $response["msg"] = "";
            echo json_encode($response);
        }
        else
        {
            $response["status"] = "400";
            $response["msg"] = "No Record found";
            echo json_encode($response);
        }
    }
 
?>