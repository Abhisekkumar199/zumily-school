<?php 
global $servername;
global $username;
global $password;
global $database;
global $conn; 
  $servername = "localhost";
  $username = "zumilool_school";
  $password = "zumilyschool@123";
  $database = "zumilool_school";
// Create connection 
  $conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}  

function store_user($fname,$lname, $email, $password, $mobile_no,$country_code,$datetime) 
{       
    global $conn;
    $passwordsd2=md5($password);  
    $user = rand(10,1000000000000); 
    if($email == '')
    {
        $result = mysqli_query($conn,"INSERT INTO users(first_name,last_name,mobile_no, password,country_code,date_created,last_updated) VALUES('$fname','$lname', '$mobile_no', '$passwordsd2', '$country_code','$datetime','$datetime')"); 
    }
    else if($mobile_no == '')
    {
        $result = mysqli_query($conn,"INSERT INTO users(first_name,last_name, email_id, password,country_code,date_created,last_updated) VALUES('$fname','$lname', '$email', '$passwordsd2', '$country_code','$datetime','$datetime')"); 
    }
    else
    {
        $result = mysqli_query($conn,"INSERT INTO users(first_name,last_name,mobile_no, email_id, password,country_code,date_created,last_updated) VALUES('$fname','$lname', '$mobile_no','$email', '$passwordsd2', '$country_code','$datetime','$datetime')"); 
    }
    
    if ($result) 
    {   
        $inserid=mysqli_insert_id($conn); 
        $result12 = mysqli_query($conn,"SELECT * FROM users WHERE user_id = \"$inserid\""); 
        $result12 = mysqli_fetch_array($result12); 
        return $result12; 
    }
    else 
    { 
        return false; 
    } 
}

function update_user1($fname,$lname, $email, $password, $mobile_no,$country_code,$datetime) 
{      
    global $conn;
    $passwordsd2=md5($password);  
    $user = rand(10,1000000000000); 
     
    $result = mysqli_query($conn,"update users set first_name ='$fname',last_name='$lname', password='$passwordsd2', last_updated='".$datetime."'  where mobile_no='$mobile_no'"); 
    $result12 = mysqli_query($conn,"SELECT * FROM users WHERE mobile_no = '".$mobile_no."'"); 
     
    $result122 = mysqli_fetch_array($result12); 
    return $result122; 
     
}

// checking if email id or password exist on not 
 function check_if_user_exists($email) 
{  
    global $conn;
    $result = mysqli_query($conn,"SELECT * from users WHERE email_id = '$email' or mobile_no='".$email."'");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    } 
} 

// checking if password is set on not 
 function check_if_password_exist($email) 
{ 
    global $conn;
    $result = mysqli_query($conn,"SELECT * from users WHERE (email_id = '$email' or mobile_no='".$email."') and password !=''");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
} 

// checking if password is correct or not
 function check_if_password_is_correct($email,$password) 
{  
    global $conn;
    $result = mysqli_query($conn,"SELECT * from users WHERE (email_id = '$email' or mobile_no='".$email."') and password='".md5($password)."'");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    {
        // user existed 
         return true;
    } 
    else 
    {
        // user not existed
        return false;
    }
}

// checking if user is verified or not
 function check_if_user_verified($email) 
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * from users WHERE (email_id = '$email' or mobile_no='".$email."')  and is_verified='1'");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
} 

// getting user details
 function get_user_detail($email) 
{
    global $conn;
    $password12=md5($password);
    $result = mysqli_query($conn,"SELECT * FROM users WHERE (email_id='".$email."' or mobile_no='".$email."')") or die(mysql_error()); 
    // check for result  
    $no_of_rows = mysqli_num_rows($result); 
    if ($no_of_rows > 0)
    { 
        $chsql = mysqli_query($conn,"SELECT * FROM users WHERE email_id = '".$email."'  or mobile_no='".$email."'"); 
        $result = mysqli_fetch_array($chsql); 
        return $result; 
    } 
    else 
    { 
        // user not found
        return false;
    } 
} 


// checking if user email exist or not
 function is_user_email_exist($email) 
{
    global $conn;
    $result = mysqli_query($conn,"SELECT email_id from users WHERE email_id = '$email' and password !=''");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}

//  Check if user mobile exist or not 
 function is_user_mobile_exist($mobile) 
{
    global $conn;
    $result = mysqli_query($conn,"SELECT mobile_no from users WHERE mobile_no = '$mobile' and password !=''");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}

 function is_user_exist($email,$mobile) 
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * from users WHERE mobile_no = '$mobile' or  email_id = '$email'");
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}


/*  Check old password  */ 
 function check_old_password($user_id,$oldpassword) 
{
    global $conn;
    $oldpassword=md5($oldpassword);
    $sqluser=mysqli_query($conn,"select * from users where user_id='".$user_id."' and password='$oldpassword'");
    $no_of_rows = mysqli_num_rows($sqluser);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}

/*  change new password  */ 
 function change_password($user_id,$newpassword)
{ 
    global $conn;
    $newpassword=md5($newpassword); 
    $updatePassword = mysqli_query($conn,"update users set password = '".$newpassword."' where user_id='".$user_id."'"); 
    if ($updatePassword) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    } 
}


/*  Check User */ 
 function check_user($user_id) 
{
    global $conn;
    $sqluser=mysqli_query($conn,"select * from users where user_id='".$user_id."'");
    $no_of_rows = mysqli_num_rows($sqluser);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}


/*  Update User */ 
 function update_user($fname,$lname,$gender,$dob,$user_id,$datetime)
{    
    global $conn;
    if($dob == '' or $dob == null)
    {
        $updatePassword = mysqli_query($conn,"update users set first_name = '".$fname."',last_name = '".$lname."',user_gender = '".$gender."', last_updated='".$datetime."'  where user_id='".$user_id."'"); 
    }
    else
    {
        $updatePassword = mysqli_query($conn,"update users set first_name = '".$fname."',last_name = '".$lname."',user_dob = '".$dob."',user_gender = '".$gender."', last_updated='".$datetime."'  where user_id='".$user_id."'"); 
    } 
    
    if ($updatePassword) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    } 
}



/*  Check otp  */ 
 function checkOtp($otp,$emailId,$type) 
{
    global $conn;
    if($type == 'email')
    { 
        $result = mysqli_query($conn,"SELECT * from users WHERE email_id = '$emailId' and mobile_otp='".$otp."'");
    }
    else
    {  
        $result = mysqli_query($conn,"SELECT * from users WHERE mobile_no = '$emailId' and mobile_otp='".$otp."'");
    }
    $no_of_rows = mysqli_num_rows($result);
    if ($no_of_rows > 0) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}



/*  reset password  */ 
 function resetPassword($emailId,$password,$type) 
{
    global $conn;
    $password=md5($password);
    if($type == 'email')
    { 
        $result = mysqli_query($conn,"update users set password='$password' WHERE email_id = '".$emailId."'") or die(mysql_error()); 
    }
    else
    {  
        $result = mysqli_query($conn,"update users set password='$password' WHERE mobile_no = '".$emailId."'") or die(mysql_error()); 
    } 
    if ($result) 
    { 
         return true;
    } 
    else 
    { 
        return false;
    }
}

// send notification
function send_notification()
{
     global $conn; 
    
    $start_date_time = date("Y-m-d H:i");
    
    $end_date_time = date("Y-m-d H:i"); 
    $total_processed_records = 0;
    
    $url = 'https://fcm.googleapis.com/fcm/send'; 
    $rand_number=rand(10000,99999); 
    
    $update_notification = mysqli_query($conn,"update notifications set sent_status ='".$rand_number."' WHERE sent_status = '0'"); 
    $get_notification = mysqli_query($conn,"select n.notification_id,n.payload_id,n.title,n.payload_type,n.description,u.fcm_key,s.school_logo from notifications as n inner join schools as s on n.school_id = s.school_id inner join users as u on n.user_id = u.user_id WHERE n.sent_status = '".$rand_number."'");
     
    $total_processed_records = mysqli_num_rows($get_notification);
    //echo mysqli_num_rows($get_notification);
    if(mysqli_num_rows($get_notification) > 0) 
    {  
        while($notification = mysqli_fetch_assoc($get_notification)) 
        {   
            $id = $notification['notification_id']; 
            $payload_id = $notification['payload_id'];
            $payload_type = $notification['payload_type'];
            $title= strip_tags($notification['title']);
            $message_body= strip_tags($notification['description']);
            $key= $notification['fcm_key'];
            $school_logo= $notification['school_logo'];
            if($school_logo != '')
            {
                $image_url =   "https://localhost/project/zumilyschool/assets/uploadimages/schoolimages/".$notification['school_logo'];
            }
            else
            {
                $image_url = "https://localhost/project/zumilyschool/assets/images/name.png";
            }
            
            $registrationIds = array($key);
            
             $notification =  array(
            "title" => $title, 
            "body" => $message_body,
            "click_action" => 'OPEN_ACTIVITY_1' 
            ); 
            
            $message =  array(
            "title" => $title, 
            "body" => $message_body, 
            "image" => $image_url,
            "tag" => time(), 
            "payload" => $payload_id, 
            "payloadtype" => $payload_type, 
            "notificationid" => $id
            );  
            
            $fields = array( 
            	'registration_ids' => $registrationIds, 
            	'notification' => $notification, 
            	'data' => $message
            ); 
            
              json_encode($fields);
            
            
            $headers = array( 
            	'Authorization: key=AIzaSyApSVxlG9IKDOmJTM32ek4_l1EnJIJlMU8', 
            	'Content-Type: application/json'
            );
            
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL,$url);
            curl_setopt( $ch,CURLOPT_POST,true);
            curl_setopt( $ch,CURLOPT_HTTPHEADER,$headers);
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($fields));
            $result = curl_exec($ch);
              $result;
            if (curl_errno($ch)) 
            {
                $update_notification = mysqli_query($conn,"update notifications set sent_status ='-1',sent_datetime='".date("Y-m-d h:i")."' WHERE notification_id = '".$id."'");
                 
            } 
            else
            { 
                $update_notification = mysqli_query($conn,"update notifications set sent_status ='1',sent_datetime='".date("Y-m-d h:i")."' WHERE notification_id = '".$id."'"); 
            } 
            curl_close($ch); 
        } 
    } 
}  

// send otp
function send_otp($mobile,$message)
{   
    global $conn; 
    $url = ''; 
    $message=urlencode($message); 
    $username="2000191610"; 
    //$username="zumily18"; 
    $password="N4jTU5Nmn"; 
    //$senderid="ZUMILY";   
    $url="https://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$message&msg_type=TEXT&userid=$username&auth_scheme=plain&password=$password&v=1.1&format=text";  
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_POST, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
    curl_exec($ch);
    curl_error($ch); 
}


?>

