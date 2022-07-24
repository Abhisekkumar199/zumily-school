<?php

defined('BASEPATH') OR exit('No direct script access allowed');

 
function get_unread_leave_request_list($school_id) {
    // Get a reference to the controller object
    $CI = get_instance();
    // Load globel model
    $CI->load->model('leave_request_model'); 
    // Call a function of the model
    $leave_unread_request_list = $CI->leave_request_model->get_unread_leave_request_list($school_id);
    return $leave_unread_request_list;
}

function image_compress_quality($file_size) 
{ 
    $percentage = '100%';
    $CI = get_instance();
    if($file_size >= 4000000)
    {
        $percentage = '10%';
    }
    else if($file_size >= 2000000 and $file_size < 4000000)
    { 
        $percentage = '15%';
    }
    else if($file_size >= 400000 and $file_size < 1000000)
    {
        $percentage = '20%';
    }
    else  
    {
        $percentage = '30%';
    }
    return $percentage;
}


// send notification
function send_notification()
{
    $CI = get_instance();
    // Load globel model 
    $CI->load->model('cron_model');
    
    $start_date_time = date("Y-m-d H:i");
    $total_processed_records = 0;
    
    $url = 'https://fcm.googleapis.com/fcm/send'; 
    $rand_number=rand(10000,99999);
    $notification_rand_number = array( 
    		'sent_status' => $rand_number
    		); 
    $CI->cron_model->update_notification_rand_number($notification_rand_number); 
    
    $notification_lists = $CI->cron_model->get_notification($rand_number); 
    //print_r($notification_lists);
    $total_processed_records = count($notification_lists);
    //echo count($notification_lists);
    //die();
    if(count($notification_lists) > 0) 
    {  
        foreach($notification_lists as $notification) 
        {   
            if($notification->is_updated == 1)
            {
                $title= strip_tags("(Updated) ".$notification->title);
            }
            else
            {
                $title= strip_tags($notification->title);
            }
            $id = $notification->notification_id; 
            $payload_id = $notification->payload_id;
            $payload_type = $notification->payload_type;
            
            $message_body= strip_tags($notification->description);
              $key= $notification->fcm_key;
            $school_logo= $notification->school_logo;
            if($school_logo != '')
            {
                $image_url =  base_url()."assets/uploadimages/schoolimages/".$notification->school_logo;
            }
            else
            {
                $image_url = base_url()."assets/images/name.png";
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
                $notification_data = array( 
        		'sent_status' => -1,
        		'sent_datetime'=>$CI->session->userdata('current_date_time')
        		); 
    		    $CI->cron_model->update_notification($notification_data,$id);
            } 
            else
            { 
                $notification_data = array( 
        		'sent_status' => 1,
        		'sent_datetime'=>$CI->session->userdata('current_date_time')
        		); 
    		    $CI->cron_model->update_notification($notification_data,$id); 
            } 
            curl_close($ch); 
        } 
    }
    
    $end_date_time = date("Y-m-d H:i"); 
    $cron_monitoring_data = array( 
	'cron_name' => 'send_notification',
	'start_datetime' => $start_date_time,
	'end_datetime' => $end_date_time, 
	'processed_records' => $total_processed_records 
	); 
    $CI->cron_model->insert_cron_monitoring($cron_monitoring_data);
} 

// send otp
function send_otp($mobile,$message)
{   
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

// messsage images
function message_images($message_id)
{   
    $CI = get_instance();
    $CI->load->model('message_model'); 
    $message_images = $CI->message_model->get_message_images($message_id);  
    return $message_images;
}

// event images
function event_images($event_id)
{   
    $CI = get_instance();
    $CI->load->model('event_model'); 
    $event_images = $CI->event_model->get_event_images($event_id);  
    return $event_images;
}
 
// leave request images
function leave_request_images($leave_request_id)
{   
    $CI = get_instance();
    $CI->load->model('leave_request_model'); 
    $leave_request_images = $CI->leave_request_model->get_leave_request_images($leave_request_id);  
    return $leave_request_images;
}



// messsage images
function reminder_students_details($class_register_students_ids)
{   
    $CI = get_instance();
    $CI->load->model('schoolfeepayment_model'); 
    $message_images = $CI->schoolfeepayment_model->get_late_fee_reminder_students_details($class_register_students_ids);  
    return $message_images;
}

// class register reporting periods
function class_register_reporting_periods($class_register_id,$current_date)
{   
    $CI = get_instance();
    $CI->load->model('report_card_model'); 
    $reporting_period_list = $CI->report_card_model->class_register_reporting_periods_list($class_register_id,$current_date);  
    return $reporting_period_list;
}


// get_teacher_teaching_classes
function get_teacher_teaching_classes($teacher_id)
{   
    $CI = get_instance();
    $CI->load->model('teacher_model'); 
    return $teacher_teaching_classes = $CI->teacher_model->get_teacher_teaching_classes($teacher_id);   
}
 ?>
