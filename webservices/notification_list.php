<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';

    $cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id'];  
    
    $sql_count = mysqli_fetch_array(mysqli_query($conn,"SELECT count(notification_id) as total_unread_count FROM `notifications` WHERE user_id = '".$user_id."' and read_status='0'"));
    
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    $sql = mysqli_query($conn,"SELECT s.school_logo,s.school_name,n.notification_id,n.title,n.description,n.read_status,n.payload_id,n.payload_type,n.sent_datetime FROM `notifications` n inner join `schools` s on n.school_id = s.school_id   WHERE n.user_id = '".$user_id."' ORDER BY n.`sent_datetime` desc "); 
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200"; 
        $response["msg"] = "Success";  
        $response["total_unread_count"] = $sql_count['total_unread_count']; 
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {  
            if($rows['school_logo'])
            { 
                $notification["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $notification["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
            $notification["school_name"] = $rows['school_name']; 
            $notification["notification_id"] = $rows['notification_id']; 
            $notification["title"] = $rows['title'];
            $notification["description"] = mysqli_real_escape_string($conn,$rows['description']);
            $notification["payload_id"] = $rows['payload_id'];
            $notification["payload_type"] = $rows['payload_type'];
            $notification["sent_datetime"] = $rows['sent_datetime']; 
            $notification["read_status"] = $rows['read_status']; 
              
            array_push($response["data"], $notification);
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