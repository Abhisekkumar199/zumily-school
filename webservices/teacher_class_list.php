<?php
session_start();
require_once 'include/DB_Functions.php';
    
    $cmpdate = date("Y-m-d");  
    $user_id = $_REQUEST['user_id'];  
    $sql_teacher_teaching_classes =  mysqli_query($conn,"select s.session_id, ttc.teacher_id, ttc.class_teacher_class_register_id,ttc.class_teacher_class_register_info,sub_class_register_ids from teacher_user_xref tux, teacher_teaching_classes ttc, sessions s where tux.user_id=$user_id and tux.teacher_id=ttc.teacher_id and tux.school_id = s.school_id and s.start_date <= '$cmpdate' and s.end_date >= '$cmpdate' and tux.is_active=1");  
    $row_teacher_teaching_classes = mysqli_fetch_array($sql_teacher_teaching_classes);
        
    $session_id = $row_teacher_teaching_classes['session_id'];
    $teacher_id = $row_teacher_teaching_classes['teacher_id'];
    $class_teacher_class_register_id = $row_teacher_teaching_classes['class_teacher_class_register_id'];
    $class_teacher_class_section_name = $row_teacher_teaching_classes['class_teacher_class_register_info'];
    $sub_class_register_ids = $row_teacher_teaching_classes['sub_class_register_ids'];
    
    $class_register_ids = ''; 
    if($sub_class_register_ids != '')
    {
        $class_register_ids = $sub_class_register_ids;
        
        if($class_teacher_class_register_id != '')
        {
            $class_register_ids .= ",".$class_teacher_class_register_id;
        }
    }
    else if($class_teacher_class_register_id != '')
    {
        $class_register_ids = $class_teacher_class_register_id;
    }   
        
        
    $sql1 =  mysqli_query($conn,"select cr.class_register_id, cr.class_name_section from class_registers cr where cr.class_register_id in ($class_register_ids) order by cr.class_name_section ");  
    
    if (mysqli_num_rows($sql1) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        $response["session_id"] = $session_id; 
        $response["teacher_id"] = $teacher_id; 
        $response["ct_cr_id"] = $class_teacher_class_register_id; 
        $response["ct_cr_class_name_section"] = $class_teacher_class_section_name; 
        $response["data"] = array();  
        while($rows = mysqli_fetch_assoc($sql1))
        {
            $class_list["class_register_id"] = $rows['class_register_id'];  
            $class_list["class_section"] = $rows['class_name_section'];  
            array_push($response["data"], $class_list); 
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