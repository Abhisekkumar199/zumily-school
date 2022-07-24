<?php
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
 
$user_id = $_REQUEST['user_id']; 
$request_status_id = $_REQUEST['request_status_id']; 
if($request_status_id != '')
{
    $str = "and slr.request_status ='".$request_status_id."'";
}

 $startIndex1 = $_REQUEST['start_index'];
$endIndex = 30 ; 
$startIndex = $startIndex1 * $endIndex ;   
$sql_count = mysqli_query($conn,"SELECT  slr.student_leave_request_id FROM  `student_leave_requests`slr inner join schools s2 on slr.school_id = s2.school_id inner join teachers t on slr.class_teacher_id = t.teacher_id inner join students s3 on slr.student_id = s3.student_id  WHERE slr.user_id = '".$user_id."' {$str} ");  
mysqli_query($conn,"SET NAMES 'utf8'"); 
    mysqli_query($conn,'SET CHARACTER SET utf8');
 
$sql = mysqli_query($conn,"SELECT  slr.leave_requests_images,slr.total_images,slr.student_leave_request_id,slr.request_title,slr.student_id,slr.request_reason,slr.session_year,slr.start_date,slr.end_date,slr.request_status,slr.approved_by,slr.comment  ,s2.school_name,s2.school_address,s2.school_logo,t.first_name as teacher_first_name,t.last_name as teacher_last_name,t.mobile_no,s3.first_name as student_first_name,s3.last_name as student_last_name, s3.profile_picture as student_profile_picture FROM  `student_leave_requests`slr inner join schools s2 on slr.school_id = s2.school_id inner join teachers t on slr.class_teacher_id = t.teacher_id inner join students s3 on slr.student_id = s3.student_id  WHERE slr.user_id = '".$user_id."' {$str} ORDER BY  slr.`start_date` desc limit $startIndex, $endIndex");  

$totalcount= mysqli_num_rows($sql_count); 
if (mysqli_num_rows($sql) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";  
    $response["totalCount"] = $totalcount; 
    $response["data"] = array();
    while($rows = mysqli_fetch_array($sql))
    {    
        $leave_request["student_id"] = $rows['student_id']; 
        $leave_request["request_title"] = $rows['request_title'];  
        $leave_request["request_reason"] = $rows['request_reason'];   
        $leave_request["session_year"] = $rows['session_year']; 
        $leave_request["start_date"] = $rows['start_date'];
        $leave_request["end_date"] = $rows['end_date']; 
        $leave_request["request_status_id"] = $rows['request_status']; 
        if($rows['request_status']==0)
        { 
            $leave_request["request_status"] = 'Denied'; 
        }
        else if ($rows['request_status']==1)
        { 
            $leave_request["request_status"] = 'Approved'; 
        }
        else
        {
            $leave_request["request_status"] = 'Pending';   
        }
        
        $leave_request["approved_by"] = $rows['approved_by']; 
        $leave_request["comment"] = $rows['comment']; 
        $leave_request["school_name"] = $rows['school_name']; 
        $leave_request["school_address"] = $rows['school_address'];
        
        if($rows['school_logo'])
        { 
            $leave_request["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
        } 
        else 
        {  
            $leave_request["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
	    }   
	    $leave_request["teacher_name"] = $rows['teacher_first_name']." ".$rows['teacher_last_name'];
	    $leave_request["teacher_mobile_no"] = $rows['mobile_no'];
        $leave_request["student_name"] = $rows['student_first_name']." ".$rows['student_last_name'];
        
        if($rows['student_profile_picture'] != '')
            {
                $leave_request["profile_pic"]="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['student_profile_picture']; 
            }
            else
            {
                $leave_request["profile_pic"]="https://localhost/project/zumilyschool/assets/images/name.png";
            }
            
        $student_leave_request_id = $rows['student_leave_request_id']; 
        $leave_request['images'] = array(); 
        
        
        if($rows['total_images'] > 0)
        {   
            $document_array = explode(';',$rows['leave_requests_images']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                $imageUrl = 'https://localhost/project/zumilyschool/assets/uploadimages/leaverequests/'.$string_array[1]; 
                $image["image_url"] = $imageUrl; 
                array_push($leave_request["images"], $image);
            } 
         
        }
      
        
        array_push($response["data"], $leave_request);
    }  
    echo json_encode($response);
} 
else
{ 
    if($startIndex > $totalcount)
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