<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classregisterfee extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();           
    }
	  
	// class register list view 
	public function classregisterList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $current_date = date('Y-m-d'); 
	    $session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true));  
        $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	    
	    $selected_session_id = base64_decode($this->input->get('session_year', TRUE)); 
	    
	    if($selected_session_id == '')
		{  
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}
		else
		{ 
		    $session_id = $selected_session_id;
		    $data['selected_session'] = $selected_session_id;   
		} 
	    
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));
		$data['classregister_lists'] = $this->classregister_model->get_classregister_list_by_session_id($this->input->cookie('school_id',true),$session_id); 
		
		
		
		$data['totalrecord'] =count($data['classregister_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('class-register-fee-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
 
	// class register fee details
	public function class_register_fee_details()
	{ 
	  
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));   
        $class_register_id = base64_decode($this->uri->segment('2'));  
        
        $data['class_register_id'] = $class_register_id;        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id);   
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$data['class_register_fee_lists'] = $this->feeconcession_model->class_register_fee($class_register_id);
	   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('class-register-fee-details',$data); 
	    
	}
	
	// class register fee details
	public function class_register_additional_fee()
	{ 
	  
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));   
        $class_register_id = base64_decode($this->uri->segment('2'));  
        
        $data['class_register_id'] = $class_register_id;        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id);   
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$data['class_registe_additional_fee'] = $this->classregister_model->class_registe_additional_fee($class_register_id);
	   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('class-register-additional-fee',$data); 
	    
	}
	
	// class register additional fee process
	public function class_register_additional_fee_process()
	{   
	    $monthly_fee_info = '';
        $class_register_id = $this->input->post('class_register_id', TRUE);  
        $fee_year_month = $this->input->post('fee_year_month', TRUE);  
        $stream = $this->input->post('stream', TRUE); 
        $fee_type = $this->input->post('fee_type', TRUE); 
        $amount = $this->input->post('amount', TRUE);    
        
        $classregister_data['yyyymm'] = $fee_year_month; 
        $classregister_data['course_stream'] = $stream; 
        $classregister_data['fee_type'] = $fee_type; 
        $classregister_data['additional_fee_amount'] = $amount; 
        $classregister_data['class_register_id'] = $class_register_id; 
        $classregister_data['school_id'] = $this->input->cookie('school_id',true); 
        $classregister_data['date_created'] = $this->session->userdata('current_date_time');
        $classregister_data['last_updated'] = $this->session->userdata('current_date_time'); 
        $this->classregister_model->insert_classregister_additional_fee($classregister_data); 
        redirect('class-register-additional-fee/'.base64_encode($class_register_id), 'refresh');
	}
	
	// update class register additional fee 
	public function update_class_register_additional_fee()
	{ 
	  
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));   
        $str = explode("-",$this->uri->segment('2'));  
        $class_register_id = base64_decode($str[0]);  
        $additional_fee_id = base64_decode($str[1]);
        $data['class_register_id'] = $class_register_id;   
        $data['additional_fee_id'] = $additional_fee_id;   
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id);   
		$data['additional_fee_info'] = $this->classregister_model->get_additional_fee_info($additional_fee_id);    
	   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('update-class-register-additional-fee',$data); 
	    
	}
	
	
	// update class register additional fee process
	public function update_class_register_additional_fee_process()
	{   
	    $monthly_fee_info = '';
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        $additional_fee_id = $this->input->post('additional_fee_id', TRUE); 
        
        $fee_year_month = $this->input->post('fee_year_month', TRUE);  
        $stream = $this->input->post('stream', TRUE); 
        $fee_type = $this->input->post('fee_type', TRUE); 
        $amount = $this->input->post('amount', TRUE);    
        
        $classregister_data['yyyymm'] = $fee_year_month; 
        $classregister_data['course_stream'] = $stream; 
        $classregister_data['fee_type'] = $fee_type; 
        $classregister_data['additional_fee_amount'] = $amount;    
        $classregister_data['last_updated'] = $this->session->userdata('current_date_time'); 
        $this->classregister_model->update_classregister_additional_fee($classregister_data,$additional_fee_id);    
        redirect('class-register-additional-fee/'.base64_encode($class_register_id), 'refresh');
	}
	
	
	// class register fee details
	public function get_month_schoolfee()
	{ 
	    $current_year_month = date("Ym",strtotime($this->session->userdata('current_date_time')));
        $class_register_id = $this->input->post('class_register_id', TRUE);  
        $year_month = $this->input->post('year_month', TRUE); 
        
        
            $month_schoolfee_info = $this->feeconcession_model->get_month_schoolfee_info($class_register_id,$year_month);   
             
            if(count($month_schoolfee_info) > 0)
            {
                if($current_year_month > $year_month)
                {
                    echo 1;
                }
                else
                { 
                    $amount_string = ''; 
                    $id_string = ''; 
                    $cr_fee_id = '';
                    foreach($month_schoolfee_info as $fee_type)
                    {
                        $fee_type_amount =  $fee_type->amount;
                        $fee_type_id =  $fee_type->students_fee_type_id;
                        $students_cr_fee_id =  $fee_type->students_cr_fee_id;
                        
                        if($amount_string == '')
                        { 
                            $amount_string .=  $fee_type_amount;
                            $id_string .=  $fee_type_id;
                            $cr_fee_id .=  $students_cr_fee_id;
                        }
                        else
                        { 
                            $amount_string .= "|".$fee_type_amount;
                            $id_string .=  "|".$fee_type_id;
                            $cr_fee_id .=  "|".$students_cr_fee_id;
                        }
                    }
                
                    if($amount_string != '')
                    { 
                        echo $amount_string.";".$id_string.";".$cr_fee_id;
                    }
                    
                }
            }
         
        
         
	} 
	
	// class register students attendance process
	public function class_register_fee_process()
	{   
	    $monthly_fee_info = '';
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        $fee_year_month = $this->input->post('fee_year_month', TRUE);  
        $fee_type_ids = $this->input->post('fee_type_id', TRUE); 
        $fee_types = $this->input->post('fee_type', TRUE); 
        $fee_type_values = $this->input->post('fee_type_value', TRUE);  
        $students_cr_fee_ids = $this->input->post('students_cr_fee_id', TRUE);  
        //print_r($fee_type_ids);  
        //print_r($fee_types);
        //print_r($fee_type_values);
        //die();
        for($i=0;$i<count($fee_type_ids);$i++)
        {
           
            $fee_type_id = $fee_type_ids[$i];
            $fee_type = $fee_types[$i];
            $fee_type_value = $fee_type_values[$i];
            $students_cr_fee_id = $students_cr_fee_ids[$i]; 
            
            if($students_cr_fee_id != '' )
            {
                if($fee_type_values[$i] == '')
                {
                    $this->feeconcession_model->delete_class_register_fee($students_cr_fee_id);  
                }  
                else
                {
                    $date_created = $this->session->userdata('current_date_time');
                    $last_updated = $this->session->userdata('current_date_time'); 
                    $student_insert = $this->feeconcession_model->insert_update_class_register_fee($this->input->cookie('school_id',true),$class_register_id,$fee_year_month,$fee_type_id,$fee_type,$fee_type_value,$date_created,$last_updated);  
                
                }
            }
            else
            {
                if($fee_type_values[$i] != '')
                {  
                    $date_created = $this->session->userdata('current_date_time');
                    $last_updated = $this->session->userdata('current_date_time'); 
                    $student_insert = $this->feeconcession_model->insert_update_class_register_fee($this->input->cookie('school_id',true),$class_register_id,$fee_year_month,$fee_type_id,$fee_type,$fee_type_value,$date_created,$last_updated);  
                
                }
            }
            
            
           
        }    
        
        
        redirect('class-register-fee-details/'.base64_encode($class_register_id), 'refresh');
	}
	
    // create class register teachers pdf
	public function create_class_register_fee_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $class_register_id = base64_decode($this->uri->segment('2'));   
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id);   
		$data['fee_types_lists'] = $this->feetype_model->get_fee_types_list($this->input->cookie('school_id',true));
		$data['class_register_fee_lists'] = $this->feeconcession_model->class_register_fee($class_register_id); 
	 
        $filename = time()."_classregister_fee.pdf"; 
        $html = $this->load->view('classregister_fee_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterfee/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterfee/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
}
