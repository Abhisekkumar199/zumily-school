<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// subject list view
	public function subjectList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true));
		$data['totalrecord'] =count($data['subject_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('subject-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// check subject name
	public function checkSubjectname()
	{  
	    $school_id = $this->input->cookie('school_id',true);
	     $subjectname = $this->input->post('subject_name', TRUE); 
	     $subjectId = $this->input->post('subjectId', TRUE);  
        echo $check_subjectname = $this->subject_model->check_subjectname($subjectname,$subjectId,$school_id);
	    
	}
	
	// add subject view
	public function addSubject()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-subject');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit subject view
	public function editSubject()
	{
        $subject_id = base64_decode($this->uri->segment('2')); 
        $data['subject_info'] = $this->subject_model->get_subject_info($subject_id);
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-subject',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add and edit subject process
	public function addSubjectProcess()
	{  
	    $subjectId = $this->input->post('subjectId', TRUE); 
        if($subjectId == '')
        {
            $school_id = $this->input->cookie('school_id',true);
            $data['subject_name'] = ucwords(ltrim(rtrim($this->input->post('subject_name', TRUE),' '),' '));
            $data['description'] = $this->input->post('description', TRUE);
            $data['school_id'] = $school_id;
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time');   
            $subject_insert = $this->subject_model->insert_subject($data); 
            if (!empty($subject_insert)) 
            {
                $sdata['success'] = 'Subject added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('subjects-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-subject', 'refresh');
            } 
        }
        else
        { 
            $data['subject_name'] = ucwords(ltrim(rtrim($this->input->post('subject_name', TRUE),' '),' '));
            $data['description'] = $this->input->post('description', TRUE); 
            $data['last_updated'] = $this->session->userdata('current_date_time');   
            $subject_insert = $this->subject_model->update_subject($data,$subjectId); 
            if (!empty($subject_insert)) 
            {
                $sdata['success'] = 'Subject updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('subjects-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-subject', 'refresh');
            } 
        }
         
	}
	
	// enable subject
	public function enableSubject()
	{  
	    $subjectId = $this->uri->segment('2');  
        $data['displayflag'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $subject_insert = $this->subject_model->update_subject($data,$subjectId); 
        if (!empty($subject_insert)) 
        {
            $sdata['success'] = 'Subject enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('subjects-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('subjects-list', 'refresh');
        }  
         
	}
	
	// disable subject
	public function disableSubject()
	{  
	    $subjectId = $this->uri->segment('2');  
        $data['displayflag'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $subject_insert = $this->subject_model->update_subject($data,$subjectId); 
        if (!empty($subject_insert)) 
        {
            $sdata['success'] = 'Subject enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('subjects-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('subjects-list', 'refresh');
        }  
	}
	
	// disable subject
	public function delete_subject()
	{  
	    $subject_id = $this->input->post('subject_id', TRUE);  
        $this->subject_model->delete_subject($subject_id); 
        
        $sdata['success'] = 'Subject deleted successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('subjects-list', 'refresh');
         
        
	}
	
	
	// create subject pdf
	public function create_subject_pdf()
	{  
	      
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true)); 
		$filename = md5($this->input->cookie('school_id',true))."_subject_list.pdf";  
        $html = $this->load->view('subject_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/subject/".$filename, "F");
        $filepath = base_url()."assets/pdfs/subject/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath);
        
        
        
	}
  
}
