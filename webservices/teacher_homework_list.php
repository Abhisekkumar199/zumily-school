<?php
session_start();
require_once 'include/DB_Functions.php'; 
    $date = $_REQUEST['date'];  
    $teacher_id = $_REQUEST['teacher_id']; 
    $startIndex1 = $_REQUEST['start_index'];
    $endIndex = 30 ; 
    $startIndex = $startIndex1 * $endIndex ; 
    mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
    
   @$totalcount = mysqli_fetch_array(mysqli_query($conn,"SELECT  count(homework_id) as total_homework    FROM `homework` WHERE teacher_id = '".$teacher_id."'"));  

    $sql = mysqli_query($conn,"SELECT h.homework_id,h.total_completed_homework,h.class_register_id,h.school_id,h.homework_type,h.class_name_section,h.session_year,h.title,h.description,h.total_documents,h.due_date,h.date_created,h.homework_documents_images,h.total_views,s.school_name,s.school_address,s.school_logo FROM `homework` h inner join `schools` s on h.school_id = s.school_id   WHERE  h.teacher_id = '".$teacher_id."' ORDER BY h.`due_date` desc  limit $startIndex, $endIndex");   
  
    $total = $totalcount['total_homework'];
    $totalindex = $total / $endIndex ;
    if (@mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["totalCount"] = $total; 
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {  
              
            $homework["school_id"] = $rows['school_id'];  
            $homework["school_name"] = $rows['school_name'];
            $homework["school_address"] = $rows['school_address'];
            if($rows['school_logo'])
            { 
                $homework["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
	            $homework["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
		    }   
		    
		    
	       
		   
		    
            $homework["homework_id"] = $rows['homework_id'];
            $homework["title"] = $rows['title'];  
            $homework["class_register_id"] = $rows['class_register_id']; 
            $homework["class_name_section"] = $rows['class_name_section']; 
            $homework["session_year"] = $rows['session_year']; 
            
            
            $homework["homework_type"] = $rows['homework_type'];  
                
            $homework["description"] = strip_tags(utf8_encode($rows['description']));
            $homework["due_date"] = $rows['due_date'];  
            $homework["date_created"] = $rows['date_created'];
            $homework["total_completed_homework"] = $rows['total_completed_homework'];
            $homework["total_views"] = $rows['total_views'];
            
            
            if($rows['due_date'] >= $date and $rows['total_completed_homework'] == 0 )
            {
                $homework["is_deletable"] = "1";  
            }
            else
            {
                $homework["is_deletable"] = "0";  
            }
            
            
            $homework['documents'] = array();   
            if($rows['homework_documents_images'] != '')
            {
                $document_array = explode(';',$rows['homework_documents_images']);   
                for($i=0;$i<count($document_array);$i++)
                { 
                    $string_array = explode('|',$document_array[$i]);
                    
                    $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/homeworkimages/'.$string_array[1];
                    $documentimage["id"] = $string_array[0]; 
                    $documentimage["url"] = $imageUrl; 
                    array_push($homework["documents"], $documentimage); 
                } 
            }
              
            array_push($response["data"], $homework);
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