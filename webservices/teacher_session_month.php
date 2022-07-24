<?php
session_start();
date_default_timezone_set('Asia/Kolkata'); 
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id'];   
      
    $sql_teacher = mysqli_query($conn,"SELECT  s.start_date,s.end_date FROM  `users` u inner join `teacher_user_xref` t on u.user_id = t.user_id inner join sessions s on  t.school_id = s.school_id  WHERE u.user_id = '".$user_id."' and s.is_active='1' ");
    $rows = mysqli_fetch_array($sql_teacher); 
    $start_date = strtotime($rows['start_date']); 
    $end_date = strtotime($rows['end_date']); 
   
    if (mysqli_num_rows($sql_teacher) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $response["data"] = array();
        $x = 1; 
        while($start_date < $end_date)
        {
            $month["month"] =  date('Y-m-d', $start_date);
            $month["year_month"] =  date('Ym', $start_date);
            $month["order_by"] =  $x;
            $start_date = strtotime("+1 month", $start_date); 
            array_push($response["data"], $month);
            $x ++;
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