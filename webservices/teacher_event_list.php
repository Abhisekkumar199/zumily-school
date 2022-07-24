<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 
$cmpdate = strtotime(date("Y-m-d"));  
$user_id = $_REQUEST['user_id'];  
$startIndex1 = $_REQUEST['start_index'];
$endIndex = 30 ; 
$startIndex = $startIndex1 * $endIndex ; 

    
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');  
    
    
    $totalcount = mysqli_fetch_array(mysqli_query($conn,"SELECT count(e.event_id) as total_events  FROM `events` e inner join `event_user_delivery` eu on e.event_id = eu.event_id   WHERE eu.user_id = '".$user_id."'"));   
    
    $sql = mysqli_query($conn,"SELECT e.event_images,e.school_id,e.event_id,e.total_images,e.title,e.description,e.date_created,e.start_date,e.start_time,e.end_time,e.creator_id,e.is_createdby_teacher, e.total_views FROM `events` e inner join `event_user_delivery` eu on e.event_id = eu.event_id   WHERE eu.user_id = '".$user_id."' ORDER BY e.`event_id` desc  limit $startIndex, $endIndex");   
    $total = $totalcount['total_events'];
    $totalindex = $total / $endIndex ;
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["totalCount"] = $total; 
        $response["data"] = array();
        while($rows_event = mysqli_fetch_array($sql))
        {  
            $sql_school = mysqli_fetch_array(mysqli_query($conn,"SELECT school_id,school_name,school_address,school_logo FROM `schools` WHERE  `school_id` = '".$rows_event['school_id']."'")); 
            $event["school_id"] = $sql_school['school_id'];  
            $event["school_name"] = $sql_school['school_name'];
            $event["school_address"] = $sql_school['school_address'];
            if($sql_school['school_logo'])
            { 
                $event["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$sql_school['school_logo'];
            } 
            else 
            {  
	            $event["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
		    
		    // getting teacher info if event created by teacher
		    if($rows_event['creator_id'] > 0)
		    {
		        $sql_teacher = mysqli_fetch_array(mysqli_query($conn,"SELECT first_name,last_name,profile_picture FROM `teachers` WHERE  `teacher_id` = '".$rows_event['creator_id']."'")); 
            
		        $event["teacher_name"] = $sql_teacher['first_name']." ".$sql_teacher['last_name'];
                if($sql_teacher['profile_picture'])
                { 
                    $event["teacher_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/".$sql_teacher['profile_picture'];
                } 
                else 
                {  
    	            $event["teacher_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
    		    }   
		        
		    }
		    else
		    {
		        $event["teacher_name"] = '';
		        $event["teacher_logo"] = '';
		    }
		    
            $event["event_id"] = $rows_event['event_id'];
            $event["title"] = $rows_event['title'];  
            $event["description"] = strip_tags(utf8_encode($rows_event['description']));
            $event["start_date"] = $rows_event['start_date'];  
            $event["start_time"] = $rows_event['start_time'];   
            $event["end_time"] = $rows_event['end_time'];  
            $event["date_created"] = $rows_event['date_created'];      
            $event["total_views"] = $rows_event['total_views'];      
            
            $event['images'] = array();
            if($rows_event['total_images'] > 0)
            {
                $document_array = explode(';',$rows_event['event_images']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]);
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/eventimages/'.$string_array[1]; 
                    $eventimage["image_url"] = $imageUrl; 
                    array_push($event["images"], $eventimage);
                }  
                
            } 
              
            array_push($response["data"], $event);
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
            $response["msg"] = "No event found";
            echo json_encode($response);
        }
    }
 
?>