<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
  
$teacher_id = $_REQUEST['teacher_id']; 
$datetime = $_REQUEST['datetime']; 

$title = ucwords($_REQUEST['title']); 
$desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);
$event_date = $_REQUEST['event_date']; 
$start_time = $_REQUEST['start_time']; 
$end_time = $_REQUEST['end_time']; 
$sending_to = $_REQUEST['sending_to']; 
$school_id = $_REQUEST['school_id']; 
$class_register_ids= $_REQUEST['class_register_ids'];  
if($title != '')  
{
    
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    
    $query=mysqli_query($conn,"insert into `events` set  `school_id`='".$school_id."',`title`='".$title."',`description` = '".$description."', `start_date` = '".$event_date."', `start_time` = '".$start_time."', `end_time` = '".$end_time."', `sending_to`='".$sending_to."', `is_createdby_teacher`='1', `creator_id`='".$teacher_id."', `date_created`='".$datetime."', `last_updated`='".$datetime."'");  
    $event_id =mysqli_insert_id($conn);      
     
    if($event_id > 0)
    { 
        if($_REQUEST['sending_to'] == 'C')
        {
             
            $sql_user=mysqli_query($conn,"select s.user_id from `class_register_students` c inner join student_user_xref s on c.student_id=s.student_id where class_register_id IN (".$class_register_ids.") UNION  select user_id from teacher_user_xref where teacher_id IN (".$teacher_id.") and is_active='1'");
         
            while($rows = mysqli_fetch_assoc($sql_user))
            {
                $query=mysqli_query($conn,"INSERT INTO `event_user_delivery`(`event_id`,`user_id`) VALUES ('".$event_id."','".$rows['user_id']."')"); 
                
                
                $query_notification=mysqli_query($conn,"INSERT INTO `notifications`(`school_id`,`payload_id`,`payload_type`,`title`,`description`,`user_id`) VALUES ('".$school_id."','".$event_id."','E','".$title."','".$desc."','".$rows['user_id']."')"); 
            }   
            $query=mysqli_query($conn,"update `events` set sending_list='".$class_register_ids."' where event_id='".$event_id."'");  
        }
       
        $event_images=$_FILES["event_images"];   
        $documents = '';   
        
        if($event_images["name"][0]!="")
        {  
            $x = 1;
            foreach($_FILES['event_images']['name'] as $key => $tmp_name )
        	{
        	    
        	    $num1=rand(1000,9999);
                $num2=rand(1000,9999); 
                $finalnum=$num1."".$num2; 
                $name= "e_".$school_id."_".$event_id."_".$finalnum;
                
        	    $filename = $_FILES['event_images']['name'][$key];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalname = $name.".".$ext;
        		$file_name = $key.$_FILES['event_images']['name'][$key];
        		$file_size =$_FILES['event_images']['size'][$key];
        		$file_tmp =$_FILES['event_images']['tmp_name'][$key];
        		$file_type=$_FILES['event_images']['type'][$key]; 
        		 
                $desired_dir="../assets/uploadimages/eventimages"; 
                 
                move_uploaded_file($file_tmp,"$desired_dir/".$finalname); 
                
                $x++;
                
                $file_size =  $_FILES['event_images']['size'][$key];
                
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
                
                $directory = "../assets/uploadimages/eventimages"; 
                $source = '../assets/uploadimages/eventimages/'.$finalname;
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
        	
        	$query=mysqli_query($conn,"update `events` set total_images='".count($event_images)."',event_images='".$documents."' where event_id='".$event_id."'"); 
        }
        send_notification(); 
        
        $response["status"] = "200";
        $response["msg"] = "Success"; 
        echo json_encode($response);  
    }
    else
    {
        $response["status"] = "400";
        $response["msg"] = "Error in creating event"; 
        echo json_encode($response); 
    }
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "error";
    echo json_encode($response);
}
    
 
?>