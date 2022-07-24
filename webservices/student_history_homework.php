<?php
session_start();
require_once 'include/DB_Functions.php';  
    $student_id = $_REQUEST['student_id']; 
    $current_date = $_REQUEST['date']; 
    
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    $sql = mysqli_query($conn,"SELECT s.school_name,s.school_logo,s.school_address, h.teacher_id, h.teacher_name, h.class_register_id, h.class_name_section, h.homework_id, h.homework_type, h.title, h.description, h.due_date, h.date_created,h.homework_documents_images, h.total_views, hcd.completed_documents_info,hcd.student_id, hcd.teacher_status, hcd.teacher_comments, hcd.student_read_status   FROM `homework` h  inner join  `schools` s on h.school_id = s.school_id inner join `homework_completed_documents` hcd on h.homework_id = hcd.homework_id   WHERE hcd.student_id = '".$student_id."' and (hcd.teacher_status = 1 and h.due_date < '$current_date') ORDER BY h.`due_date` desc");   
 
    if (@mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {    
            $homework["school_name"] = $rows['school_name'];
	        if($rows['school_logo'])
            { 
                $homework["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $homework["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }    
            $homework["school_address"] = $rows['school_address']; 
            
            
            
            $homework["student_id"] = $rows['student_id']; 
            $homework["teacher_id"] = $rows['teacher_id']; 
            $homework["teacher_name"] = $rows['teacher_name']; 
            $homework["class_register_id"] = $rows['class_register_id'];  
            $homework["class_name_section"] = $rows['class_name_section'];  
            $homework["homework_id"] = $rows['homework_id'];  
            $homework["homework_type"] = $rows['homework_type'];  
            $homework["title"] = $rows['title'];  
            $homework["description"] = $rows['description'];  
            $homework["due_date"] = $rows['due_date'];  
            $homework["date_created"] = $rows['date_created'];  
            $homework["teacher_status"] = $rows['teacher_status'];  
            $homework["teacher_comment"] = $rows['teacher_comments'];  
            $homework["student_read_status"] = $rows['student_read_status'];  
            $homework["total_views"] = $rows['total_views'];  
            
            $homework['homework_documents'] = array();   
            if($rows['homework_documents_images'] != NULL)
            {
                $document_array = explode(';',$rows['homework_documents_images']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]); 
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/homeworkimages/'.$string_array[1];
                    $documentimage["id"] = $string_array[0]; 
                    $documentimage["url"] = $imageUrl;   
                    array_push($homework["homework_documents"], $documentimage); 
                }
            }
            
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
              
            array_push($response["data"], $homework);
        }  
        echo json_encode($response);
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