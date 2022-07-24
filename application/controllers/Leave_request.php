<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_request extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	 
	// leave list  
 	public function leave_request_list()
	{   
	    $current_date = date('Y-m-d'); 
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year;  
	    
	     $is_session_changed =  $this->input->get('is_session_changed', TRUE);
        $session_id = base64_decode($this->input->get('session_id', TRUE));
        $class_register_id = base64_decode($this->input->get('class_register_id', TRUE)); 
        if($is_session_changed == 1)
        {
            $status ='';
        }
        else
        {
	        $status = $this->input->get('approve_status', TRUE); 
        } 
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
		$data['selected_status'] = $status; 
		
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['classregister_lists'] = $this->classregister_model->get_classregister_dropdown_list($session_id); 
		
		$data['leave_request_lists'] = $this->leave_request_model->get_leave_request_list($session_id,$class_register_id,$status,$is_session_changed);
	  
		 
		$data['totalrecord'] =count($data['leave_request_lists']);
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('leave-request-list',$data); 
	} 
	
	// update leave request 
	public function update_leave_request()
	{    
        $leave_request_id = $this->input->post('leave_request_id', TRUE);  
        $data['request_status'] = $this->input->post('request_status', TRUE);
        $data['comment'] = $this->input->post('comment', TRUE);
        $data['approved_by'] = 'A'; 
        $data['last_updated'] = $this->session->userdata('current_date_time'); 
        $leave_request_insert = $this->leave_request_model->update_leave_request($data,$leave_request_id);  
        
        redirect('leave-request-list', 'refresh');
	}  
	
	// delete leave request
	public function delete_leave_request()
	{  
	    $leave_request_id = $this->uri->segment('2');    
        $delete_leave_request = $this->leave_request_model->delete_leave_request($leave_request_id);   
        
        if (!empty($delete_leave_request)) 
        {
            $sdata['success'] = 'Leave request deleted successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('leave-request-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('leave-request-list', 'refresh');
        }  
	}
	
	// leave request details  
 	public function leave_request_details()
	{ 
	    $leave_request_id = $this->uri->segment('2');   
	    
	    
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['leave_request_id'] = $leave_request_id; 
		$data['leave_request_info'] = $this->leave_request_model->get_leave_request_info($leave_request_id); 
		
		   
		 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('leave-request-details',$data); 
		$this->load->view('include/right_sidebar');
	} 
	
	// leave request approval  
 	public function leave_request_approval()
	{ 
	    
	    $leave_request_id = base64_decode($this->uri->segment('2'));   
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['leave_request_id'] = $leave_request_id; 
		$data['leave_request_info'] = $this->leave_request_model->get_leave_request_info($leave_request_id);  
		
		 
		$is_read_by = $data['leave_request_info']['read_by'];
		if($is_read_by == '')
		{
		    $leave_data['read_by'] = 'A'; 
            $leave_data['read_datetime'] = $this->session->userdata('current_date_time'); 
            $leave_request_insert = $this->leave_request_model->update_leave_request($leave_data,$leave_request_id); 
		}
		
		 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('leave-request-approval',$data); 
		$this->load->view('include/right_sidebar');
	} 
	
	// create event pdf
	public function leave_request_pdf()
	{   
	    
	    $current_date = date('Y-m-d'); 
	    
	    $url = $this->uri->segment('2'); 
	    $str = explode("-",$url);
	    
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $session_year = base64_decode($str[0]);
	    $class_name = base64_decode($str[1]);
	    $status = base64_decode($str[2]);
	    
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_year = $session_data[0]->session_year;   
	 
	    if($session_year != '')
		{
		    $session_year = $session_year;   
		}
		else
		{
		    $session_year = $current_session_year; 
		} 
	 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['leave_request_lists'] = $this->leave_request_model->get_leave_request_list($session_year,$class_name,$status,$this->input->cookie('school_id',true));
	   
		$filename = md5($this->input->cookie('school_id',true))."_leave_request_list.pdf";  
        $html = $this->load->view('leave_request_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/leaverequest/".$filename, "F");
        $filepath = base_url()."assets/pdfs/leaverequest/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
}
