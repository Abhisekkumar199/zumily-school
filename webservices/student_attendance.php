<?php
require_once 'include/DB_Functions.php';
include("include/mailfunction.php");
 
$student_id = $_REQUEST['student_id'];    
$year_month = $_REQUEST['year_month'];   
$school_id = $_REQUEST['school_id']; 

$sql_calendar = mysqli_query($conn,"select * from school_calendars where YYYYMM='".$year_month."' and school_id = '".$school_id."'");
if(mysqli_num_rows($sql_calendar) > 0)
{
    $total_no_attendance = 0;
    $total_present = 0;
    $total_absent = 0;
    $total_leave = 0;
    $total_off = 0; 
    $total_holidays = 0;
    $rows_calendar = mysqli_fetch_array($sql_calendar); 
    $response["status"] = "200";
    $response["msg"] = "Success";  
    $response["data"] = array();
    $year = substr($year_month,0,4);
    $month = substr($year_month,4,2);
    $day_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
     
    $sql = mysqli_query($conn,"SELECT crs.student_id,sa.day_01,sa.day_02,sa.day_03,sa.day_04,sa.day_05,sa.day_06,sa.day_07,sa.day_08,sa.day_09,sa.day_10,sa.day_11,sa.day_12,sa.day_13,sa.day_14,sa.day_15,sa.day_16,sa.day_17,sa.day_18,sa.day_19,sa.day_20,sa.day_21,sa.day_22,sa.day_23,sa.day_24,sa.day_25,sa.day_26,sa.day_27,sa.day_28,sa.day_29,sa.day_30,sa.day_31   FROM `class_register_students` crs  left join student_attendance sa  on crs.class_register_student_id = sa.class_register_student_id WHERE crs.student_id = '".$student_id."' and sa.attendance_year_month = '".$year_month."'"); 
    
    
    $rows_attendance = mysqli_fetch_array($sql); 
     
    
    for($month_day=1;$month_day <=$day_in_month;$month_day++)
    {
        if($month_day < 10)
        {
            $month_day = "0".$month_day;
        }
        
        $day = "day_".$month_day; 
        if($rows_calendar[$day] == '' or $rows_calendar[$day] == NULL)
        { 
            $date = $year."-".$month."-".$month_day;
            $attendance["date"] = $date;  
            
            if($rows_attendance[$day] == '')
            {
                $rows_attendance[$day] ='';
                $total_no_attendance = $total_no_attendance + 1;
            }
            else if($rows_attendance[$day] == 'P')
            {
                $total_present = $total_present + 1;
            }
            else if($rows_attendance[$day] == 'A')
            {
                $total_absent = $total_absent + 1;
            }
            else 
            { 
                $rows_attendance[$day] = '';
                $total_leave = $total_leave + 1;
            } 
            
             
            $attendance["status"] = $rows_attendance[$day]; 
        }
        else
        { 
              $date = $year."-".$month."-".$month_day;
            $attendance["date"] = $date; 
            
            $attendance["status"] = $rows_calendar[$day];  
            if($rows_calendar[$day] == '')
            {
                 
            }
            else if($rows_calendar[$day] == 'O,Saturday Off' or $rows_calendar[$day] == 'O,Sunday Off')
            {
                $total_off = $total_off + 1;
            }
            else  
            {
                $total_holidays = $total_holidays + 1;
            }
        }
        
        array_push($response["data"], $attendance);
        
    } 
    
        $response["total_no_attendance"] = $total_no_attendance; 
        $response["total_present"] = $total_present; 
        $response["total_absent"] = $total_absent; 
        $response["total_leave"] = $total_leave; 
        $response["total_off"] = $total_off; 
        $response["total_holidays"] = $total_holidays; 
    
    echo json_encode($response);
     
}
else
{
    $response["status"] = "400";
    $response["msg"] = "No record found";
    echo json_encode($response); 
} 
 
?>