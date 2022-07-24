<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();    
    }
 
	public function messageList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['message_lists'] = $this->message_model->get_message_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('message-list',$data); 
	}
	public function addMessage()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['classregister_lists'] = $this->classregister_model->get_messages_class_registers($this->input->cookie('school_id',true)); 
		$data['student_lists'] = $this->class_register_student_model->get_class_register_active_session_student_list($this->input->cookie('school_id',true));
		$data['message_type_lists'] = $this->message_model->get_message_type_list(); 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-message',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	public function addMessageProcess()
	{ 
	    $student_id_list ='';
	    $class_register_id_list = '';
	    $documents = '';
	    // insert message
	    
	    if($this->input->post('sent_to') == 'all')
	    {
	        $sending_to ='A';
	    }
	    else if($this->input->post('sent_to') == 'selected')
	    {
	        $sending_to ='C';
	    } 
	    else if($this->input->post('sent_to') == 'students')
	    {
	        $sending_to ='S';
	    } 
	    
	    
        $school_id = $this->input->cookie('school_id',true);
        $message_data['title'] = $this->input->post('title', TRUE);
        $message_data['description'] = $this->input->post('desc', TRUE);
        $message_data['message_type_id'] = $this->input->post('message_type_id', TRUE);
        $message_data['message_type_display_name'] = $this->input->post('message_type_text', TRUE);
        $message_data['sending_to'] =  $sending_to; 
        $message_data['school_id'] = $school_id; 
        $message_data['date_created'] = $this->session->userdata('current_date_time');
        $message_data['last_updated'] = $this->session->userdata('current_date_time'); 
        $message_images=$_FILES["images"];   
        
        
        $message_id = $this->message_model->insert_message($message_data);   
        
        if($message_id > 0)
        {
            if($message_images["name"][0]!="")
            { 
                for($i=0;$i<count($message_images["name"]);$i++)
                { 
                    
                    $num1=rand(1000,9999);
                    $num2=rand(1000,9999); 
                    $finalnum=$num1."".$num2; 
                    $name= "m_".$school_id."_".$message_id."_".$finalnum;
    			    $filename = $_FILES['images']['name'][$i];  
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $finalname = $name.".".$ext;  
                    
                    $_FILES['file']['name'] = $_FILES['images']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['images']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['images']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['images']['size'][$i];
                    
                    $file_size =  $_FILES['images']['size'][$i];
                    
                    $percentage = image_compress_quality($file_size);
                  
                        
                    $config['upload_path']  = './assets/uploadimages/messageimages/';
        			$config['allowed_types'] = '*';  
                    $config['file_name'] = $finalname;
        			$this->upload->initialize($config); 
        			$this->load->library('upload', $config);
                      
        			$this->upload->do_upload('file');
        			$upload_data = $this->upload->data();  
        			 
        			// image compress 
        			$config1['image_library'] = 'gd2';
        			$config1['file_permissions'] = 0644;
                    $config1['source_image'] = './assets/uploadimages/messageimages/'.$finalname;   
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
                
                $message_image_data['message_images'] =  $documents; 
                $message_image_data['total_images'] =  $total_document;   
                $this->message_model->update_message($message_image_data,$message_id);
                
                $is_image_order = 1;
            }
            else
            {
                $is_image_order = 0;
            } 
            
            if($this->input->post('sent_to') == 'all')
            {  
                $userids = $this->class_register_student_model->get_message_class_register_student_list($this->input->cookie('school_id',true));
                foreach($userids as $userid)
        	    {
    	            $user_id = $userid->user_id;
    	            $message_user_data['message_id'] = $message_id;
    	            $message_user_data['user_id'] = $user_id; 
                    $this->message_model->insert_message_user_delivery($message_user_data);  
                    
                    // insert into notifications
    	            $notification_data['school_id'] = $school_id; 
    	            $notification_data['payload_id'] = $message_id;
    	            $notification_data['payload_type'] = 'M'; 
    	            $notification_data['title'] = $this->input->post('title', TRUE); 
    	            $notification_data['description'] = $this->input->post('desc', TRUE);  
    	            $notification_data['user_id'] = $userid->user_id; 
                    $notification_data['date_created'] = $this->session->userdata('current_date_time');
                    $this->cron_model->insert_notification($notification_data);   
                    
        	    }
        	    
                $update_message_data['sending_list'] =  'all';  
                $this->message_model->update_message($update_message_data,$message_id);  
            }
            else if($this->input->post('sent_to') == 'students')
            {  
                $student_ids = $this->input->post('students', TRUE); 
                $userids = $this->student_model->get_students_user_list($student_ids);
                foreach($userids as $userid)
        	    {
    	            $user_id = $userid->user_id;
    	            $message_user_data['message_id'] = $message_id;
    	            $message_user_data['user_id'] = $user_id; 
                    $this->message_model->insert_message_user_delivery($message_user_data);  
                    
                    // insert into notifications
                    $notification_data['school_id'] = $school_id; 
    	            $notification_data['payload_id'] = $message_id;
    	            $notification_data['payload_type'] = 'M'; 
    	            $notification_data['title'] = $this->input->post('title', TRUE); 
    	            $notification_data['description'] = $this->input->post('desc', TRUE);  
    	            $notification_data['user_id'] = $userid->user_id; 
                    $notification_data['date_created'] = $this->session->userdata('current_date_time');
                    $this->cron_model->insert_notification($notification_data);  
        	    }
                $student_id_list = implode(',',$student_ids); 
                $update_message_data['sending_list'] =  $student_id_list;  
                $this->message_model->update_message($update_message_data,$message_id); 
            }
            else
            {
                $class_register_ids = $this->input->post('class_register_ids', TRUE);  
                $teacher_list = $this->class_register_student_model->get_class_register_teacher_list($class_register_ids);
                foreach($teacher_list as $teachers)
        	    {
    	            $teacher_ids = $teachers->class_teacher_id.",".$teachers->subject_teachers.","; 
        	    } 
        	    
                $teacher_ids = substr($teacher_ids,0,-1);
                
                $userids = $this->class_register_student_model->get_selected_class_student_list($class_register_ids,$teacher_ids);
                
                foreach($userids as $userid)
        	    {
    	            $user_id = $userid->user_id;
    	            $message_user_data['message_id'] = $message_id;
    	            $message_user_data['user_id'] = $user_id; 
                    $this->message_model->insert_message_user_delivery($message_user_data); 
                    
                    // insert into notifications
                    $notification_data['school_id'] = $school_id; 
    	            $notification_data['payload_id'] = $message_id;
    	            $notification_data['payload_type'] = 'M'; 
    	            $notification_data['title'] = $this->input->post('title', TRUE); 
    	            $notification_data['description'] = $this->input->post('desc', TRUE);  
    	            $notification_data['user_id'] = $userid->user_id; 
                    $notification_data['date_created'] = $this->session->userdata('current_date_time');
                    $this->cron_model->insert_notification($notification_data);  
                    
        	    } 
                $class_register_id_list = implode(',',$class_register_ids); 
                $update_message_data['sending_list'] =  $class_register_id_list;  
                $this->message_model->update_message($update_message_data,$message_id);
            }  
       
        }
        
        if($is_image_order == 1)
        {
           redirect('message-image-order/'.base64_encode($message_id), 'refresh'); 
        }
        else
        { 
            if (!empty($message_id)) 
            {
                send_notification();
                $sdata['success'] = 'Message sent successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('messages-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('messages-list', 'refresh');
            } 
        }
	}
 
    public function messageImageOrder()
	{ 
	    $message_id = base64_decode($this->uri->segment('2'));
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $data['message_id'] = $this->uri->segment('2');  
	    $data['message_date'] = $this->message_model->get_message_info($message_id);    
	   
	    $this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('message-image-order',$data); 
		$this->load->view('include/right_sidebar');
          
	} 
	
	public function messageImageOrderProcess()
	{ 
	    $imagestring = implode(',',$this->input->post('image_names', TRUE)); 
	    $image_names = explode(',',$imagestring);  
          $message_id = $this->input->post('message_id', TRUE);   
	    $documents = NULL;
	    for($i=0;$i<count($image_names);$i++)
        { 
            
            $new_document_id = $i + 1 ;
              
            $documents .= "$new_document_id|$image_names[$i];"; 
        }      
         $documents = substr($documents, 0, -1);   
        $message_data['message_images'] = $documents;   
	    $this->message_model->update_message($message_data,$message_id); 
        send_notification();
	}
	
	public function deleteMessageImage()
	{ 
        $str = explode('-',$this->uri->segment('2'));
        $message_id=$str[0];
        $message_image_id=$str[1];  
	    $message_info = $this->message_model->get_message_info($message_id);
	    
	    $total_images =  $message_info['total_images'];
        $images = $message_info['message_images']; 
        $document_array = explode(';',$message_info['message_images']); 
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0]; 
            $document_name = $string_array[1]; 
            
            if($message_image_id == $current_document_id)
            {
               unlink('./assets/uploadimages/messageimages/'.$string_array[1]);  
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
        
        $message_data['message_images'] = $documents;  
        $message_data['total_images'] = $total_images - 1; 
	    $student_update = $this->message_model->update_message($message_data,$message_id);  
	}
	
	
	
	// delete message
	public function deleteMessage()
	{  
	    $message_id = $this->uri->segment('2');   
        $this->cron_model->delete_notification($message_id,'M'); 
        
        
        $message_info = $this->message_model->get_message_info($message_id); 
        $images = $message_info['message_images']; 
        $document_array = explode(';',$message_info['message_images']); 
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0]; 
            $document_name = $string_array[1];  
            if($string_array[1] != '')
            { 
                unlink('./assets/uploadimages/messageimages/'.$string_array[1]);  
            } 
            
        }   
         
        $delete_message = $this->message_model->delete_message($message_id); 
        
        if (!empty($delete_message)) 
        {
            $sdata['success'] = 'Message deleted successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('messages-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('messages-list', 'refresh');
        }  
	}
	
	
	// create messsage pdf
	public function message_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['message_lists'] = $this->message_model->get_message_list($this->input->cookie('school_id',true)); 
		
		$filename = md5($this->input->cookie('school_id',true))."_message_list.pdf"; 
        $html = $this->load->view('message_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/message/".$filename, "F");
        $filepath = base_url()."assets/pdfs/message/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
}
