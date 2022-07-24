<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));   
$class_register_id = $_REQUEST['class_register_id'];   
$year_month= $_REQUEST['attendance_date'];  
$year_filter = " and sa.attendance_year_month = '".$year_month."'";  

if($_REQUEST['class_register_student_id'] != '')
{
    $student_filter = " and c.class_register_student_id = '".$_REQUEST['class_register_student_id']."'"; 
}


$year = substr($year_month,0,4);
$month = substr($year_month,4,2);
$day_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);  
 
$sql_student = mysqli_query($conn,"SELECT s.student_id,s.first_name,s.last_name,c.class_register_student_id,sa.day_01,sa.day_02,sa.day_03,sa.day_04,sa.day_05,sa.day_06,sa.day_07,sa.day_08,sa.day_09,sa.day_10,sa.day_11,sa.day_12,sa.day_13,sa.day_14,sa.day_15,sa.day_16,sa.day_17,sa.day_18,sa.day_19,sa.day_20,sa.day_21,sa.day_22,sa.day_23,sa.day_24,sa.day_25,sa.day_26,sa.day_27,sa.day_28,sa.day_29,sa.day_30,sa.day_31  FROM  `class_register_students` c inner join `students` s on c.student_id = s.student_id inner join `student_attendance` sa on c.class_register_student_id = sa.class_register_student_id  WHERE c.class_register_id = '".$class_register_id."' {$student_filter} {$year_filter}  order by s.first_name asc "); 

if (mysqli_num_rows($sql_student) > 0) 
{	
    $response["status"] = "200";
    $response["msg"] = "Success";   
    $response["data"] = array();
    while($rows = mysqli_fetch_array($sql_student))
    {   
        $student_list["class_register_student_id"] = $rows['class_register_student_id'];  
        $student_list["student_name"] = $rows['first_name']." ".$rows['last_name']; 
        $student_list["attendance"] = array();
        for($month_day=1;$month_day <=$day_in_month;$month_day++)
        {
            if($month_day < 10)
            {
                $month_day = "0".$month_day;
            }
            $day = "day_".$month_day;   
            $date = $year."-".$month."-".$month_day; 
            $attendance["date"] = $date;  
            $attendance["status"] = $rows[$day]; 
            array_push($student_list["attendance"], $attendance); 
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