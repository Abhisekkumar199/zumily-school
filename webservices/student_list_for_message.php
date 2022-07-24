<?php
session_start();
require_once 'include/DB_Functions.php';
   
    $teacher_id =  $_REQUEST['teacher_id']; 
    $sql_student = mysqli_query($conn,"SELECT ss.student_id,ss.first_name,ss.last_name,ss.profile_picture,c.class_name,c.section,ss.father_name,ss.parent_mobile_no FROM class_registers cr inner join `class_register_students` crs on cr.class_register_id = crs.class_register_id  inner join `classes` c on cr.class_id = c.class_id  inner join `sessions` s on cr.session_id = s.session_id inner join `students` ss on crs.student_id = ss.student_id WHERE cr.class_teacher_id = '".$teacher_id."' and cr.is_active='1' order by first_name,last_name"); 
    
    if (mysqli_num_rows($sql_student) > 0) 
    {
         $response["status"] = "200";
        $response["msg"] = "Success";    
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql_student))
        {    
            $student_list["student_id"] = $rows['student_id']; 
            $student_list["student_name"] = $rows['first_name']." ".$rows['last_name']; 
            if($rows['profile_picture'])
            { 
                $student_list["student_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture'];
            } 
            else 
            {  
	            $student_list["student_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }  
            $student_list["class_name"] = $rows['class_name']; 
            $student_list["section"] = $rows['section']; 
            $student_list["father_name"] = $rows['father_name']; 
            $student_list["parent_mobile_no"] = $rows['parent_mobile_no'];  
            array_push($response["data"], $student_list);
        }  
        echo json_encode($response);
    } 
    else
    { 
        $response["status"] = "400";
        $response["msg"] = "No record found";
        echo json_encode($response); 
    }
     
 
?>