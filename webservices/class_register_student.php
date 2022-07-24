<?php
session_start();
require_once 'include/DB_Functions.php';
  
    $class_register_id = $_REQUEST['class_register_id']; 
    $attendance_date = $_REQUEST['attendance_date'];
    $year_month= date("Ym",strtotime($_REQUEST['attendance_date']));  
    $current_date  = date("d",strtotime($_REQUEST['attendance_date']));  
    $day ="day_".$current_date;
    $day1 ="a.day_".$current_date;
    $sql_attendance_check = mysqli_fetch_array(mysqli_query($conn,"select count(attendance_monitoring_id) as is_attendance_marked,last_updated from attendance_monitoring where attendance_date='".$attendance_date."' and class_register_id='".$class_register_id."' and status='COMPLETED'"));
    
    $sql_is_attendance = mysqli_num_rows(mysqli_query($conn,"select student_attendance_id from student_attendance where attendance_year_month='".$year_month."' and class_register_id='".$class_register_id."'"));
    
    if($sql_is_attendance == 0)
    {
        $sql_student = mysqli_query($conn,"SELECT s.student_id,s.first_name,s.last_name,s.date_of_birth, s.father_name,s.profile_picture, c.class_register_student_id, c.class_register_id  FROM  `class_register_students` c inner join `students` s on c.student_id = s.student_id  WHERE c.class_register_id = '".$class_register_id."' order by s.first_name asc ");  
    }
    else
    {
        $sql_student = mysqli_query($conn,"SELECT s.student_id,s.first_name,s.last_name,s.date_of_birth, s.father_name,s.profile_picture, c.class_register_student_id, c.class_register_id ,{$day1}  FROM  `class_register_students` c inner join `students` s on c.student_id = s.student_id left join student_attendance a on a.class_register_student_id = c.class_register_student_id WHERE c.class_register_id = '".$class_register_id."' and a.attendance_year_month='".$year_month."' order by s.first_name asc "); 
    } 
    
    if (mysqli_num_rows($sql_student) > 0) 
    {
         $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["is_attendance"] = $sql_attendance_check['is_attendance_marked'];  
        $response["attendance_date"] = $sql_attendance_check['last_updated'];  
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql_student))
        {   
            $student_list["class_register_student_id"] = $rows['class_register_student_id']; 
            $student_list["student_id"] = $rows['student_id']; 
            $student_list["class_register_id"] = $rows['class_register_id']; 
            $student_list["student_name"] = $rows['first_name']." ".$rows['last_name']; 
            $student_list["date_of_birth"] = $rows['date_of_birth']; 
            $student_list["father_name"] = $rows['father_name']; 
            
            if($rows['profile_picture'] != '')
            {
                $student_list["profile_pic"]="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture']; 
            }
            else
            {
                $student_list["profile_pic"]="https://localhost/project/zumilyschool/assets/images/name.png";
            }
            
            if($sql_attendance_check['is_attendance_marked']== 0)
            { 
                $student_list["status"] = 'P';
            }
            else
            { 
                $student_list["status"] = $rows[$day];
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