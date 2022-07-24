<?php
date_default_timezone_set('Asia/Kolkata'); 
    require_once 'include/DB_Functions.php';
     
    $user_id = $_REQUEST['user_id'];
    $sqluser=mysqli_query($conn,"select * from users where user_id='".$user_id."'");
    $sql_count = mysqli_fetch_array(mysqli_query($conn,"SELECT count(notification_id) as total_unread_count FROM `notifications` WHERE user_id = '".$user_id."' and read_status='0'"));
    $numuser=mysqli_num_rows($sqluser);
    if($numuser>"0")
    {
        while($rows = mysqli_fetch_array($sqluser))
        { 
			$response["status"] = "200";
			$response["msg"] = "Success";
            $response["total_unread_count"] = $sql_count['total_unread_count']; 
			$response["userId"]=$rows['user_id'];
	        $response["fname"]=$rows['first_name'];
	        $response["lname"]=$rows['last_name'];
	        $response["isemailverified"]=$rows['is_email_verified'];
	        $response["ismobileverified"]=$rows['is_mobile_verified'];
	        $response["email"]=$rows['email_id'];
	        $response["phone"]=$rows['mobile_no'];
	        $response["country"]=$rows['country_code'];
	        $response["gender"]=$rows['user_gender'];
            $response["session_id"] = "1";
	        if($rows['user_dob'] == '0000-00-00')
	        {
	            $response["dob"]= '';
	        }
	        else
	        {
	            $response["dob"]= date("M d, Y", strtotime($rows['user_dob']));
	        }
	        
	        $response["zipcode"]=$rows['zipcode'];
	        if($rows['user_image'] != '')
	        {
	            $response["profilePic"]="https://localhost/project/zumilyschool/assets/uploadimages/userimages/".$rows['user_image']; 
	        }
	        else
	        {
	            $response["profilePic"]="https://localhost/project/zumilyschool/assets/images/name.png"; 
	        }
        }  
		echo json_encode($response); 
    }
    else 
    {
    	$response["status"] = "400";
    	$response["msg"] = "User do not exist";
    	echo json_encode($response);
    }
?>