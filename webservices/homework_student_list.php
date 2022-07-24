<?php
session_start();
require_once 'include/DB_Functions.php';  
    $homework_id = $_REQUEST['homework_id'];  
    $sql = mysqli_query($conn,"SELECT s.student_id, s.first_name,s.last_name,s.profile_picture,s.father_name, h.completed_documents_info,h.teacher_status,h.teacher_comments,h.student_read_status,h.total_views   FROM `homework_completed_documents` h inner join `students` s on h.student_id = s.student_id   WHERE h.homework_id = '".$homework_id."' ORDER BY s.`first_name`,s.`last_name` ");   
 
    if (@mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {   
	        $homework["student_name"] = $rows['first_name']." ".$rows['last_name'];
            if($rows['profile_picture'])
            { 
                $homework["student_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture'];
            } 
            else 
            {  
	            $homework["student_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
		    
            $homework["father_name"] = $rows['father_name']; 
            $homework["student_id"] = $rows['student_id']; 
            $homework["teacher_status"] = $rows['teacher_status']; 
            $homework["teacher_comments"] = $rows['teacher_comments']; 
            $homework["student_read_status"] = $rows['student_read_status'];  
            $homework["total_views"] = $rows['total_views'];  
            
            $homework['documents'] = array();   
            if($rows['completed_documents_info'] != NULL)
            {
                $document_array = explode(';',$rows['completed_documents_info']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]);
                    
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/homeworkcompletedimages/'.$string_array[1];
                    $documentimage["id"] = $string_array[0]; 
                    $documentimage["url"] = $imageUrl;  
                    $documentimage["upload_date"] = $string_array[2]; 
                    array_push($homework["documents"], $documentimage); 
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