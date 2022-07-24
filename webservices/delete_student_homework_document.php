<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $homework_id = $_REQUEST['homework_id']; 
    $student_id = $_REQUEST['student_id']; 
    $document_id = $_REQUEST['document_id']; 
    
    $sql = mysqli_query($conn,"SELECT  completed_documents_info from homework_completed_documents
  WHERE homework_id = '".$homework_id."' and student_id = '".$student_id."'");   
    
    $rows = mysqli_fetch_array($sql); 	
        
    $document_array = explode(';',$rows['completed_documents_info']); 
    
    $new_document_id = 1;
    $documents = NULL;
    for($i=0;$i<count($document_array);$i++)
    { 
        $string_array = explode('|',$document_array[$i]); 
        $current_document_id = $string_array[0]; 
        $document_name = $string_array[1]; 
        $date_time = $string_array[2]; 
        
        if($document_id == $current_document_id)
        {
            @chmod("../assets/uploadimages/homeworkcompletedimages/".$string_array[1], 0644);
	        @unlink("../assets/uploadimages/homeworkcompletedimages/".$string_array[1]);
        }
        else
        { 
            if($new_document_id == 1)
            {
                $documents .= "$new_document_id|$document_name|$date_time";  
            }
            else
            { 
                $documents .= ";$new_document_id|$document_name|$date_time"; 
            }   
            $new_document_id++;
        } 
    }   
    mysqli_query($conn,"update homework_completed_documents set completed_documents_info='$documents' WHERE homework_id = '".$homework_id."' and student_id = '".$student_id."'"); 
    
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);
    
 
?>