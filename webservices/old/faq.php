<?php

session_start();
require_once 'include/DB_Functions.php';

$type = $_REQUEST['type'];  

$sql = mysqli_query($conn,"SELECT * FROM `faq` WHERE `usertype` = '".$type."' ");
  
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";   
        
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {  
            $flyer["question"] = $rows['question'];  
            $flyer["answer"] = nl2br($rows['answer']); 
            array_push($response["data"], $flyer);
        }  
        echo json_encode($response);
    } 
    else
    {
        if($startIndex > $totalcount)
        {
            $response["status"] = "300";
            $response["msg"] = "";
            echo json_encode($response);
        }
        else
        {
            $response["status"] = "400";
            $response["msg"] = "No flyer found";
            echo json_encode($response);
        }
    }
 
?>