<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
 
$user_id = $_REQUEST['user_id']; 
$student_id = $_REQUEST['student_id'];
$request_title = $_REQUEST['request_title']; 
$request_reason = $_REQUEST['request_reason']; 
$start_date = $_REQUEST['start_date']; 
$end_date = $_REQUEST['end_date'];  
mysqli_query($conn,"SET NAMES 'utf8'"); 
mysqli_query($conn,'SET CHARACTER SET utf8');
 $documents = '';   
    if(!empty($student_id))
    {
        $sql_student_data = mysqli_fetch_array(mysqli_query($conn,"SELECT s.school_id,cr.class_register_id,cr.class_name_section,cr.session_id,cr.session_year,cr.class_teacher_id FROM students s inner join `class_registers` cr on s.current_class_register_id=cr.class_register_id  WHERE s.student_id = '".$student_id."'")); 
        
        $sql1 = mysqli_query($conn,"insert into student_leave_requests set school_id='".$sql_student_data['school_id']."',user_id='".$user_id."',student_id='".$student_id."',session_id='".$sql_student_data['session_id']."',session_year='".$sql_student_data['session_year']."',class_register_id='".$sql_student_data['class_register_id']."',class_name='".$sql_student_data['class_name_section']."',class_teacher_id='".$sql_student_data['class_teacher_id']."',request_title='".$request_title."',request_reason='".$request_reason."',start_date='".$start_date."',end_date='".$end_date."', `date_created`='".date('Y-m-d H:i:s')."', `last_updated`='".date('Y-m-d H:i:s')."'");
        $id =mysqli_insert_id($conn);
        
        if($id > 0)
        {
            foreach($_FILES['leave_request_image']['name'] as $key => $tmp_name )
        	{
        	    $num1=rand(1000,9999);
                $num2=rand(1000,9999); 
                $finalnum=$num1."".$num2;
                $name= "lr_".$student_id."_".$id."_".$finalnum;
                
        	    $filename = $_FILES['leave_request_image']['name'][$key];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalname = $name.".".$ext;
        		$file_name = $key.$_FILES['leave_request_image']['name'][$key];
        		$file_size =$_FILES['leave_request_image']['size'][$key];
        		$file_tmp =$_FILES['leave_request_image']['tmp_name'][$key];
        		$file_type=$_FILES['leave_request_image']['type'][$key]; 
        	 
                $desired_dir="../assets/uploadimages/leaverequests";
                move_uploaded_file($file_tmp,"$desired_dir/".$finalname);
                
                
                $file_size =  $_FILES['leave_request_image']['size'][$key];
                
                if($file_size >= 4000000)
                {
                    $percentage = '10%';
                }
                else if($file_size >= 2000000 and $file_size < 4000000)
                { 
                    $percentage = '15%';
                }
                else if($file_size >= 400000 and $file_size < 1000000)
                {
                    $percentage = '20%';
                }
                else  
                {
                    $percentage = '30%';
                }
                
                $directory = "../assets/uploadimages/leaverequests"; 
                $source = '../assets/uploadimages/leaverequests/'.$finalname;
                $im_php = imagecreatefromjpeg($source); 
                $new_height = imagesy($im_php); 
                imagejpeg($im_php, $directory.'/'.$finalname,$percentage);
                
                if($documents == '')
                {
                    $documents .= "1|$finalname"; 
                    $total_document = 1;
                }
                else
                {
                    $doc_array = explode(';',$documents);
                    $total_document = count($doc_array) + 1;
                    $documents .= ";$total_document|$finalname"; 
                }  
        		 
        	}   
        	$query=mysqli_query($conn,"update `student_leave_requests` set total_images='".$total_document."',leave_requests_images='".$documents."' where student_leave_request_id='".$id."'");  
         
            $response["status"] = "200";
            $response["msg"] = "Success"; 
            echo json_encode($response);
        }
        else
        {
            $response["status"] = "400";
            $response["msg"] = "Error in creating leave request"; 
            echo json_encode($response); 
        }
    }    
    else
    {
        $response["status"] = "400";
        $response["msg"] = "Student is required";
        echo json_encode($response);
    }
?>