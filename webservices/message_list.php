<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id']; 
    $school_id = $_REQUEST['school_id']; 
    $message_type_id = $_REQUEST['message_type_id']; 
    $startIndex1 = $_REQUEST['start_index'];
    $endIndex = 30 ; 
    $startIndex = $startIndex1 * $endIndex ; 
    if(!empty($school_id))
    {
        $school_filter = "and m.school_id = '".$school_id."'";
    }
    
    if(!empty($message_type_id))
    {
        $message_type_filter = "and m.message_type_id = '".$message_type_id."'";
    }
    
    
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    $totalcount = mysqli_fetch_array(mysqli_query($conn,"SELECT count(m.message_id) as totalrows   FROM `messages` m inner join `message_user_delivery` ms on m.message_id = ms.message_id WHERE ms.user_id = '".$user_id."' {$school_filter} {$message_type_filter}"));  
  
    $sql = mysqli_query($conn,"SELECT m.school_id,m.message_id,m.title,m.description,m.date_created,m.is_createdby_teacher,m.creator_id,m.total_images,m.message_images,m.message_type_id,m.total_views,m.message_type_display_name FROM `messages` m inner join `message_user_delivery` ms on m.message_id = ms.message_id   WHERE ms.user_id = '".$user_id."' {$school_filter} {$message_type_filter} ORDER BY m.`message_id` desc  limit $startIndex, $endIndex");   
    $total = $totalcount['totalrows'];
    $totalindex = $total / $endIndex ;
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["totalCount"] = $total; 
        $response["data"] = array();
        while($rows_message = mysqli_fetch_array($sql))
        {  
            $sql_school = mysqli_fetch_array(mysqli_query($conn,"SELECT school_id,school_name,school_address,school_logo FROM `schools` WHERE  `school_id` = '".$rows_message['school_id']."'")); 
            $message["school_id"] = $sql_school['school_id'];  
            $message["school_name"] = $sql_school['school_name'];
            $message["school_address"] = $sql_school['school_address'];
            if($sql_school['school_logo'])
            { 
                $message["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql_school['school_logo'];
            } 
            else 
            {  
	            $message["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
		    
		    // getting teacher info if message created by teacher
		    if($rows_message['creator_id'] > 0)
		    {
		        $sql_teacher = mysqli_fetch_array(mysqli_query($conn,"SELECT first_name,last_name,profile_picture FROM `teachers` WHERE  `teacher_id` = '".$rows_message['creator_id']."'")); 
            
		        $message["teacher_name"] = $sql_teacher['first_name']." ".$sql_teacher['last_name'];
                if($sql_teacher['profile_picture'])
                { 
                    $message["teacher_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/".$sql_teacher['profile_picture'];
                } 
                else 
                {  
    	            $message["teacher_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
    		    }   
		        
		    }
		    else
		    {
		        $message["teacher_name"] = '';
		        $message["teacher_logo"] = '';
		    }
		    
            $message["message_id"] = $rows_message['message_id'];
            $message["title"] = $rows_message['title'];  
            
            $message["message_type_id"] = $rows_message['message_type_id'];  
            $message["type"] = $rows_message['message_type_display_name'];  
            $message["description"] = strip_tags($rows_message['description']);
//            $message["description"] = strip_tags(utf8_encode($rows_message['description']));
            $message["total_views"] = $rows_message['total_views'];  
            $message["date_created"] = $rows_message['date_created'];  
            $message['images'] = array();
            
            if($rows_message['total_images'] > 0)
            {   
                $document_array = explode(';',$rows_message['message_images']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]);
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/messageimages/'.$string_array[1]; 
                    $messageimage["image_url"] = $imageUrl; 
                    array_push($message["images"], $messageimage);
                } 
             
            }
              
            array_push($response["data"], $message);
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
            $response["msg"] = "No message found";
            echo json_encode($response);
        }
    }
 
?>