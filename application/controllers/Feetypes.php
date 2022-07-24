<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feetypes extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// subject list view
	public function fee_types_list()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$data['totalrecord'] =count($data['fee_types_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('fee-types-list',$data); 
		$this->load->view('include/right_sidebar'); 
	} 
	
	// add fee type view
	public function add_fee_type()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-fee-type');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit fee type view
	public function edit_fee_type()
	{
        $fee_type_id = $this->uri->segment('2'); 
        $data['fee_type_info'] = $this->feetype_model->get_fee_type_info($fee_type_id);
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-fee-type',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add and edit fee type process
	public function add_fee_type_process()
	{  
	    $fee_type_id = $this->input->post('fee_type_id', TRUE); 
        if($fee_type_id == '')
        {
            $school_id = $this->input->cookie('school_id',true);
            $data['fee_type'] = ucwords(rtrim($this->input->post('fee_type_name', TRUE)));
            $data['description'] = $this->input->post('description', TRUE);
            $data['school_id'] = $school_id;
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time');   
            $subject_insert = $this->feetype_model->insert_fee_type($data); 
            if (!empty($subject_insert)) 
            {
                $sdata['success'] = 'Fee Type added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('fee-types-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-fee-type', 'refresh');
            } 
        }
        else
        { 
            $data['fee_type'] = ucwords(rtrim($this->input->post('fee_type_name', TRUE)));
            $data['description'] = $this->input->post('description', TRUE); 
            $data['last_updated'] = $this->session->userdata('current_date_time');   
            $fee_type_update = $this->feetype_model->update_fee_type($data,$fee_type_id); 
            if (!empty($fee_type_update)) 
            {
                $sdata['success'] = 'Fee Type updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('fee-types-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-fee-type', 'refresh');
            } 
        }
         
	}
	
	// enable fee type
	public function enable_fee_type()
	{  
	    $fee_type_id = $this->uri->segment('2');  
        $data['displayflag'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
        $fee_type_update = $this->feetype_model->update_fee_type($data,$fee_type_id);  
        $sdata['success'] = 'Fee Type enabled successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('fee-types-list', 'refresh');
     
	}
	
	// disable fee type
	public function disable_fee_type()
	{  
	    $fee_type_id = $this->uri->segment('2');  
        $data['displayflag'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
        $fee_type_update = $this->feetype_model->update_fee_type($data,$fee_type_id);  
        $sdata['success'] = 'Fee Type desabled successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('fee-types-list', 'refresh');  
	}
	
	// delete fee type
	public function delete_fee_type()
	{  
	    $fee_type_id = $this->input->post('fee_type_id', TRUE);  
        $this->feetype_model->delete_fee_type($fee_type_id); 
        
        $sdata['success'] = 'Fee Type deleted successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('fee-types-list', 'refresh');
         
        
	}
	
	// create fee type pdf
	public function create_fee_type_pdf()
	{  
	      
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$filename = md5($this->input->cookie('school_id',true))."_feetype_list.pdf";   
        $html = $this->load->view('fee_type_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/studentfeetype/".$filename, "F");
        $filepath = base_url()."assets/pdfs/studentfeetype/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath);
        
        
        
	}
	
	
	
  
}
