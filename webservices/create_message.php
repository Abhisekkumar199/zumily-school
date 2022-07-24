<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 
$datetime = $_REQUEST['datetime'];  

$teacher_id = $_REQUEST['teacher_id']; 
$title = ucwords($_REQUEST['title']); 
$desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);
$message_type_id = $_REQUEST['message_type_id']; 
$sending_to = $_REQUEST['sending_to']; 
$school_id = $_REQUEST['school_id']; 
$class_register_ids= $_REQUEST['class_register_ids']; 
$student_ids =  $_REQUEST['student_ids']; 

    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
if($title != '')  
{
    $sql_message_types=mysqli_fetch_assoc(mysqli_query($conn,"select display_name from `message_types` where message_type_id = '".$message_type_id."'")); 
    
    $mesage_type = $sql_message_types['display_name'];
     
    $query=mysqli_query($conn,"insert into `messages` set  `school_id`='".$school_id."',`title`='".$title."',`description` = '".$desc."', `message_type_id` = '".$message_type_id."', `message_type_display_name` = '".$mesage_type."', `sending_to`='".$sending_to."', `is_createdby_teacher`='1', `creator_id`='".$teacher_id."', `date_created`='".$datetime."', `last_updated`='".$datetime."'");  
    $message_id =mysqli_insert_id($conn);      
    
    if($message_id > 0)
    {
        if($_REQUEST['sending_to'] == 'C')
        {
            // sending message to classes
             
            
            $sql_user=mysqli_query($conn,"select s.user_id from `class_register_students` c inner join student_user_xref s on c.student_id=s.student_id where class_register_id IN (".$class_register_ids.") UNION  select user_id from teacher_user_xref where teacher_id IN (".$teacher_id.") and is_active='1'");
         
            while($rows = mysqli_fetch_assoc($sql_user))
            {
                $query=mysqli_query($conn,"INSERT INTO `message_user_delivery`(`message_id`,`user_id`) VALUES ('".$message_id."','".$rows['user_id']."')");  
                $query_notification=mysqli_query($conn,"INSERT INTO `notifications`(`school_id`,`payload_id`,`payload_type`,`title`,`description`,`user_id`) VALUES ('".$school_id."','".$message_id."','M','".$title."','".$desc."','".$rows['user_id']."')"); 
            }   
            $query=mysqli_query($conn,"update `messages` set sending_list='".$class_register_ids."' where message_id='".$message_id."'");  
        }
        else
        {
            // sending message to students
            
           $sql_user=mysqli_query($conn,"select user_id from `student_user_xref`  where student_id IN ('".$student_ids."')");
         
            while($rows = mysqli_fetch_assoc($sql_user))
            {
                $query=mysqli_query($conn,"INSERT INTO `message_user_delivery`(`message_id`,`user_id`) VALUES ('".$message_id."','".$rows['user_id']."','0')"); 
                
                $query_notification=mysqli_query($conn,"INSERT INTO `notifications`(`school_id`,`payload_id`,`payload_type`,`title`,`description`,`user_id`) VALUES ('".$school_id."','".$message_id."','M','".$title."','".$desc."','".$rows['user_id']."')"); 
            }   
            $query=mysqli_query($conn,"update `messages` set sending_list='".$student_ids."' where message_id='".$message_id."'");  
        }
        
        $message_images=$_FILES["message_images"];  
         
    	 $documents = '';   
        if($message_images["name"][0]!="")
        { 
            $x = 1;
            foreach($_FILES['message_images']['name'] as $key => $tmp_name )
        	{
        	    $num1=rand(1000,9999);
                $num2=rand(1000,9999); 
                $finalnum=$num1."".$num2; 
                $name= "m_".$school_id."_".$message_id."_".$finalnum;
                
        	    $filename = $_FILES['message_images']['name'][$key];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalname = $name.".".$ext;
                
        		$file_name = $key.$_FILES['message_images']['name'][$key];
        		$file_size =$_FILES['message_images']['size'][$key];
        		$file_tmp =$_FILES['message_images']['tmp_name'][$key];
        		$file_type=$_FILES['message_images']['type'][$key]; 
        		 
                $desired_dir="../assets/uploadimages/messageimages"; 
                
                move_uploaded_file($file_tmp,"$desired_dir/".$finalname); 
                $x++;
                
                $file_size =  $_FILES['message_images']['size'][$key];
                
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
                
                $directory = "../assets/uploadimages/messageimages"; 
                $source = '../assets/uploadimages/messageimages/'.$finalname;
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
        	
        	$query=mysqli_query($conn,"update `messages` set total_images='".$total_document."',message_images='".$documents."' where message_id='".$message_id."'");  
        } 
        send_notification(); 
    }
    else
    {
        $response["status"] = "400";
        $response["msg"] = "Error in creating message"; 
        echo json_encode($response); 
    }
    
    $response["status"] = "200";
    $response["msg"] = "Success"; 
    echo json_encode($response);  
} 
else
{
    $response["status"] = "400";
    $response["msg"] = "error";
    echo json_encode($response);
}
    
 
?>