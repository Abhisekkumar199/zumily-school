<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	
	// contact us
	public function contact_us()
	{   
	    
	    $leave_request_id = $this->uri->segment('2');   
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('contact-us');
		$this->load->view('include/right_sidebar');
	}   
	   
	// faq view
	public function faq()
	{   
		$data['faq_lists'] = $this->pages_model->get_faq_list();
		$this->load->view('include/header_static_pages');
	    $this->load->view('faq',$data);
		$this->load->view('include/footer'); 
	}
	
	// privacy policy view
	public function privacyPolicy()
	{  
		$this->load->view('include/header_static_pages');
	    $this->load->view('privacy-policy');
		$this->load->view('include/footer'); 
	}
	
	// terms of use view
	public function termsOfuse()
	{  
		$this->load->view('include/header_static_pages');
	    $this->load->view('terms-of-use');
		$this->load->view('include/footer'); 
	}
	
	
	
	// terms of use view
	public function contactUs()
	{  
		$this->load->view('include/header');
	    $this->load->view('contact-us');
		$this->load->view('include/footer'); 
	}
	
	// sign up process
	public function contactUsProcess()
	{    
		    $data['name'] = $this->input->post('name', TRUE);
            $data['mobile'] = $this->input->post('mobile', TRUE);
            $data['email'] = $this->input->post('email', TRUE);
            $data['message'] = $this->input->post('message', TRUE); 
            $data['date_created'] = $this->session->userdata('current_date_time');
            $school_id = $this->pages_model->store_contactus($data);
             
		    $this->session->set_flashdata('message', '<font color="green">Your query has been submitted successfully</font>'); 
            redirect('contact-us', 'refresh'); 
	}
	
	// forget password view
	public function forgetPassword()
	{ 
		$this->load->view('include/header');
	    $this->load->view('forget-password');
		$this->load->view('include/footer'); 
	}

}
