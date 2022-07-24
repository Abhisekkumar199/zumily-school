<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();  
        $this->load->model('school_model');
        $this->load->model('dashboard_model');
        $this->load->model('subject_model');
        $this->load->model('session_model');
        $this->load->model('holiday_model'); 
        $this->load->helper(array('cookie', 'url')); 
        $this->load->library('image_lib');
    }
	  
    // dashboard
	public function dashboard()
	{ 
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $attendance_date = $this->input->post('attendance_date', TRUE);
	    $filter_start_date = $this->input->post('filter_start_date', TRUE);
	    $filter_end_date = $this->input->post('filter_end_date', TRUE);
	     
	    if($attendance_date == '')
	    {
	        $current_date =  $this->session->userdata('current_date'); 
	    }
	    else
	    { 
	        $current_date =  date('Y-m-d',strtotime($attendance_date));
	    }
	    
	    
	    if($filter_start_date == '')
	    {
	        $current_month_year = explode("-",$this->session->userdata('current_date'));
	        $filter_start_date = $current_month_year[0]."-".$current_month_year[1]."-01";
	    }
	    else
	    {
	        $current_month_year = date('Y-m-d',strtotime($filter_start_date));
	        $filter_start_date = $current_month_year;
	    }
	    
	    if($filter_end_date == '')
	    {
	        $filter_end_date = $this->session->userdata('current_date');
	    }
	    else
	    {
	        $filter_end_date = date('Y-m-d',strtotime($filter_end_date));
	    }
	      $this->input->cookie('school_id',true);
	     
	    
	    $session_data = $this->session_model->get_current_session($this->session->userdata('current_date'),$this->input->cookie('school_id',true)); 
	    if(count($session_data) == 0)
	    {
	        redirect('school-info', 'refresh');
	    }
	    else
	    {
	        $current_session_id = $session_data->session_id;
            echo $session_start_date = $session_data->start_date; 
            die();
    	    $session_date = explode("-",$session_start_date);
    	    $data['session_start_year'] = $session_date[0]; 
    	    $data['session_start_month'] = $session_date[1]; 
    	    $data['session_start_date'] = $session_date[2];  
    	    $data['filter_start_date'] = $filter_start_date;  
    	    $data['filter_end_date'] = $filter_end_date;
    	    
    	    $data['current_date'] = $current_date;
    	    
    	    $data['attendance_list'] = $this->dashboard_model->school_attendance_daywise($this->input->cookie('school_id',true),$current_date);
    	    $data['leave_request_list'] = $this->dashboard_model->dashboard_leave_request_list($this->input->cookie('school_id',true),$filter_start_date,$filter_end_date);
    	    
    	    $data['holidays_list'] = $this->dashboard_model->dashboard_holidays_list($this->input->cookie('school_id',true),$filter_start_date,$filter_end_date);
    	    $data['message_list'] = $this->dashboard_model->dashboard_message_list($this->input->cookie('school_id',true),$filter_start_date,$filter_end_date);
    	    $data['event_list'] = $this->dashboard_model->dashboard_event_list($this->input->cookie('school_id',true),$filter_start_date,$filter_end_date);
    	     
    		$this->load->view('include/header_merchant',$data); 
    		$this->load->view('include/left_home');
    	    $this->load->view('dashboard',$data); 
	    }
	}
 
 
}
