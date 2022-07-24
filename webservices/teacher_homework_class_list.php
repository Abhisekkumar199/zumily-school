<?php
session_start();
require_once 'include/DB_Functions.php';

    $cmpdate = strtotime(date("Y-m-d"));   
    $session_id = $_REQUEST['session_id']; 
    $teacher_id = $_REQUEST['teacher_id'];  
    $sql1 =  mysqli_query($conn,"SELECT  sub_class_registers_info   FROM `teacher_teaching_classes` WHERE teacher_id = '".$teacher_id."' and session_id = '".$session_id."'");  
    if (mysqli_num_rows($sql1) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        $response["data"] = array();
        $rows = mysqli_fetch_array($sql1); 
             
        if($rows['sub_class_registers_info'] != '')
        {
            $document_array = explode(';',$rows['sub_class_registers_info']);   
            for($i=0;$i<count($document_array);$i++)
            { 
                $string_array = explode('|',$document_array[$i]);
                 
                $class_data["class_register_id"] = $string_array[0];
                $class_data["class_section_name"] = $string_array[1]; 
                array_push($response["data"], $class_data); 
            } 
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