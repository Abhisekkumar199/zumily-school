<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FeeConcession extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();           
    }
	  
	// class register list view 
	public function fee_concession()
	{ 
	    
	    $current_date = date('Y-m-d'); 
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
	    $is_session_changed =  $this->input->get('is_session_changed', TRUE);
        $session_id = base64_decode($this->input->get('session_id', TRUE));
        $class_register_id = base64_decode($this->input->get('class_register_id', TRUE)); 
	     
	      
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
		
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['classregister_lists'] = $this->classregister_model->get_classregister_dropdown_list($session_id); 
		
	    
	    
	    
	    
	    if($this->uri->segment('2') != '')
	    {
    	    $class_register_student_id = base64_decode($this->uri->segment('2'));   
            $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);   
    	     
            $data['student_details'] = $student_info['first_name']." ".$student_info['last_name']." (".$student_info['class_name_section']."), ".$student_info['father_name']." (F)";
            
            
            $is_active_concession = $this->feeconcession_model->check_if_is_active_concession($class_register_student_id);
            
            $data['student_fee_concession_list'] = $this->feeconcession_model->student_feeconcession_list($class_register_student_id); 
            $data['class_register_student_id'] = $class_register_student_id;
            $data['class_register_id'] = $student_info['class_register_id'];
            $data['first_name'] = trim($student_info['first_name']);
            $data['middle_name'] = '';
            $data['last_name'] = trim($student_info['last_name']);
            $data['father_name'] = $student_info['last_name']; 
            $data['class_name_section'] = $student_info['class_name_section'];
            $data['student_id'] = $student_info['student_id'];
            
            $data['is_active_concession'] = $is_active_concession;
	    }
	    else
	    {
	        
            $data['student_fee_concession_list'] = $this->feeconcession_model->student_feeconcession_list_for_session($session_id,$class_register_id); 
	        $data['student_details'] = ''; 
            $data['class_register_student_id'] = '';
            $data['class_register_id'] = '';
            $data['first_name'] = '';
            $data['middle_name'] = '';
            $data['last_name'] = '';
            $data['father_name'] = '';
            $data['parent_mobile_no'] = '';
            $data['class_name_section'] = '';
            $data['student_id'] = '';
            $data['is_active_concession'] = '';
	    }
	    
	     
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('fee-concession',$data);  
	} 
	 
	
	// add class register student
	public function add_fee_concession_process()
	{  
	    $current_date = date('Y-m-d'); 
	    $id =  $this->uri->segment('2');    
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
	    $current_session_id = $session_data[0]->session_id;
	    
	    $class_register_student_id = $this->input->post('class_register_student_id',true); 
	    $first_name = $this->input->post('first_name',true); 
	    $middle_name = $this->input->post('middle_name',true); 
	    $last_name = $this->input->post('last_name',true); 
	    $father_name = $this->input->post('father_name',true);  
	    $class_name_section = $this->input->post('class_name_section',true); 
	    $student_id = $this->input->post('student_id',true); 
         
        if($id == '')
        { 
            $student_data['concession_type'] = $this->input->post('concession_type', TRUE); 
            $student_data['concession_frequency'] = $this->input->post('frequency', TRUE);  
            $student_data['concession_amount'] = $this->input->post('amount', TRUE);  
            $student_data['reason_for_concession'] = $this->input->post('reason', TRUE);  
            $student_data['session_id'] = $current_session_id;  
            $student_data['school_id'] = $this->input->cookie('school_id',true);  
            $student_data['student_id'] = $this->input->post('student_id',true);  
            $student_data['class_register_student_id'] = $this->input->post('class_register_student_id',true);  
            $student_data['class_register_id'] = $this->input->post('class_register_id',true);  
            $student_data['class_name_section'] = $this->input->post('class_name_section',true);  
            $student_data['date_created'] = $this->session->userdata('current_date_time');  
             
            if(!empty($_FILES['concession_document']['name']))
            {  
                $num1=rand(100000,999999);
                $num2=rand(100000,999999); 
                $finalnum=$num1."".$num2; 
                $name= "m_".$school_id."_".$finalnum;  
			    $filename = $_FILES['concession_document']['name'];  
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $finalname = $name.".".$ext;  
                
                $_FILES['file']['name'] = $_FILES['concession_document']['name'];
                $_FILES['file']['type'] = $_FILES['concession_document']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['concession_document']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['concession_document']['error'];
                $_FILES['file']['size'] = $_FILES['concession_document']['size'];
                
                $file_size =  $_FILES['concession_document']['size'];
                
                $percentage = image_compress_quality($file_size);
              
                    
                $config['upload_path']  = './assets/uploadimages/student/fee_concessions/';
    			$config['allowed_types'] = '*';  
                $config['file_name'] = $finalname;
    			$this->upload->initialize($config); 
    			$this->load->library('upload', $config);
                  
    			$this->upload->do_upload('file');
    			$upload_data = $this->upload->data();  
    			 
    			// image compress 
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/student/fee_concessions/'.$finalname;   
                $config1['quality'] = $percentage;
                $config1['maintain_ratio'] = FALSE; 
                
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);  
                 
                if ( ! $this->image_lib->resize())
                {
                        echo $this->image_lib->display_errors();
                }
                
                $this->image_lib->clear(); 
                
                
                $student_data['concession_document'] = $finalname; 
            }
                
            $insert = $this->feeconcession_model->insert_fee_concession($student_data);    
            redirect('fee-concessions/'.base64_encode($class_register_student_id), 'refresh'); 
        } 
	}
	
    	// disable class register
	public function disable_fee_concession()
	{  
	    $fee_concession_id = $this->input->post('id');  
        $data['status'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
        $this->feeconcession_model->update_fee_concession($data,$fee_concession_id);  
        redirect('fee-concession', 'refresh');
        
	}
	
	
    // create fee concession pdf
	public function create_fee_concession_pdf()
	{   
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $class_register_student_id = base64_decode($this->uri->segment('2'));   
        $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);   
	     
        $data['student_details'] = $student_info['first_name']." ".$student_info['last_name']." (".$student_info['class_name_section']."), ".$student_info['father_name']." (F)";
        
        
        $is_active_concession = $this->feeconcession_model->check_if_is_active_concession($class_register_student_id);
        
        $data['student_fee_concession_list'] = $this->feeconcession_model->student_feeconcession_list($class_register_student_id); 
   
		$filename = md5($this->input->cookie('school_id',true))."_fee_concession_list.pdf";    
        $html = $this->load->view('fee_concession_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/feeconcession/".$filename, "F");
        $filepath = base_url()."assets/pdfs/feeconcession/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	
	
	
 
 
}
