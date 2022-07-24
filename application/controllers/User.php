<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    } 
	// verify school
	public function verifyUser()
	{
	   $emailid = base64_decode($this->uri->segment('2')); 
	    $data['is_email_verified'] = '1';
	    $data['is_verified'] = '1';
	   
        $verify_user = $this->user_model->verifyUser($data,$emailid);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Thank you! your email id has been verified.<br> Please login on your app!  </div>'); 
        $this->load->view('include/header-user');
	    $this->load->view('user');
		$this->load->view('include/footer-user'); 
	}
	
  
 
}
