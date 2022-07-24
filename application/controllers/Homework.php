<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homework extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();          
    }
 
	public function homework_list()
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
		
		$data['homework_lists'] = $this->homework_model->get_homework_list($session_id,$class_register_id,$is_session_changed);
		$data['currentdate'] = $this->session->userdata('current_date');
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('homework',$data); 
	}
	public function add_homework()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));    
	    
	    $current_date = $this->session->userdata('current_date');
	    $current_session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $current_session_data[0]->session_id; 
	    
	    
		$data['teacher_lists'] = $this->teacher_model->get_teacher_list($this->input->cookie('school_id',true),$current_session_id);
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-homework',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	public function update_homework()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
        $homework_id = base64_decode($this->uri->segment('2'));  
         
	    $data['homework_id'] = $this->uri->segment('2');  
        $data['homework_info'] = $this->homework_model->get_homework_info($homework_id);  
		$data['classregister_lists'] = $this->classregister_model->get_messages_class_registers($this->input->cookie('school_id',true));   
		
		$current_date = $this->session->userdata('current_date');
	    $current_session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $current_session_data[0]->session_id; 
	    
	    
		$data['teacher_lists'] = $this->teacher_model->get_teacher_list($this->input->cookie('school_id',true),$current_session_id);
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-homework',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	public function add_homework_process()
	{ 
	    $id = $this->input->post('id', TRUE);
	    $documents = $this->input->post('old_documents', TRUE);
	    
	    if($id== '')
	    {
    	    $student_id_list ='';
    	    $class_register_id_list = '';
    	    $documents = '';
    	    // insert homework  
    	    
    	    $class_register_id = $this->input->post('class_register_id', TRUE);
    	    $session_data = $this->classregister_model->get_session_year($class_register_id); 
    	    $session_year = $session_data[0]->session_year; 
    	    
    	    $datetime = $this->session->userdata('current_date_time');
    	    
    	    $class_section_name_str = explode('(', $this->input->post('class_section_name', TRUE));
            $class_section_name = rtrim ($class_section_name_str[0],' '); 
    	    
            $school_id = $this->input->cookie('school_id',true);
            $homework_data['title'] = $this->input->post('title', TRUE);
            $homework_data['description'] = $this->input->post('desc', TRUE); 
            $homework_data['teacher_id'] = $this->input->post('teacher_id', TRUE); 
            $homework_data['teacher_name'] = $this->input->post('teacher_name', TRUE); 
            $homework_data['class_register_id'] = $this->input->post('class_register_id', TRUE); 
            $homework_data['class_name_section'] = $class_section_name; 
            $homework_data['session_year'] = $session_year; 
            $homework_data['homework_type'] = $this->input->post('submit_type', TRUE); 
            $homework_data['due_date'] =  date("Y-m-d",strtotime($this->input->post('due_date', TRUE))); 
            $homework_data['school_id'] = $school_id; 
            $homework_data['date_created'] = $this->session->userdata('current_date_time');
            $homework_data['last_updated'] = $this->session->userdata('current_date_time');  
            $homework_documents=$_FILES["documents"];   
             
            
            $homework_id = $this->homework_model->insert_homework($homework_data);  
            
            if($homework_id > 0)
            {
                if($homework_documents["name"][0]!="")
                { 
                    for($i=0;$i<count($homework_documents["name"]);$i++)
                    {  
                        $num1=rand(1000,9999);
                        $num2=rand(1000,9999); 
                        $finalnum=$num1."".$num2; 
                        $name= "hw_".$school_id."_".$homework_id."_".$finalnum;
        			    $filename = $_FILES['documents']['name'][$i];  
                        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $finalname = $name.".".$ext;  
                        
                        $_FILES['file']['name'] = $_FILES['documents']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['documents']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['documents']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['documents']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['documents']['size'][$i];
                        
                        $file_size =  $_FILES['documents']['size'][$i]; 
                        $percentage = image_compress_quality($file_size);
                      
                            
                        $config['upload_path']  = './assets/uploadimages/homeworkimages/';
            			$config['allowed_types'] = '*';  
                        $config['file_name'] = $finalname;
            			$this->upload->initialize($config); 
            			$this->load->library('upload', $config);
                          
            			$this->upload->do_upload('file');
            			$upload_data = $this->upload->data();  
            			 
            			// image compress 
            			if($ext == 'jpg' or $ext == 'jpeg' or $ext == 'png' or $ext == 'GIF' )
            			{
                			$config1['image_library'] = 'gd2';
                			$config1['file_permissions'] = 0644;
                            $config1['source_image'] = './assets/uploadimages/homeworkimages/'.$finalname;   
                            $config1['quality'] = $percentage;
                            $config1['maintain_ratio'] = FALSE; 
                            
                            $this->load->library('image_lib', $config1);
                            $this->image_lib->initialize($config1);  
                             
                            if ( ! $this->image_lib->resize())
                            {
                                    echo $this->image_lib->display_errors();
                            }
                            
                            $this->image_lib->clear();
            			} 
            			
                        if($documents == '')
                        {
                            $documents .= "1|$finalname"; 
                            $total_document = 1;
                        }
                        else
                        {
                            $doc_array = explode(';',$documents);
                            $total_document = count($doc_array) + 1;
                            $documents .= ";$total_document|$finalname"; 
                        }  
                    }
                    
                    $homework_image_data['total_documents'] =  $total_document;  
                    $homework_image_data['homework_documents_images'] =  $documents; 
                    $this->homework_model->update_homework($homework_image_data,$homework_id);  
                    
                    $is_image_order = 1;
                }
                else
                {
                    $is_image_order = 0;
                }  
               
                $class_register_ids = $this->input->post('class_register_id', TRUE);  
                $userids = $this->class_register_student_model->get_student_list_for_homework($class_register_ids);
                 
                $student_ids = array();  
                foreach($userids as $userid)
        	    { 
        	        if($this->input->post('submit_type', TRUE) == 'O')
        	        {
            	        if(in_array($userid->student_id, $student_ids) == false)
            	        {
            	            $student_ids[] = $userid->student_id; 
            	            
            	            $homework_completed_data['homework_id'] = $homework_id; 
                            $homework_completed_data['student_id'] = $userid->student_id;  
                            $homework_completed_data['date_created'] = $this->session->userdata('current_date_time');
                            $this->homework_model->insert_homework_completed_documents($homework_completed_data);  
            	        } 
        	        }
        	        
                    $message_user_data['homework_id'] = $homework_id;
                    $message_user_data['user_id'] = $userid->user_id; 
                    $message_user_data['student_id'] = $userid->student_id; 
                    
                    $this->homework_model->insert_homework_user_delivery($message_user_data); 
                    
                    // insert into notifications
                    $notification_data['school_id'] = $school_id; 
                    $notification_data['payload_id'] = $homework_id;
                    $notification_data['payload_type'] = 'H'; 
                    $notification_data['title'] = $this->input->post('title', TRUE); 
                    $notification_data['description'] = $this->input->post('desc', TRUE);  
                    $notification_data['user_id'] = $userid->user_id; 
                    $notification_data['date_created'] = $this->session->userdata('current_date_time');
                    $this->cron_model->insert_notification($notification_data);  
                    
        	    }   
    	     
            }
            
            if($is_image_order == 1)
            {
               redirect('homework-document-order/'.$homework_id, 'refresh'); 
            }
            else
            { 
                if (!empty($homework_id)) 
                {
                    send_notification();
                    $sdata['success'] = 'Message sent successfully. '; 
                    $this->session->set_userdata($sdata);
                    redirect('homework', 'refresh');
                } 
                else 
                {
                    $sdata['exception'] = 'Something went wrong!! Please try again.';  
                    $this->session->set_userdata($sdata);
                    redirect('homework', 'refresh');
                } 
            }
	    }
	    else
	    {
	        
	        $homework_documents=$_FILES["documents"];  
	        
            $old_title = $this->input->post('old_title', TRUE);
            $old_desc = $this->input->post('old_desc', TRUE);   
            $old_submit_type = $this->input->post('old_submit_type', TRUE); 
            $old_due_date =   $this->input->post('old_due_date', TRUE);  
            
            $new_title = $this->input->post('title', TRUE);  
            $new_desc = $this->input->post('desc', TRUE);
            $new_submit_type = $this->input->post('submit_type', TRUE);
            $new_due_date = $this->input->post('due_date', TRUE);
            
	        if($homework_documents["name"][0] != "" or $old_title != $new_title or $old_desc != $new_desc or $old_submit_type != $new_submit_type or $old_due_date != $new_due_date)
	        {  
	            if($old_title != $new_title or $old_desc != $new_desc or $old_submit_type != $new_submit_type or $old_due_date != $new_due_date)
	            {
            	    // update homework  
            	    $class_section_name_str = explode('(', $this->input->post('class_section_name', TRUE));
                    $class_section_name = rtrim ($class_section_name_str[0],' '); 
            	    
                    $school_id = $this->input->cookie('school_id',true);
                    $message_data['title'] = $this->input->post('title', TRUE);
                    $message_data['description'] = $this->input->post('desc', TRUE);   
                    $message_data['homework_type'] = $this->input->post('submit_type', TRUE); 
                    $message_data['due_date'] =  date("Y-m-d",strtotime($this->input->post('due_date', TRUE)));  
                    $message_data['last_updated'] = $this->session->userdata('current_date_time');  
                    $this->homework_model->update_homework($message_data,$id);  
	            }
                
                // update homework notifications
                $notification_data['sent_status'] = '0'; 
                $notification_data['read_status'] = '0'; 
                $notification_data['is_updated'] = '1'; 
                $notification_data['read_datetime'] = NULL;
                $notification_data['sent_datetime'] = $this->session->userdata('current_date_time');
                $payload_type = 'H'; 
                $payload_id = $id;  
                $this->cron_model->update_homework_notification($notification_data,$payload_type,$payload_id);   
            
                // upload document
                if($homework_documents["name"][0]!="")
                { 
                    for($i=0;$i<count($homework_documents["name"]);$i++)
                    {  
                        $num1=rand(1000,9999);
                        $num2=rand(1000,9999); 
                        $finalnum=$num1."".$num2; 
                        $name= "m_".$school_id."_".$id."_".$finalnum;  
        			    $filename = $_FILES['documents']['name'][$i];  
                        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $finalname = $name.".".$ext;  
                        
                        $_FILES['file']['name'] = $_FILES['documents']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['documents']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['documents']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['documents']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['documents']['size'][$i];
                        
                        $file_size =  $_FILES['documents']['size'][$i]; 
                        $percentage = image_compress_quality($file_size);
                      
                            
                        $config['upload_path']  = './assets/uploadimages/homeworkimages/';
            			$config['allowed_types'] = '*';  
                        $config['file_name'] = $finalname;
            			$this->upload->initialize($config); 
            			$this->load->library('upload', $config);
                          
            			$this->upload->do_upload('file');
            			$upload_data = $this->upload->data();  
            			 
            			// image compress 
            			if($ext == 'jpg' or $ext == 'jpeg' or $ext == 'png' or $ext == 'GIF' )
            			{
                			$config1['image_library'] = 'gd2';
                			$config1['file_permissions'] = 0644;
                            $config1['source_image'] = './assets/uploadimages/homeworkimages/'.$finalname;   
                            $config1['quality'] = $percentage;
                            $config1['maintain_ratio'] = FALSE; 
                            
                            $this->load->library('image_lib', $config1);
                            $this->image_lib->initialize($config1);  
                             
                            if ( ! $this->image_lib->resize())
                            {
                                    echo $this->image_lib->display_errors();
                            }
                            
                            $this->image_lib->clear();
            			}
            			
            			if($documents == '')
                        {
                            $documents .= "1|$finalname"; 
                            $total_document = 1;
                        }
                        else
                        {
                            $doc_array = explode(';',$documents);
                            $total_document = count($doc_array) + 1;
                            $documents .= ";$total_document|$finalname"; 
                        }  
                			  
                    } 
                    $homework_document_update_data['total_documents'] =  $total_document;  
                    $homework_document_update_data['homework_documents_images'] =  $documents;  
                    $this->homework_model->update_homework($homework_document_update_data,$id);
                    
                    
                    $is_image_order = 1;
                }
                else
                {
                    $is_image_order = 0;
                } 
                
            
                if($is_image_order == 1)
                {
                   redirect('homework-document-order/'.$id, 'refresh'); 
                }
                else
                { 
                    send_notification();
                    if (!empty($homework_id)) 
                    {
                        $sdata['success'] = 'Message sent successfully. '; 
                        $this->session->set_userdata($sdata);
                        redirect('homework', 'refresh');
                    } 
                    else 
                    {
                        $sdata['exception'] = 'Something went wrong!! Please try again.';  
                        $this->session->set_userdata($sdata);
                        redirect('homework', 'refresh');
                    } 
                }
	        }
	        else
	        { 
                redirect('homework', 'refresh');
	        }
	    }
	}
	
	
    public function homework_document_order()
	{ 
	    $homework_id = $this->uri->segment('2');
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $data['homework_id'] = $this->uri->segment('2');  
	    $data['homework_info'] = $this->homework_model->get_homework_info($homework_id);   
	   
	    $this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('homework-document-order',$data); 
		$this->load->view('include/right_sidebar');
          
	} 
	
	public function homework_document_order_process()
	{  
          $imagestring = implode(',',$this->input->post('image_names', TRUE)); 
        
         
	    $image_names = explode(',',$imagestring);  
        $homework_id = $this->input->post('homework_id', TRUE);   
	    $documents = NULL;
	    for($i=0;$i<count($image_names);$i++)
        { 
            
            $new_document_id = $i + 1 ;
              
            $documents .= "$new_document_id|$image_names[$i];"; 
        }      
         $documents = substr($documents, 0, -1);  
        
        $homework_data['homework_documents_images'] = $documents;   
	    $this->homework_model->update_homework($homework_data,$homework_id);
	  
        send_notification();
	}
	
	public function delete_homework_document()
	{ 
	    $str = explode('-',$this->uri->segment('2'));
	    $homework_id=$str[0];
	    $document_id=$str[1]; 
	    
	    
	    $homework_info = $this->homework_model->get_homework_info($homework_id); 
	    $total_documents =  $homework_info['total_documents'];
	    $document_array = explode(';',$homework_info['homework_documents_images']);
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0]; 
            $document_name = $string_array[1]; 
            
            if($document_id == $current_document_id)
            {
               unlink('./assets/uploadimages/homeworkimages/'.$string_array[1]);  
            }
            else
            { 
                if($new_document_id == 1)
                {
                    $documents .= "$new_document_id|$document_name";  
                }
                else
                { 
                    $documents .= ";$new_document_id|$document_name"; 
                }   
                $new_document_id++;
            } 
        }   
        
        $homework_data['homework_documents_images'] = $documents;  
        $homework_data['total_documents'] = $total_documents - 1; 
	    $student_update = $this->homework_model->update_homework($homework_data,$homework_id);  
	    
	     redirect($_SERVER['HTTP_REFERER'], 'refresh');
	    
	}
	
	
	public function homework_details()
	{ 
	    $sentto='';
	    $homework_id = $this->input->post('homework_id');
	    $homework_data = $this->homework_model->get_homework_info($homework_id); 
	    $homework_documents_images = $homework_data['homework_documents_images']; 
	    $document_array = explode(';',$homework_documents_images);  
	    
        $output = '<div class="modal-header"> 
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">'.$homework_data['title'].'</h4>
            
            </div>
            <div class="modal-body"> 
                <div class="col-md-12" >    
                    <span class="desc" >'.$homework_data['description'].' </span>
                    
                    <div class="clearfix"></div>
                    <div class="preview col">   
                        <div class="app-figure" id="zoom-fig"> '; 
                        
                        if(count($document_array) > 0)
                        {  
                            $output .= '<div id="myCarousel'.$homework_id.'" class="carousel slide" data-ride="carousel"> 
                            <!-- Indicators -->
                            <div class="carousel-inner">';  
                            for($i=0;$i<count($document_array);$i++)
                            { 
                                $string_array = explode('|',$document_array[$i]);
                                if($i==1) {  $is_active = 'active';  } else { $is_active ='';} 
                                
                                $output .= '<div style="display:block" class="item '.$is_active.'"> <a id="Zoom-'.$homework_id.'" class="MagicZoom"  href="'.base_url().'/assets/uploadimages/homeworkimages/'.$string_array[1].'">
                                <img data-animation="animated zoomInLeft" src="'.base_url().'/assets/uploadimages/homeworkimages/'.$string_array[1].'"> </a> </div>';
                                if($i>1)  
                                {
                                    $output .= '<a class="left carousel-control" href="#myCarousel'.$homework_id.'" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 140px 0px;
                                    font-size: 28px;background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a> 
                                    
                                    <a class="right carousel-control" href="#myCarousel'.$homework_id.'" data-slide="next"><i class="fa fa-chevron-right" style="margin: 140px 0px; font-size: 28px;
                                    background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a>';
                                } 
                                $output .= '<div class="selectors">
                                <a data-zoom-id="Zoom-'.$homework_id.'" href="'.base_url().'/assets/uploadimages/homeworkimages/'.$string_array[1].'"
                                data-image="'.base_url().'/assets/uploadimages/homeworkimages/'.$string_array[1].'" >
                                <img srcset="'.base_url().'/assets/uploadimages/homeworkimages/'.$string_array[1].'">
                                </a>
                                </div>';
                                 
                            }     
                            $output .= '</div>
                            </div>';
                        } 
                           
                        $output .= '</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row" style="margin:15px 0px;">  
                        <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;'.$homework_data['date_created'].'</span> 
                    </div> 
                </div> 
            </div>'; 
            
        echo $output;
	} 
	
	
	// delete message
	public function delete_homework()
	{  
	    $homework_id = $this->uri->segment('2');   
        $this->cron_model->delete_notification($homework_id,'H');  
        
	    $homework_documents = $this->homework_model->get_homework_documents($homework_id);  
        foreach($homework_documents as $document)
        {
            unlink('./assets/uploadimages/homeworkimages/'.$document->document_name); 
        }
         
        $delete_homework= $this->homework_model->delete_homework($homework_id);  
        
        
        if (!empty($delete_homework)) 
        {
            $sdata['success'] = 'Homework deleted successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('homework', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('homework', 'refresh');
        }  
	}
	
	
	// class register students grid view
	public function homework_student_list()
	{
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $homework_id = base64_decode($this->uri->segment('2'));  
		$data['homework_info'] = $this->homework_model->get_homework_info($homework_id);   
		$class_register_id = $data['homework_info']['class_register_id']; 
        $data['homework_id'] = $homework_id; 
        
		$data['homework_student_list'] = $this->homework_model->get_homework_student_list($class_register_id); 
		//$data['student_lists'] = $this->student_model->get_unallocated_student_list($this->input->cookie('school_id',true)); 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('homework-students',$data); 
	    
	}
	
	public function student_homework_details()
	{ 
        $uri_id = $this->uri->segment('2');   
	    $uri_array = explode('-',$uri_id);
	    
        $homework_id = base64_decode($uri_array[0]);
	    $student_id =  base64_decode($uri_array[1]);
	    
	    $data['homework_info'] = $this->homework_model->get_homework_info($homework_id);  
	    $data['student_homework'] = $this->homework_model->get_student_homework_documents($homework_id,$student_id);   
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['homework_id'] = $homework_id;
		 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('student-homework-details',$data); 
		$this->load->view('include/right_sidebar');
	} 
	
	public function update_student_homework_status()
	{  
	    $school_id = $this->input->cookie('school_id',true);
	    $homework_id = $this->input->post('homework_id', TRUE);
	    $homework_info = $this->homework_model->get_homework_info($homework_id);
	    
	    $student_id = $this->input->post('student_id', TRUE);
	    
	    $homework_data['teacher_status'] = $this->input->post('status', TRUE); 
        $homework_data['teacher_comments'] =  $this->input->post('comment', TRUE); 
        $this->homework_model->update_student_homework_status($homework_data,$homework_id,$student_id); 
        redirect('student-homework-details/'.$homework_id.'-'.$student_id, 'refresh');
        
        if($this->input->post('status', TRUE) == 0)
        {
            $status = "Incomplete";
        }
        else
        {
            $status = "Approved";
        }
        
        $userids = $this->class_register_student_model->get_user_list_for_student($student_id);
        
        foreach($userids as $userid)
	    { 
            // insert into notifications
            $notification_data['school_id'] = $school_id; 
            $notification_data['payload_id'] = $homework_id;
            $notification_data['payload_type'] = 'H'; 
            $notification_data['title'] = $homework_info['title']."($status)"; 
            $notification_data['description'] = $homework_info['description'];   
            $notification_data['user_id'] = $userid->user_id; 
            $notification_data['date_created'] = $this->session->userdata('current_date_time');
            $this->cron_model->insert_notification($notification_data);   
	    }   
	    
        send_notification();
        
	}
	
	public function get_teacher_classes()
	{
	    $current_date = $this->session->userdata('current_date');
	    $teacher_id = $this->input->post('teacher_id', TRUE);
	    $current_session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $current_session_data[0]->session_id; 
	    $teacher_class_data = $this->teacher_model->teacher_subject_teaching_classes($teacher_id,$current_session_id);  
        $sub_class_registers_info = $teacher_class_data['sub_class_registers_info']; 
        
	    $class_data = explode(';',$sub_class_registers_info); 
	    $output = "<option value=''>Select Class</option>";
	    for($i=0;$i<count($class_data);$i++)
	    { 
	        $str =   explode('|',$class_data[$i]); 
	        $output .= "<option value='$str[0]'>$str[1]</option>";
	    }
	    
	    echo $output;
	    
	}
	
	// create homework pdf
	public function create_homework_pdf()
	{   
	    $url = $this->uri->segment('2'); 
	    $str = explode("-",$url);
	    
        $session_year = base64_decode($str[0]);
	    $class_name = base64_decode($str[1]);
	    $status = '';
	   
	    $current_date = date('Y-m-d'); 
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	     
		if($session_year != '')
		{
		    $session_year = $session_year;   
		}
		else
		{
		    $session_year = $current_session_year; 
		} 
		
		$data['selected_class'] = $class_name;    
		$data['selected_status'] = $status; 
	    
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['homework_lists'] = $this->homework_model->get_homework_list($session_year,$class_name,$status,$this->input->cookie('school_id',true));
		
		
		$filename = md5($this->input->cookie('school_id',true))."_homework_list.pdf";  
        $html = $this->load->view('homework_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/homework/".$filename, "F");
        $filepath = base_url()."assets/pdfs/homework/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
}
