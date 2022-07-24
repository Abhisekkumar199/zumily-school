<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id'];  
    $school_id = $_REQUEST['school_id'];
    $session_id = $_REQUEST['session_id'];  
    if(!empty($school_id) and empty($session_id))
    { 
        $sql = mysqli_query($conn,"SELECT  h.holiday_name,h.holiday_start_date,h.holiday_end_date,s.session_year,s2.school_name FROM  `holidays` h inner join sessions s on h.session_id = s.session_id inner join schools s2 on h.school_id = s2.school_id  WHERE h.school_id = '".$school_id."' ORDER BY  s.`session_year` desc, h.holiday_start_date asc");  
        
        $totalcount= mysqli_num_rows($sql); 
        if (mysqli_num_rows($sql) > 0) 
        {	
            $response["status"] = "200";
            $response["msg"] = "Success";  
            $response["totalCount"] = $totalcount; 
            $response["data"] = array();
            while($rows = mysqli_fetch_array($sql))
            {   
                
                $holidays["school_name"] = $rows['school_name'];  
                $holidays["holiday_name"] = $rows['holiday_name'];   
                $holidays["holiday_start_date"] = $rows['holiday_start_date']; 
                $holidays["holiday_end_date"] = $rows['holiday_end_date'];
                $holidays["session_year"] = $rows['session_year']; 
                array_push($response["data"], $holidays);
            }  
            echo json_encode($response);
        } 
        else
        { 
            $response["status"] = "400";
            $response["msg"] = "No record found";
            echo json_encode($response); 
        }
    }
    else if(!empty($school_id) and !empty($session_id))
    { 
        $sql = mysqli_query($conn,"SELECT  h.holiday_name,h.holiday_start_date,h.holiday_end_date,s.session_year,s2.school_name FROM  `holidays` h inner join sessions s on h.session_id = s.session_id inner join schools s2 on h.school_id = s2.school_id  WHERE s.school_id = '".$school_id."' and s.session_id = '".$session_id."' ORDER BY h.holiday_start_date asc"); 
        
        $totalcount= mysqli_num_rows($sql); 
        if (mysqli_num_rows($sql) > 0) 
        {	
            $response["status"] = "200";
            $response["msg"] = "Success";  
            $response["totalCount"] = $totalcount; 
            $response["data"] = array();
            while($rows = mysqli_fetch_array($sql))
            {   
                
                $holidays["school_name"] = $rows['school_name'];  
                $holidays["holiday_name"] = $rows['holiday_name'];   
                $holidays["holiday_start_date"] = $rows['holiday_start_date']; 
                $holidays["holiday_end_date"] = $rows['holiday_end_date'];
                $holidays["session_year"] = $rows['session_year']; 
                array_push($response["data"], $holidays);
            }  
            echo json_encode($response);
        } 
        else
        { 
            $response["status"] = "400";
            $response["msg"] = "No record found";
            echo json_encode($response); 
        }
    }
    else
    { 
    
        $sql_user = mysqli_fetch_array(mysqli_query($conn,"SELECT is_parent,is_teacher FROM `users` WHERE  `user_id` = '".$user_id."'")); 
        if($sql_user['is_parent'] == 1)   
        {  
            $sql = mysqli_query($conn,"SELECT  h.holiday_name,h.holiday_start_date,h.holiday_end_date,s.session_year,s2.school_name FROM  `holidays` h inner join sessions s on h.session_id = s.session_id inner join schools s2 on h.school_id = s2.school_id  WHERE h.school_id IN (select DISTINCT school_id from student_user_xref where user_id ='".$user_id."') ORDER BY s2.school_name,s.`session_year` desc, h.holiday_start_date asc");   
            
            $totalcount= mysqli_num_rows($sql); 
            if (mysqli_num_rows($sql) > 0) 
            {	
                $response["status"] = "200";
                $response["msg"] = "Success";  
                $response["totalCount"] = $totalcount; 
                $response["data"] = array();
                while($rows = mysqli_fetch_array($sql))
                {   
                    
                    $holidays["school_name"] = $rows['school_name'];  
                    $holidays["holiday_name"] = $rows['holiday_name'];   
                    $holidays["holiday_start_date"] = $rows['holiday_start_date']; 
                    $holidays["holiday_end_date"] = $rows['holiday_end_date'];
                    $holidays["session_year"] = $rows['session_year']; 
                    array_push($response["data"], $holidays);
                }  
                echo json_encode($response);
            } 
            else
            { 
                $response["status"] = "400";
                $response["msg"] = "No record found";
                echo json_encode($response); 
            }
        }
        else if($sql_user['is_teacher'] == 1)   
        {  
            $sql = mysqli_query($conn,"SELECT  h.holiday_name,h.holiday_start_date,h.holiday_end_date,s.session_year,s2.school_name FROM  `holidays` h inner join sessions s on h.session_id = s.session_id inner join schools s2 on h.school_id = s2.school_id WHERE h.school_id IN (select DISTINCT school_id from teachr_user_xref where user_id ='".$user_id."') ORDER BY s2.school_name,s.`session_year` desc, h.holiday_start_date asc");      
            $totalcount= mysqli_num_rows($sql); 
            if (mysqli_num_rows($sql) > 0) 
            {	
                $response["status"] = "200";
                $response["msg"] = "Success";  
                $response["totalCount"] = $totalcount; 
                $response["data"] = array();
                while($rows = mysqli_fetch_array($sql))
                {   
                    $holidays["school_name"] = $rows['school_name']; 
                    $holidays["holiday_name"] = $rows['holiday_name']; 
                    $holidays["holiday_start_date"] = $rows['holiday_start_date']; 
                    $holidays["holiday_end_date"] = $rows['holiday_end_date'];
                    $holidays["session_year"] = $rows['session_year']; 
                    array_push($response["data"], $holidays);
                }  
                echo json_encode($response);
            } 
            else
            { 
                $response["status"] = "400";
                $response["msg"] = "No record found";
                echo json_encode($response); 
            }
        }
        else
        { 
            $response["status"] = "400";
            $response["msg"] = "No record found";
            echo json_encode($response); 
        }
    }
?>