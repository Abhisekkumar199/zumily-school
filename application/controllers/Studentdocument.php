<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studentdocument extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    } 
	public function report_card()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('report_card',$data); 
		$this->load->view('include/right_sidebar'); 
	} 
	
	
	public function transfer_certificate()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('transfer_certificate',$data); 
		$this->load->view('include/right_sidebar'); 
	} 
   
}
