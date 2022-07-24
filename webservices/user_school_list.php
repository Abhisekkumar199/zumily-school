<?php
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
    $user_id = $_REQUEST['user_id'];   
    $sql_user = mysqli_fetch_array(mysqli_query($conn,"SELECT is_parent,is_teacher FROM `users` WHERE  `user_id` = '".$user_id."'")); 
    if($sql_user['is_parent'] == 1)   
    {  
        $sql = mysqli_query($conn,"SELECT  s.school_name,s.school_id FROM   schools s WHERE s.school_id IN (select DISTINCT school_id from student_user_xref where user_id ='".$user_id."') ORDER BY s.`school_name`");   
        $totalcount= mysqli_num_rows($sql); 
        if (mysqli_num_rows($sql) > 0) 
        {	
            $response["status"] = "200";
            $response["msg"] = "Success";  
            $response["totalCount"] = $totalcount; 
            $response["data"] = array();
            while($rows = mysqli_fetch_array($sql))
            {   
                $schools["school_id"] = $rows['school_id'];   
                $schools["school_name"] = $rows['school_name']; 
                array_push($response["data"], $schools);
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
        $sql = mysqli_query($conn,"SELECT  s.school_name,s.school_id FROM   schools s WHERE s.school_id IN (select DISTINCT school_id from teachr_user_xref where user_id ='".$user_id."') ORDER BY s.`school_name`");      
        $totalcount= mysqli_num_rows($sql); 
        if (mysqli_num_rows($sql) > 0) 
        {	
            $response["status"] = "200";
            $response["msg"] = "Success";  
            $response["totalCount"] = $totalcount; 
            $response["data"] = array();
            while($rows = mysqli_fetch_array($sql))
            {    
                $schools["school_id"] = $rows['school_id'];   
                $schools["school_name"] = $rows['school_name'];
                array_push($response["data"], $schools);
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
?>