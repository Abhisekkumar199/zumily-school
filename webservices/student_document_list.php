<?php
session_start();
require_once 'include/DB_Functions.php'; 
    $class_register_id = $_REQUEST['class_register_id'];  
    $student_id = $_REQUEST['student_id'];  
  mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');   
    $sql = mysqli_query($conn,"SELECT   class_register_student_id,documents_info from class_register_students  WHERE class_register_id = '".$class_register_id."' and  student_id= '".$student_id."'");   
  
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $rows = mysqli_fetch_array($sql);
        if($rows['documents_info'] != '')
        {  
             
            $response["data"] = array();
            $document_array = explode(';',$rows['documents_info']);  
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $document["class_register_student_id"] = $rows['class_register_student_id'];
                $document["document_id"] = $string_array[0];
                $document["title"] = $string_array[1];
                $document["url"] = "https://localhost/project/zumilyschool/assets/uploadimages/student/documents/".$string_array[2];
                $document["adddate"] =  $string_array[3]; 
                
                array_push($response["data"], $document);
            }   
            echo json_encode($response);
        }
        else
        {
            $response["status"] = "400";
            $response["msg"] = "No document found";
            echo json_encode($response); 
        }
        
    }  
    else
    { 
        $response["status"] = "400";
        $response["msg"] = "No document found";
        echo json_encode($response); 
    }
 
?>