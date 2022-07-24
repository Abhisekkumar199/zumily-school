<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();     
    }
	  
	public function index()
	{ 
		$this->load->view('include/header_merchant');
		$this->load->view('include/left_home');
	    $this->load->view('school-info');
		$this->load->view('include/right_sidebar');
	}
	
	// sign up view
	public function signup()
	{  
		$this->load->view('include/header');
	    $this->load->view('signup');
		$this->load->view('include/footer'); 
	}
	
	// sign up process
	public function signupProcess()
	{ 
	    $flag = 1;
	    
		if($this->input->post('emailid') != '')
		{
	        $data = array(
    		'email_id' => $this->input->post('emailid') 
    		); 
    		$emailcheck = $this->school_model->emailCheck($data); 
		    if($emailcheck > 0)
    		{
    		    echo "<div class='alert alert-danger'><strong>Oops!</strong> Email id already exist</div>";
    		    $flag = 0; 
    		    die();
    		}
		}
		
		if($this->input->post('phone') != '')
		{
		    $data = array(
    		'phone' => $this->input->post('phone') 
    		); 
    		$phonecheck = $this->school_model->mobileCheck($data);
		    if($phonecheck > 0)
    		{ 
    		    echo "<div class='alert alert-danger'>Phone no. already exist</div>"; 
    		    $flag = 0; 
    		    die();
    		}
		} 
		
		if($flag == 1)
		{
		    $contact_person = ucwords($this->input->post('contact_person_name', TRUE)); 
            $hash=base64_encode($this->input->post('emailid', TRUE));
		    $data['contact_person'] = ucwords($this->input->post('contact_person_name', TRUE));
		    if($this->input->post('emailid', TRUE) != '')
		    {
                $data['email_id'] = $this->input->post('emailid', TRUE);
		    }
            $data['country_code'] = $this->input->post('country', TRUE);
            $data['phone'] = $this->input->post('phone', TRUE);
            $data['password'] = md5($this->input->post('password', TRUE)); 
            $data['date_created'] = $this->session->userdata('current_date_time');
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $school_id = $this->school_model->store_school($data);
            $mobile = $this->input->post('phone', TRUE);
            $country = "IN";
		    if($mobile != '') 
		    { 
                $otp = rand(100000,999999); 
                
            	$session_data = array(
    			'school_mobile' => $mobile, 
    			'school_email' => $this->input->post('emailid', TRUE), 
    			'school_id' => $school_id, 
    			'school_otp' => $otp, 
    			); 
    			
    			// Add user data in session
    			$this->session->set_userdata($session_data); 
			    
                $otpdata = array(
        		'mobile_otp' => $otp 
        		); 
    		    $saveotp = $this->school_model->updateSchool($otpdata,$school_id);  
                
                $this->school_model->updateSchool($otpdata,$school_id); 
                 
                $url = '';
                
                $message="Welcome to Zumily School! Your OTP is  ".$otp;  
                send_otp($mobile,$message); 
		    } 
		    if($this->input->post('emailid', TRUE) != '')
		    {
    	        $messagec='<body style="width:100%; float:left; padding:0; margin:0; font-family:arial"> 
                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff"> 
                <tr>
                <td colspan="3"  valign="top" align="center">
                <table  width="680" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:arial; border: 1px solid #ddd; margin:20px 0">
                
                <tr><td>&nbsp;</td></tr>
                <tr>
                  <td colspan="3"  valign="top" align="center"><a href="https://localhost/project/zumilyschool/"  target="_blank" ><img src="https://localhost/project/zumilyschool/assets/images/zumily-logo-new.png" style="width:200px"></a></td>
                </tr>
                <tr><td colspan="3" ><hr style="border-color:#eee;"></td></tr>
                <tr><td colspan="3"  valign="top" align="center"><h3 style="font-size:17px; margin-bottom:10px"><strong>COMMUNICATE WITH STUDENTS & PARENTS</strong></h3></td></tr>
                <tr>
                <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-weight:inherit; padding-top:10px;">
                <p style="padding:0 20px; font-size:14px; line-height:20px;"><strong>Dear '.$contact_person.',</strong></p></td>
                </tr>		
                <tr>
                	<td colspan="3"  valign="top" align="left">
                 
                	<p style="padding:0 20px; font-size:14px; line-height:20px;">Congratulations and thank you for joining the Zumily School community!<br><br>
                
                	Now, you can start listing your messages, events, program reminders to be delivered to students and parents. They can see them on Zumily school app in real-time.<br><br>
                
                	Please DO remind your students and parents to download the zumily school app and signup ASAP.
                	</p>
                
                	<h3 style="padding:0 20px; margin-bottom:0"><strong>Benefits:</strong></h3>
                	<ul style="font-size:14px; line-height:20px; margin-top:0">
                		<li>Publish messages as often or as little as you like.</li>
                		<li>You can publish all your session-year’s holidays.</li>
                		<li>School or class-teacher can take attendance online, no registers needed!</li>
                		<li>Approve or deny student’s leave request online.</li>
                		<li>Track student’s fees status online.</li> 
                		<li>You create events and let Students/Parents get notified on-time, no worries for reminders!</li> 
                		<li>Totally paperless and delivered to students as you create them. No wait!</li> 
                	</ul>
                
                	<p style="font-size:14px; line-height:20px;padding:0 20px;">We do not want anyone to misuse your email so please click on the link below to verify that you have signed up for our services.<br><a href="https://localhost/project/zumilyschool/verify-school/'.$hash.'">https://localhost/project/zumilyschool/verify-school/'.$hash.'</a></p>
                	<p style="font-size:14px; line-height:20px;padding:0 20px;">If you have any questions, feel free to contact us at <a href="#">help@www.zumilyschool.com</a> or visit the live chat on our website.</p>
                	<p style="line-height:20px;padding:0 20px;">Thank you,<br>
                	Zumily School Team
                	</p>
                	</td>
                </tr>
                <tr><td colspan="3" ><hr style="border-color:#eee;"></td></tr>
                <tr><td valign="top" align="center">
                <h4 style="margin-bottom:10px">Download our free app</h4>
                <a href="#"><img src="https://localhost/project/zumilyschool/assets/images/android.png" alt="" style="width:100px"> </a>
                <a href="#"><img src="https://localhost/project/zumilyschool/assets/images/apple.png" alt="" style="width:100px"> </a>
                
                </td>
                <td valign="top" align="left" style="width:200px">&nbsp;</td>
                <td  valign="top" align="center">
                <h4 style="margin-bottom:10px">Follow with us</h4>
                
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/facebook-icon.png" style="width:20px"></a>
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/google-icon.png" style="width:20px"></a>
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/link-icon.png" style="width:20px"></a>
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/twitter-icon.png" style="width:20px"></a>
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/youtube-icon.png" style="width:20px"></a>
                <a href=""><img src="https://localhost/project/zumilyschool/assets/images/icon/whatsapp-icon.png" style="width:20px"></a>
                <p>&nbsp;</p></td>
                
                </tr>
                
                <tr><td colspan="3" valign="top" align="center">
                <ul style="padding:0; display:block; margin:0;">
                <li style="width:auto; display:inline-block;"><a href="https://localhost/project/zumilyschool/privacy-policy" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none">Privacy Policy |</a></li>
                <li style="width:auto; display:inline-block;"><a href="https://localhost/project/zumilyschool/terms-services" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none">Term & Services |</a></li>
                <li style="width:auto; display:inline-block;"><a href="https://localhost/project/zumilyschool/faq" style="width:100%; float:left; color:#5f88ff;font-size:12px; text-decoration:none"> FAQ</a></li></ul>
                
                
                </td></tr>
                <tr><td colspan="3" valign="top" align="center">
                <p style="font-size:11px;color:#333">19504 Kilfinan St, Porter Ranch, CA 91326 <br>&copy; 2018 Zumily.com. All Rights Reserved</p>
                
                </td></tr>
                </table></td>
                </tr>
                </table></body>';
		    
    		    $email = $this->input->post('emailid', TRUE);
                $from_email ="info@zumily.com";
                $to_email = $email; 
                $this->email->set_header('Content-Type', 'text/html');
                $this->email->from($from_email, 'www.zumilyschool.com'); 
                $this->email->to($to_email);
                $this->email->subject('www.zumilyschool.com | Registration'); 
                $this->email->message($messagec);
                $this->email->send();
		    }
            
            
		}  	
		if($country == "IN")
		{
		    echo "verify-mobile";
		}
		else
		{
		    echo "verify-email";
		} 
	}
	
	// verify school from email
	public function verifySchool()
	{
	   $emailid = base64_decode($this->uri->segment('2')); 
	    $data['is_email_verified'] = 1;
	    $data['is_verified'] = 1;
	   
        $verify_school = $this->school_model->verifySchool($data,$emailid);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Account verified. please login here.</div>'); 
        $this->load->view('include/header');
	    $this->load->view('login');
		$this->load->view('include/footer'); 
	}
	
	//verify school through mobile
	public function verifyMobile()
	{
	    $data['mobile_no'] = $this->session->userdata('school_mobile'); 
	    $data['school_id'] = $this->input->cookie('school_id',true);  
	    $data['school_otp'] = $this->session->userdata('school_otp'); 
        $this->load->view('include/header');
	    $this->load->view('verify-mobile',$data);
		$this->load->view('include/footer'); 
	}
	
	//verify school mobile Process		
	public function verifyMobileProcess() 
	{ 
	    $school_info = $this->school_model->get_school_info($this->session->userdata('school_id'));
	     
	    $mobileno  = $this->input->post('mobileno', TRUE);  
	    $otp  = $this->input->post('otp', TRUE);
	    if($otp == $this->session->userdata('school_otp'))
	    {
	        $data['is_phoneno_verified'] = 1;
	        $data['is_verified'] = 1; 
            $verify_school = $this->school_model->verifyMobile($data,$mobileno);
            
            $session_data = array(
			'email_id' => $school_info['email_id'],
			'password' => $school_info['password'],
			'mobile' => $school_info['phone'],
			'contact_person' => $school_info['contact_person'],  
			'school_id' => $school_info['school_id'], 
			); 
			
		    
		    $cookie_school_id= array(
                  'name'   => 'school_id',
                  'value'  => $school_info['school_id'],
                   'expire' => '2592000',
            );
            $this->input->set_cookie($cookie_school_id);
            
            $cookie_school_mobile= array(
                  'name'   => 'school_mobile',
                  'value'  => $school_info['phone'],
                   'expire' => '2592000',
            );
			
		    $this->session->set_userdata($session_data);  
		    
		    
            $this->input->set_cookie($cookie_school_mobile);  
			redirect('dashboard', 'refresh'); 
			 
	    }
	    else
	    { 
            $this->session->set_flashdata('message', '<div class="alert alert-danger">OTP is invalid.</div>'); 
	        $data['mobile_no'] = $this->session->userdata('school_mobile'); 
    	    $data['school_id'] = $this->input->cookie('school_id',true);  
    	    $data['school_otp'] = $this->session->userdata('school_otp'); 
            $this->load->view('include/header');
    	    $this->load->view('verify-mobile',$data);
    		$this->load->view('include/footer'); 
	    }
		  
	}  
	
	// verify mobile otp page
	public function verifyMobileLogin()
	{
	    $data['mobile_no'] = $this->session->userdata('school_mobile'); 
	    $data['school_id'] = $this->session->userdata('school_id');
	    $data['school_otp'] = $this->session->userdata('school_otp'); 
	    
	    if($this->session->userdata('school_mobile') != '') 
	    { 
	        $mobile = $this->session->userdata('school_mobile');
            $otp = rand(100000,999999); 
            $school_id = $this->session->userdata('school_id');
        	$session_data = array(
			'school_mobile' => $this->session->userdata('school_mobile'),  
			'school_id' => $this->session->userdata('school_id'), 
			'school_otp' => $otp, 
			); 
		    $this->session->set_userdata($session_data);  
		    
		    
            $otpdata = array(
    		'mobile_otp' => $otp 
    		); 
		    $saveotp = $this->school_model->updateSchool($otpdata,$school_id);  
             
            $message="Welcome to Zumily School! Your OTP is  ".$otp;  
            send_otp($mobile,$message); 
	    } 
        $this->load->view('include/header');
	    $this->load->view('verify-mobile',$data);
		$this->load->view('include/footer'); 
	}
	
	// forgot password view
	public function forgotPassword()
	{  
		$this->load->view('include/header');
	    $this->load->view('forgot-password');
		$this->load->view('include/footer'); 
	}
	
	// forgot password process
	public function forgotPasswordProcess()
	{   
	    $mobile = $this->input->post('mobile');
		$data = array(
    		'phone' => $mobile 
    		); 
		$phonecheck = $this->school_model->mobileCheck($data);
	    if($phonecheck > 0)
		{ 
		     
		    $school_info = $this->school_model->get_school_info_by_mobile($mobile);
            if($mobile != '') 
    	    {  
                $otp = rand(100000,999999);  
                $school_id = $school_info->school_id;
            	$session_data = array(
    			'school_mobile' => $school_info->phone,  
    			'school_id' => $school_info->school_id, 
    			'school_otp' => $otp, 
    			); 
    		    $this->session->set_userdata($session_data);  
    		    
    		     
    		    
                $otpdata = array(
        		'mobile_otp' => $otp 
        		); 
    		    $saveotp = $this->school_model->updateSchool($otpdata,$school_id);  
                 
                $message="Welcome to Zumily School! Your OTP is  ".$otp;  
                send_otp($mobile,$message);  
    	    }  
    		echo 1 ; 
		}
		else
		{
		    echo "<div class='alert alert-danger'><strong>Oops!</strong> Mobile No. does not exist.</div>"; 
		}
	}
	
	// verify forget password otp view
	public function verifyForgetPasswordOtp()
	{
	    $data['mobile_no'] = $this->session->userdata('school_mobile'); 
	    $data['school_id'] = $this->input->cookie('school_id',true);  
	    $data['school_otp'] = $this->session->userdata('school_otp');   
	    
        $this->load->view('include/header');
	    $this->load->view('verify-forgot-password-mobile',$data);
		$this->load->view('include/footer'); 
	}
	
	// set new password view
	public function SetNewPassword()
	{  
	    $data['mobile_no'] = $this->session->userdata('school_mobile'); 
	    $data['school_id'] = $this->session->userdata('school_id');  
		$this->load->view('include/header');
	    $this->load->view('set-new-password',$data);
		$this->load->view('include/footer'); 
	}
	
	// set new password process
	public function SetNewPasswordProcess()
	{    
		$data['password']  = md5($this->input->post('password')); 
	      $school_id = $this->input->post('school_id');  
	    $this->school_model->updateSchool($data,$school_id);
	} 
	
	// login view
	public function login()
	{ 
		$this->load->view('include/header');
	    $this->load->view('login');
		$this->load->view('include/footer'); 
	}
	
	// login process
	public function schoolLogin()
	{ 
	    $data = array(
		'email_id' => $this->input->post('emailid'),
		'password' => md5($this->input->post('password'))
		);
	 
        $schooldata = $this->school_model->login($data);  
		if (!empty($schooldata)) 
		{ 
		     $country_code = $schooldata->country_code; 
            $check_is_school_verified = $this->school_model->is_school_verified($data);  
		    if (!empty($check_is_school_verified)) 
		    {  
		          $payment_reminder_datetime = $check_is_school_verified->payment_reminder_datetime; 
		        $valid_until = $check_is_school_verified->valid_until;  
                $date_created = $check_is_school_verified->date_created;   
                $current_date_time = $this->session->userdata('current_date_time');
                  $this->session->userdata('current_date_time');
                $diff = strtotime($current_date_time) - strtotime($date_created);  
                $diff1 = strtotime($current_date_time) - strtotime($valid_until); 
                  
                $diff2 = strtotime($current_date_time) - strtotime($payment_reminder_datetime); 
                
                
                $total_days =  round($diff / 86400); 
                $total_days1 =  round($diff1 / 86400); 
                 $total_days2 =  round($diff2 / 86400); 
                $is_paid = 0;
                if($valid_until == '2099-12-31')
		        {
		            $subscription_message = ''; 
    		        
                    $subscription_status = 0 ; 
		            $subscription_message = "You have Owner granted LIFE-TIME FREE memebreship.";
                    $is_payble = 0 ;
		        }
		        else
		        {  
                    $is_payble = 1 ;
                    if($valid_until == '' and $total_days > 90)
    		        {
    		            
                        // popup shown, school cann't access site: site completely blocked 
    		            $subscription_message = "Your trial period has ended and account has been locked. Please make the payment to continue using it.";
    		            $subscription_status  = 2;
    		        }
    		        else if($valid_until == '' and $total_days > 60)
    		        {
    		            $subscription_message = "Your trial period is going to end soon, please make the payment to continue using it."; 
    		            if($payment_reminder_datetime == '' or $total_days2 > 4)
                        { 
                            
                            // popup shown, school can still access site 
    		                $subscription_status  = 1;
    		                
    		                $school_reminder['school_id'] = $check_is_school_verified->school_id;  
                            $school_reminder['reminder_datetime'] = $this->session->userdata('current_date_time'); 
                            $this->school_model->school_payment_reminder($school_reminder);
                            
                            $school_data['payment_reminder_datetime'] = $this->session->userdata('current_date_time'); 
                            $this->school_model->updateSchool($school_data,$check_is_school_verified->school_id);
    		                
                        }
                        else 
                        {
                            // no popup shown
                            $subscription_status = 0;
                        }
    		        }
    		        else if($valid_until != '' and $total_days1 >= 30)
    		        {
    		            
                        // popup shown, school cann't access site: site completely blocked 
    		            $subscription_message = "Payment due date is over 30 days so your account has been locked until you pay the amount due.";
    		            $subscription_status  = 2;
    		        }
    		        else if($valid_until != '' and $total_days1 >= 15)
    		        {
    		            $subscription_message = "Payment due date has been passed, please make the payment to continue using it."; 
    		            if($payment_reminder_datetime == '' or $diff2 > 4)
                        { 
                            
                            // popup shown, school can still access site 
    		                $subscription_status  = 1;  
    		                $school_reminder['school_id'] = $check_is_school_verified->school_id;  
                            $school_reminder['reminder_datetime'] = $this->session->userdata('current_date_time'); 
                            $this->school_model->school_payment_reminder($school_reminder);
                            
                            $school_data['payment_reminder_datetime'] = $this->session->userdata('current_date_time'); 
                            $this->school_model->updateSchool($school_data,$check_is_school_verified->school_id);
                        }
                        else 
                        {
                            // no popup shown
                            $subscription_status = 0 ;
                        } 
    		        }
    		        else
    		        {
    		            $subscription_message = ''; 
    		            // no popup shown
                        $subscription_status = 0 ;
    		            // no popup shown
                        $is_paid = 1 ;
    		        } 
		        }
		        
		        $session_data = array(
    			'email_id' => $check_is_school_verified->email_id,
    			'password' => $check_is_school_verified->password,
    			'mobile' => $check_is_school_verified->phone,
    			'contact_person' => $check_is_school_verified->contact_person,  
    			'school_id' => $check_is_school_verified->school_id, 
    			'subscription_message' => $subscription_message,
    			'subscription_status' => $subscription_status,
    			'is_payble' => $is_payble,
    			'is_paid' => $is_paid,
    			);
    			
    			$cookie_school_id= array(
                      'name'   => 'school_id',
                      'value'  => $check_is_school_verified->school_id,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_school_id);
                
                $cookie_school_mobile= array(
                      'name'   => 'school_mobile',
                      'value'  => $check_is_school_verified->phone,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_school_mobile);
                
                
                $cookie_subscription_message= array(
                      'name'   => 'subscription_message',
                      'value'  => $subscription_message,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_subscription_message);
                
                $cookie_subscription_status= array(
                      'name'   => 'subscription_status',
                      'value'  => $subscription_status,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_subscription_status);
                
                $cookie_is_payble= array(
                      'name'   => 'is_payble',
                      'value'  => $is_payble,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_is_payble);
                
                $cookie_is_paid= array(
                      'name'   => 'is_paid',
                      'value'  => $is_paid,
                       'expire' => '2592000',
                );
                $this->input->set_cookie($cookie_is_paid);
                 
    			// Add user data in session
    			$this->session->set_userdata($session_data); 
    		 
    			redirect('dashboard', 'refresh'); 
		    }
		    else
		    {
		        if($country_code == 'IN')
		        {
		            $session_data = array(  
        			'school_mobile' => $schooldata->phone,   
        			'school_id' => $schooldata->school_id, 
        			);  
    			    $this->session->set_userdata($session_data);
    			    
    			     
        		    
                    $this->session->set_flashdata('message','<div class="alert alert-danger">Your Mobile No. is not verified yet. <a href="verify-account">Click here to send OTP and verify your mobile no.</a></div>');
		            redirect('login', 'refresh'); 
		        }
		        else
		        {
		            
		        }
		        
		    }
		    
			
		} 
		else 
		{ 
            $this->session->set_flashdata('message','<div class="alert alert-danger">Email Address/Mobile No. OR Password is invalid!</div>');
            redirect('login', 'refresh'); 
		}
	}
	
	// change password
	public function changePassword()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('change-password',$data);
		$this->load->view('include/right_sidebar');
	}
	
	// change password process
	public function changePasswordProcess()
	{ 
	    $old_password = $this->input->post('oldfpassword');
	    $newpassword = $this->input->post('password'); 
	     $check_old_password = $this->school_model->check_old_password($old_password,$this->input->cookie('school_id',true));
	    
	    if($check_old_password== 1)
	    { 
            $data['password'] = md5($newpassword);
            $insert_id = $this->school_model->updateSchool($data,$this->input->cookie('school_id',true)); 
            
            echo "<div class='alert alert-success'>Password changed successfully</div>";
	    }
	    else
	    {
	        echo "<div class='alert alert-danger'>Old password is wrong.</div>";
	    }
	    
	   
	}  
	
	  
	
	// school info view
	public function schoolInfo()
	{ 
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	     
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('school-info',$data);
		$this->load->view('include/right_sidebar'); 
	}
	
	// school update view
	public function schoolUpdate()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	    
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home',$data);
	    $this->load->view('school-information');
		$this->load->view('include/right_sidebar'); 
	} 
	
	// school update process
	public function updateSchoolInfo()
	{ 
            $school_id = $this->input->cookie('school_id',true); 
	       
            $data['school_name'] = ucwords($this->input->post('school_name', TRUE));
            if($this->input->post('emailid', TRUE) != '')
            {
                $data['email_id'] = ucwords($this->input->post('email_id', TRUE));
            }
            $data['school_address'] = ucwords($this->input->post('school_address', TRUE));
            $data['school_description'] = $this->input->post('school_description', TRUE);
            $data['contact_person'] = ucwords($this->input->post('contact_person', TRUE)); 
            $data['principal_name'] = ucwords($this->input->post('principal_name', TRUE)); 
            $data['principal_mobile_no'] = !empty($this->input->post('principal_mobile_no', TRUE)) ? $this->input->post('principal_mobile_no', TRUE) : NULL;     
            $data['vice_principal_mobile_no'] = !empty($this->input->post('vice_principal_mobile_no', TRUE)) ? $this->input->post('vice_principal_mobile_no', TRUE) : NULL;   
            $data['transport_incharge'] = ucwords($this->input->post('transport_incharge', TRUE));  
            $data['transport_incharge_mobile_no'] = !empty($this->input->post('transport_incharge_mobile_no', TRUE)) ? $this->input->post('transport_incharge_mobile_no', TRUE) : NULL;  
            $data['vice_principal_name'] = ucwords($this->input->post('vice_principal_name', TRUE)); 
            $data['school_website'] = $this->input->post('school_website', TRUE); 
            $data['school_facebook_page'] = $this->input->post('school_facebook_page', TRUE); 
            $data['school_youtube_channel'] = $this->input->post('school_youtube_channel', TRUE); 
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            
               
            $image = $this->input->post("result1");
            if(!empty($image))
            {
                $oldimage = $this->input->post('oldimage', TRUE);
                if($oldimage != '')
                { 
                    unlink('./assets/uploadimages/schoolimages/'.$oldimage);  
                } 
                
                define('UPLOAD_DIR', './assets/uploadimages/schoolimages/');
                $image_parts = explode(";base64,", $_REQUEST['result1']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                
                $filename = uniqid() . '.png';
                $file = UPLOAD_DIR . $filename;
                file_put_contents($file, $image_base64);
                
                
                
                // image compress 
                //$percentage = '60%';
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/schoolimages/'.$filename;   
                //$config1['quality'] = $percentage;
                $config1['width']         = 100;
                $config1['height']       = 100;
                $config1['maintain_ratio'] = FALSE; 
                
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);  
                 
                if ( ! $this->image_lib->resize())
                {
                        echo $this->image_lib->display_errors();
                }
                
                $this->image_lib->clear();
                
    	        $data['school_logo'] = $filename;
            }
                
    	     
     
           /* if (isset($_FILES['picture_name']['name']) && !empty($_FILES['picture_name']['name'])) 
            {
                
                $a = $_FILES['picture_name']['name'];     
                $config['upload_path']  = './assets/uploadimages/schoolimages/';
    			$config['allowed_types'] = 'gif|jpg|png'; 
    			$this->upload->initialize($config); 
    			$this->load->library('upload', $config);
    			$this->upload->do_upload('picture_name');
    			$upload_data = $this->upload->data(); 
                $file_name1 = $a;   
            }
            else
            {
                $file_name1 = $this->input->post('blankimage');
            }*/
            
            
            $insert_id = $this->school_model->updateSchool($data,$school_id); 
            
            if (!empty($insert_id)) 
            {
                $sdata['success'] = '<div class="alert alert-success">Profile update successfully.</div> '; 
                $this->session->set_userdata($sdata);
                redirect('school-info', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = '<div class="alert alert-danger">Something went wrong!! Please try again..</div>';  
                $this->session->set_userdata($sdata);
                redirect('school-information', 'refresh');
            } 
	} 
	
	// check school email exist or not
	public function checkSchoolEmail()
	{ 
	    $school_id = $this->input->cookie('school_id',true);
        $email_id = $this->input->post('email_id', TRUE);   
        $check_school_email = $this->school_model->check_school_email($email_id,$school_id);
        
        if($check_school_email == 1)
        {
            echo $check_school_email;
            exit();
        }
        else
        { 
            echo 0 ; 
        } 
	}
	 
	// reset subscription status
	public function resetSubscriptionStatus() 
	{ 
		// Removing session data
	    delete_cookie('subscription_status');  
		$session_data = array(
		'subscription_status' => '' 
		);
		$this->session->unset_userdata('user', $session_data);
		$this->session->set_flashdata('message', 'you have Logout Successfully '); 
		redirect('', 'refresh');
		
		
	} 
	
	// logout user
	public function logout() 
	{ 
		// Removing session data
	    delete_cookie('school_id'); 
		delete_cookie('school_mobile'); 
		delete_cookie('subscription_message'); 
		delete_cookie('subscription_status'); 
		delete_cookie('is_payble'); 
		delete_cookie('is_paid'); 
		$session_data = array(
		'email_id' => '',
		'password' => '',
		'mobile' => '',
		'contact_person' => '',  
		'school_id' => '', 
		'school_mobile' => '',
		'subscription_message' => '',
		'subscription_status' => '',
		'is_payble' => '',
		'is_paid' => ''
		);
		$this->session->unset_userdata('user', $session_data);
		$this->session->set_flashdata('message', 'you have Logout Successfully '); 
		redirect('', 'refresh');
		
		
	} 
 
}
