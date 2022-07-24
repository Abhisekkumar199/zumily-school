<?php
date_default_timezone_set('Asia/Kolkata'); 
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$user_id = $_REQUEST['user_id'];    
$sql = mysqli_query($conn,"SELECT  s.student_id,s.address,s.first_name,s.last_name,s.profile_picture, s.mobile_no,s.email_id,s.father_name,s.mother_name,s.parent_mobile_no,s.date_of_birth,s.current_class_register_id,s1.school_name,s1.school_id,s1.school_address,s1.school_logo, cr.class_name_section, cr.session_year, cr.room_no, t.first_name as teacher_first_name,t.last_name as teacher_last_name,t.mobile_no as teacher_mobile_no FROM  `student_user_xref` sux inner join `students` s on sux.student_id = s.student_id inner join `schools` s1 on s.school_id = s1.school_id inner join `class_registers` cr on s.current_class_register_id = cr.class_register_id  inner join teachers t on cr.class_teacher_id = t.teacher_id WHERE sux.user_id = '".$user_id."' ORDER BY s.`first_name` asc "); 

    
$totalcount = mysqli_num_rows($sql); 
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {  
             
            $class_register_id = $rows['current_class_register_id'];  
            if($rows['profile_picture'] != '')
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture']; 
	        }
	        else
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/images/name.png"; 
	        }
	        
            $student["student_id"] = $rows['student_id']; 
            $student["first_name"] = $rows['first_name'];  
            $student["last_name"] = $rows['last_name'];
            $student["mobile_no"] = $rows['mobile_no']; 
            $student["email_id"] = $rows['email_id'];
            $student["father_name"] = $rows['father_name'];
            $student["mother_name"] = $rows['mother_name'];
            $student["parent_mobile_no"] = $rows['parent_mobile_no'];
            $student["date_of_birth"] = $rows['date_of_birth']; 
            $student["address"] = $rows['address']; 
            $student["school_id"] = $rows['school_id']; 
            $student["school_name"] = $rows['school_name'];
            $student["school_address"] = $rows['school_address'];
            if($rows['school_logo'])
            { 
                $student["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $student["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }  
        
            $student["class_teacher"] = $rows['teacher_first_name']." ".$sql1['teacher_last_name']; 
            $student["class_teacher_mobile"] = $rows['teacher_mobile_no']; 
            $student["class_session"] = $rows['session_year']; 
            $student["class_section"] = $rows['class_name_section']; 
            $student["class_room_no"] = $rows['room_no']; 
            
            array_push($response["data"], $student);
             
        } 
         
        $response["totalCount"] = $totalcount; 
        echo json_encode($response);
        
    } 
    else
    {
         
        $response["status"] = "400";
        $response["msg"] = "No record found";
        echo json_encode($response);
         
    }
     
 
?>