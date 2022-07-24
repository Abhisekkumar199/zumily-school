<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php'; 

$datetime = $_REQUEST['datetime'];  
$teacher_id = $_REQUEST['teacher_id'];  
$teacher_name = $_REQUEST['teacher_name'];  
$subject1 = $_REQUEST['subject1']; 

if($teacher_name !='')
{
    $teacher_name_with_subject = $teacher_name."(".$subject1.")";
}
else
{
    $teacher_name_with_subject = NULL;
}
$school_id = $_REQUEST['school_id']; 
$title = ucwords($_REQUEST['title']); 
$desc = mysqli_real_escape_string($conn,$_REQUEST['desc']);  
$homework_type = $_REQUEST['homework_type']; 
$due_date = $_REQUEST['due_date'];  
$class_register_id= $_REQUEST['class_register_id']; 

$sql_class_register = mysqli_fetch_assoc(mysqli_query("select session_year from class_registers where class_register_id='".$class_register_id."'"));
$session_year = $sql_class_register['session_year'];
$class_name_section = $_REQUEST['class_name_section'];
$documents = $_FILES["document"];   
mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
if($title != '')  
{
    $query=mysqli_query($conn,"insert into `homework` set  `school_id`='".$school_id."',`session_year`='".$session_year."',`title`='".$title."',`description` = '".$desc."',total_documents='$total_document', `class_register_id` = '$class_register_id', `class_name_section` = '".$class_name_section."',homework_type='$homework_type', `teacher_id`='".$teacher_id."', `teacher_name`='".$teacher_name_with_subject."', `due_date`='".$due_date."', `date_created`='".$datetime."', `last_updated`='".$datetime."'");  
    
    $homework_id =mysqli_insert_id($conn);  
    
    if($homework_id > 0)
    {
        $documents1 = '';
        if($documents['name'][0]!="")
        { 
            $x = 1;
            foreach($_FILES['document']['name'] as $key => $tmp_name )
        	{
                $num1=rand(1000,9999);
                $num2=rand(1000,9999); 
                $finalnum=$num1."".$num2; 
                $name= "hw_".$school_id."_".$homework_id."_".$finalnum;
                
        	    $filename = $_FILES['document']['name'][$key];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                
                    $finalname = $name.".".$ext;
            		$file_name = $key.$_FILES['document']['name'][$key];
            		$file_size =$_FILES['document']['size'][$key];
            		$file_tmp =$_FILES['document']['tmp_name'][$key];
            		$file_type=$_FILES['document']['type'][$key]; 
            		 
                    
                    @chmod("../assets/uploadimages/homeworkimages/".$finalname, 0755);
            		 
                    $desired_dir="../assets/uploadimages/homeworkimages"; 
                    
              	
                     
                    move_uploaded_file($file_tmp,"$desired_dir/".$finalname); 
                    if($ext != 'png')
                    {
                   
                        $x++;
                        
                        $file_size =  $_FILES['document']['size'][$key];
                        
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
                        
                        
                        $directory = "../assets/uploadimages/homeworkimages"; 
                        $source = '../assets/uploadimages/homeworkimages/'.$finalname;
                        $im_php = imagecreatefromjpeg($source); 
                        $new_height = imagesy($im_php); 
                        imagejpeg($im_php, $directory.'/'.$finalname,$percentage);
                    }
                    
                    if($documents1 == '')
                    {
                        $documents1 .= "1|$finalname"; 
                        $total_document = 1;
                    }
                    else
                    {
                        $doc_array = explode(';',$documents1);
                        $total_document = count($doc_array) + 1;
                        $documents1 .= ";$total_document|$finalname"; 
                    } 
                
                    
        	}
        	
        	$query=mysqli_query($conn,"update `homework` set total_documents='".$total_document."',homework_documents_images = '".$documents1."' where homework_id='".$homework_id."'");  
        } 
    	
        $sql_students=mysqli_query($conn,"select sux.user_id, sux.student_id from class_register_students crs inner join student_user_xref sux on crs.student_id=sux.student_id where crs.class_register_id = '.$class_register_id.'  "); 
        $student_ids = array();  
        
        while($rows_students = mysqli_fetch_assoc($sql_students))
        {
            if($homework_type == 'O')
            {
    	        if(in_array($rows_students['student_id'], $student_ids) == false)
    	        {
    	            $student_ids[] = $rows_students['student_id'];  
                    $sql_delivery = mysqli_query($conn,"insert into homework_completed_documents set homework_id='$homework_id',student_id='".$rows_students['student_id']."',date_created='$datetime'");
    	        } 
            }
            
            
            
            $user_id = $rows_students['user_id'];
            $student_id = $rows_students['student_id'];
            
            $sql_delivery = mysqli_query($conn,"insert into homework_user_delivery set user_id='$user_id',student_id='$student_id',homework_id='$homework_id',delivery_datetime='$datetime'");
            
            $sql_delivery = mysqli_query($conn,"insert into notifications set school_id='$school_id',payload_id='$homework_id',payload_type='H',title='$title',description='$desc',user_id='$user_id',date_created='$datetime'");
        }
        send_notification(); 
        
        $response["status"] = "200";
        $response["msg"] = "Success"; 
        echo json_encode($response); 
    }
    else
    {
        $response["status"] = "400";
        $response["msg"] = "Error in creating homework"; 
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