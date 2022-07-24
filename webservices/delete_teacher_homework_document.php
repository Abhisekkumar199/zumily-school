<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $homework_id = $_REQUEST['homework_id']; 
    $document_id = $_REQUEST['document_id']; 
    
    $sql = mysqli_query($conn,"SELECT  homework_documents_images from homework
  WHERE homework_id = '".$homework_id."'");   
    
    $rows = mysqli_fetch_array($sql); 	
        
    $document_array = explode(';',$rows['homework_documents_images']); 
    
    $new_document_id = 1;
    $documents = NULL;
    for($i=0;$i<count($document_array);$i++)
    { 
        $string_array = explode('|',$document_array[$i]); 
        $current_document_id = $string_array[0]; 
        $document_name = $string_array[1]; 
        
        if($document_id == $current_document_id)
        {
            @chmod("../assets/uploadimages/homeworkimages/".$string_array[1], 0644);
	        @unlink("../assets/uploadimages/homeworkimages/".$string_array[1]);
        }
        else
        { 
            if($new_document_id == 1)
            {
                $documents .= "$new_document_id|$document_name";  
            }
            else
            { 
                $documents .= ";$new_document_id|$document_name"; 
            }   
            $new_document_id++;
        } 
    }   
    mysqli_query($conn,"update homework set homework_documents_images='$documents',total_documents= total_documents - 1  WHERE homework_id = '".$homework_id."'"); 
    
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);
    
 
?>