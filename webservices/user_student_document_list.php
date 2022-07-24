<?php
session_start();
require_once 'include/DB_Functions.php';
  
$user_id = $_REQUEST['user_id'];  
mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    $sql = mysqli_query($conn,"SELECT   s.first_name,s.last_name,s.profile_picture,s.father_name,s.date_of_birth,s1.school_name,s1.school_address,s1.school_logo,crs.documents_info,crs.class_register_student_id,crs.student_id,crs.class_register_id FROM  `student_user_xref` sux inner join `students` s on sux.student_id = s.student_id inner join `schools` s1 on s.school_id = s1.school_id inner join `class_register_students` crs on s.student_id = crs.student_id  WHERE sux.user_id = '".$user_id."' ORDER BY s.`first_name`asc ,crs.class_name_section desc ");  
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {  
             
            $document["first_name"] = $rows['first_name'];
            $document["last_name"] = $rows['last_name']; 
            
            if($rows['profile_picture'])
            { 
                $document["student_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture'];
            } 
            else 
            {  
	            $document["student_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }  
            $document["father_name"] = $rows['father_name'];
            $document["school_name"] = $rows['school_name'];
            $document["school_address"] = $rows['school_address'];
            if($rows['school_logo'])
            { 
                $document["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $document["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }  
		    
		    
            $document["class_register_student_id"] = $rows['class_register_student_id'];
            $document["student_id"] = $rows['student_id'];
            $document["class_register_id"] = $rows['class_register_id'];
            $document['documents'] = array();
             
            if($rows['documents_info'] != '')
            {
                $document_array = explode(';',$rows['documents_info']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]);
                    
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/student/documents/'.$string_array[2];
                    $documentimage["id"] = $string_array[0];
                    $documentimage["title"] = $string_array[1];
                    $documentimage["date"] = $string_array[2];
                    $documentimage["url"] = $imageUrl; 
                    array_push($document["documents"], $documentimage); 
                } 
            }   
            array_push($response["data"], $document);
        }  
        echo json_encode($response);
    } 
    else
    { 
        $response["status"] = "400";
        $response["msg"] = "No message found";
        echo json_encode($response);
         
    }
 
?>