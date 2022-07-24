<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $class_register_student_id = $_REQUEST['class_register_student_id']; 
    $document_id = $_REQUEST['document_id']; 
    
    $sql = mysqli_query($conn,"SELECT  documents_info from class_register_students  WHERE class_register_student_id = '".$class_register_student_id."'");   
    
    $rows = mysqli_fetch_array($sql); 	
        
    $document_array = explode(';',$rows['documents_info']); 
    
    $new_document_id = 1;
    $documents = NULL;
    for($i=0;$i<count($document_array);$i++)
    { 
        $string_array = explode('|',$document_array[$i]); 
        $current_document_id = $string_array[0];
        $document_title = $string_array[1];
        $document_name = $string_array[2];
        $document_add_date = $string_array[3];
        
        if($document_id == $current_document_id)
        {
            @chmod("../assets/uploadimages/student/documents/".$string_array[2], 0644);
	        @unlink("../assets/uploadimages/student/documents/".$string_array[2]);
        }
        else
        { 
            if($new_document_id == 1)
            {
                $documents .= "$new_document_id|$document_title|$document_name|$document_add_date";  
            }
            else
            { 
                $documents .= ";$new_document_id|$document_title|$document_name|$document_add_date"; 
            }   
            $new_document_id++;
        } 
    }   
    mysqli_query($conn,"update class_register_students set documents_info='$documents',total_documents= total_documents - 1  WHERE class_register_student_id = '".$class_register_student_id."'"); 
    
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);
    
 
?>