<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classregister extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();           
    }
	  // hellooooooo
	// class register list view 
	public function classregisterList()
	{ 
	    
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
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));  
		
		$data['classregister_lists'] = $this->classregister_model->get_classregister_list_by_session_id($this->input->cookie('school_id',true),$session_id); 
		
		
		$data['totalrecord'] =count($data['classregister_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('class-register-list',$data); 
	}
	
    
    // add unallocated classes
	public function getUnallocatedClasses()
	{  
	    $session_id = $this->input->post('session_id', TRUE);
        $school_id = $this->input->cookie('school_id',true);  
		 $class_lists = $this->class_model->get_unallocated_class_list($session_id,$school_id);     
		$array['class_list'] =  $class_lists; 
		$class_teacher_lists = $this->teacher_model->get_unallocated_class_teacher_list($session_id,$school_id);  
		$array['class_teacher_list'] =  $class_teacher_lists;
		echo $myJSON = json_encode($array); 
        
	}
	
	// add class register view
	public function addClassregister()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['session_lists'] = $this->session_model->get_active_session_list($this->input->cookie('school_id',true));  
		   
		   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-classregister',$data);
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit class register view
	public function editClassregister()
	{
        $class_register_id = base64_decode($this->uri->segment('2')); 
        $school_id = $this->input->cookie('school_id',true);  
        $data['classregister_info'] = $this->classregister_model->get_classregister_info($class_register_id);
         
          $session_id = $data['classregister_info']['session_id']; 
        
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
        
		$data['class_teacher_lists'] = $this->teacher_model->get_unallocated_class_teacher_list2($session_id,$school_id);  
		
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-classregister',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add  and  edit class register process
	public function addClassregisterProcess()
	{  
         $class_register_id = $this->input->post('class_register_id', TRUE);  
        
        if($class_register_id == '')
        {  
            // insert Class Register
            $school_id = $this->input->cookie('school_id',true);
            $classregister_data['class_id'] = $this->input->post('class_id', TRUE);
            $classregister_data['class_name_section'] = $this->input->post('class_name', TRUE);
            $classregister_data['session_id'] = $this->input->post('session_id', TRUE);
            $classregister_data['session_year'] = $this->input->post('session_year', TRUE);
            $classregister_data['room_no'] = $this->input->post('room_no', TRUE); 
            $classregister_data['class_teacher_id'] = $this->input->post('class_teacher_id', TRUE);    
            $classregister_data['school_id'] = $school_id; 
            $classregister_data['date_created'] = $this->session->userdata('current_date_time');
            $classregister_data['last_updated'] = $this->session->userdata('current_date_time'); 
            $class_register_id = $this->classregister_model->insert_classregister($classregister_data);   
            
            $class_name_section = $this->input->post('class_name', TRUE);
            
            $this->classregister_model->insert_update_class_teacher_teaching_classes($this->input->post('class_teacher_id', TRUE),$this->input->post('session_id', TRUE),$class_register_id,$class_name_section,$this->session->userdata('current_date_time'));
            
            $this->classregister_model->update_teacher_types_in_users($this->input->post('class_teacher_id', TRUE));
            
            if (!empty($class_register_id)) 
            {
                $sdata['success'] = 'Class register added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('classes-register-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('classes-register-list', 'refresh');
            } 
        }
        else
        { 
            // update Class Register   
            $class_register_data['room_no'] = $this->input->post('room_no', TRUE);
            if($this->input->post('class_teacher_id', TRUE)  != '')
            { 
                $current_class_teacher_id = $this->input->post('current_class_teacher_id', TRUE);
                $class_register_data['class_teacher_id'] = $this->input->post('class_teacher_id', TRUE);
                
                $class_name_section = $this->input->post('class_name_section', TRUE);
            
                $this->classregister_model->insert_update_class_teacher_teaching_classes($current_class_teacher_id,$this->input->post('class_register_session_id', TRUE),NULL,NULL,$this->session->userdata('current_date_time'));
            
                $this->classregister_model->insert_update_class_teacher_teaching_classes($this->input->post('class_teacher_id', TRUE),$this->input->post('class_register_session_id', TRUE),$class_register_id,$class_name_section,$this->session->userdata('current_date_time'));
            
                
                $this->classregister_model->update_teacher_types_in_users($current_class_teacher_id); 
                $this->classregister_model->update_teacher_types_in_users($this->input->post('class_teacher_id', TRUE)); 
            } 
            $class_register_data['last_updated'] = $this->session->userdata('current_date_time'); 
            
            $class_register_update = $this->classregister_model->update_classregister($class_register_data,$class_register_id); 
            if (!empty($class_register_update)) 
            {
                $sdata['success'] = 'Class updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('classes-register-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('classes-register-list', 'refresh');
            } 
        } 
	}
	 
	// class register students grid view
	public function classStudent()
	{
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
        $school_id = $this->input->cookie('school_id',true);
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
        $data['class_register_id'] = $class_register_id; 
		$data['class_student_list'] = $this->class_register_student_model->get_class_register_student_list($class_register_id);  
	    $class_section_name = $data['classregister_info']['class_name']." ".$data['classregister_info']['section'];  
        $data['class_section_name'] = $class_section_name;  
		$data['class_unassigned_student_list']  = $this->student_model->get_class_register_unassigned_student_list($class_register_id,$school_id);  
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('class-students',$data); 
	    
	}
	// add class register student
	public function add_student_to_class()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $str = explode("-",$this->uri->segment('2'));
	    $class_register_id = base64_decode($str[0]);
	    $class_section_name = base64_decode($str[1]);
	    
	    $data['class_register_id']=  $class_register_id;
	    $data['class_section_name']=  $class_section_name; 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-student-to-class',$data);
		$this->load->view('include/right_sidebar');
	}
	
	// add class register student
	public function add_class_register_student()
	{  
	    $student_ids = $this->input->post('student_id', TRUE);  
	    $class_register_id = $this->input->post('class_register_id', TRUE); 
	    $class_section_name = $this->input->post('class_section_name', TRUE);  
        
        if($class_register_id != '')
        { 
            for($i=0;$i<count($student_ids);$i++)
            {
                if($student_ids[$i] > 0 and $class_register_id > 0)
                {
                    $student_data['class_register_id'] = $class_register_id;
                    $student_data['student_id'] = $student_ids[$i];  
                    $student_data['class_name_section'] = $class_section_name;  
                    $student_data['date_created'] = $this->session->userdata('current_date_time');
                    $student_data['last_updated'] = $this->session->userdata('current_date_time'); 
                    
                    $student_insert = $this->class_register_student_model->insert_class_register_student($student_data);  
                    $student_data1['current_class_register_id'] = $class_register_id;
                    $student_update = $this->student_model->update_student($student_data1,$student_ids[$i]); 
                      
                    $student_update = $this->classregister_model->update_classregister_for_total_students($class_register_id);
                }
                
                
            }  
        } 
        if (!empty($student_insert)) 
        { 
            redirect('class-students/'.base64_encode($class_register_id), 'refresh');
        } 
        else 
        { 
            redirect('class-students/'.base64_encode($class_register_id), 'refresh');
        }
	}
	
	// update class register student documents view
	public function updateClassRegisterStudent()
	{
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $str = explode('-',$this->uri->segment('2'));
        
	    $class_register_student_id = base64_decode($str[0]);
		$data['class_register_student_info'] = $this->class_register_student_model->get_class_register_student_info($class_register_student_id); 
		 
	    $data['class_register_student_id'] = base64_decode($str[0]);
	    $data['class_register_id'] = base64_decode($str[1]); 
	    
	    $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);  
	    
		$data['class_name'] = $student_info['class_name_section'];
		$data['student_name'] = $student_info['first_name']." ".$student_info['last_name'];
		$data['registration_no'] =$student_info['registration_no'];
		$data['date_of_birth'] =$student_info['date_of_birth'];
		$data['father_name'] = $student_info['father_name'];
		$data['profile_picture'] =''; 
		$data['student_id'] = $student_info['student_id'];
		
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('update-class-register-student',$data); 
		$this->load->view('include/right_sidebar');
	    
	}
	
	// update class register student process
	public function updateClassRegisterStudentProcess()
	{  
	    $datetime = $this->session->userdata('current_date_time');;
        $class_register_student_id = $this->input->post('class_register_student_id', TRUE); 
        $student_id = $this->input->post('student_id', TRUE); 
         
        
        $class_register_id = $this->input->post('class_register_id', TRUE); 
	    $school_id = $this->input->cookie('school_id',true);
	    $class_register_student_info = $this->class_register_student_model->get_class_register_student_info($class_register_student_id); 
	    $documents =$class_register_student_info['documents_info'];
	    $title = $this->input->post('title', TRUE); 
	     
	    
	    $num1=rand(100000,999999);
        $num2=rand(100000,999999); 
        $finalnum=$num1."".$num2; 
        $name= $school_id."_".$finalnum;  
	    
        $finalname1 = $name; 
	    
        if($class_register_student_id != '')
        { 
            if (isset($_FILES['document']['name']) && !empty($_FILES['document']['name'])) 
            { 
                $filename = $_FILES['document']['name'];  
                $ext = pathinfo($filename, PATHINFO_EXTENSION); 
                $finalname = "document_".$finalname1.".".$ext; 
                $a = $_FILES['document']['name'];     
                $config['upload_path']  = './assets/uploadimages/student/documents/';
    			$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
                $config['file_name'] = $finalname;
    			$this->upload->initialize($config); 
    			$this->load->library('upload', $config);
    			$this->upload->do_upload('document');
    			$upload_data = $this->upload->data(); 
    			
    			// image compression 
    			$file_size =  $_FILES['document']['size']; 
                $percentage = image_compress_quality($file_size);  
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/student/documents/'.$finalname;   
                $config1['quality'] = $percentage;
                $config1['maintain_ratio'] = FALSE;  
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);   
                if ( ! $this->image_lib->resize())
                {
                     echo $this->image_lib->display_errors();
                }
                $this->image_lib->clear();
                
                if($documents == '')
                {
                    $documents .= "1|$title|$finalname|$datetime"; 
                    $total_document = 1;
                }
                else
                {
                    $doc_array = explode(';',$documents);
                    $total_document = count($doc_array) + 1;
                    $documents .= ";$total_document|$title|$finalname|$datetime"; 
                } 
    			
                $student_data['documents_info'] = $documents; 
                $student_data['total_documents'] = $total_document; 
            } 
            
            
            $userids = $this->student_model->get_students_user_list($student_id);
            foreach($userids as $userid)
    	    { 
                // insert into notifications
                $notification_data['school_id'] = $school_id; 
                $notification_data['payload_id'] = $class_register_student_id;
                $notification_data['payload_type'] = 'D'; 
                $notification_data['title'] = $title; 
                $notification_data['description'] = '';  
                $notification_data['user_id'] = $userid->user_id; 
                $notification_data['date_created'] = $this->session->userdata('current_date_time');
                $this->cron_model->insert_notification($notification_data); 
    	    }
            
            
            $student_update = $this->class_register_student_model->update_class_register_student($student_data,$class_register_student_id); 
            if (!empty($student_update)) 
            {
                $sdata['success'] = 'Student updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('update-class-register-student/'.base64_encode($class_register_student_id)."-".base64_encode($class_register_id), 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('class-students/'.$class_register_id, 'refresh');
            } 
        } 
	}
	
	
	// update class register student process
	public function update_class_register_stream()
	{   
        $class_register_student_id = $this->input->post('updateid', TRUE); 
        $class_register_id = $this->input->post('class_register_id', TRUE);
        $stream = $this->input->post('stream', TRUE);  
        $data['course_stream'] = $stream;   
        $data['last_updated'] = $this->session->userdata('current_date_time');
        
        $student_update = $this->class_register_student_model->update_class_register_student($data,$class_register_student_id);  
               
        redirect('class-students/'.base64_encode($class_register_id), 'refresh');
            
	}
	
	public function delete_student_document()
	{  
	    $class_register_student_id =  $this->input->post('class_register_student_id', TRUE);
	    $document_id = $this->input->post('document_id', TRUE);
	    
	    $class = $this->input->post('class_id', TRUE);
		$student_name =  $this->input->post('student_name', TRUE);
		$registration_no = $this->input->post('registration_no', TRUE);
		$dob = $this->input->post('dob', TRUE);
		$father_name =$this->input->post('father_name', TRUE);
	    
	    $class_register_student_info = $this->class_register_student_model->get_class_register_student_info($class_register_student_id); 
	    $class_register_id =  $class_register_student_info['class_register_id'];
	    $total_documents =  $class_register_student_info['total_documents'];
	    $document_array = explode(';',$class_register_student_info['documents_info']);
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0];
            $document_title = $string_array[1];
            $document_name = $string_array[2];
            $document_add_date = $string_array[3];
            
            if($document_id == $current_document_id)
            {
                $path = './assets/uploadimages/student/documents/'.$string_array[2];
                if (file_exists($path))
                {
                    @unlink('./assets/uploadimages/student/documents/'.$string_array[2]); 
                }
                
            }
            else
            {
                
                
                if($new_document_id == 1)
                {
                    $documents .= "$new_document_id|$document_title|$document_name|$document_add_date";  
                }
                else
                { 
                    $documents .= ";$new_document_id|$document_title|$document_name|$document_add_date"; 
                }   
                $new_document_id++;
            } 
        }   
        
        $student_data['documents_info'] = $documents;  
        $student_data['total_documents'] = $total_documents - 1; 
	    $student_update = $this->class_register_student_model->update_class_register_student($student_data,$class_register_student_id); 
	    redirect('update-class-register-student/'.$class_register_student_id."-".$class_register_id."-".$class."-".$student_name."-".$registration_no."-".$dob."-".$father_name, 'refresh');
	    
	}
	
	public function delete_class_student()
	{
        $class_register_student_id = $this->input->post('class_register_student_id', TRUE); 
        $student_id = $this->input->post('studentid', TRUE); 
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        
        $this->class_register_student_model->delete_class_register_student($class_register_student_id);
        
        
        $student_update = $this->classregister_model->update_classregister_for_total_students($class_register_id);
        
        $student_data1['current_class_register_id'] = NULL; 
        $student_data1['last_updated'] = $this->session->userdata('current_date_time'); 
        $student_update = $this->student_model->update_student($student_data1,$student_id);  
        
         
        $sdata['success'] = 'Student removed from class register successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('class-students/'.$class_register_id, 'refresh');
         
	}
	
	
	// class register subject teacher grid view
	public function classSubjectTeacher()
	{
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
         
        $data['classregister_info'] = $this->classregister_model->get_classregister_info($class_register_id); 
        $data['class_register_id'] = $class_register_id;   
        $data['session_id'] = $data['classregister_info']['session_id'];  
		$data['class_subject_teacher_list'] = $this->classregister_model->get_class_register_subject_teacher_list($class_register_id,$data['classregister_info']['session_id']); 
	 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('class-subject-teachers',$data); 
	    
	}
	
	// add class register subject teacher
	public function add_class_register_subject_teacher()
	{  
	    $string = explode('-',$this->uri->segment('2'));  
	    $subject_teacher_id = $string[0];   
        $class_register_id = $string[1]; 
        $session_id = $string[2];
         
        if($class_register_id != '')
        { 
            $teacher_data['class_register_id'] = $class_register_id;
            $teacher_data['sub_teacher_id'] = $subject_teacher_id;  
            $teacher_data['session_id'] = $session_id;  
            $teacher_data['date_created'] = $this->session->userdata('current_date_time');  
            $teacher_insert = $this->classregister_model->insert_class_register_sub_teachers($teacher_data);  
            
            
            
            $class_register_sub_teacher_ids = $this->classregister_model->get_class_register_sub_teacher_ids($class_register_id);
            $teacher_ids = '';
            foreach($class_register_sub_teacher_ids as $sub_teacher_ids) 
            {  
                $teacher_ids .= $sub_teacher_ids->sub_teacher_id.",";
            }
            $teacher_ids =  rtrim($teacher_ids, ","); 
            $class_register_data['subject_teachers'] = $teacher_ids;  
            $class_register_data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_register_update = $this->classregister_model->update_classregister($class_register_data,$class_register_id); 
            
            
            
            
            $classregisterids = '';
            $get_class_register_ids = $this->classregister_model->get_teacher_class_register_ids($subject_teacher_id,$session_id);
            $class_register_ids = '';
            $class_section_names = '';
            foreach($get_class_register_ids as $class_register_id1) 
            {  
                $class_register_ids .= $class_register_id1->class_register_id.",";
                $class_section_names .= $class_register_id1->class_name_section.", ";
                
                if($classregisterids == '')
                {
                    $classregisterids .= $class_register_id1->class_register_id."|".$class_register_id1->class_name_section;  
                }
                else
                { 
                    $classregisterids .= ";".$class_register_id1->class_register_id."|".$class_register_id1->class_name_section; 
                }  
            }
            $class_register_ids =  rtrim($class_register_ids, ",");
            $class_section_names =  rtrim($class_section_names, ", ");
            
            $get_class_register_ids = $this->classregister_model->insert_update_teacher_teaching_classes($subject_teacher_id,$session_id,$class_register_ids,$class_section_names,$classregisterids,$this->session->userdata('current_date_time'));
             
            $this->classregister_model->update_teacher_types_in_users($subject_teacher_id);  
            redirect('class-subject-teachers/'.base64_encode($class_register_id), 'refresh'); 
        } 
	}
	
	// delete subject teacher
	public function delete_subject_teacher()
	{
        $class_register_sub_teacher_id = $this->input->post('class_register_sub_teacher_id', TRUE);  
        $class_register_id = $this->input->post('class_register_id', TRUE);  
        $subject_teacher_id = $this->input->post('sub_teacher_id', TRUE);  
        $session_id = $this->input->post('session_id', TRUE); 
        
        //$string = explode('-',$this->uri->segment('2')); 
        //$class_register_sub_teacher_id = $string[0];  
        // $class_register_id = $string[1]; 
	    //  $subject_teacher_id = $string[2];  
        //  $session_id = $string[3];
        
        $this->classregister_model->delete_class_register_subject_teacher($class_register_sub_teacher_id);
        
        $class_register_sub_teacher_ids = $this->classregister_model->get_class_register_sub_teacher_ids($class_register_id);
        $teacher_ids = NULL;
        foreach($class_register_sub_teacher_ids as $sub_teacher_ids) 
        {  
            $teacher_ids .= $sub_teacher_ids->sub_teacher_id.",";
        }
        if($teacher_ids != NULL)
        {
            $teacher_ids =  rtrim($teacher_ids, ","); 
        }
        
        $class_register_data['subject_teachers'] = $teacher_ids;  
        $class_register_data['last_updated'] = $this->session->userdata('current_date_time');  
        $class_register_update = $this->classregister_model->update_classregister($class_register_data,$class_register_id);  
        
        
        
        $get_class_register_ids = $this->classregister_model->get_teacher_class_register_ids($subject_teacher_id,$session_id); 
        
        $class_register_ids = NULL;
        $class_section_names = NULL;
        $classregisterids = '';
        
        foreach($get_class_register_ids as $class_register_id1) 
        {  
            $is_id_exist = 1 ;
            $class_register_ids .= $class_register_id1->class_register_id.",";
            $class_section_names .= $class_register_id1->class_name_section.", ";
            
            if($classregisterids == '')
            {
                $classregisterids .= $class_register_id1->class_register_id."|".$class_register_id1->class_name_section;  
            }
            else
            { 
                $classregisterids .= ";".$class_register_id1->class_register_id."|".$class_register_id1->class_name_section; 
            }  
            
            
        }
        
        if($is_id_exist == 1)
        {
            $class_register_ids =  rtrim($class_register_ids, ",");
            $class_section_names =  rtrim($class_section_names, ", ");
        } 
        
        $get_class_register_ids = $this->classregister_model->insert_update_teacher_teaching_classes($subject_teacher_id,$session_id,$class_register_ids,$class_section_names,$classregisterids,$this->session->userdata('current_date_time')); 
        
        
        $this->classregister_model->update_teacher_types_in_users($subject_teacher_id);  
        
        
        redirect('class-subject-teachers/'.$class_register_id, 'refresh');
         
	}
	
	
	// class register students attendance view
	public function studentAttendance()
	{
        //$current_month  = date('m');
        //$current_year  = date('Y');  
		//$data['current_year'] = $current_year."".$current_month;
		
        $day_of_month  = $this->session->userdata('day_of_month');
        if(strlen($day_of_month) == 1)
		{
		    $day_of_month = "0".$day_of_month;
		}  
        
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
        $str = explode('.',$this->uri->segment('2'));
        
        if(count($str) == 2)
        { 
            $class_register_id = base64_decode($str[0]);  
            $selected_date = base64_decode($str[1]);  
            $attendance_date = base64_decode($str[1]);
            $year_month = date("Ym",strtotime($attendance_date));
            
            $date= date("d",strtotime($selected_date));
        } 
        else
        {
            $class_register_id = base64_decode($this->uri->segment('2'));
            $selected_date = ''; 
            $attendance_date = $this->session->userdata('current_date');
            $date= $day_of_month;
            $year_month = date("Ym",strtotime($this->session->userdata('current_date'))); 
        } 
        $column = "day_".$date;
        
        
        $data['class_register_id'] = $class_register_id;    
        $data['selected_date'] = $selected_date;  
        $data['is_attendance_exist']  = $this->student_model->check_attendance_exist($class_register_id,$attendance_date);  
        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
	    $data['class_student_attendance_lists'] = $this->student_model->get_student_attendance_list($class_register_id,$year_month,$column);  
	   
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('student-attendance',$data); 
	    
	}
	
	// class register students attendance process
	public function studentAttendanceProcess()
	{   
        $attendance_date = date("Y-m-d",strtotime($this->input->post('attendance_date')));
        $date=  date("d",strtotime($this->input->post('attendance_date'))); 
        $year_month= date("Ym",strtotime($this->input->post('attendance_date')));   
        $class_register_student_ids = $this->input->post('class_register_student_ids', TRUE);  
        $student_attendance_ids = $this->input->post('student_attendance_ids', TRUE); 
        $class_register_id = $this->input->post('class_register_id', TRUE);  
        $previous_url = $this->input->post('previous_url', TRUE); 
        $total_presents = 0;
        $total_absents = 0;
        $total_leaves = 0;
        for($i=0;$i<count($class_register_student_ids);$i++)
        {
            $j = $i + 1;
            
            $day_column = "day_".$date;
            $statuscolumn = "status".$j; 
            $status = $this->input->post($statuscolumn, TRUE);
            
            if($status == 'A')
            {
               $total_absents = $total_absents + 1; 
            }
            else if($status == 'P')
            {
              $total_presents = $total_presents + 1;   
            }
            else if($status == 'L')
            {
                $total_leaves = $total_leaves + 1; 
            }
            $class_register_student_id =$class_register_student_ids[$i];
            $student_attendance_id =$student_attendance_ids[$i];
            
             $check_student_attendance_is_exist = $this->student_model->check_student_attendance_is_exist($class_register_id,$class_register_student_id,$year_month); 
            
            if($check_student_attendance_is_exist == 1)
            { 
                $student_data['class_register_student_id'] = $class_register_student_id;
                $student_data['attendance_year_month'] = $year_month; 
                $student_data[$day_column] = $status; 
                $student_data['last_updated'] = $this->session->userdata('current_date_time'); 
                $student_update = $this->student_model->update_student_attendance($student_data,$student_attendance_id);  
                
                
                $this->session->set_flashdata('message', 'Attendance has been updated for the class!');
            }
            else
            { 
                $student_data['class_register_student_id'] = $class_register_student_id;
                $student_data['attendance_year_month'] = $year_month; 
                $student_data['class_register_id'] = $class_register_id; 
                $student_data[$day_column] = $status; 
                $student_data['date_created'] = $this->session->userdata('current_date_time');
                $student_data['last_updated'] = $this->session->userdata('current_date_time'); 
                $student_insert = $this->student_model->insert_student_attendance($student_data);  
            }
            
            $j++;
        } 
        
        
        
        $check_is_attendance_monitoring_exist = $this->student_model->check_attendance_monitoring_is_exist($class_register_id,$attendance_date);  
        if($check_is_attendance_monitoring_exist == 1)
        { 
            $monitoring_data['status'] = 'COMPLETED'; 
            $monitoring_data['done_by'] = 'A'; 
            $monitoring_data['total_presents'] = $total_presents; 
            $monitoring_data['total_absents'] = $total_absents; 
            $monitoring_data['total_leaves'] = $total_leaves; 
            $monitoring_data['last_updated'] = $this->session->userdata('current_date_time'); 
            $student_update = $this->student_model->update_attendance_monitoring($monitoring_data,$class_register_id,$attendance_date); 
        }
        else
        { 
            $class_section_data = $this->student_model->get_class_section($class_register_id); 
            
            $class_section_name = $class_section_data['class_name']." ".$class_section_data['section'];
            
            $monitoring_data['class_register_id'] = $class_register_id;
            $monitoring_data['attendance_date'] = $attendance_date; 
            $monitoring_data['status'] = 'COMPLETED'; 
            $monitoring_data['total_presents'] = $total_presents; 
            $monitoring_data['total_absents'] = $total_absents; 
            $monitoring_data['total_leaves'] = $total_leaves; 
            $monitoring_data['class_name_section'] = $class_section_name; 
            $monitoring_data['done_by'] = 'A'; 
            $monitoring_data['date_created'] = $this->session->userdata('current_date_time');
            $monitoring_data['last_updated'] = $this->session->userdata('current_date_time'); 
            $student_insert = $this->student_model->insert_attendance_monitoring($monitoring_data); 
        }
                 
        
        
        redirect($previous_url, 'refresh');
	}
	
	// get ajax students attendance  
	public function getStudentAttendance()
	{
	    $output="";  
        $date= date("d",strtotime($this->input->post('attendance_date')));  
	    $class_register_id = $this->input->post('class_register_id');
	    $is_class_active = $this->input->post('is_class_active');
	    
        $year_month = date("Ym",strtotime($this->input->post('attendance_date'))); 
        $attendance_date = date("Y-m-d",strtotime($this->input->post('attendance_date'))); 
        
        $is_attendance_exist  = $this->student_model->check_attendance_exist($class_register_id,$attendance_date); 
        
        if(count($is_attendance_exist) == 0) 
        { 
            $attendancedate  = "<strong>Attendance taken on:</strong> <span class='label label-danger'>No attendance taken yet!</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Taken By:</strong> <span class='label label-danger'>None</span>";
        }
        else 
        {  
            $attendancedate = "<strong>Attendance taken on:</strong> <span class='label label-primary mono-font '>".date('D, d M, Y h:i',strtotime($is_attendance_exist['last_updated']))."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Taken By: </strong>";
            
            if($is_attendance_exist['done_by'] == 'T') 
            {   
                $attendancedate .= "<span class='label label-primary mono-font '>Class Teacher </span>"; 
            
            } 
            else 
            {
                $attendancedate .= "<span class='label label-primary mono-font '>Admin</span>"; 
                
            }
            
        }  
        $column = "day_".$date;
        $class_student_attendance_lists = $this->student_model->get_student_attendance_list($class_register_id,$year_month,$column);
        if(count($class_student_attendance_lists) > 0) 
        { 
            if($is_class_active ==  0)
            {
                $x = 1; 
                foreach($class_student_attendance_lists as $class_student_attendance_list) 
                { 
                    if($class_student_attendance_list->attendance_day== 'L') {   $leave = "<i class='fa fa-check' aria-hidden='true' style='background-color:#f0ad4e;color: #ffffff;padding: 5px 6px;' title='Presents'></i>"; } else { $leave =""; }
                    if($class_student_attendance_list->attendance_day== 'A') {   $absent = "<i class='fa fa-times ' aria-hidden='true' style='background-color:#d9534f;color: #ffffff;padding: 5px 6px;' title='Presents'></i>"; } else { $absent =""; }
                    if($class_student_attendance_list->attendance_day== 'P') {   $present = "<i class='fa fa-check' aria-hidden='true' style='background-color:#5cb85c;color: #ffffff;padding: 5px 6px;' title='Presents'></i>"; } else { $present =""; }
                   $output.="<input type='hidden' name='class_register_student_ids[]' value='".$class_student_attendance_list->class_register_student_id."' />
            	    <input type='hidden' name='student_attendance_ids[]' value='". $class_student_attendance_list->student_attendance_id."' />
            	     <tr class=' '   >
                		<td class='business_list_'>";
                		
                    		if(!empty($class_student_attendance_list->profile_picture)) 
                	        { 
                                $output.="<img src='https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$class_student_attendance_list->profile_picture."' style='width:30px; height:30px;' class='img-circle'>";
                            } 
                            else 
                            {  
                                $output.="<img src='https://localhost/project/zumilyschool/assets/images/name.png' style='width:30px; height:30px;' class='img-circle'>";
                            }   
                		$output.=$class_student_attendance_list->first_name." ".$class_student_attendance_list->middle_name." ".$class_student_attendance_list->last_name."</td> 
                		<td class='business_list_ text-center'>$leave </td>  
                		<td class='business_list_ text-center'>$absent</td> 
                		<td class='business_list_ text-center'>$present </td>  
            		</tr>";
                $x++;  
                } 
            }
            else
            {
                $x = 1; 
                foreach($class_student_attendance_lists as $class_student_attendance_list) 
                { 
                    if($class_student_attendance_list->attendance_day== 'L') {   $leave = "checked"; } else { $leave =""; }
                    if($class_student_attendance_list->attendance_day== 'A') {   $absent = "checked"; } else { $absent =""; }
                    if($class_student_attendance_list->attendance_day== 'P' or count($is_attendance_exist) == 0) {   $present = "checked"; } else { $present =""; }
                   $output.="<input type='hidden' name='class_register_student_ids[]' value='".$class_student_attendance_list->class_register_student_id."' />
            	    <input type='hidden' name='student_attendance_ids[]' value='". $class_student_attendance_list->student_attendance_id."' />
            	     <tr class=' '   >
                		<td class='business_list_'>";
                		
                    		if(!empty($class_student_attendance_list->profile_picture)) 
                	        { 
                                $output.="<img src='https://localhost/project/zumilyschool/assets/uploadimages/studentimages/".$class_student_attendance_list->profile_picture."' style='width:30px; height:30px;' class='img-circle'>&nbsp;";
                            } 
                            else 
                            {  
                                $output.="<img src='https://localhost/project/zumilyschool/assets/images/name.png' style='width:30px; height:30px;' class='img-circle'>&nbsp;";
                            }   
                		$output.= $class_student_attendance_list->first_name." ".$class_student_attendance_list->middle_name." ".$class_student_attendance_list->last_name."</td> 
                		<td class='business_list_'><input type='radio' class='form-control' name='status".$x."' value='L' $leave /> </td>  
                		<td class='business_list_'><input type='radio' class='form-control' name='status".$x."' value='A'  $absent /> </td> 
                		<td class='business_list_'><input type='radio' class='form-control' name='status".$x."' value='P' $present /> </td>  
            		</tr>";
                $x++;  
                } 
            }
        }
        
        $array = array('updated_date'=>$attendancedate,"attendance_list"=>$output);
        echo $myJSON = json_encode($array); 
	}
	
	
	
	// enable class register
	public function enableClassregister()
	{  
	    $class_register_id = $this->uri->segment('2');  
        $data['displayflag'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time'); 
         
        $teacher_update = $this->classregister_model->update_classregister($data,$class_register_id); 
        if (!empty($teacher_update)) 
        {
            $sdata['success'] = 'Class enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('classes-register-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('classes-register-list', 'refresh');
        }  
         
	}
	
	// disable class register
	public function disableClassregister()
	{  
	    $class_register_id = $this->uri->segment('2');  
        $data['displayflag'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time'); 
         
        $student_update = $this->classregister_model->update_classregister($data,$class_register_id); 
        if (!empty($student_update)) 
        {
            $sdata['success'] = 'Class enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('classes-register-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('classes-register-list', 'refresh');
        }  
	}
	
	
	public function delete_class_register()
	{
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        $class_teacher_id = $this->input->post('class_teacher_id', TRUE); 
        $session_id = $this->input->post('session_id', TRUE); 
        
        $this->classregister_model->insert_update_class_teacher_teaching_classes($class_teacher_id,$session_id,NULL,NULL,$this->session->userdata('current_date_time')); 
        
        $this->classregister_model->delete_class_register($class_register_id); 
         
        $sdata['success'] = 'Class register deleted successfully. '; 
        $this->session->set_userdata($sdata);
        redirect('classes-register-list', 'refresh');
         
	}
	
	// create class register pdf
	public function create_class_register_pdf()
	{   
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['classregister_lists'] = $this->classregister_model->get_classregister_list($this->input->cookie('school_id',true)); 
		
		$filename = md5($this->input->cookie('school_id',true))."_classregister_list.pdf";  
         $html = $this->load->view('classregister_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregister/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregister/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	
	// create class register students pdf
	public function create_class_register_students_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
        $data['class_register_id'] = $class_register_id; 
		$data['class_student_list'] = $this->class_register_student_model->get_class_register_student_list($class_register_id);  
	    $class_section_name = $data['classregister_info']['class_name']." ".$data['classregister_info']['section'];  
        $data['class_section_name'] = $class_section_name; 
        
        
		$filename = md5($this->input->cookie('school_id',true))."_classregister_student_list.pdf";  
         $html = $this->load->view('classregister_students_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterstudents/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterstudents/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	// create class register teachers pdf
	public function create_class_register_teachers_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
         
        $data['classregister_info'] = $this->classregister_model->get_classregister_info($class_register_id); 
        $data['class_register_id'] = $class_register_id;   
        $data['session_id'] = $data['classregister_info']['session_id'];  
		$data['class_subject_teacher_list'] = $this->classregister_model->get_class_register_subject_teacher_list($class_register_id,$data['classregister_info']['session_id']); 
	 
	 
		$filename = md5($this->input->cookie('school_id',true))."_classregister_teacher_list.pdf";    
        $html = $this->load->view('classregister_teachers_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterteachers/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterteachers/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
}
