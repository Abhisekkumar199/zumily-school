<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studentfeepayment extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();           
    }
	  
	// class register list view 
	public function classregisterList()
	{  
	    $current_date = date('Y-m-d'); 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
        $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
	    $selected_session_id = base64_decode($this->input->get('session_year', TRUE));  
	    if($selected_session_id == '')
		{  
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}
		else
		{ 
		    $session_id = $selected_session_id;
		    $data['selected_session'] = $selected_session_id;  
		} 
	    
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));  
		$data['classregister_lists'] = $this->classregister_model->get_classregister_list_by_session_id($this->input->cookie('school_id',true),$session_id);  
		
		
		$data['totalrecord'] =count($data['classregister_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('school-fee-payment-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
 
	// class register fee details
	public function class_register_students()
	{ 
	  
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
        $data['class_register_id'] = $class_register_id; 
		$data['class_student_list'] = $this->class_register_student_model->get_class_register_student_list($class_register_id);  
	    $class_section_name = $data['classregister_info']['class_name']." ".$data['classregister_info']['section']; 
		 
        $data['class_section_name'] = $class_section_name; 
		//$data['student_lists'] = $this->student_model->get_unallocated_student_list($this->input->cookie('school_id',true)); 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('class-register-students',$data); 
		$this->load->view('include/right_sidebar'); 
	    
	}
	
	// class register fee details
	public function update_class_register_student_fee()
	{ 
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $str = explode('-',$this->uri->segment('2')); 
        
        
        $class_register_student_id = base64_decode($str[0]); 
	    $class_register_id = base64_decode($str[1]);
        $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);  
        
        $class_register_fee_payment_list = $this->schoolfeepayment_model->class_register_fee_payment($class_register_student_id); 
		$class_total_year_fee = $this->schoolfeepayment_model->class_total_year_fee($class_register_id); 
        $total_year_fee = $class_total_year_fee[0]->total_fee_amount; 
	    
        $data['class_register_student_id'] = $class_register_student_id;
	    $data['class_register_id'] = $class_register_id;  
		$data['class_name'] = $student_info['class_name_section'];
		$data['student_name'] = $student_info['first_name']." ".$student_info['last_name'];
		$data['course_stream'] =$student_info['course_stream'];
		$data['registration_no'] =$student_info['registration_no'];
		$data['date_of_birth'] =$student_info['date_of_birth'];
		$data['father_name'] = $student_info['father_name'];
		$data['profile_picture'] =''; 
		$data['student_id'] = $student_info['student_id'];
		$data['total_year_fee'] = $total_year_fee;
		$data['class_register_fee_payment_list'] = $class_register_fee_payment_list; 
	    
	    
		//$data['student_additional_fee_info'] = $this->schoolfeepayment_model->get_student_additional_fee_info($class_register_student_id);
		$data['class_register_active_concession'] = $this->feeconcession_model->get_class_register_active_concession($class_register_student_id); 
		$data['class_register_student_info'] = $this->class_register_student_model->get_class_register_student_info($class_register_student_id); 
		
		
		
		$paid_month = '';
		foreach($class_register_fee_payment_list as $payment)
        {
            if($paid_month == '')
            {
                $paid_month = $payment->payment_months; 
            }
            else
            { 
                $paid_month .= ",".$payment->payment_months;
            }
        } 
	   
		
	    $data['paid_month'] = $paid_month; 
	    
		
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2(base64_decode($str[1]));   
	 	$class_register_fee_setuped_month = $this->schoolfeepayment_model->class_register_fee_setuped_month(base64_decode($str[1])); 
	 	
	 	$setuped_month = '';
		foreach($class_register_fee_setuped_month as $month)
        {
            if($setuped_month == '')
            {
                $setuped_month = $month->yyyymm; 
            }
            else
            { 
                $setuped_month .= ",".$month->yyyymm;
            }
        }
        $schoolid = $this->input->cookie('school_id',true); 
		$data['setuped_month'] = $setuped_month;   
        $maxid = $this->db->query("SELECT MAX(receipt_number) AS `maxid` FROM `students_fee_payments` where school_id='".$schoolid."'")->row()->maxid;  
        
        if($maxid == '') 
        {
            $maxid = 999;
        }
        
		$data['receipt_no'] = $maxid;  
		
		
		 
		
		
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('update-class-register-student-fee',$data);  
	} 
	
	// late additional fee list
	public function students_additional_fee_list()
	{    
	    $year_month =  date('Ym', strtotime("last month")); 
	    $current_date = date('Y-m-d');  
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
        $is_session_changed =  $this->input->get('is_session_changed', TRUE);
        $session_id = base64_decode($this->input->get('session_id', TRUE));
        $class_register_id = base64_decode($this->input->get('class_register_id', TRUE)); 
	     
	      
		if($session_id != '')
		{
		    $session_id = $session_id;  
		    $data['selected_session'] = $session_id;
		}
		else
		{
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}   
		
		$data['selected_class'] = $class_register_id;  
		 
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['classregister_lists'] = $this->classregister_model->get_classregister_dropdown_list($session_id); 
		
	    $data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
	    
	    
	    if($this->uri->segment('2') != '')
	    {
    	    $class_register_student_id = base64_decode($this->uri->segment('2'));   
            $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);   
    	     
              $is_active_additional_fee = $this->schoolfeepayment_model->check_if_is_active_additional_fee($class_register_student_id); 
		    $data['student_lists'] = $this->schoolfeepayment_model->student_additional_fee_list_for_specific_student($class_register_student_id);
            $data['student_details'] = $student_info['first_name']." ".$student_info['last_name']." (".$student_info['class_name_section']."), ".$student_info['father_name']." (F)";
            $data['class_register_student_id'] = $class_register_student_id;
            $data['first_name'] = trim($student_info['first_name']);
            $data['middle_name'] = '';
            $data['last_name'] = trim($student_info['last_name']);
            $data['father_name'] = $student_info['last_name']; 
            $data['class_name_section'] = $student_info['class_name_section'];
            $data['student_id'] = $student_info['student_id'];
            $data['class_register_id'] = $student_info['class_register_id'];
            $data['session_id'] = $session_id;
            $data['is_active_additional_fee'] = $is_active_additional_fee;
	    }
	    else
	    {
		    $data['student_lists'] = $this->schoolfeepayment_model->student_additional_fee_list($session_id,$class_register_id); 
	        $data['student_details'] = '';
	        $data['class_register_student_id'] = '';
            $data['first_name'] = '';
            $data['middle_name'] = '';
            $data['last_name'] = '';
            $data['father_name'] = '';
            $data['parent_mobile_no'] = '';
            $data['class_name_section'] = '';
            $data['student_id'] = '';
            $data['session_id'] = '';
            $data['class_register_id'] = '';
            $data['is_active_additional_fee'] = '';
	    } 
		
		$data['currentdate'] = $this->session->userdata('current_date');
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('additional-fee-list',$data); 
        
	}
	
	
	public function add_additional_fee_process()
	{ 
	    $student_data['school_id'] = $this->input->cookie('school_id',true);  
        $student_data['class_register_student_id'] = $this->input->post('class_register_student_id',true);  
        $student_data['class_register_id'] = $this->input->post('class_register_id',true);  
        $student_data['session_id'] = $this->input->post('session_id',true);  
        $student_data['class_name_section'] = $this->input->post('class_name_section',true);  
        $student_data['student_id'] = $this->input->post('student_id',true);   
        $student_data['fee_type'] = $this->input->post('fee_type',true);  
        $student_data['additional_fee_amount'] = $this->input->post('amount',true);  
        $student_data['reason'] = $this->input->post('reason',true);   
        $student_data['date_created'] = $this->session->userdata('current_date_time');  
        $student_data['last_updated'] = $this->session->userdata('current_date_time'); 
        $is_axist = $this->schoolfeepayment_model->check_if_active_additional_fee($this->input->post('class_register_student_id',true)); 
        if($is_axist > 0)
        {
            echo "<font color='red'>You cannot add another record because there is already an active Additional Fee Record for this student.</font>" ;
        }
        else
        { 
            $insert = $this->schoolfeepayment_model->insert_additional_fee($student_data); 
            echo 1 ;
        }  
	}
	
	// get_month_fee_amount
	public function get_month_fee_amount()
	{ 
        $months = $this->input->post('months', TRUE); 
	    $class_register_id = $this->input->post('class_register_id', TRUE); 
	    $concession_amount = $this->input->post('concession_amount', TRUE); 
        $fee_type = $this->input->post('fee_type', TRUE);  
        $course_stream = $this->input->post('course_stream', TRUE);   
	  
	    $class_register_student_id = $this->input->post('class_register_student_id', TRUE); 
	    
	    
	    if(count($months) > 0)
	    {
    	 	$months_fee_amount = $this->schoolfeepayment_model->get_month_fee_amount($class_register_id,$months,$course_stream,$class_register_student_id);  
    	  
    	    $result = '<p>'; 
    	    $total_amount = 0;
    	    
    	    $fee_breakup_info = '';
    	    $is_fee_type_matched = '';
    	    $is_added_additional_fee = 0 ;
    	    $additional_fee_string = '';
    	    
    	    foreach($months_fee_amount as $fee_amount)
            {  
                $specific_fee_type_amount = $fee_amount->fee_amount ; 
                
                $result .= "<strong>".$fee_amount->fee_type.":</strong> &#x20B9;".$specific_fee_type_amount."&nbsp;&nbsp;&nbsp;";  
                
                if($fee_breakup_info == '')
                {
                    $fee_breakup_info = $fee_amount->fee_type."~".$specific_fee_type_amount;
                }
                else
                {
                    $fee_breakup_info .= ";".$fee_amount->fee_type."~".$specific_fee_type_amount;
                }
                $total_amount = $total_amount + $specific_fee_type_amount;
            } 
             
             
            
            if($concession_amount > 0)
            {
                $total_amount = $total_amount - $concession_amount;
                $result .= "<strong>Concession:</strong> &#x20B9;".$concession_amount."&nbsp;&nbsp;&nbsp;"; 
            } 
            
            
            
            $result .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style='color:red;'><strong>Total Amount:</strong></label> <label style='font-weight:bold;'>&#x20B9;".$total_amount."</label>";
            $result .= "</p>";
            if($total_amount >= 0)
            {
                echo $total_amount."|".$result."|".$fee_breakup_info; 
            }
	    }
	}
	
	// class register students attendance process
	public function school_fee_payment_process()
	{     
	    $str = $this->input->post('fee_year_month', TRUE);
        $total_month = count($this->input->post('fee_year_month', TRUE)); 
	    $letest_month = $str[$total_month - 1]; 
	    
        $fee_year_months = implode(',',$this->input->post('fee_year_month', TRUE));  
        $receipt_number = $this->input->post('receipt_number', TRUE); 
        $total_fee = $this->input->post('total_fee', TRUE);  
        $late_fee =  $this->input->post('late_fee', TRUE); 
        $received_amount =  $this->input->post('received_amount', TRUE); 
        $payment_mode =  $this->input->post('payment_mode', TRUE); 
        
           
        
        $student_data['payment_months'] = $fee_year_months; 
        $student_data['receipt_number'] = $receipt_number;  
        $student_data['total_fee'] = $total_fee;  
        $student_data['late_fee'] = $late_fee;  
        $student_data['received_amount'] = $received_amount;  
        $student_data['payment_mode'] = $payment_mode;  
        $student_data['late_fee'] = $late_fee;  
        $student_data['school_id'] = $this->input->cookie('school_id',true);  
        $student_data['student_id'] = $this->input->post('student_id',true);  
        $student_data['class_register_student_id'] = $this->input->post('class_register_student_id',true);  
        $student_data['concession'] = $this->input->post('concession_amount',true);  
        $student_data['student_fee_concession_id'] = $this->input->post('student_fee_concession_id',true);  
        $student_data['payment_date'] = date("Y-m-d",strtotime($this->input->post('received_date',true))); 
        $student_data['yyyymm'] = date("Ym",strtotime($this->input->post('received_date',true))); 
        
         
       
        $student_data['fee_breakup_info'] = str_replace("~","|",$this->input->post('fee_breakup_info',true));   
        
        $payment_id = $this->schoolfeepayment_model->insert_fee($student_data);   
        
        $class_register_student_id = $this->input->post('class_register_student_id',true); 
        $class_register_student_data['last_fee_payment_yyyymm'] = $letest_month;
        $this->class_register_student_model->update_class_register_student($class_register_student_data,$class_register_student_id);
        
        
        
        
        $additional_fee_data['students_fee_payment_id'] = $payment_id; 
        $additional_fee_data['last_updated'] = $this->session->userdata('current_date_time'); 
        $this->schoolfeepayment_model->update_student_additional_fee($additional_fee_data,$class_register_student_id); 
   
        
        $concession_frequency = $this->input->post('concession_frequency',true);  
        $concession_id = $this->input->post('student_fee_concession_id',true);
        if($concession_frequency == "Onetime")
        {
            $concession_data['status'] = '2';    
             $this->feeconcession_model->update_fee_concession($concession_data,$concession_id);   
        }
        
        
        
        
        
        
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        $class_register_student_id = $this->input->post('class_register_student_id', TRUE); 
        $class = $this->input->post('class', TRUE); 
        $student_name = $this->input->post('student_name', TRUE); 
        $registration_no = $this->input->post('registration_no', TRUE); 
        $dob= $this->input->post('dob', TRUE); 
        $father_name = $this->input->post('father_name', TRUE); 
        $profile_picture = $this->input->post('profile_picture', TRUE); 
        $student_id = $this->input->post('student_id', TRUE);  
         
        redirect('update-class-register-student-fee/'.base64_encode($class_register_student_id)."-".base64_encode($class_register_id), 'refresh');
        
	}
	
	// create class register student fee pdf
	public function create_class_register_student_fee_pdf()
	{   
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $str = explode('-',$this->uri->segment('2'));  
        
	    $class_register_student_id = base64_decode($str[0]);
        
        $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);  
	    
		$data['class_name'] = $student_info['class_name_section'];
		$data['student_name'] = $student_info['first_name']." ".$student_info['last_name'];
		$data['registration_no'] =$student_info['registration_no'];
		$data['date_of_birth'] =$student_info['date_of_birth'];
		$data['father_name'] = $student_info['father_name']; 
	    
	    
	    $class_register_id = base64_decode($str[1]);
	    $class_total_year_fee = $this->schoolfeepayment_model->class_total_year_fee($class_register_id); 
        $total_year_fee = $class_total_year_fee[0]->total_fee_amount; 
		$data['total_year_fee'] = $total_year_fee;
	    
	    
	    $data['class_register_fee_payment_list'] = $this->schoolfeepayment_model->class_register_fee_payment($class_register_student_id); 
	    
	   
	    
		$filename = md5($this->input->cookie('school_id',true))."_classregister_student_fee_list.pdf";  
        $html = $this->load->view('classregister_student_fee_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterstudentfee/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterstudentfee/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	
	// late fee students list
	public function late_fee_reminder_list()
	{    
	    $year_month =  date('Ym', strtotime("last month"));  
	    $current_date = date('Y-m-d'); 
	    
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
	    $selected_session_id = $this->input->get('session_year', TRUE);  
	     
		if($selected_session_id == '')
		{  
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}
		else
		{ 
		    $session_id = $selected_session_id;
		    $data['selected_session'] = $selected_session_id;  
		} 
		
		$data['selected_class'] = $class_register_id;    
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));  
		 
	    $data['reminder_lists'] = $this->schoolfeepayment_model->late_fee_reminder_list($session_id); 
		 
		$data['currentdate'] = $this->session->userdata('current_date');
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('late-fee-reminder-list',$data); 
        
	}
	
    // late fee students list
	public function late_fee_students_list()
	{    
        $year_month =  date('Ym', strtotime("last month"));   
        
	    $current_date = date('Y-m-d'); 
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
        $is_session_changed =  $this->input->get('is_session_changed', TRUE);
        $session_id = base64_decode($this->input->get('session_id', TRUE));
        $class_register_id = base64_decode($this->input->get('class_register_id', TRUE)); 
	     
	      
		if($session_id != '')
		{
		    $session_id = $session_id;  
		    $data['selected_session'] = $session_id;
		}
		else
		{
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}   
		
		$data['selected_class'] = $class_register_id;   
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['classregister_lists'] = $this->classregister_model->get_classregister_dropdown_list($session_id); 
		
		if($class_register_id == '' or $is_session_changed == 1)
		{ 
		    $data['student_lists'] = $this->schoolfeepayment_model->student_list_for_late_fee_for_all_class($year_month,$session_id);
		}
		else
		{
		    $data['student_lists'] = $this->schoolfeepayment_model->student_list_for_late_fee_for_specific_class($year_month,$class_register_id); 
		}
		
		$data['currentdate'] = $this->session->userdata('current_date');
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('late-fee-students-list',$data); 
        
	}
	
	
	public function late_fee_reminder_process()
	{ 
        $school_id = $this->input->cookie('school_id',true);
	    $year_month =  date('Ym', strtotime("last month"));   
	    
	    $session_id = $this->input->post('session_id');
	    $session_year = $this->input->post('session_year');
	    $class_register_id = $this->input->post('selected_class'); 
        $student_ids = $this->input->post('student_ids', TRUE);   
        $class_register_student_ids = $this->input->post('class_register_student_ids', TRUE); 
        $total_students =  count($class_register_student_ids);
        $sending_to ='S'; 
	    
        $message_data['title'] = "Late Fee Reminder";
        $message_data['description'] = $this->input->post('desc', TRUE);
        $message_data['message_type_id'] = "20";
        $message_data['message_type_display_name'] = "LateFeeReminder";
        $message_data['sending_to'] =  $sending_to; 
        $message_data['school_id'] = $school_id; 
        $message_data['date_created'] = $this->session->userdata('current_date_time');
        $message_data['last_updated'] = $this->session->userdata('current_date_time');  
      
        $message_id = $this->message_model->insert_message($message_data); 
        
        $userids = $this->student_model->get_students_user_list($student_ids);
        foreach($userids as $userid)
	    {
            $user_id = $userid->user_id;
            $message_user_data['message_id'] = $message_id;
            $message_user_data['user_id'] = $user_id; 
            $this->message_model->insert_message_user_delivery($message_user_data);  
            
            // insert into notifications
            $notification_data['school_id'] = $school_id; 
            $notification_data['payload_id'] = $message_id;
            $notification_data['payload_type'] = 'R'; 
            $notification_data['title'] = "Late Fee Reminder";
            $notification_data['description'] = $this->input->post('desc', TRUE);  
            $notification_data['user_id'] = $userid->user_id; 
            $notification_data['date_created'] = $this->session->userdata('current_date_time');
            $this->cron_model->insert_notification($notification_data);   
                
	    } 
        $student_id_list = implode(',',$student_ids); 
        $update_message_data['sending_list'] =  $student_id_list;    
        $this->message_model->update_message($update_message_data,$message_id);   
        
        $class_register_student_id_list = implode(',',$class_register_student_ids); 
        $reminder_data['school_id '] = $school_id;
        $reminder_data['session_id'] = $session_id;
        $reminder_data['session_year'] = $session_year;
        $reminder_data['title'] = "Late Fee Reminder";
        $reminder_data['class_register_students_list '] = $class_register_student_id_list;
        $reminder_data['total_students '] = $total_students;
        $reminder_data['message_id'] =  $message_id;  
        $reminder_data['date_created'] = $this->session->userdata('current_date_time'); 
      
        $message_id = $this->schoolfeepayment_model->insert_student_late_fee_reminder($reminder_data);  
        send_notification(); 
        
        $sdata['success'] = 'Message sent successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('late-fee-reminder-list', 'refresh'); 
	}
	
	
	// create class register student list for late fee reminder pdf
	public function create_class_register_student_list_for_latefee_reminder_pdf()
	{    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $year_month =  date('Ym', strtotime("last month"));  
	    $current_date = date('Y-m-d'); 
	    
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_id = $session_data[0]->session_id; 
	    
	    $str = explode('|',$this->uri->segment('2')); 
	      $selected_session_id = base64_decode($str[0]); 
	    $class_register_id = base64_decode($str[1]); 
		if($selected_session_id == '')
		{  
		    $session_id = $current_session_id; 
		}
		else
		{ 
		    $session_id = $selected_session_id; 
		} 
		     
		
		if($class_register_id == '')
		{ 
		    $data['student_lists'] = $this->schoolfeepayment_model->student_list_for_late_fee_for_all_class($year_month,$session_id);
		}
		else
		{
		    $data['student_lists'] = $this->schoolfeepayment_model->student_list_for_late_fee_for_specific_class($year_month,$class_register_id); 
		}
	    
	   
	    
		$filename = md5($this->input->cookie('school_id',true))."_classregister_student_list.pdf";  
        $html = $this->load->view('latefee_reminder_student_list_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterstudentlist_for_latefee/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterstudentlist_for_latefee/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	
	// create late fee reminder pdf
	public function create_latefee_reminder_pdf()
	{    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $year_month =  date('Ym', strtotime("last month"));  
	    $current_date = date('Y-m-d'); 
	    
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
	    $selected_session_id =  base64_decode($this->uri->segment('2'));   
		if($selected_session_id == '')
		{  
		    $session_id = $current_session_id; 
		}
		else
		{ 
		    $session_id = $selected_session_id; 
		} 
		    
	    $data['reminder_lists'] = $this->schoolfeepayment_model->late_fee_reminder_list($this->input->cookie('school_id',true),$session_id); 
	    
		$filename = md5($this->input->cookie('school_id',true))."_reminder_list.pdf";  
        $html = $this->load->view('latefee_reminder_list_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/latefeereminder/".$filename, "F");
        $filepath = base_url()."assets/pdfs/latefeereminder/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	} 
	
	
	// student fee receipt
	public function student_fee_receipt()
	{ 
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        
        $receipt_number =  $this->input->post('receipt_number', TRUE);   
        $student_fee_receipt_info = $this->schoolfeepayment_model->get_student_fee_receipt_info($receipt_number,$this->input->cookie('school_id',true));  
       
        
        $data['student_fee_receipt_info'] = $student_fee_receipt_info;
		$data['receipt_no'] = $receipt_number;  
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('student_fee_receipt',$data); 
		$this->load->view('include/right_sidebar'); 
	} 
	
	
	// create student fee receipt pdf
	public function student_fee_receipt_pdf()
	{    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	     
	    
        $receipt_number =  base64_decode($this->uri->segment('2'));  
	    
	    $student_fee_receipt_info = $this->schoolfeepayment_model->get_student_fee_receipt_info($receipt_number,$this->input->cookie('school_id',true));  
	    
	    $data['student_fee_receipt_info'] = $student_fee_receipt_info;
		$data['receipt_no'] = $receipt_number;  
		
		$filename = md5($this->input->cookie('school_id',true))."_student_fee_receipt.pdf";  
        $html = $this->load->view('student_fee_receipt_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/studentfeereceipt/".$filename, "F");
        $filepath = base_url()."assets/pdfs/studentfeereceipt/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
}
