<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// teacher list view
	public function teacherList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['teacher_lists'] = $this->teacher_model->teacher_list($this->input->cookie('school_id',true)); 
		$data['totalrecord'] =count($data['teacher_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('teacher-list',$data); 
	}
	
	// terminated teacher  list view
	public function terminatedTeacherList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['teacher_lists'] = $this->teacher_model->get_terminated_teacher_list($this->input->cookie('school_id',true)); 
		$data['totalrecord'] =count($data['teacher_lists']);
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('terminated_teacher_lists',$data); 
	}
	
	// check teacher email exist or not
	public function checkTeacherEmail()
	{ 
	    $school_id = $this->input->cookie('school_id',true);
        $email_id = $this->input->post('email_id', TRUE); 
        $teacher_id = $this->input->post('teacher_id', TRUE);  
        $check_teacher_email = $this->teacher_model->check_teacher_email($email_id,$teacher_id,$school_id);
        
        if($check_teacher_email == 1)
        {
            echo $check_teacher_email;
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
	
	// check teacher mobile exist or not
	public function checkTeacherMobile()
	{
	    $school_id = $this->input->cookie('school_id',true);
        $mobile_no = $this->input->post('mobile_no', TRUE); 
        $teacher_id = $this->input->post('teacher_id', TRUE);  
        $check_teacher_mobile = $this->teacher_model->check_teacher_mobile($mobile_no,$teacher_id,$school_id);
        
        if($check_teacher_mobile == 1)
        {
            echo $check_teacher_mobile;
            exit();
        }
        else
        { 
            $check_user_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('mobile_no', TRUE));
            if($check_user_mobile == 1 )
            {
                $user_info = $this->user_model->get_user_info_by_mobile($this->input->post('mobile_no', TRUE));
                echo json_encode($user_info);  
            }
        }
	    
	}
	
	// add teacher view
	public function addTeacher()
	{  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-teacher');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit teacher view
	public function editTeacher()
	{
        $teacher_id = base64_decode($this->uri->segment('2')); 
        $data['teacher_info'] = $this->teacher_model->get_teacher_info($teacher_id);
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-teacher',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add  and  edit teacher process
	public function addTeacherProcess()
	{  
        $school_id = $this->input->cookie('school_id',true);
	    $teacherId = $this->input->post('teacherId', TRUE); 
        if($teacherId == '')
        {  
            // insert teacher
            $school_id = $this->input->cookie('school_id',true);
            $dataschool['first_name'] = ucwords(ltrim(rtrim($this->input->post('first_name', TRUE),' '),' '));
            $dataschool['last_name'] = ucwords(ltrim(rtrim($this->input->post('last_name', TRUE),' '),' '));
            $dataschool['email_id'] = $this->input->post('email_id', TRUE);
            $dataschool['mobile_no'] = $this->input->post('mobile_no', TRUE); 
            $dataschool['address'] = ucwords($this->input->post('address', TRUE));
            $dataschool['gender'] = $this->input->post('gender', TRUE);  
            $dataschool['subject1'] = $this->input->post('subject1', TRUE);  
            $dataschool['subject2'] = $this->input->post('subject2', TRUE);  
            $dataschool['subject3'] = $this->input->post('subject3', TRUE);   
            $dataschool['aadhar_card_number'] = $this->input->post('aadhar1', TRUE)."-".$this->input->post('aadhar2', TRUE)."-".$this->input->post('aadhar3', TRUE);  
               
            $dataschool['designation'] = ucwords(ltrim(rtrim($this->input->post('designation'),' '),' '));
            $dataschool['joining_date'] = date("Y-m-d",strtotime($this->input->post('joining_date')));
            
            
            $dataschool['searchable_data'] = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'))." (".$this->input->post('subject1').") ".$this->input->post('mobile_no', TRUE)."";
            
            $image = $this->input->post("result1");
            if(!empty($image))
            {
                define('UPLOAD_DIR', './assets/uploadimages/teacherimages/');
                $image_parts = explode(";base64,", $_REQUEST['result1']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                
                $filename = 'pi_t_'.uniqid() . '.png';
                $file = UPLOAD_DIR . $filename;
                file_put_contents($file, $image_base64);
                
                // image compression  
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/teacherimages/'.$filename;   
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
                
    	        $dataschool['profile_picture'] = $filename;
            }
            
            
            $dataschool['school_id'] = $school_id;
            $dataschool['employee_code'] = '';
            $dataschool['date_created'] = $this->session->userdata('current_date_time');  
            $dataschool['last_updated'] = $this->session->userdata('current_date_time');  
            $teacher_id = $this->teacher_model->insert_teacher($dataschool); 
            
            if($teacher_id > 0)
            {
                $check_user_email = $this->user_model->check_if_user_email_exist($this->input->post('email_id', TRUE)); 
                $check_user_mobile = $this->user_model->check_if_user_mobile_exist($this->input->post('mobile_no', TRUE));
                
                // if user email exist then get info and update user
                if($check_user_email == 1 )
                {
                    $user_info_by_email = $this->user_model->get_user_info_by_email($this->input->post('email_id', TRUE)); 
                    $user_id = $user_info_by_email->user_id;  
                    $user_types = $user_info_by_email->user_types;  
                    
                    if($user_types != '')
                    {
                        if(strpos($user_types,"T") == '')
                        { 
                            $data1['user_types'] = $user_types.',T'; 
                        }
                    }
                    else
                    { 
                        $data1['user_types'] = 'T'; 
                    }
                    $data1['active_teacher_school_id'] = $school_id; 
                    $data1['active_teacher_id'] = $teacher_id; 
                    $data1['active_teacher_name'] = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE))." (".$this->input->post('subject1', TRUE).")";
                     
                    
                    $data1['is_teacher'] = '1';    
                    $data1['last_updated'] = $this->session->userdata('current_date_time');   
                    $update_user = $this->user_model->update_user($data1,$user_id);  
                }
                
                // if user mobile exist then get info and update user
                else if($check_user_mobile == 1)
                {
                    $user_info_by_mobile = $this->user_model->get_user_info_by_mobile($this->input->post('mobile_no', TRUE)); 
                     
                    $user_id = $user_info_by_mobile['user_id'];   
                     $user_types = $user_info_by_mobile['user_types'];  
                    if($user_types != '')
                    {
                        if(strpos($user_types,"T") == '')
                        { 
                            $data1['user_types'] = $user_types.',T'; 
                        }
                    }
                    else
                    { 
                        $data1['user_types'] = 'T'; 
                    }
                      $data1['active_teacher_school_id'] = $school_id; 
                    $data1['active_teacher_id'] = $teacher_id; 
                    $data1['active_teacher_name'] = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE))." (".$this->input->post('subject1', TRUE).")";
                     
                    
                    $data1['is_teacher'] = '1';    
                    $data1['last_updated'] = $this->session->userdata('current_date_time');  
                    $update_user = $this->user_model->update_user($data1,$user_id);
                }
                // if user does not exist then insert user
                else
                {
                    $data['first_name'] = ucwords(ltrim(rtrim($this->input->post('first_name', TRUE),' '),' '));
                    $data['last_name'] = ucwords(ltrim(rtrim($this->input->post('last_name', TRUE),' '),' '));
                    $data['email_id'] = $this->input->post('email_id', TRUE);
                    $data['mobile_no'] = $this->input->post('mobile_no', TRUE); 
                    $data['address'] = ucwords($this->input->post('address', TRUE));
                    $data['user_gender'] = $this->input->post('gender', TRUE); 
                    $data['aadhar_card_number'] = $this->input->post('aadhar1', TRUE)."-".$this->input->post('aadhar2', TRUE)."-".$this->input->post('aadhar3', TRUE);  
                 
                    $data['user_types'] = "T"; 
                    $data['active_teacher_school_id'] = $school_id; 
                    $data['active_teacher_id'] = $teacher_id; 
                    $data['active_teacher_name'] = ucwords($this->input->post('first_name', TRUE))." ".ucwords($this->input->post('last_name', TRUE))." (".$this->input->post('subject1', TRUE).")";
                     
                    $data['created_by_school_id'] = $school_id;  
                    $data['is_teacher'] = '1';   
                    $data['date_created'] = $this->session->userdata('current_date_time');  
                    $data['last_updated'] = $this->session->userdata('current_date_time');  
                    $user_id = $this->user_model->insert_user($data); 
                }  
                
                
                if($user_id != '')
                {
                    $teacher_user_xref['teacher_id']= $teacher_id;
                    $teacher_user_xref['user_id']= $user_id;
                    $teacher_user_xref['school_id']= $school_id;
                    $teacher_user_xref['is_active'] = '1';   
                    $teacher_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                    $teacher_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                    $this->teacher_model->teacher_user_xref($teacher_user_xref);   
                    $teacher_data['user_id'] = $user_id;
                    $this->teacher_model->update_teacher($teacher_data,$teacher_id);    
                } 
            }
            
            if (!empty($teacher_id)) 
            { 
                $school_id = $this->input->cookie('school_id',true);
                $searchable_data = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'))." (".$this->input->post('mobile_no', TRUE).") (".$this->input->post('subject1').") ";
                $last_updated = $this->session->userdata('current_date_time');
                if($filename == '')
                {
                    $profile_picture = $this->input->post('profile_picture');
                }
                else
                {
                    $profile_picture = $filename;
                } 
                $this->teacher_model->insert_update_teacher_searchable_data($school_id,$teacher_id,$profile_picture,$searchable_data,$last_updated);    
                
                //$sdata['success'] = 'Teacher added successfully. '; 
                //$this->session->set_userdata($sdata);
                redirect('teachers-list', 'refresh');
            } 
            else 
            {
                //$sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-teacher', 'refresh');
            } 
        }
        else
        { 
            // update teacher 
            
            $data['first_name'] = ucwords(ltrim(rtrim($this->input->post('first_name', TRUE),' '),' '));
            $data['last_name'] = ucwords(ltrim(rtrim($this->input->post('last_name', TRUE),' '),' ')); 
            $data['address'] = ucwords($this->input->post('address', TRUE));
            $data['gender'] = $this->input->post('gender', TRUE);  
            $data['mobile_no'] = $this->input->post('mobile_no', TRUE);  
            $data['email_id'] = $this->input->post('email_id', TRUE);  
            $data['subject1'] = $this->input->post('subject1', TRUE);  
            $data['subject2'] = $this->input->post('subject2', TRUE);  
            $data['subject3'] = $this->input->post('subject3', TRUE);  
            $data['joining_date'] = date("Y-m-d",strtotime($this->input->post('joining_date')));
            $data['designation'] = ucwords(ltrim(rtrim($this->input->post('designation'),' '),' '));
            
            $data['searchable_data'] = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'))." (".$this->input->post('subject1').") ".$this->input->post('mobile_no', TRUE)."";
            
            
            
            
            if($this->input->post('termination_date') !='')
            {
                $data['termination_date'] = date("Y-m-d",strtotime($this->input->post('termination_date'))); 
                $data['is_active'] = '0';   
                
                $teacher_user_xref['is_active'] = '0';    
                $teacher_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                $this->teacher_model->update_teacher_user_xref($teacher_user_xref,$teacherId);  
            } 
            if($this->input->post('ternimation_reason', TRUE) != '' and $this->input->post('ternimation_reason', TRUE) != "<p><br></p>")
            { 
                $data['ternimation_reason'] = $this->input->post('ternimation_reason', TRUE);
            }
            
            
            
            $image = $this->input->post("result1");
            if(!empty($image))
            {
                
                $oldimage = $this->input->post('oldimage', TRUE);
                if($oldimage != '')
                { 
                    unlink('./assets/uploadimages/teacherimages/'.$oldimage);  
                }
                
                define('UPLOAD_DIR', './assets/uploadimages/teacherimages/');
                $image_parts = explode(";base64,", $_REQUEST['result1']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                
                $filename = 'pi_t_'.uniqid() . '.png';
                $file = UPLOAD_DIR . $filename;
                file_put_contents($file, $image_base64);
                
                
                // image compression  
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/teacherimages/'.$filename;   
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
                
    	        $data['profile_picture'] = $filename;
            }
            
            $data['is_search_data_updated'] = '0';
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $teacher_update = $this->teacher_model->update_teacher($data,$teacherId); 
            
            
            $school_id = $this->input->cookie('school_id',true);
            $searchable_data = ucwords($this->input->post('first_name'))." ".ucwords($this->input->post('last_name'))." (".$this->input->post('mobile_no', TRUE).") (".$this->input->post('subject1').") ";
            $last_updated = $this->session->userdata('current_date_time');
            if($filename == '')
            {
                $profile_picture = $this->input->post('profile_picture');
            }
            else
            {
                $profile_picture = $filename;
            } 
            $this->teacher_model->insert_update_teacher_searchable_data($school_id,$teacherId,$profile_picture,$searchable_data,$last_updated);    
            
            
            $old_mobile_no= $this->input->post('old_mobile_no'); 
            $new_mobile_no = $this->input->post('mobile_no', TRUE); 
            if($old_mobile_no != $new_mobile_no)
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
                        $user_update_data['is_teacher'] = 1;
    	                $this->user_model->update_user($user_update_data,$new_user_id);
    	                
    	                $old_user_update_data['is_teacher'] = "0";
    	                $this->user_model->update_user($old_user_update_data,$old_user_id);
    	                
    	                $is_user_teacher_xref_exist = $this->user_model->check_if_user_teacher_xref_exist($new_user_id,$teacherId);
    	                if($is_user_teacher_xref_exist == 0)
    	                {
                            $teacher_user_xref['teacher_id']= $teacherId;
                            $teacher_user_xref['user_id']= $new_user_id;
                            $teacher_user_xref['school_id']= $school_id;
                            $teacher_user_xref['date_created'] = $this->session->userdata('current_date_time');  
                            $teacher_user_xref['last_updated'] = $this->session->userdata('current_date_time');   
                            $this->teacher_model->teacher_user_xref($teacher_user_xref);  
                            
                            if($teacherId > 0 and $old_user_id > 0)
                            {
                                $this->delete_teacher_user_xref($teacherId,$old_user_id);  
                            }
    	                } 
    	                 
	                    $this->user_model->copy_old_user_data_to_new_user($new_user_id,$old_user_id);
    	                
                    }
                    else
                    {
                         
                        $sdata['success'] = '<div class="alert alert-danger">This phone is already being used by other teacher. Please check the number</div>'; 
                        $this->session->set_userdata($sdata);
                        redirect('update-teacher/'.$teacherId, 'refresh');
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
        
            
            
            if (!empty($teacher_update)) 
            {
                //$sdata['success'] = 'Teacher updated successfully. '; 
                //$this->session->set_userdata($sdata);
                redirect('teachers-list', 'refresh');
            } 
            else 
            {
                //$sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-teacher', 'refresh');
            } 
        }
         
	}
	
	// enable teacher
	public function enableTeacher()
	{  
	    $subjectId = $this->uri->segment('2');  
        $data['is_active'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $teacher_update = $this->teacher_model->update_teacher($data,$subjectId); 
        if (!empty($teacher_update)) 
        {
            //$sdata['success'] = 'Teacher enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('teachers-list', 'refresh');
        } 
        else 
        {
            //$sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('teachers-list', 'refresh');
        }  
         
	}
	
	// disable teacher
	public function disableTeacher()
	{  
	    $teacherId = $this->uri->segment('2');  
        $data['is_active'] = 0; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $teacher_update = $this->teacher_model->update_teacher($data,$teacherId); 
        if (!empty($teacher_update)) 
        {
            //$sdata['success'] = 'Teacher enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('teachers-list', 'refresh');
        } 
        else 
        {
            //$sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('teachers-list', 'refresh');
        }  
	} 
	
	//delete teacher user xref		
	public function delete_teacher_user_xref($teacherId,$user_id) 
	{    
        $this->db->where('teacher_id', $teacherId);
        $this->db->where('user_id', $user_id);
        $this->db->delete('teacher_user_xref');  
        
	} 
	
	// create teacher pdf
	public function create_teacher_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['teacher_lists'] = $this->teacher_model->teacher_list($this->input->cookie('school_id',true));  
		$filename = md5($this->input->cookie('school_id',true))."_teacher_list.pdf";   
        $html = $this->load->view('teacher_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/teacher/".$filename, "F");
        $filepath = base_url()."assets/pdfs/teacher/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
}
