<?php
date_default_timezone_set('Asia/Kolkata'); 
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$user_id = $_REQUEST['user_id'];    
$sql = mysqli_query($conn,"SELECT  s.first_name, s.last_name,s.profile_picture, crs.class_name_section, crs.class_register_student_id, s.student_id FROM class_register_students crs, students s, student_user_xref urx WHERE urx.user_id = '".$user_id."' and urx.student_id = s.student_id and crs.student_id = s.student_id
order by s.first_name, crs.class_register_id desc");  
    
    $totalcount = mysqli_num_rows($sql); 
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        
        $response["totalCount"] = $totalcount; 
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {   
            if($rows['profile_picture'] != '')
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture']; 
	        }
	        else
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/images/name.png"; 
	        }
	         
            $student["student_id"] = $rows['student_id'];
            if($rows['class_name_section'] != '')
            {
                $student["name"] = $rows['first_name']." ". $rows['last_name']." (".$rows['class_name_section'].")";  
            }  
            else
            { 
                $student["name"] = $rows['first_name']." ". $rows['last_name']; 
            }
            $student["class_register_student_id"] = $rows['class_register_student_id'];  
            $student["class_name_section"] = $rows['class_name_section'];  
            
            array_push($response["data"], $student);
             
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