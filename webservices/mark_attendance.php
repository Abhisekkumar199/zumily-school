<?php
date_default_timezone_set('Asia/Kolkata'); 
session_start();
require_once 'include/DB_Functions.php'; 
$datetime = $_REQUEST['datetime']; 

$user_id = $_REQUEST['user_id'];
$class_register_id = $_REQUEST['class_register_id']; 

$attendance_date = date("Y-m-d",strtotime($_REQUEST['attendance_date']));
$date=  date("d",strtotime($_REQUEST['attendance_date'])); 
$year_month= date("Ym",strtotime($_REQUEST['attendance_date'])); 

$class_register_student_ids = explode(',',$_REQUEST['class_register_student_ids']);  
$status1 = explode(',',$_REQUEST['status']);     
$total_presents = 0;
$total_absents = 0;
$total_leaves = 0;

    for($i=0;$i<count($class_register_student_ids);$i++)
    {
        $j = $i + 1; 
        $day_column = "day_".$date; 
        $status = $status1[$i];
        
        if($status == 'A')
        {
           $total_absents = $total_absents + 1; 
        }
        else if($status == 'P')
        {
          $total_presents = $total_presents + 1;   
        }
        else if($status == 'L')
        {
            $total_leaves = $total_leaves + 1; 
        }
         
        
        
        $class_register_student_id =$class_register_student_ids[$i];  
        $sql_check_attendance = mysqli_query($conn,"select * from student_attendance where class_register_id =" . "'" . $class_register_id . "' and attendance_year_month =" . "'" . $year_month . "' and class_register_student_id='".$class_register_student_id."'");   
        
         
        
        if(mysqli_num_rows($sql_check_attendance) > 0)
        {    
             
            $sql_check_attendance = mysqli_query($conn,"update student_attendance set $day_column='".$status."',last_updated='".$datetime."' where class_register_id =" . "'" . $class_register_id . "' and  attendance_year_month =" . "'" . $year_month . "' and class_register_student_id='".$class_register_student_id."'"); 
    	    
    	     
        }
        else
        { 
            $sql_check_attendance = mysqli_query($conn,"insert into student_attendance set $day_column='".$status."',class_register_student_id =". "'" . $class_register_student_id . "',class_register_id =" . "'" . $class_register_id . "',attendance_year_month =" . "'" . $year_month . "', date_created='".$datetime."', last_updated='".$datetime."' ");  
    	     
        }
        
    }   
    
    
    $sql_check_attendance = mysqli_num_rows(mysqli_query($conn,"select * from attendance_monitoring where class_register_id =" . "'" . $class_register_id . "' and attendance_date=" . "'" . $attendance_date . "'"));  
    if($sql_check_attendance == 1)
    { 
        // update attendance monetring
        $sql_check_attendance = mysqli_query($conn,"update attendance_monitoring set  status =". "'COMPLETED',done_by ='T',total_presents='".$total_presents."',total_absents='".$total_absents."',total_leaves='".$total_leaves."',last_updated='".$datetime."' where class_register_id='".$class_register_id."' and attendance_date=" . "'" . $attendance_date . "'");  
    }
    else
    {  
        $class_section_data = mysqli_fetch_assoc(mysqli_query($conn,"select c.class_name,c.section from class_registers cr inner join classes as c on cr.class_id = c.class_id where cr.class_register_id = '".$class_register_id."'"));  
        $class_section_name = $class_section_data['class_name']." ".$class_section_data['section'];
  
        // insert attendance monetring
        $sql_check_attendance = mysqli_query($conn,"insert into attendance_monitoring set  status =". "'COMPLETED',attendance_date =" . "'$attendance_date',class_name_section='".$class_section_name."',class_register_id =" . "'$class_register_id',done_by = 'T',total_presents='".$total_presents."',total_absents='".$total_absents."',total_leaves='".$total_leaves."',date_created='".$datetime."',last_updated='".$datetime."'");  
    }
    
    
    $response["status"] = "200";
    $response["msg"] = "Success";  
    echo json_encode($response);   
 
?>