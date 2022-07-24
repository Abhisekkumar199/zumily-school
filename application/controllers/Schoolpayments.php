<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schoolpayments extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// payment list view
	public function schoolPaymentTransactions()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['payment_lists'] = $this->schoolpayments_model->get_payment_list($this->input->cookie('school_id',true)); 
		$data['totalrecord'] =count($data['payment_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('school-payment-transactions',$data); 
	}
	 
 
	// add payment view
	public function addPayment()
	{  
	    $current_date = $this->session->userdata('current_date');
	    
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_year_end_date = $session_data[0]->end_date; 
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $data['total_students'] = $this->class_register_student_model->total_class_register_students($this->input->cookie('school_id',true)); 
	    
	    $total_student = $data['total_students']; 
	    $data['rate_per_month'] = $this->schoolpayments_model->rate_student_permonth($total_student);   
	     
        $valid_until = $data['user_info']['valid_until'];  
        $date_created = $data['user_info']['date_created'];
        $diff = strtotime($current_session_year_end_date) - strtotime($date_created);  
        $total_days =  abs(round($diff / 86400));
        $total_month = $total_days/30;
        
        $total_month = number_format((float)$total_month, 2, '.', '');
        if($valid_until == '')
        { 
    	    
            
            $amount_due = ($total_month * $total_student *  $data['rate_per_month']['rate_student_permonth'])* .75;
            $data['total_amount'] = $total_month * $total_student *  $data['rate_per_month']['rate_student_permonth'];
            $data['discount_amount'] = ($total_month * $total_student *  $data['rate_per_month']['rate_student_permonth'])* .25;
    	    $data['discount'] = "25";
    	    $data['amount_due'] = $amount_due;  
    	    $data['total_month'] = $total_month; 
        }
        else
        {
            $amount_due = $total_month * $total_student *  $data['rate_per_month']['rate_student_permonth'];
            $data['total_amount'] = $amount_due;
            $data['discount_amount'] = 0;
    	    $data['discount'] = "0";
    	    $data['amount_due'] = $amount_due;  
    	    $data['total_month'] = 12; 
        } 
	    $data['valid_until'] = $current_session_year_end_date; 
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-school-payment',$data);
		$this->load->view('include/right_sidebar'); 
	}
	 
	// add  payment process
	public function addSchoolPaymentProcess()
	{    
        $payment_id = $this->input->post('payment_id', TRUE);  
        if($payment_id == '')
        {  
            // insert payment
            $payment_data['school_id'] = $this->input->cookie('school_id',true);
            $payment_data['total_students'] = $this->input->post('total_student', TRUE);
            $payment_data['rate_student_permonth'] = $this->input->post('rate_student_permonth', TRUE); 
            $payment_data['discount_percentage'] = $this->input->post('discount_percentage', TRUE);  
            $payment_data['amount_paid'] = $this->input->post('amount_paid', TRUE);  
            $payment_data['transaction_date'] = $this->session->userdata('current_date_time');  
            $payment_data['valid_until'] = $this->input->post('valid_until', TRUE);  
            $payment_data['total_months'] = $this->input->post('total_months', TRUE); 
            $payment_data['payment_type'] = $this->input->post('payment_type');
            $payment_data['check_draft_number'] = $this->input->post('check_draft_number');
            $payment_data['bank_name'] = $this->input->post('bank_name');
            $payment_data['bank_branch_name'] = $this->input->post('bank_branch_name');
            $payment_data['utr_number'] = $this->input->post('utr_number');    
            $payment_data['date_created'] = $this->session->userdata('current_date_time');  
            $payment_data['last_updated'] = $this->session->userdata('current_date_time');     
            $school_payment_transaction_id = $this->schoolpayments_model->insert_payment($payment_data);   
            
            $school_data['valid_until'] = $this->input->post('valid_until', TRUE);  
            $school_data['payment_reminder_datetime'] = NULL;    
            $school_data['latest_payment_transaction_id'] = $school_payment_transaction_id;   
            $school_data['last_updated'] = $this->session->userdata('current_date_time');     
            $this->school_model->updateSchool($school_data,$this->input->cookie('school_id',true)); 
            
            delete_cookie('subscription_status');  
    		$session_data = array(
    		'subscription_status' => '' 
    		);
    		$this->session->unset_userdata('user', $session_data);
            
            $sdata['success'] = '<div class="alert alert-success">Payment Submitted successfully.</div> '; 
            $this->session->set_userdata($sdata);
            redirect('school-payments-transactions', 'refresh'); 
        }
        else
        {
                // insert payment 
                $payment_data['total_students'] = $this->input->post('total_student', TRUE);
                $payment_data['rate_student_permonth'] = $this->input->post('rate_student_permonth', TRUE); 
                $payment_data['discount_percentage'] = $this->input->post('discount_percentage', TRUE);  
                $payment_data['amount_paid'] = $this->input->post('amount_paid', TRUE);  
                $payment_data['transaction_date'] = $this->session->userdata('current_date');  
                $payment_data['valid_until'] = $this->input->post('valid_until', TRUE);  
                $payment_data['total_months'] = $this->input->post('total_months', TRUE); 
                $payment_data['payment_type'] = $this->input->post('payment_type');
                $payment_data['check_draft_number'] = $this->input->post('check_draft_number');
                $payment_data['bank_name'] = $this->input->post('bank_name');
                $payment_data['bank_branch_name'] = $this->input->post('bank_branch_name');
                $payment_data['utr_number'] = $this->input->post('utr_number');  
                $payment_data['last_updated'] = $this->session->userdata('current_date_time');     
                $this->schoolpayments_model->update_payment($payment_data,$payment_id);    
                if (!empty($student_update)) 
                {
                    $sdata['success'] = '<div class="alert alert-success">Student updated successfully.</div>'; 
                    $this->session->set_userdata($sdata);
                    redirect('students-list', 'refresh');
                } 
                else 
                {
                    $sdata['exception'] = '<div class="alert alert-danger">Something went wrong!! Please try again.</div>';  
                    $this->session->set_userdata($sdata);
                    redirect('add-student', 'refresh');
                }
    	    } 
	}
	
	 
 
 
}
