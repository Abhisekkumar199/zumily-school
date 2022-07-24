<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();            
    }
	  
	// student list view
	public function studentList()
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
	    
	    
	    
	    if($class_register_id != '' and $is_session_changed == 0)
	    {
		    $data['student_lists'] = $this->student_model->get_student_list_for_specific_class($class_register_id);  
	        
	    }
	    else
	    {
		    $data['student_lists'] = $this->student_model->get_student_list_for_specific_session($session_id);  
	    }
	    
	    
		$data['unassigned_student_lists'] = $this->student_model->unassigned_student_lists($this->input->cookie('school_id',true)); 
	 
		$data['totalrecord'] =count($data['student_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('student-list',$data); 
	}
	
	// check student email exist or not
	public function checkStudentEmail()
	{ 
	    $school_id = $this->input->cookie('school_id',true);
        $email_id = $this->input->post('email_id', TRUE); 
        $student_id = $this->input->post('student_id', TRUE);  
        $check_student_email = $this->student_model->check_student_email($email_id,$student_id,$school_id);
        
        if($check_student_email == 1)
        {
            echo $check_student_email;
            exit();
        }
        else
        { 
            $check_user_email = $this->user_model->check_if_user_email_exist($this->input->post('email_id', TRUE)); 
            if($check_user_email == 1 )
            {
                $user_info = $this->user_model->get_user_info_by_email($this->input->post('email_id', TRUE));  
                echo json_encode($user_info); 
            }
        } 
	}
	
	// check student mobile exist or not
	public function checkStudentMobile()
	{
	    $school_id = $this->input->cookie('school_id',true);
        $mobile_no = $this->input->post('mobile_no', TRUE); 
        $student_id = $this->input->post('student_id', TRUE);  
        echo $check_student_mobile = $this->student_model->check_student_mobile($mobile_no,$student_id,$school_id);
        
        if($check_student_mobile == 1)
        {
            echo $check_student_mobile; 
        }
        else
        { 
            echo 0; 
        }
	    
	}
	
	// check if student exist or not
	public function checkIfStudentExist()
	{
	    $school_id = $this->input->cookie('school_id',true);
        $first_name = $this->input->post('first_name', TRUE); 
        $last_name = $this->input->post('last_name', TRUE);   
        $date_of_birth = date("Y-m-d",strtotime($this->input->post('date_of_birth')));
        $father_name= $this->input->post('father_name', TRUE);   
        $student_id = $this->input->post('student_id', TRUE);    
        $check_if_student_exist = $this->student_model->check_if_student_exist($first_name,$last_name,$date_of_birth,$father_name,$student_id,$school_id);
        
        if($check_if_student_exist == 1)
        {
            echo 1;
        }
        else
        { 
            echo 0; 
        }
	    
	}
	// add student view
	public function addStudent()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-student',$data);
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit student view
	public function editStudent()
	{
        $student_id = base64_decode($this->uri->segment('2')); 
        $data['student_info'] = $this->student_model->get_student_info($student_id);
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
        
		$data['session_lists'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['class_lists'] = $this->class_model->get_class_list($this->input->cookie('school_id',true));  
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-student',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add  and  edit student process
	public function addStudentProcess()
	{  
        $student_id = $this->input->post('studentId', TRUE);  
        $school_id = $this->input->cookie('school_id',true);
        $user_id = '';
        $parent_user_id = '';
        
        if($student_id == '')
        {   
            // insert student
            $student_data['first_name'] = ucwords(ltrim(rtrim($this->input->post('first_name', TRUE),' '),' '));
            $student_data['middle_name'] = ucwords(ltrim(rtrim($this->input->post('middle_name', TRUE),' '),' '));
            $student_data['last_name'] = ucwords(ltrim(rtrim($this->input->post('last_name', TRUE),' '),' ')); 
            $student_data['registration_no'] = $this->input->post('registration_no', TRUE);  
            $student_data['registration_date'] = $this->input->post('reg_year', TRUE)."-".$this->input->post('reg_month', TRUE)."-".$this->input->post('reg_date', TRUE);  
            $student_data['gender'] = $this->input->post('gender', TRUE); 
            if($this->input->post('mobile_no', TRUE) != '')
            {
                $student_data['mobile_no'] = $this->input->post('mobile_no', TRUE);  
            } 
            $student_data['email_id'] = $this->input->post('email_id', TRUE);  
            $student_data['father_name'] = ucwords(ltrim(rtrim($this->input->post('father_name', TRUE),' '),' '));  
            $student_data['mother_name'] = ucwords(ltrim(rtrim($this->input->post('mother_name', TRUE),' '),' ')); 
            if($this->input->post('parent_mobile_no') != '')
            {
                $student_data['parent_mobile_no'] = $this->input->post('parent_mobile_no');
            }
            else
            { 
                $student_data['parent_mobile_no'] = NULL;
            }
            $student_data['parent_email_id'] = $this->input->post('parent_email_id');
            $student_data['address'] = ucwords($this->input->post('address', TRUE));
            $student_data['date_of_birth'] = $this->input->post('birth_year', TRUE)."-".$this->input->post('birth_month', TRUE)."-".$this->input->post('birth_date', TRUE);  
            $student_data['aadhar_card_number'] = $this->input->post('aadhar1', TRUE)."-".$this->input->post('aadhar2', TRUE)."-".$this->input->post('aadhar3', TRUE);  
            $student_data['caste'] = ucwords($this->input->post('caste', TRUE));
            $student_data['school_id'] = $school_id; 
            $student_data['date_created'] = $this->session->userdata('current_date_time');  
            $student_data['last_updated'] = $this->session->userdata('current_date_time');   
            $searchable_data = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE))." (". $this->input->post('registration_no', TRUE).") ".ucwords($this->input->post('father_name', TRUE))." (F) ".$this->input->post('parent_mobile_no', TRUE); 
            $student_data['searchable_data'] = $searchable_data;  
            
            $image = $this->input->post("result1");
            $filename = '';
            if(!empty($image))
            {
                define('UPLOAD_DIR', './assets/uploadimages/studentimages/');
                $image_parts = explode(";base64,", $_REQUEST['result1']); 
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                
                $filename = 'pi_s_'.uniqid() . '.png';
                $file = UPLOAD_DIR . $filename; 
                file_put_contents($file, $image_base64);
                
                 
                
                // image compression  
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/studentimages/'.$filename;   
                $config1['width']         = 100;
                $config1['height']       = 100;
                $config1['maintain_ratio'] = FALSE;  
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);   
                if ( ! $this->image_lib->resize())
                {
                        echo $this->image_lib->display_errors();
                } 
                $this->image_lib->clear();
                
    	        $student_data['profile_picture'] = $filename;
            }
            $student_name =  ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('middle_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE)); 
            if($filename != '')
            {
                $logo = $filename;
            }
            else
            {
                $logo = 'name.png';
            }
            
            $student_id = $this->student_model->insert_student($student_data);  
            
            if($student_id > 0)
            {
                if($this->input->post('mobile_no', TRUE) != '')
                {
                    $check_student_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('mobile_no', TRUE)); 
                    if($check_student_mobile == 1)
                    { 
                        $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('mobile_no', TRUE));
                        $user_id = $user_data['user_id'];  
                        $user_types = $user_data['user_types']; 
                
                        if($user_types != '')
                        {
                            if(strpos($user_types,"S") == '')
                            { 
                                $user_update_data['user_types'] = $user_types.',S'; 
                            }
                        }
                        else
                        { 
                            $user_update_data['user_types'] = 'S'; 
                        }
                        
                        $connected_students_info = $user_data['connected_students_info']; 
                        if($connected_students_info == '')
                        {
                            $connected_students_info .= "$student_id|$student_name|$logo";  
                        }
                        else
                        {
                            $connected_students_info .= ";$student_id|$student_name|$logo"; 
                        }  
                        $user_update_data['is_parent'] = 1;
                        $user_update_data['connected_students_info'] = $connected_students_info;
    	                $this->user_model->update_user($user_update_data,$user_id);
    	                
    	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($user_id,$student_id);
    	                if($is_user_student_xref_exist == 0)
    	                {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
    	                } 
                    }
                    else
                    {  
                        $data['connected_students_info'] = "$student_id|$student_name|$logo"; 
                        $data['first_name'] = ucwords($this->input->post('first_name', TRUE));
                        $data['last_name'] = ucwords($this->input->post('last_name', TRUE));
                        $data['email_id'] = $this->input->post('email_id', TRUE);
                        $data['mobile_no'] = $this->input->post('mobile_no', TRUE); 
                        $data['address'] = ucwords($this->input->post('address', TRUE)); 
                        $data['user_gender'] = $this->input->post('gender', TRUE);  
                        $data['user_types'] = "S";  
                        $data['created_by_school_id'] = $school_id;  
                        $data['is_parent'] = '1';    
                        $data['date_created'] = $this->session->userdata('current_date_time');  
                        $data['last_updated'] = $this->session->userdata('current_date_time');   
                        $user_id = $this->user_model->insert_user($data);  
                        
                        if($user_id != '')
                        {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
                        } 
                        
                    }  
                } 
                
                if($this->input->post('parent_mobile_no') != '')
                {
                    $check_parent_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('parent_mobile_no')); 
                    if($check_parent_mobile == 1)
                    {
                        $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('parent_mobile_no'));
                        $parent_user_id = $user_data['user_id'];
                        $connected_students_info = $user_data['connected_students_info']; 
                        
                        $user_types = $user_data['user_types']; 
                
                        if($user_types != '')
                        {
                            if(strpos($user_types,"P") == '')
                            { 
                                $user_update_data['user_types'] = $user_types.',P'; 
                            }
                        }
                        else
                        { 
                            $user_update_data['user_types'] = 'P'; 
                        }
                        
                        
                        if($connected_students_info == '')
                        {
                            $connected_students_info .= "$student_id|$student_name|$logo";  
                        }
                        else
                        {
                            $connected_students_info .= ";$student_id|$student_name|$logo"; 
                        }  
                        $user_update_data['is_parent'] = 1;
                        $user_update_data['connected_students_info'] = $connected_students_info; 
    	                $this->user_model->update_user($user_update_data,$parent_user_id);
    	                
    	                
    	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($parent_user_id,$student_id);
    	                if($is_user_student_xref_exist == 0)
    	                {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $parent_user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
    	                } 
                    }
                    else
                    {  
                        $father_name = explode(' ',$this->input->post('father_name'));
                        $total = count($father_name);
                        $father_first_name = $father_name[0];
                        if($total > 1)
                        {
                            $father_last_name = $father_name[$total -1];
                            $parent_data['last_name'] = ucwords($father_last_name);  
                            
                        }
                        $parent_data['connected_students_info'] = "$student_id|$student_name|$logo"; 
                        $parent_data['first_name'] = ucwords($father_first_name);
                        $parent_data['email_id'] = $this->input->post('parent_email_id');
                        $parent_data['mobile_no'] = $this->input->post('parent_mobile_no');   
                        $parent_data['created_by_school_id'] = $school_id;  
                        $parent_data['user_types'] = "P";  
                        $parent_data['is_parent'] = '1';   
                        $parent_data['date_created'] = $this->session->userdata('current_date_time');  
                        $parent_data['last_updated'] = $this->session->userdata('current_date_time');   
                        $parent_user_id = $this->user_model->insert_user($parent_data);  
                        
                        if($parent_user_id != '')
                        {
                            $parent_user_xref['student_id']= $student_id;
                            $parent_user_xref['user_id']= $parent_user_id;
                            $parent_user_xref['school_id']= $school_id;
                            $parent_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $parent_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($parent_user_xref);
                        }
                        
                    }
                
                    
                }   
            
                $school_id = $this->input->cookie('school_id',true); 
                $last_updated = $this->session->userdata('current_date_time');
                if($filename == '')
                {
                    $profile_picture = $this->input->post('profile_picture');
                }
                else
                {
                    $profile_picture = $filename;
                } 
            
            
                $searchable_data = ucwords($this->input->post('first_name'));
                
                if($this->input->post('last_name') !=  '')
                {
                    $searchable_data .= " ".ucwords($this->input->post('last_name'));
                }
                if($this->input->post('registration_no', TRUE) !=  '')
                {
                    $searchable_data .= " (".$this->input->post('registration_no', TRUE).") ";
                }
                if($this->input->post('father_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('father_name', TRUE))." (F)";
                }
                if($this->input->post('mother_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('mother_name', TRUE))." (M)";
                }
                if($this->input->post('parent_mobile_no') !=  '')
                {
                    $searchable_data .= " (".$this->input->post('parent_mobile_no').")";
                } 
                
                $this->student_model->insert_update_student_searchable_data($school_id,$student_id,$profile_picture,$searchable_data,$last_updated);   
                
                $batch_data_success['status'] = 'Success';   
         
                $sdata['success'] = '<div class="alert alert-success">Student added successfully.</div> '; 
                $this->session->set_userdata($sdata);
                redirect('add-student', 'refresh');
            }
            
        }
        else
        {
            $check_if_student_exist = $this->student_model->check_if_student_exist($this->input->post('first_name', TRUE),$this->input->post('last_name', TRUE),date("Y-m-d",strtotime($this->input->post('date_of_birth'))),$this->input->post('parent_mobile_no', TRUE),$student_id,$school_id); 
    	    if($check_if_student_exist== 1)
    	    { 
    	        $sdata['success'] = '<div class="alert alert-danger">Student already exist.</div>'; 
                $this->session->set_userdata($sdata);
                redirect('update-student/'.$student_id, 'refresh');
    	    }
    	    else
    	    { 
                 
                
                $old_mobile_no= $this->input->post('old_mobile_no'); 
                $new_mobile_no = $this->input->post('mobile_no', TRUE);
                $old_parent_mobile_no = $this->input->post('old_parent_mobile_no');
                $new_parent_mobile_no = $this->input->post('parent_mobile_no', TRUE);
                if($new_mobile_no != '' and $old_mobile_no != $new_mobile_no)
                { 
                    if($old_mobile_no != '')
                    {
                        $check_user = $this->user_model->check_if_user_mobile_exist($new_mobile_no); 
                        if($check_user == 1)
                        {
                            
                            $old_user_data = $this->user_model->get_user_info_by_mobile($old_mobile_no); 
                            $old_user_id = $old_user_data['user_id']; 
                            
                            $user_data = $this->user_model->get_user_info_by_mobile($new_mobile_no);
                            
                            $first_name= $user_data['first_name'];   
                            $last_name = $user_data['last_name']; 
                            if($this->input->post('first_name', TRUE) == $first_name and  $this->input->post('last_name', TRUE) == $last_name)
                            { 
                            
                                $new_user_id = $user_data['user_id'];  
                                $user_update_data['is_parent'] = 1;
                                
            	                $this->user_model->update_user($user_update_data,$new_user_id);
            	                
            	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($new_user_id,$student_id);
            	                if($is_user_student_xref_exist == 0)
            	                {
                                    $student_user_xref['student_id']= $student_id;
                                    $student_user_xref['user_id']= $new_user_id;
                                    $student_user_xref['school_id']= $school_id;
                                    $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                                    $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                                    $this->student_model->student_user_xref($student_user_xref);  
                                    
                                    if($student_id > 0 and $old_user_id > 0)
                                    {
                                        $this->delete_student_user_xref($student_id,$old_user_id);  
                                    }
            	                } 
            	                 
        	                    $this->user_model->copy_old_user_data_to_new_user($new_user_id,$old_user_id);
            	                
                            }
                            else
                            {
                                $sdata['success'] = '<div class="alert alert-danger">This phone is already being used by other student OR parent. Please check the number</div>'; 
                                $this->session->set_userdata($sdata);
                                redirect('update-student/'.$student_id, 'refresh');
                            }
                        }
                        else
                        {
                            $user_data = $this->user_model->get_user_info_by_mobile($old_mobile_no);
                            $user_id = $user_data['user_id'];  
                            $user_update_data['mobile_no'] = $new_mobile_no;
        	                $this->user_model->update_user($user_update_data,$user_id); 
                        }
                    }
                    else
                    { 
                        $old_user_data = $this->user_model->get_user_info_by_mobile($old_mobile_no); 
                        $old_user_id = $old_user_data['user_id']; 
                            
                        $check_student_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('mobile_no', TRUE)); 
                        if($check_student_mobile == 1)
                        { 
                            
                            $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('mobile_no', TRUE));
                            $user_id = $user_data['user_id'];  
                            
                            $first_name= $user_data['first_name'];   
                            $last_name = $user_data['last_name']; 
                            if($this->input->post('first_name', TRUE) == $first_name and  $this->input->post('last_name', TRUE) == $last_name)
                            { 
                                $user_update_data['is_parent'] = 1;
            	                $this->user_model->update_user($user_update_data,$user_id);
            	                
            	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($user_id,$student_id);
            	                if($is_user_student_xref_exist == 0)
            	                {
                                    $student_user_xref['student_id']= $student_id;
                                    $student_user_xref['user_id']= $user_id;
                                    $student_user_xref['school_id']= $school_id;
                                    $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                                    $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                                    $this->student_model->student_user_xref($student_user_xref);  
                                    
                                    if($student_id > 0 and $old_user_id > 0)
                                    {
                                        $this->delete_student_user_xref($student_id,$old_user_id);  
                                    }
            	                } 
                            }
                            else
                            {
                                $sdata['success'] = '<div class="alert alert-danger">This phone is already being used by other student OR parent. Please check the number</div>'; 
                                $this->session->set_userdata($sdata);
                                redirect('update-student/'.$student_id, 'refresh');
                            }
                        }
                        else
                        {
                            
                            
                            $data['first_name'] = ucwords($this->input->post('first_name', TRUE));
                            $data['last_name'] = ucwords($this->input->post('last_name', TRUE));
                            $data['email_id'] = $this->input->post('email_id', TRUE);
                            $data['mobile_no'] = $this->input->post('mobile_no', TRUE); 
                            $data['address'] = ucwords($this->input->post('address', TRUE)); 
                            $data['user_gender'] = $this->input->post('gender', TRUE);  
                            $data['created_by_school_id'] = $school_id;  
                            $data['is_parent'] = '1';   
                            $data['date_created'] = $this->session->userdata('current_date_time');  
                            $data['last_updated'] = $this->session->userdata('current_date_time');   
                            $user_id = $this->user_model->insert_user($data);  
                            
                            if($user_id != '')
                            {
                                $student_user_xref['student_id']= $student_id;
                                $student_user_xref['user_id']= $user_id;
                                $student_user_xref['school_id']= $school_id;
                                $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                                $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                                $this->student_model->student_user_xref($student_user_xref);  
                                if($student_id > 0 and $old_user_id > 0)
                                {
                                    $this->delete_student_user_xref($student_id,$old_user_id);  
                                }
                            }  
                            
                        } 
                    }
                    
                }
                
                if($old_parent_mobile_no != $new_parent_mobile_no)
                {
                    if($this->input->post('old_parent_mobile_no') != '')
                    {
                        $old_parent_data = $this->user_model->get_user_info_by_mobile($this->input->post('old_parent_mobile_no'));
                        $old_parent_user_id = $old_parent_data['user_id'];
                    }  
                    
                    if($this->input->post('parent_mobile_no') != '')
                    { 
                        $check_parent_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('parent_mobile_no')); 
                        if($check_parent_mobile == 1)
                        {
                            $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('parent_mobile_no'));
                            $parent_user_id = $user_data['user_id'];
                            
                            $user_update_data['is_parent'] = 1;
        	                $this->user_model->update_user($user_update_data,$parent_user_id);
        	                
        	                
        	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($parent_user_id,$student_id);
        	                if($is_user_student_xref_exist == 0)
        	                {
                                $student_user_xref['student_id']= $student_id;
                                $student_user_xref['user_id']= $parent_user_id;
                                $student_user_xref['school_id']= $school_id;
                                $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                                $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                                $this->student_model->student_user_xref($student_user_xref); 
                                
                                if($student_id > 0 and $old_parent_user_id > 0)
                                {
                                    $this->delete_student_user_xref($student_id,$old_parent_user_id);  
                                }
        	                } 
                        }
                        else
                        { 
                            
                            
                            $parent_data['first_name'] = ucwords($this->input->post('father_name')); 
                            $parent_data['email_id'] = $this->input->post('parent_email_id');
                            $parent_data['mobile_no'] = $this->input->post('parent_mobile_no');   
                            $parent_data['created_by_school_id'] = $school_id;  
                            $parent_data['is_parent'] = '1';   
                            $parent_data['date_created'] = $this->session->userdata('current_date_time');  
                            $parent_data['last_updated'] = $this->session->userdata('current_date_time');   
                            $parent_user_id = $this->user_model->insert_user($parent_data);  
                            
                            if($parent_user_id != '')
                            {
                                $parent_user_xref['student_id']= $student_id;
                                $parent_user_xref['user_id']= $parent_user_id;
                                $parent_user_xref['school_id']= $school_id;
                                $parent_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                                $parent_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                                $this->student_model->student_user_xref($parent_user_xref);
                                 
                                if($student_id > 0 and $old_parent_user_id > 0)
                                {
                                    $this->delete_student_user_xref($student_id,$old_parent_user_id);  
                                }
                            }
                            
                        }
                    }
                }
                
                
                
                // update student 
                $student_data['first_name'] = ucwords(ltrim(rtrim($this->input->post('first_name', TRUE),' '),' '));
                $student_data['middle_name'] = ucwords(ltrim(rtrim($this->input->post('middle_name', TRUE),' '),' '));
                $student_data['last_name'] = ucwords(ltrim(rtrim($this->input->post('last_name', TRUE),' '),' ')); 
                $student_data['registration_no'] = $this->input->post('registration_no', TRUE);   
                $student_data['registration_date'] = $this->input->post('reg_year', TRUE)."-".$this->input->post('reg_month', TRUE)."-".$this->input->post('reg_date', TRUE);  
                $student_data['gender'] = $this->input->post('gender', TRUE); 
                $student_data['aadhar_card_number'] = $this->input->post('aadhar1', TRUE)."-".$this->input->post('aadhar2', TRUE)."-".$this->input->post('aadhar3', TRUE);  
                $student_data['caste'] = ucwords($this->input->post('caste', TRUE));
                if($this->input->post('mobile_no', TRUE) != '')
                {
                    $student_data['mobile_no'] = $this->input->post('mobile_no', TRUE);  
                }   
                
                $student_data['email_id'] = $this->input->post('email_id', TRUE);  
                $student_data['father_name'] = ucwords(ltrim(rtrim($this->input->post('father_name', TRUE),' '),' '));  
                $student_data['mother_name'] = ucwords(ltrim(rtrim($this->input->post('mother_name', TRUE),' '),' ')); 
                if($this->input->post('parent_mobile_no') != '')
                { 
                        $student_data['parent_mobile_no'] = $this->input->post('parent_mobile_no');
                }
                else
                {
                        $student_data['parent_mobile_no'] = NULL;
                }
                $student_data['parent_email_id'] = $this->input->post('parent_email_id');
                $student_data['address'] = ucwords($this->input->post('address', TRUE));
                $student_data['date_of_birth'] = $this->input->post('birth_year', TRUE)."-".$this->input->post('birth_month', TRUE)."-".$this->input->post('birth_date', TRUE); 
                $student_data['is_search_data_updated'] = '0';
                $student_data['last_updated'] = $this->session->userdata('current_date_time');  
                
                $searchable_data = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE)).", ".ucwords($this->input->post('father_name', TRUE))." (F) ".$this->input->post('parent_mobile_no', TRUE); 
                $student_data['searchable_data'] = $searchable_data;  
                
                $filename = '';
                $image = $this->input->post("result1");
                if(!empty($image))
                {
                    $oldimage = $this->input->post('oldimage', TRUE);
                    if($oldimage != '')
                    { 
                        unlink('./assets/uploadimages/studentimages/'.$oldimage);  
                    }
                    
                    define('UPLOAD_DIR', './assets/uploadimages/studentimages/');
                    $image_parts = explode(";base64,", $_REQUEST['result1']); 
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $filename = 'pi_s_'.uniqid() . '.png';
                    $file = UPLOAD_DIR . $filename;
                    file_put_contents($file, $image_base64); 
                    
                    
                    // image compression  
        			$config1['image_library'] = 'gd2';
        			$config1['file_permissions'] = 0644;
                    $config1['source_image'] = './assets/uploadimages/studentimages/'.$filename;    
                    $config1['width']         = 100;
                    $config1['height']       = 100;
                    $config1['maintain_ratio'] = FALSE;  
                    $this->load->library('image_lib', $config1);
                    $this->image_lib->initialize($config1);   
                    if ( ! $this->image_lib->resize())
                    {
                            echo $this->image_lib->display_errors();
                    } 
                    $this->image_lib->clear();
                    
                    
                    
        	        $student_data['profile_picture'] = $filename;
                }
                
                $student_update = $this->student_model->update_student($student_data,$student_id);
                
                $school_id = $this->input->cookie('school_id',true); 
                $last_updated = $this->session->userdata('current_date_time');
                if($filename == '')
                {
                    $profile_picture = $this->input->post('profile_picture');
                }
                else
                {
                    $profile_picture = $filename;
                } 
                
                
                $searchable_data = ucwords($this->input->post('first_name'));
                
                if($this->input->post('last_name') !=  '')
                {
                    $searchable_data .= " ".ucwords($this->input->post('last_name'));
                }
                if($this->input->post('registration_no', TRUE) !=  '')
                {
                    $searchable_data .= " (".$this->input->post('registration_no', TRUE).") ";
                }
                else
                {
                    if($this->input->post('old_mobile_no', TRUE) != '')
                    {
                    $searchable_data .= " (".$this->input->post('old_mobile_no', TRUE).") ";
                    }
                }
                if($this->input->post('father_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('father_name', TRUE))." (F)";
                }
                if($this->input->post('mother_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('mother_name', TRUE))." (M)";
                }
                if($this->input->post('parent_mobile_no') !=  '')
                {
                    $searchable_data .= " (".$this->input->post('parent_mobile_no').")";
                } 
                
                $this->student_model->insert_update_student_searchable_data($school_id,$student_id,$profile_picture,$searchable_data,$last_updated);  
                
                 
                $sdata['success'] = '<div class="alert alert-success">Student updated successfully.</div>'; 
                $this->session->set_userdata($sdata);
                redirect('students-list', 'refresh');
                  
                
    	    }
        } 
	}
	
	// add  and  edit student process
	public function add_student_to_class_process()
	{  
        $class_register_id = $this->input->post('class_register_id', TRUE);  
        $school_id = $this->input->cookie('school_id',true);
        $user_id = '';
        $parent_user_id = '';
        
       
             
                // insert student
                $student_data['first_name'] = ucwords($this->input->post('first_name', TRUE));
                $student_data['middle_name'] = ucwords($this->input->post('middle_name', TRUE));
                $student_data['last_name'] = ucwords($this->input->post('last_name', TRUE)); 
                $student_data['registration_no'] = $this->input->post('registration_no', TRUE);  
                $student_data['registration_date'] = $this->input->post('reg_year', TRUE)."-".$this->input->post('reg_month', TRUE)."-".$this->input->post('reg_date', TRUE);  
                $student_data['gender'] = $this->input->post('gender', TRUE); 
                if($this->input->post('mobile_no', TRUE) != '')
                {
                    $student_data['mobile_no'] = $this->input->post('mobile_no', TRUE);  
                } 
                $student_data['email_id'] = $this->input->post('email_id', TRUE);  
                $student_data['father_name'] = ucwords($this->input->post('father_name', TRUE));  
                $student_data['mother_name'] = ucwords($this->input->post('mother_name', TRUE)); 
                if($this->input->post('parent_mobile_no') != '')
                {
                    $student_data['parent_mobile_no'] = $this->input->post('parent_mobile_no');
                }
                else
                { 
                    $student_data['parent_mobile_no'] = NULL;
                }
                $student_data['parent_email_id'] = $this->input->post('parent_email_id');
                $student_data['address'] = ucwords($this->input->post('address', TRUE));
                $student_data['date_of_birth'] = $this->input->post('birth_year', TRUE)."-".$this->input->post('birth_month', TRUE)."-".$this->input->post('birth_date', TRUE);  
                
                $student_data['aadhar_card_number'] = $this->input->post('aadhar1', TRUE)."-".$this->input->post('aadhar2', TRUE)."-".$this->input->post('aadhar3', TRUE);  
                $student_data['caste'] = ucwords($this->input->post('caste', TRUE));
                $student_data['school_id'] = $school_id; 
                $student_data['date_created'] = $this->session->userdata('current_date_time');  
                $student_data['last_updated'] = $this->session->userdata('current_date_time');   
                $searchable_data = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE))." (". $this->input->post('registration_no', TRUE).") ".ucwords($this->input->post('father_name', TRUE))." (F) ".$this->input->post('parent_mobile_no', TRUE); 
                $student_data['searchable_data'] = $searchable_data;  
                
                $image = $this->input->post("result1");
                $filename = '';
                if(!empty($image))
                {
                    define('UPLOAD_DIR', './assets/uploadimages/studentimages/');
                    $image_parts = explode(";base64,", $_REQUEST['result1']); 
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    
                    $filename = 'pi_s_'.uniqid() . '.png';
                    $file = UPLOAD_DIR . $filename; 
                    file_put_contents($file, $image_base64);
                    
                     
                    
                    // image compression  
        			$config1['image_library'] = 'gd2';
        			$config1['file_permissions'] = 0644;
                    $config1['source_image'] = './assets/uploadimages/studentimages/'.$filename;   
                    $config1['width']         = 100;
                    $config1['height']       = 100;
                    $config1['maintain_ratio'] = FALSE;  
                    $this->load->library('image_lib', $config1);
                    $this->image_lib->initialize($config1);   
                    if ( ! $this->image_lib->resize())
                    {
                            echo $this->image_lib->display_errors();
                    } 
                    $this->image_lib->clear();
                    
        	        $student_data['profile_picture'] = $filename;
                }
                $student_name =  ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('middle_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE)); 
                if($filename != '')
                {
                    $logo = $filename;
                }
                else
                {
                    $logo = 'name.png';
                }
                
                $student_id = $this->student_model->insert_student($student_data);  
                
            
                $student_data2['class_register_id'] = $class_register_id;
                $student_data2['student_id'] = $student_id;  
                $student_data2['class_name_section'] = $this->input->post('class_section_name', TRUE); 
                $student_data2['course_stream'] = $this->input->post('stream', TRUE);  
                $student_data2['date_created'] = $this->session->userdata('current_date_time');
                $student_data2['last_updated'] = $this->session->userdata('current_date_time');  
                $student_insert = $this->class_register_student_model->insert_class_register_student($student_data2);  
                $student_data1['current_class_register_id'] = $class_register_id;
                $student_update = $this->student_model->update_student($student_data1,$student_id);  
                $student_update = $this->classregister_model->update_classregister_by_one($class_register_id); 
             
                
                if($this->input->post('mobile_no', TRUE) != '')
                {
                    $check_student_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('mobile_no', TRUE)); 
                    if($check_student_mobile == 1)
                    { 
                        $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('mobile_no', TRUE));
                        $user_id = $user_data['user_id'];  
                        $user_types = $user_data['user_types']; 
                
                        if($user_types != '')
                        {
                            if(strpos($user_types,"S") == '')
                            { 
                                $user_update_data['user_types'] = $user_types.',S'; 
                            }
                        }
                        else
                        { 
                            $user_update_data['user_types'] = 'S'; 
                        }
                        
                        $connected_students_info = $user_data['connected_students_info']; 
                        if($connected_students_info == '')
                        {
                            $connected_students_info .= "$student_id|$student_name|$logo";  
                        }
                        else
                        {
                            $connected_students_info .= ";$student_id|$student_name|$logo"; 
                        }  
                        $user_update_data['is_parent'] = 1;
                        $user_update_data['connected_students_info'] = $connected_students_info;
    	                $this->user_model->update_user($user_update_data,$user_id);
    	                
    	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($user_id,$student_id);
    	                if($is_user_student_xref_exist == 0)
    	                {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
    	                } 
                    }
                    else
                    {  
                        $data['connected_students_info'] = "$student_id|$student_name|$logo"; 
                        $data['first_name'] = ucwords($this->input->post('first_name', TRUE));
                        $data['last_name'] = ucwords($this->input->post('last_name', TRUE));
                        $data['email_id'] = $this->input->post('email_id', TRUE);
                        $data['mobile_no'] = $this->input->post('mobile_no', TRUE); 
                        $data['address'] = ucwords($this->input->post('address', TRUE)); 
                        $data['user_gender'] = $this->input->post('gender', TRUE);  
                        $data['user_types'] = "S";  
                        $data['created_by_school_id'] = $school_id;  
                        $data['is_parent'] = '1';    
                        $data['date_created'] = $this->session->userdata('current_date_time');  
                        $data['last_updated'] = $this->session->userdata('current_date_time');   
                        $user_id = $this->user_model->insert_user($data);  
                        
                        if($user_id != '')
                        {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
                        } 
                        
                    }  
                } 
                
                if($this->input->post('parent_mobile_no') != '')
                {
                    $check_parent_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('parent_mobile_no')); 
                    if($check_parent_mobile == 1)
                    {
                        $user_data = $this->user_model->get_user_info_by_mobile($this->input->post('parent_mobile_no'));
                        $parent_user_id = $user_data['user_id'];
                        $connected_students_info = $user_data['connected_students_info']; 
                        
                        $user_types = $user_data['user_types']; 
                
                        if($user_types != '')
                        {
                            if(strpos($user_types,"P") == '')
                            { 
                                $user_update_data['user_types'] = $user_types.',P'; 
                            }
                        }
                        else
                        { 
                            $user_update_data['user_types'] = 'P'; 
                        }
                        
                        
                        if($connected_students_info == '')
                        {
                            $connected_students_info .= "$student_id|$student_name|$logo";  
                        }
                        else
                        {
                            $connected_students_info .= ";$student_id|$student_name|$logo"; 
                        }  
                        $user_update_data['is_parent'] = 1;
                        $user_update_data['connected_students_info'] = $connected_students_info; 
    	                $this->user_model->update_user($user_update_data,$parent_user_id);
    	                
    	                
    	                $is_user_student_xref_exist = $this->user_model->check_if_user_student_xref_exist($parent_user_id,$student_id);
    	                if($is_user_student_xref_exist == 0)
    	                {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $parent_user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
    	                } 
                    }
                    else
                    {  
                        $father_name = explode(' ',$this->input->post('father_name'));
                        $total = count($father_name);
                        $father_first_name = $father_name[0];
                        if($total > 1)
                        {
                            $father_last_name = $father_name[$total -1];
                            $parent_data['last_name'] = ucwords($father_last_name);  
                            
                        }
                        $parent_data['connected_students_info'] = "$student_id|$student_name|$logo"; 
                        $parent_data['first_name'] = ucwords($father_first_name);
                        $parent_data['email_id'] = $this->input->post('parent_email_id');
                        $parent_data['mobile_no'] = $this->input->post('parent_mobile_no');   
                        $parent_data['created_by_school_id'] = $school_id;  
                        $parent_data['user_types'] = "P";  
                        $parent_data['is_parent'] = '1';   
                        $parent_data['date_created'] = $this->session->userdata('current_date_time');  
                        $parent_data['last_updated'] = $this->session->userdata('current_date_time');   
                        $parent_user_id = $this->user_model->insert_user($parent_data);  
                        
                        if($parent_user_id != '')
                        {
                            $parent_user_xref['student_id']= $student_id;
                            $parent_user_xref['user_id']= $parent_user_id;
                            $parent_user_xref['school_id']= $school_id;
                            $parent_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $parent_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($parent_user_xref);
                        }
                        
                    }
                
                    
                } 
                
                
                
                
                $school_id = $this->input->cookie('school_id',true); 
                $last_updated = $this->session->userdata('current_date_time');
                if($filename == '')
                {
                    $profile_picture = $this->input->post('profile_picture');
                }
                else
                {
                    $profile_picture = $filename;
                } 
                
                
                $searchable_data = ucwords($this->input->post('first_name'));
                
                if($this->input->post('last_name') !=  '')
                {
                    $searchable_data .= " ".ucwords($this->input->post('last_name'));
                }
                if($this->input->post('registration_no', TRUE) !=  '')
                {
                    $searchable_data .= " (".$this->input->post('registration_no', TRUE).") ";
                }
                if($this->input->post('father_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('father_name', TRUE))." (F)";
                }
                if($this->input->post('mother_name', TRUE) !=  '')
                {
                    $searchable_data .= ", ".ucwords($this->input->post('mother_name', TRUE))." (M)";
                }
                if($this->input->post('parent_mobile_no') !=  '')
                {
                    $searchable_data .= " (".$this->input->post('parent_mobile_no').")";
                } 
                
                $this->student_model->insert_update_student_searchable_data($school_id,$student_id,$profile_picture,$searchable_data,$last_updated);   
                
                $batch_data_success['status'] = 'Success';  
    	    
             
            $sdata['success'] = '<div class="alert alert-success">Student added successfully.</div> '; 
            $this->session->set_userdata($sdata);
            redirect('class-students/'.base64_encode($class_register_id), 'refresh');
            
       
	}
	
	// enable student
	public function enableStudent()
	{  
	    $student_id = $this->uri->segment('2');  
        $data['displayflag'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');   
         
        $teacher_update = $this->student_model->update_student($data,$student_id); 
        if (!empty($teacher_update)) 
        {
            $sdata['success'] = 'Student enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('students-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('students-list', 'refresh');
        }  
         
	}
	
	// disable student
	public function disableStudent()
	{  
	    $student_id = $this->uri->segment('2');  
        $data['displayflag'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');   
         
        $student_update = $this->student_model->update_student($data,$student_id); 
        if (!empty($student_update)) 
        {
            $sdata['success'] = 'Student enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('students-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('students-list', 'refresh');
        }  
	}
	
	// get student details
	public function get_student_details()
	{   
	    $output = '';
        $student_id  =  $this->input->post('student_id', TRUE);
		$student_lists = $this->student_model->get_student_details($student_id);  
		
		if(count($student_lists) > 0)
		{ 
            $output .='<table style="width:100%">'; 
		}
		
    	$x = 1;
		foreach($student_lists as $students)
    	{ 
            if($x == 1)
            {
               $output .=' 
        	    <tr>
                	<td><strong>Class Name</strong></td>  
                	<td><strong>Course Stream</strong></td>  
                	<td><strong>Session</strong></td>
                	<td><strong>Room No</strong></td>
                	<td><strong>Teacher</strong></td>  
            	</tr>
            	  
            	';
        
            }
            if($students->course_stream == 'A') { $course_stream = "Arts"; } else if($students->course_stream == 'B') { $course_stream = "Biology"; } else if($students->course_stream == 'H') { $course_stream = "Home Science"; } else if($students->course_stream == 'M') { $course_stream = "Mathematics"; } else if($students->course_stream == 'S') { $course_stream = "Science"; } else { $course_stream= "N/A"; } 
            $output .='<tr> 
	        <td class="business_list_">'.$students->class_name_section.'</td> 
	        <td class="business_list_">'.$course_stream.'</td> 
	        <td class="business_list_">'.$students->session_year.'</td> 
	        <td class="business_list_">'.$students->room_no.'</td> 
	        <td class="business_list_">'; 
                if(!empty($students->profile_picture)) 
                { 
    		         $output .='<img src="https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/'.$students->profile_picture.'" style="width:30px; height:30px;" class="img-circle">';
		        } 
		        else 
		        {  
    		        $output .='<img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">';
		        }  
		        
		        $output .='&nbsp'.$students->first_name." ".$students->last_name;
		        
		        if(!empty($students->mobile_no)) 
                {
                    $output .='('.$students->mobile_no.')';
                }
	            $output .= '</td></tr>'; 
    	                
    	$x++;
    	}
    	
    	if(count($student_lists) > 0)
		{ 
            $output .=' </table>'; 
		}
    	
    	echo $output;
		
	}
	
	
	// import student view
	public function importStudent()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('import-student',$data);
		$this->load->view('include/right_sidebar'); 
	}
	
	// import student process 
	public function importStudentProcess()
	{
	    $school_id = $this->input->cookie('school_id',true);
	    $batch_id = date("YmdHis");
	    $sdata['batch_id'] = $batch_id;
        $this->session->set_userdata($sdata);
        
	    $student_upload_batch['batch_id'] = $batch_id; 
        $student_upload_batch['school_id'] = $school_id; 
        $student_upload_batch['date_created'] = $this->session->userdata('current_date_time');  
        $student_upload_batch['last_updated'] = $this->session->userdata('current_date_time');   
        
        $student_upload_batch_insert = $this->batch_model->student_upload_batch($student_upload_batch); 
        
	    ini_set('auto_detect_line_endings', true); 
    	$tot = 0;
    	$columns = 0; 
    	$handle = fopen($_FILES["uploaded"]["tmp_name"], "r");
     
    	$i="1";
    
    	$randnum=rand(100,999);
    	$arr = array();
    	while (($data = fgetcsv($handle,0, ",")) !== FALSE) 
    	{ 
    		if($i!='1' and $data[0] != '' and $data[2] !='' and $data[4]!='' and $data[7] !='') 
    		{    
    		    $str = explode('-',$data[12]);
    		    $dob = $str[2]."-".$str[1]."-".$str[0];
                $student_data['batch_id'] = $batch_id;
                $student_data['school_id'] = $school_id; 
                $student_data['first_name'] = $data[0];
                $student_data['middle_name'] = $data[1];
                $student_data['last_name'] = $data[2]; 
                $student_data['registration_no'] = $data[3];  
                $student_data['gender'] = $data[4];  
                $student_data['mobile_no'] = $data[5];  
                $student_data['email_id'] = $data[6];  
                $student_data['father_name'] = $data[7];  
                $student_data['mother_name'] = $data[8]; 
                $student_data['parent_mobile_no'] = $data[9];
                $student_data['parent_email_id'] = $data[10];
                $student_data['address'] = $data[11];
                $student_data['date_of_birth'] = $dob;
                $student_data['date_created'] = $this->session->userdata('current_date_time');  
                $student_data['last_updated'] = $this->session->userdata('current_date_time');   
                
                $student_insert = $this->batch_model->insert_student_staging($student_data);  
    		} 
    	$i=$i+1;
    	}
    	
    	if (!empty($student_insert)) 
        {
            $sdata['success'] = '<div class="alert alert-success"><strong>Success!</strong> Batch created successfully.</div>'; 
            $this->session->set_userdata($sdata);
            redirect('process-batch', 'refresh');
        }
        else
        {
            $sdata['success'] = '<div class="alert alert-danger"><strong>Error!</strong> Something went wrong.</div>'; 
            $this->session->set_userdata($sdata);
            redirect('process-batch', 'refresh');
        }
	}
	
	
	// process batch view
	public function processBatch()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
	    $data['batch_id'] = $this->session->userdata('batch_id');
	    
	    // total batch student count
	    $data['total_batch_record'] = $this->batch_model->total_batch_students_count($this->session->userdata('batch_id'),$this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('process-batch',$data);
		$this->load->view('include/right_sidebar'); 
	}
	
	// validate mobile no
	public function validateMobileNumber($number)
	{  
	    $number_count = strlen((string)$number); 
	    $first_character = substr($number, 0, 1); 
	    if(is_numeric($number) and $number_count == 10 and $first_character != 0 and $first_character != 1)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
	
	// batch process 
	public function processBatchProcess()
	{   
        $school_id = $this->input->cookie('school_id',true);
	    $batch_id = $this->input->post('batch_id'); 
	    
	    // get all row of a batch from staging 
	    $batch_list =$this->batch_model->get_batch_students_from_staging($batch_id);
	    
    	foreach($batch_list as $record) 
    	{ 
    	    $is_mobile_valid = $this->validateMobileNumber($record->mobile_no);
    	    $is_parent_mobile_valid = $this->validateMobileNumber($record->parent_mobile_no);
    	    $student_id = '';
    	    if($is_mobile_valid == true and $is_parent_mobile_valid == true)
    	    {
    	        if($record->first_name != '' and $record->father_name != '' and $record->date_of_birth != '')
    	        {
        	        $check_if_student_exist = $this->student_model->check_if_student_exist($record->first_name,$record->last_name,$record->date_of_birth,$record->parent_mobile_no,$student_id,$school_id); 
            	    if($check_if_student_exist== 1)
            	    {
            	        $batch_data['status'] = 'Failed';
                        $batch_data['upload_error'] = 'Student already exists';
            	        $this->batch_model->update_batch_status($batch_data,$record->student_upload_staging_id);
            	    }
            	    else
            	    {
            	        $student_data['first_name'] = $record->first_name;
                        $student_data['middle_name'] = $record->middle_name;
                        $student_data['last_name'] = $record->last_name;
                        $student_data['registration_no'] = $record->registration_no;  
                        $student_data['gender'] = $record->gender; 
                        $student_data['mobile_no'] = $record->mobile_no;  
                        $student_data['email_id'] = $record->email_id;
                        $student_data['father_name'] = $record->father_name;  
                        $student_data['mother_name'] = $record->mother_name;
                        $student_data['parent_mobile_no'] = $record->parent_mobile_no;
                        $student_data['parent_email_id'] = $record->parent_email_id;
                        $student_data['address'] = $record->address;
                        $student_data['date_of_birth'] = $record->date_of_birth;
                        $student_data['school_id'] = $school_id; 
                        $student_data['date_created'] = $this->session->userdata('current_date_time');  
                        $student_data['last_updated'] = $this->session->userdata('current_date_time');   
                        $student_id = $this->student_model->insert_student($student_data);
                        
                        $check_student_mobile = $this->user_model->check_if_user_mobile_exist($record->mobile_no); 
                        if($check_student_mobile == 1)
                        { 
                            $user_data = $this->user_model->get_user_info_by_mobile($record->mobile_no);
                            $user_id = $user_data['user_id']; 
                            
                            $user_update_data['is_parent'] = 1;
        	                $this->user_model->update_user($user_update_data,$user_id);
                        }
                        else
                        {
                            
                            if($record->email_id != '')
                            {
                                $check_user_email = $this->user_model->check_if_user_email_exist($record->email_id);
                                if($check_user_email== 0)
                                { 
                                    $data['email_id'] = $record->email_id;
                                }
                            }  
                            
                            $data['first_name'] = $record->first_name;
                            $data['last_name'] = $record->last_name; 
                            $data['mobile_no'] = $record->mobile_no; 
                            $data['address'] = $record->address; 
                            $data['user_gender'] = $record->gender; 
                             
                            $data['created_by_school_id'] = $school_id;  
                            $data['is_parent'] = '1';   
                            $data['date_created'] = $this->session->userdata('current_date_time');  
                            $data['last_updated'] = $this->session->userdata('current_date_time');   
                            $user_id = $this->user_model->insert_user($data);
                             
                        }
                         
                        if($user_id != '')
                        {
                            $student_user_xref['student_id']= $student_id;
                            $student_user_xref['user_id']= $user_id;
                            $student_user_xref['school_id']= $school_id;
                            $student_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $student_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($student_user_xref);  
                        }
                        
                        
                        
                        
                        
                        $check_parent_mobile = $this->user_model->check_if_user_mobile_exist($record->parent_mobile_no); 
                        if($check_parent_mobile == 1)
                        {
                            $user_data = $this->user_model->get_user_info_by_mobile($record->parent_mobile_no);
                            $parent_user_id = $user_data['user_id'];
                            
                            $user_update_data['is_parent'] = 1;
        	                $this->user_model->update_user($user_update_data,$parent_user_id);
                        }
                        else
                        {
                            if($record->parent_email_id != '')
                            {
                                $check_parent_email = $this->user_model->check_if_user_email_exist($record->parent_email_id);
                                if($check_parent_email== 0)
                                { 
                                    $data['email_id'] = $record->parent_email_id;
                                }
                            } 
                            $data['first_name'] = $record->father_name; 
                            $data['mobile_no'] = $record->parent_mobile_no;
                             
                            $data['created_by_school_id'] = $school_id;  
                            $data['is_parent'] = '1';   
                            $data['date_created'] = $this->session->userdata('current_date_time');  
                            $data['last_updated'] = $this->session->userdata('current_date_time');   
                            $parent_user_id = $this->user_model->insert_user($data);  
                        }
                        
                        if($parent_user_id != '')
                        {
                            $parent_user_xref['student_id']= $student_id;
                            $parent_user_xref['user_id']= $parent_user_id;
                            $parent_user_xref['school_id']= $school_id;
                            $parent_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $parent_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->student_model->student_user_xref($parent_user_xref);
                        }
                        
                        
                        $batch_data_success['status'] = 'Success'; 
            	        $this->batch_model->update_batch_status($batch_data_success,$record->student_upload_staging_id);
            	    }
    	        }
    	        else
        	    {
        	        $batch_data['status'] = 'Failed';
                    $batch_data['upload_error'] = 'Missing mandatory fields';
        	        $this->batch_model->update_batch_status($batch_data,$record->student_upload_staging_id);
        	    }
    	    }
    	    else
    	    {
    	        $batch_data['status'] = 'Failed';
                $batch_data['upload_error'] = 'Invalid mobile number';
    	        $this->batch_model->update_batch_status($batch_data,$record->student_upload_staging_id);
    	    }
    	}
    	
    	
    	$total_batch_students_count = $this->batch_model->total_batch_students_count($batch_id,$school_id); 
    	$total_success_batch_process_count = $this->batch_model->total_success_batch_process_count($batch_id,$school_id); 
    	$total_batch_error_count = $this->batch_model->total_batch_error_count($batch_id,$school_id); 
    	
    	$update_batch_data['total_students'] = $total_batch_students_count;
    	$update_batch_data['successful_processed'] = $total_success_batch_process_count;
    	$update_batch_data['total_errors'] = $total_batch_error_count;
    	$total_batch_error_count = $this->batch_model->update_student_upload_batch($update_batch_data,$batch_id,$school_id); 
    	 
            $sdata['success'] = 'Batch processed successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('batch-lists', 'refresh');
         
	} 
	
	//delete message		
	public function delete_student_user_xref($student_id,$user_id) 
	{    
        $this->db->where('student_id', $student_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('student_user_xref');  
        
	} 
	
	// create student pdf
	public function create_student_pdf()
	{   
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['student_lists'] = $this->student_model->get_student_list($this->input->cookie('school_id',true)); 
		$filename = md5($this->input->cookie('school_id',true))."_student_list.pdf";   
        $html = $this->load->view('student_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/student/".$filename, "F");
        $filepath = base_url()."assets/pdfs/student/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
}
