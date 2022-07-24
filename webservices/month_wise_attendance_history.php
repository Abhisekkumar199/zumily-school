<?php
session_start();
require_once 'include/DB_Functions.php';
   

$class_register_id = $_REQUEST['class_register_id'];   
$year_month= $_REQUEST['year_month'];   

$year = substr($year_month,0,4);
$month = substr($year_month,4,2);

$day_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);  
$startdate = $year."-".$month."-01";
  
$enddate = $year."-".$month."-".$day_in_month; 
$sql_student = mysqli_query($conn,"SELECT attendance_date,status,last_updated,done_by  FROM  `attendance_monitoring`  WHERE class_register_id = '".$class_register_id."' and attendance_date >='".$startdate."' and  attendance_date <= '".$enddate."' order by attendance_date desc "); 

if (mysqli_num_rows($sql_student) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";   
    $response["data"] = array();
    while($rows = mysqli_fetch_array($sql_student))
    {   
        $student_list["attendance_date"] = $rows['attendance_date'];  
        $student_list["status"] = $rows['status']; 
        $student_list["last_updated"] = $rows['last_updated']; 
      
        if($rows['done_by'] == 0)
        { 
            $student_list["done_by"] = 'A'; 
        }
        else
        {
            $student_list["done_by"] = 'T';
        }
        
        array_push($response["data"], $student_list);
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