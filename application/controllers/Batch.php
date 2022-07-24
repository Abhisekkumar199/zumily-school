<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	 
	// student info view  abc
	public function batchList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['batch_lists'] = $this->batch_model->get_batch_list($this->input->cookie('school_id',true)); 
		$data['totalrecord'] =count($data['batch_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('batch-list',$data); 
	}
	
 
	
}
