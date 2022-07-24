<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();    
		$this->load->database();   
    }
	 // new    
	// school info view
	public function classList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['class_lists'] = $this->class_model->get_class_list($this->input->cookie('school_id',true));
		$data['totalrecord'] =count($data['class_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('classes-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// check class name
	public function checkClassname()
	{  
	    
	       $classname = $this->input->post('class_name', TRUE); 
	     $section = $this->input->post('section', TRUE); 
	      $classId = $this->input->post('classId', TRUE);  
	     if($section != '' and $classname != '')
	     { 
	        echo   $classname = $this->class_model->check_classname($classname,$section,$classId,$this->input->cookie('school_id',true));
	     }
	    
	}
	// add class view
	public function addClass()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-class');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit class view
	public function editClass()
	{
        $class_id = base64_decode($this->uri->segment('2')); 
        $data['class_info'] = $this->class_model->get_class_info($class_id);
        //print_r($data['class_info']);
        //die();
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-class',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add and edit class process
	public function addClassProcess()
	{  
	    $classId = $this->input->post('classId', TRUE); 
        if($classId == '')
        {
            $school_id = $this->input->cookie('school_id',true);
            $data['class_name'] = strtoupper(ltrim(rtrim($this->input->post('class_name', TRUE),' '),' '));
            $data['section'] = strtoupper(ltrim(rtrim($this->input->post('section', TRUE),' '),' '));
            $data['school_id'] = $school_id;
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_insert = $this->class_model->insert_class($data); 
            if (!empty($class_insert)) 
            {
                $sdata['success'] = 'Class added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('classes-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-class', 'refresh');
            } 
        }
        else
        { 
            $data['class_name'] = strtoupper(ltrim(rtrim($this->input->post('class_name', TRUE),' '),' '));
            $data['section'] = strtoupper(ltrim(rtrim($this->input->post('section', TRUE),' '),' ')); 
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_update = $this->class_model->update_class($data,$classId); 
            if (!empty($class_update)) 
            {
                $sdata['success'] = 'Class updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('classes-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-class', 'refresh');
            } 
        }
         
	}
	
	// enable class
	public function enableClass()
	{  
	    $classId = $this->uri->segment('2');  
        $data['displayflag'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $class_update = $this->class_model->update_class($data,$classId); 
        if (!empty($class_update)) 
        {
            $sdata['success'] = 'Class enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('classes-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('classes-list', 'refresh');
        }  
         
	}
	
	// disable class
	public function disableClass()
	{  
	    $classId = $this->uri->segment('2');  
        $data['displayflag'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');   
         
        $class_update = $this->class_model->update_class($data,$classId); 
        if (!empty($class_update)) 
        {
            $sdata['success'] = 'Class enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('classes-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('classes-list', 'refresh');
        }  
	} 
	
	// delete class
	public function delete_class()
	{  
	    $class_id = $this->input->post('class_id', TRUE);  
        $this->class_model->delete_class($class_id); 
        
        $sdata['success'] = 'Class deleted successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('classes-list', 'refresh');
         
        
	}
	
	// create class pdf
	public function create_class_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['class_lists'] = $this->class_model->get_class_list($this->input->cookie('school_id',true));
		$filename = md5($this->input->cookie('school_id',true))."_class_list.pdf";   
        $html = $this->load->view('class_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/class/".$filename, "F");
        $filepath = base_url()."assets/pdfs/class/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath);
        
        
        
	}
}
