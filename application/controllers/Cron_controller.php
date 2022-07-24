<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_controller extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// class register info view
	public function get_system_created_user()
	{
	    $start_date_time = date("Y-m-d H:i");
	    $total_processed_records = 0; 
	    // first reminder  
        $user_lists = $this->cron_model->get_user_where_password_null();
        //print_r($user_lists);
        //echo count($user_lists);
        //die();
        if(count($user_lists) > 0) 
        {  
            foreach($user_lists as $user) 
            { 
                $user_id = $user->user_id;
                $mobile_no = $user->mobile_no;
                $total_reminders_sent= 1 + $user->total_reminders_sent;
                $hash=base64_encode($user_id);
                $url = base_url()."reset-user-password/".$hash; 
                
                if($mobile_no != '') 
    		    {  
                    if($user->is_teacher== 1)
                    {
                        $str="Your Zumily-School Teacher account has been created by $user->school_name.  Click $url to RESET PASSWORD &  Click  to download app"; 
                    }
                    else
                    {
                        $str="Your Zumily-School Parent account has been created by $user->school_name. Click $url to RESET PASSWORD &  Click to download app"; 
                    } 
                      
                    $message=urlencode($str); 
                    $username="2000191610"; 
                    $password="N4jTU5Nmn"; 
                    $senderid="ZUMILY";  
                     
                    $url="https://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$message&msg_type=TEXT&userid=$username&auth_scheme=plain&password=$password&v=1.1&format=text"; 
           
                    $url= '';
                    $ch = curl_init($url); 
                    curl_setopt($ch, CURLOPT_HEADER, 0); 
                    curl_setopt($ch, CURLOPT_POST, 0); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
                    curl_exec($ch);
                    curl_error($ch);
                    
    		    }  
                
                $user_data = array(
        		'last_reminder_sent' => $this->session->userdata('current_date'), 
        		'total_reminders_sent' => $total_reminders_sent
        		); 
    		    $this->user_model->update_user($user_data,$user_id); 
    		    
    		    
    		    $data['user_id'] = $user_id;
                $data['is_sent_on_mobile'] = 1;
                $data['is_sent_on_email'] = 0;
                $data['first_reminder_date'] = $this->session->userdata('current_date'); 
                $this->cron_model->insert_system_created_ac_reminder($data); 
               
            } 
        } 
        
        
        // second or third reminder  
        $user_lists_2 = $this->cron_model->get_user_where_password_null_with_interval();
        if(count($user_lists_2) > 0) 
        {  
            foreach($user_lists_2 as $user) 
            { 
                $user_id = $user->user_id;
                $mobile_no = $user->mobile_no;
                $total_reminders_sent= 1 + $user->total_reminders_sent;
                
                $hash=base64_encode($user_id);
                $url = base_url()."reset-user-password/".$hash;
                if($mobile_no != '') 
    		    {  
                    if($user->is_teacher== 1)
                    {
                       $str='Your Zumily-School Teacher account has been created by '.$user->school_name.'. <a href="'.$url.'" target="_blank" >Click here</a> to RESET PASSWORD & <a href="#" target="_blank" >Click here</a> to download app'; 
                    }
                    else
                    {
                        $str='Your Zumily-School Parent account has been created by '.$user->school_name.'. <a href="'.$url.'" target="_blank" >Click here</a> to RESET PASSWORD & <a href="#" target="_blank" >Click here</a> to download app'; 
                    }  
                    
                    $message=urlencode($str); 
                    $username="2000191610"; 
                    $password="N4jTU5Nmn"; 
                    $senderid="ZUMILY";  
                     
                    $url="https://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$message&msg_type=TEXT&userid=$username&auth_scheme=plain&password=$password&v=1.1&format=text"; 
           
                    $url= '';
                    $ch = curl_init($url); 
                    curl_setopt($ch, CURLOPT_HEADER, 0); 
                    curl_setopt($ch, CURLOPT_POST, 0); 
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
                    curl_exec($ch);
                    curl_error($ch);
    		    }  
                
                $user_data = array(
        		'last_reminder_sent' => $this->session->userdata('current_date'), 
        		'total_reminders_sent' => $total_reminders_sent
        		); 
    		    $this->user_model->update_user($user_data,$user_id); 
    		    
    		    if($total_reminders_sent == 2)
    		    { 
                    $data['second_reminder_date'] = $this->session->userdata('current_date');
    		    }
    		    else
    		    {
    		        $data['third_reminder_date'] = $this->session->userdata('current_date');
    		    } 
    		    
                $this->cron_model->update_system_created_ac_reminder($data,$user_id); 
               
            } 
        } 
        $total_processed_records = count($user_lists) + count($user_lists_2);
        $end_date_time = date("Y-m-d H:i"); 
        $cron_monitoring_data = array( 
		'cron_name' => 'send_app_download_notification',
		'start_datetime' => $start_date_time,
		'end_datetime' => $end_date_time, 
		'processed_records' => $total_processed_records 
		); 
	    $this->cron_model->insert_cron_monitoring($cron_monitoring_data);
        
	} 
	
	// send notification
	public function send_notification()
	{
	    $start_date_time = date("Y-m-d H:i");
	    $total_processed_records = 0;
	    
	    $url = 'https://fcm.googleapis.com/fcm/send'; 
        $rand_number=rand(10000,99999);
        $notification_rand_number = array( 
        		'sent_status' => $rand_number
        		); 
	    $this->cron_model->update_notification_rand_number($notification_rand_number); 
	    
        $notification_lists = $this->cron_model->get_notification($rand_number); 
        $total_processed_records = count($notification_lists);
        if(count($notification_lists) > 0) 
        {  
            foreach($notification_lists as $notification) 
            { 
                 
                $id = $notification->notification_id; 
                $payload_id = $notification->payload_id;
                $payload_type = $notification->payload_type;
                $title= strip_tags($notification->title);
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
                "payload" => $payload_id
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
            		'sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_notification($notification_data,$id);
                } 
                else
                { 
                    $notification_data = array( 
            		'sent_status' => 1,
            		'sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_notification($notification_data,$id); 
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
	    $this->cron_model->insert_cron_monitoring($cron_monitoring_data);
	} 
	
	// send leave request notification to parent
	public function send_leave_request_notification_to_parent()
	{ 
	    $start_date_time = date("Y-m-d H:i");
	    $total_processed_records = 0;
	    
	    $url = 'https://fcm.googleapis.com/fcm/send';   
        $rand_number=rand(10000,99999);
        $notification_rand_number = array( 
        		'notification_to_parent' => $rand_number
        		); 
	    $this->cron_model->update_notification_rand_number_for_parent($notification_rand_number); 
	    
        $notification_lists = $this->cron_model->get_leave_request_notification_for_parent($rand_number); 
        $total_processed_records = count($notification_lists);
        if(count($notification_lists) > 0) 
        {  
            foreach($notification_lists as $notification) 
            { 
                 
                  $payload_id = $notification->student_leave_request_id;
                  $payload_type = 'L';
                 $title= strip_tags($notification->request_title);
                 $message_body= strip_tags($notification->comment);
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
                "payload" => $payload_id
                ); 
                
              
                
                $fields = array( 
                	'registration_ids' => $registrationIds,
                	'notification' => $notification, 
                	'data'             => $message
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
                
                if (curl_errno($ch)) 
                {
                    $notification_data = array( 
            		'notification_to_parent' => -1,
            		'parent_sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_leave_request_notification($notification_data,$payload_id);
                } 
                else
                { 
                    $notification_data = array( 
            		'notification_to_parent' => 1,
                		'parent_sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_leave_request_notification($notification_data,$payload_id);   
                }
    		    
                curl_close($ch); 
            } 
        } 
        
        $end_date_time = date("Y-m-d H:i"); 
        $cron_monitoring_data = array( 
		'cron_name' => 'send_leave_request_notification_to_parent',
		'start_datetime' => $start_date_time,
		'end_datetime' => $end_date_time, 
		'processed_records' => $total_processed_records 
		); 
	    $this->cron_model->insert_cron_monitoring($cron_monitoring_data);
	} 
	
	// send leave request notification to teacher
	public function send_leave_request_notification_to_teacher()
	{
	    $start_date_time = date("Y-m-d H:i");
	    $total_processed_records = 0;
	    
	    $url = 'https://fcm.googleapis.com/fcm/send';   
        $rand_number=rand(10000,99999);
        $notification_rand_number = array( 
        		'notification_to_teacher' => $rand_number
        		); 
	    $this->cron_model->update_notification_rand_number_for_teacher($notification_rand_number); 
	    
        $notification_lists = $this->cron_model->get_leave_request_notification_for_teacher($rand_number);
        $total_processed_records = count($notification_lists);
        if(count($notification_lists) > 0) 
        {  
            foreach($notification_lists as $notification) 
            { 
                 
                  $payload_id = $notification->student_leave_request_id;
                  $payload_type = 'L';
                 $title= strip_tags($notification->request_title);
                 $message_body= strip_tags($notification->request_reason);
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
                "payload" => $payload_id
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
                
                 if (curl_errno($ch)) 
                {
                    $notification_data = array( 
            		'notification_to_teacher' => -1,
            		'teacher_sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_leave_request_notification($notification_data,$payload_id);
                } 
                else
                {  
                    $notification_data = array( 
            		'notification_to_teacher' => 1,
            		'teacher_sent_datetime'=>$this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_leave_request_notification($notification_data,$payload_id);   
                } 
                curl_close($ch); 
            } 
        } 
        
        $end_date_time = date("Y-m-d H:i"); 
        $cron_monitoring_data = array( 
		'cron_name' => 'send_leave_request_notification_to_teacher',
		'start_datetime' => $start_date_time,
		'end_datetime' => $end_date_time, 
		'processed_records' => $total_processed_records 
		); 
	    $this->cron_model->insert_cron_monitoring($cron_monitoring_data);
	} 
	
	
	// already implemented in code currentlly not in use
	// update searchable data
	public function update_searchable_data()
	{ 
	    $start_date_time = date("Y-m-d H:i");
	    $total_processed_records = 0;
	    // student searchable data
        $student_lists = $this->student_model->get_searchable_data_student_list(); 
        $total_processed_records = count($student_lists);
        if(count($student_lists) > 0) 
        {
            
            foreach($student_lists as $student) 
            { 
                 
                $school_id = $student->school_id;
                $first_name = $student->first_name;
                $last_name = $student->last_name;
                $student_id = $student->student_id;
                $mobile_no = $student->mobile_no;
                $profile_picture = $student->profile_picture;
                $father_name = $student->father_name;
                $mother_name = $student->mother_name;
                $parent_mobile_no = $student->parent_mobile_no;
                
                $searchable_data = $first_name;
                if($last_name !=  '')
                {
                    $searchable_data .= " ".$last_name;
                }
                if($mobile_no !=  '')
                {
                    $searchable_data .= " (".$mobile_no.") ";
                }
                if($father_name !=  '')
                {
                    $searchable_data .= ", ".$father_name." (F)";
                }
                if($mother_name !=  '')
                {
                    $searchable_data .= ", ".$mother_name." (M)";
                }
                if($parent_mobile_no !=  '')
                {
                    $searchable_data .= " (".$parent_mobile_no.")";
                }
                
                $check = $this->cron_model->check_seachable_data($school_id,$student_id,'S'); 
                $searchable_data_id = $check['searchable_data_id']; 
    		    if($searchable_data_id > 0)
        		{
        		    $searchable_data_array = array( 
            		'searchable_data' => $searchable_data,
            		'profile_picture'=>$profile_picture,
            		'last_updated' => $this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_seachable_data($searchable_data_array,$searchable_data_id);
        		}
        		else
        		{
        		    $searchable_data_array = array( 
            		'school_id' => $school_id,
            		'pointer_id' => $student_id,
            		'pointer_type' => 'S',
            		'profile_picture'=>$profile_picture,
            		'searchable_data' => $searchable_data,
            		'last_updated' => $this->session->userdata('current_date_time')
            		);  
            		 
        		    $this->cron_model->insert_seachable_data($searchable_data_array);
        		} 
        		
        		$student_data = array( 
        		'is_search_data_updated' => '1', 
        		'last_updated' => $this->session->userdata('current_date_time')
        		); 
    		    $this->student_model->update_student($student_data,$student_id);
        		
            } 
        }  
        
        // teacher searchable data
        $teacher_lists = $this->teacher_model->get_searchable_data_teacher_list(); 
        $total_processed_records  = $total_processed_records + count($teacher_lists);
        if(count($teacher_lists) > 0) 
        {  
            foreach($teacher_lists as $teacher) 
            { 
                 
                $school_id = $teacher->school_id;
                $first_name = $teacher->first_name;
                $last_name = $teacher->last_name;
                $teacher_id = $teacher->teacher_id;
                $mobile_no = $teacher->mobile_no;
                $profile_picture = $teacher->profile_picture;
                $subject1 = $teacher->subject1;
                $subject2 = $teacher->subject2;
                $subject3 = $teacher->subject3;
                
                $searchable_data = $first_name;
                if($last_name !=  '')
                {
                    $searchable_data .= " ".$last_name;
                }
                if($mobile_no !=  '')
                {
                    $searchable_data .= " (".$mobile_no.") ";
                }
                if($subject1 !=  '')
                {
                    $searchable_data .= ", (".$subject1;
                }
                if($subject2 !=  '')
                {
                    $searchable_data .= ", ".$subject2;
                }
                if($subject3 !=  '')
                {
                    $searchable_data .= ", ".$subject3;
                }
                $searchable_data .= ")";
                
                $check = $this->cron_model->check_seachable_data($school_id,$teacher_id,'T'); 
                $searchable_data_id = $check['searchable_data_id'];
    		    if($searchable_data_id > 0)
        		{
        		    $searchable_data_array = array( 
            		'searchable_data' => $searchable_data,
            		'profile_picture'=>$profile_picture,
            		'last_updated' => $this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->update_seachable_data($searchable_data_array,$searchable_data_id);
        		}
        		else
        		{
        		    $searchable_data_array = array( 
            		'school_id' => $school_id,
            		'pointer_id' => $teacher_id,
            		'pointer_type' => 'T',
            		'profile_picture'=>$profile_picture,
            		'searchable_data' => $searchable_data,
            		'last_updated' => $this->session->userdata('current_date_time')
            		); 
        		    $this->cron_model->insert_seachable_data($searchable_data_array);
        		} 
        		
        		
        		$teacher_data = array( 
        		'is_search_data_updated' => '1', 
        		'last_updated' => $this->session->userdata('current_date_time')
        		); 
    		    $this->teacher_model->update_teacher($teacher_data,$teacher_id);
        		
            } 
        }  
        
        $end_date_time = date("Y-m-d H:i"); 
        $cron_monitoring_data = array( 
		'cron_name' => 'update_searchable_data',
		'start_datetime' => $start_date_time,
		'end_datetime' => $end_date_time, 
		'processed_records' => $total_processed_records 
		); 
	    $this->cron_model->insert_cron_monitoring($cron_monitoring_data);
	} 
	
	public function syncup_user_for_teacher_user_type()
	{
	     $this->db->query(" UPDATE users u, teacher_user_xref tux, sessions s, teacher_teaching_classes ttc, teachers t SET u.active_teacher_id = tux.teacher_id, u.active_teacher_name = concat(t.first_name, ' ', t.last_name, ' (', t.subject1, ')'), u.active_teacher_school_id = tux.school_id, u.active_teacher_curr_session_id = s.session_id, u.teacher_types = concat_ws(',',case WHEN ttc.class_teacher_class_register_id !='' then 'CT' end, case WHEN ttc.sub_class_register_ids !='' then 'ST' end)
        where u.user_id=tux.user_id
        and u.is_teacher=1
        and tux.is_active=1
        and tux.school_id = s.school_id
        and now() <= s.end_date
        and now() >= s.start_date
        and tux.teacher_id=ttc.teacher_id
        and s.session_id = ttc.session_id
        and ttc.teacher_id=t.teacher_id");  
        
        $this->db->query("update users u set u.user_types = NULL");
        $this->db->query("update users u, students s set u.user_types = 'S' where u.mobile_no = s.mobile_no");
        $this->db->query("update users u, students s set u.user_types = concat_ws(',', u.user_types, 'P') where u.mobile_no = s.parent_mobile_no");
        $this->db->query("update users u, teacher_user_xref tux set u.user_types = concat_ws(',', u.user_types, 'T') where u.user_id = tux.user_id and tux.is_active=1");
	    
	}
	
  
}
