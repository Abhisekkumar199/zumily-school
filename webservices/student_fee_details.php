<?php
date_default_timezone_set('Asia/Kolkata'); 
session_start();
require_once 'include/DB_Functions.php';

$cmpdate = strtotime(date("Y-m-d"));  
$class_register_student_id = $_REQUEST['class_register_student_id'];    
$sql = mysqli_query($conn,"SELECT  s.first_name, s.last_name,s.profile_picture,s.father_name,sc.school_name,sc.school_address,sc.school_logo,sf.payment_months,sf.receipt_number,sf.payment_mode,sf.total_fee,sf.concession,sf.late_fee,sf.paid_fee,sf.payment_date,sf.fee_breakup  FROM students_fee_payments sf inner join students s on sf.student_id= s.student_id inner join schools sc on sf.school_id = sc.school_id   WHERE sf.class_register_student_id = '".$class_register_student_id."' order by sf.students_fee_payment_id desc");  
    
    $totalcount = mysqli_num_rows($sql); 
    if (mysqli_num_rows($sql) > 0) 
    {	
        $response["status"] = "200";
        $response["msg"] = "Success";  
        
        $response["totalCount"] = $totalcount; 
        $response["data"] = array();
        while($rows = mysqli_fetch_array($sql))
        {   
            if($rows['profile_picture'] != '')
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$rows['profile_picture']; 
	        }
	        else
	        {
	            $student["profile_pic"]="https://localhost/project/zumilyschool/assets/images/name.png"; 
	        }
	         
            $student["name"] = $rows['first_name']." ". $rows['last_name']; 
            $student["father_name"] = $rows['father_name']; 
           
            
            $student["school_name"] = $rows['school_name'];
            $student["school_address"] = $rows['school_address'];
            if($rows['school_logo'])
            { 
                $student["school_logo"]  =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$rows['school_logo'];
            } 
            else 
            {  
                $student["school_logo"]  =  "https://localhost/project/zumilyschool/assets/images/name.png";
            }
            
            
            $student["payment_months"] = $rows['payment_months'];  
            $student["receipt_number"] = $rows['receipt_number'];  
            $student["payment_mode"] = $rows['payment_mode'];  
            $student["total_fee"] = $rows['total_fee'];  
            $student["concession"] = $rows['concession'];  
            $student["late_fee"] = $rows['late_fee'];  
            $student["paid_fee"] = $rows['paid_fee'];  
            $student["payment_date"] = $rows['payment_date'];   
            $student["download_fee_reciept"]  =  "https://localhost/project/zumilyschool/assets/uploadimages/student/fee_concessions/name.png";
            $student['fee_breakup'] = array();
            
            if($rows['fee_breakup'] != '')
            {   
                $fee_breakup_array = explode(';',$rows['fee_breakup']);   
                for($i=0;$i<count($fee_breakup_array);$i++)
                { 
                    $string_array = explode('|',$fee_breakup_array[$i]); 
                    $breakup["fee_type"] = $string_array[0]; 
                    $breakup["amount"] = $string_array[1]; 
                    array_push($student["fee_breakup"], $breakup);
                } 
            }
            
            array_push($response["data"], $student);
             
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