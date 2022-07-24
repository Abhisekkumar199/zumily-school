<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 
$notification_id = $_REQUEST['notification_id'];  
$payload_type = $_REQUEST['payload_type'];  
$payload_id = $_REQUEST['payload_id']; 
$user_id = $_REQUEST['user_id']; 

if ($notification_id !='') 
{ 
    $sql_count = mysqli_query($conn,"update `notifications` set read_status='1',read_datetime='".date("Y-m-d H:i")."' WHERE notification_id = '".$notification_id."' and read_status='0'"); 
    $response["status"] = "200"; 
    $response["msg"] = "Success";   
    if($payload_type == 'M')
    {
        $update_message = mysqli_query($conn,"update `messages` set total_views = total_views + 1 WHERE message_id = '".$payload_id."'");
    
        if($user_id != '')
        { 
            $update_message_delivery = mysqli_query($conn,"update `message_user_delivery` set read_status = '1',read_datetime='".date("Y-m-d h:i")."' WHERE message_id = '".$payload_id."' and user_id='".$user_id."'");
        }
        
        $sql = mysqli_fetch_array(mysqli_query($conn,"SELECT s.school_id,s.school_name,s.school_address,s.school_logo,m.message_id,m.title,m.description,m.date_created,m.is_createdby_teacher,m.creator_id,m.total_images,m.message_type_id,m.message_images,m.message_type_display_name FROM `messages` m  inner join `schools` s on m.school_id = s.school_id   WHERE m.message_id = '".$payload_id."'"));    
         
        $response["data"]["title"] = $sql['title'];  
        $response["data"]["type"] = $sql['message_type_display_name'];  
        $response["data"]["description"] = strip_tags(utf8_encode($sql['description']));
        $response["data"]["start_date"] = '';  
        $response["data"]["start_time"] = '';   
        $response["data"]["end_time"] = ''; 
        $response["data"]["date_created"] = $sql['date_created'];
        
        $response["data"]['images'] = array(); 
        if($sql['total_images'] > 0)
        {
            $document_array = explode(';',$sql['message_images']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/messageimages/'.$string_array[1]; 
                $messageimage["image_url"] = $imageUrl; 
                array_push($response["data"]["images"], $messageimage);
            }  
        }
        
    
        $response["data"]["school_id"] = $sql['school_id'];  
        $response["data"]["school_name"] = $sql['school_name'];
        $response["data"]["school_address"] = $sql['school_address'];
        if($sql['school_logo'])
        { 
            $response["data"]["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql['school_logo'];
        } 
        else 
        {  
            $response["data"]["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }   
        
        // getting teacher info if message created by teacher
        if($sql['creator_id'] > 0)
        {
            $sql_teacher = mysqli_fetch_array(mysqli_query($conn,"SELECT first_name,last_name,profile_picture FROM `teachers` WHERE  `teacher_id` = '".$sql['creator_id']."'")); 
        
            $response["data"]["teacher_name"] = $sql_teacher['first_name']." ".$sql_teacher['last_name'];
            if($sql_teacher['profile_picture'])
            { 
                $response["data"]["teacher_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/".$sql_teacher['profile_picture'];
            } 
            else 
            {  
                $response["data"]["teacher_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
    	    }   
            
        }
        else
        {
            $response["data"]["teacher_name"] = '';
            $response["data"]["teacher_logo"] = '';
        }
        
    }
    else if($payload_type == 'E')
    {
        
        $sql_count = mysqli_query($conn,"update `events` set total_views = total_views + 1 WHERE event_id = '".$payload_id."'");
        
        if($user_id != '')
        { 
            $update_event_delivery = mysqli_query($conn,"update `event_user_delivery` set read_status = '1',read_datetime='".date("Y-m-d h:i")."' WHERE event_id = '".$payload_id."' and user_id='".$user_id."'");
        }
         
        $sql = mysqli_fetch_array(mysqli_query($conn,"SELECT s.school_id,s.school_name,s.school_address,s.school_logo,e.event_id,e.total_images,e.title,e.description,e.date_created,e.start_date,e.start_time,e.end_time,e.is_createdby_teacher,e.creator_id,e.event_images FROM `events` e inner join `schools` s on e.school_id = s.school_id WHERE e.event_id = '".$payload_id."' "));   
        
        $response["data"]["title"] = $sql['title'];  
        $response["data"]["description"] = strip_tags(utf8_encode($sql['description']));
        $response["data"]["start_date"] = $sql['start_date'];  
        $response["data"]["start_time"] = $sql['start_time'];   
        $response["data"]["end_time"] = $sql['end_time'];  
        $response["data"]["date_created"] = $sql['date_created'];  
        
        $response["data"]['images'] = array();
        if($sql['total_images'] > 0)
        {
            $document_array = explode(';',$sql['event_images']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/eventimages/'.$string_array[1]; 
                $eventimage["image_url"] = $imageUrl; 
                array_push($response["data"]["images"], $eventimage);
            }  
           
        } 
         
        $response["data"]["school_id"] = $sql['school_id'];  
        $response["data"]["school_name"] = $sql['school_name'];
        $response["data"]["school_address"] = $sql['school_address'];
        if($sql['school_logo'])
        { 
            $response["data"]["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql['school_logo'];
        } 
        else 
        {  
            $response["data"]["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }   
        
        // getting teacher info if message created by teacher
        if($sql['creator_id'] > 0)
        {
            $sql_teacher = mysqli_fetch_array(mysqli_query($conn,"SELECT first_name,last_name,profile_picture FROM `teachers` WHERE  `teacher_id` = '".$sql['creator_id']."'")); 
        
            $response["data"]["teacher_name"] = $sql_teacher['first_name']." ".$sql_teacher['last_name'];
            if($sql_teacher['profile_picture'])
            { 
                $response["data"]["teacher_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/".$sql_teacher['profile_picture'];
            } 
            else 
            {  
                $response["data"]["teacher_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
    	    }   
            
        }
        else
        {
            $response["data"]["teacher_name"] = '';
            $response["data"]["teacher_logo"] = '';
        }
        
    } 
    else if($payload_type == 'H')
    {
        
        $sql_count = mysqli_query($conn,"update `homework` set total_views = total_views + 1 WHERE homework_id = '".$homework_id."'");
        
        if($user_id != '')
        { 
            $update_homework_delivery = mysqli_query($conn,"update `homework_user_delivery` set read_status = '1',read_datetime='".date("Y-m-d h:i")."' WHERE homework_id = '".$payload_id."' and user_id='".$user_id."'");
        }
        
        $sql = mysqli_fetch_array(mysqli_query($conn,"SELECT s.school_name,s.school_logo,s.school_address,h.homework_id,h.teacher_name,h.due_date,h.total_documents,h.title,h.description,h.date_created,h.homework_documents_images FROM `homework` h inner join schools s on h.school_id = s.school_id  WHERE homework_id = '".$payload_id."' "));  
       
          
        $response["data"]["school_name"] = $sql['school_name']; 
        $response["data"]["school_address"] = $sql['school_address'];
        if($sql['school_logo'])
        { 
            $response["data"]["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql['school_logo'];
        } 
        else 
        {  
            $response["data"]["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }   
        
        $response["data"]["title"] = $sql['title'];  
        $response["data"]["description"] = strip_tags(utf8_encode($sql['description'])); 
        $response["data"]["date_created"] = $sql['date_created'];  
        $response["data"]["teacher_name"] = $sql['teacher_name'];  
        $response["data"]["due_date"] = $sql['due_date'];  
        
        $response["data"]['images'] = array();
        if($sql['total_documents'] > 0)
        {
            $document_array = explode(';',$sql['homework_documents_images']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/homeworkimages/'.$string_array[1]; 
                $eventimage["image_url"] = $imageUrl; 
                array_push($response["data"]["images"], $eventimage);
            }  
        } 
        
    } 
    else if($payload_type == 'D')
    { 
     
        $sql = mysqli_fetch_array(mysqli_query($conn,"SELECT sc.school_address,sc.school_name,sc.school_logo,s.first_name,s.last_name,s.profile_picture,c.class_name_section,c.documents_info,c.total_documents,c.date_created  FROM `class_register_students` c inner join students s on c.student_id=s.student_id inner join schools sc on s.school_id=sc.school_id WHERE c.class_register_student_id = '".$payload_id."' "));   
        
         
          
        $response["data"]["school_name"] = $sql['school_name']; 
        $response["data"]["school_address"] = $sql['school_address'];
        if($sql['school_logo'])
        { 
            $response["data"]["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql['school_logo'];
        } 
        else 
        {  
            $response["data"]["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }    
        
        $response["data"]["first_name"] = $sql['first_name'];
        $response["data"]["last_name"] = $sql['last_name'];  
        if($sql['profile_picture'])
        { 
            $response["data"]["profile_pic"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$sql['profile_picture'];
        } 
        else 
        {  
            $response["data"]["profile_pic"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }  
        
        
           
        $response["data"]["class_name_section"] = $sql['class_name_section']; 
        $response["data"]["date_created"] = $sql['date_created'];  
        
        $response["data"]['images'] = array();
        if($sql['total_documents'] > 0)
        {
            $document_array = explode(';',$sql['documents_info']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/student/documents/'.$string_array[2]; 
                $documentinfo["title"] = $string_array[1];
                $documentinfo["image_url"] = $imageUrl; 
                array_push($response["data"]["images"], $documentinfo);
            }  
        } 
        
    } 
    else if($payload_type == 'L')
    { 
     
        $sql = mysqli_fetch_array(mysqli_query($conn,"SELECT sc.school_address,sc.school_name,sc.school_logo,sc.school_address,s.first_name,s.last_name,s.profile_picture,slr.leave_requests_images,slr.total_images,slr.request_title,slr.request_reason,slr.session_year,slr.start_date,slr.end_date,slr.request_status,slr.approved_by,slr.comment,slr.date_created FROM `student_leave_requests` slr inner join students s on slr.student_id=s.student_id inner join schools sc on s.school_id=sc.school_id  WHERE student_leave_request_id = '".$payload_id."'"));    
         
         
         
        $response["data"]["school_name"] = $sql['school_name']; 
        $response["data"]["school_address"] = $sql['school_address'];
        if($sql['school_logo'])
        { 
            $response["data"]["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql['school_logo'];
        } 
        else 
        {  
            $response["data"]["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }    
        
        $response["data"]["first_name"] = $sql['first_name'];
        $response["data"]["last_name"] = $sql['last_name'];  
        if($sql['profile_picture'])
        { 
            $response["data"]["profile_pic"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$sql['profile_picture'];
        } 
        else 
        {  
            $response["data"]["profile_pic"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
        }   
         
        $response["data"]["title"] = $sql['request_title'];   
        $response["data"]["description"] = strip_tags(utf8_encode($sql['request_reason']));
        $response["data"]["session_year"] = $sql['session_year']; 
        $response["data"]["start_date"] = $sql['start_date'];
        $response["data"]["end_date"] = $sql['end_date'];
        $response["data"]["request_status"] = $sql['request_status'];
        $response["data"]["approved_by"] = $sql['approved_by'];
        $response["data"]["comment"] = $sql['comment'];
        $response["data"]["date_created"] = $sql['date_created'];
        
        $response["data"]['images'] = array(); 
        if($sql['total_images'] > 0)
        {
            $document_array = explode(';',$sql['leave_requests_images']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/leaverequests/'.$string_array[1]; 
                $leaverequestimage["image_url"] = $imageUrl; 
                array_push($response["data"]["images"], $leaverequestimage);
            }  
        } 
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