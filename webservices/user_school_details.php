<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id'];   
     

    $sql = mysqli_query($conn,"SELECT s.school_name,s.school_logo,s.school_address,s.school_description,s.contact_person,s.email_id,s.phone,s.principal_name,s.vice_principal_name,s.principal_mobile_no,s.vice_principal_mobile_no,s.transport_incharge,s.transport_incharge_mobile_no,s.school_website,s.school_facebook_page, s.school_youtube_channel FROM `schools` s WHERE s.school_id IN (select school_id from student_user_xref where user_id = $user_id UNION select school_id from teacher_user_xref where user_id = $user_id)");   
        
    $totalcount= mysqli_num_rows($sql); 
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["totalCount"] = $totalcount; 
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {   
            $student["school_name"] = $rows['school_name'];  
            if($rows['school_logo'])
            { 
                $student["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $student["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
            $student["school_address"] = $rows['school_address']; 
            $student["school_description"] = '';
            $student["contact_person"] = $rows['contact_person'];
            $student["email_id"] = $rows['email_id'];
            $student["phone"] = $rows['phone'];
            $student["principal_name"] = $rows['principal_name']; 
            $student["vice_principal_name"] = $rows['vice_principal_name'];
            $student["principal_mobile_no"] = $rows['principal_mobile_no'];
            $student["vice_principal_mobile_no"] = $rows['vice_principal_mobile_no'];
            $student["transport_incharge"] = $rows['transport_incharge'];
            $student["transport_incharge_mobile_no"] = $rows['transport_incharge_mobile_no'];
            $student["school_website"] = $rows['school_website'];
            $student["school_facebook_page"] = $rows['school_facebook_page'];  
            $student["school_youtube_channel"] = $rows['school_youtube_channel']; 
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