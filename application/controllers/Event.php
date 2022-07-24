<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
        
    }
 
	public function eventList()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['event_lists'] = $this->event_model->get_event_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('event-list',$data); 
	}
	public function addevent()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	    
		$data['event_time_lists'] = $this->event_model->get_event_time(); 
		$data['classregister_lists'] = $this->classregister_model->get_classregister_list($this->input->cookie('school_id',true)); 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-event',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	public function addeventProcess()
	{ 
	    $documents = '';
	    // insert event
        $school_id = $this->input->cookie('school_id',true);
        
        if($this->input->post('sent_to') == 'all')
	    {
	        $sending_to ='A';
	    }
	    else if($this->input->post('sent_to') == 'selected')
	    {
	        $sending_to ='C';
	    } 
	    
	    
        $event_data['title'] = $this->input->post('title', TRUE);
        $event_data['description'] = $this->input->post('desc', TRUE); 
        
        $event_data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date', TRUE))); 
        $event_data['start_time'] = $this->input->post('start_time', TRUE);  
        $event_data['end_time'] = $this->input->post('end_time', TRUE); 
        
        $event_data['sending_to'] =  $sending_to; 
        $event_data['school_id'] = $school_id; 
        $event_data['date_created'] = $this->session->userdata('current_date_time');
        $event_data['last_updated'] = $this->session->userdata('current_date_time');   
        
        $event_id = $this->event_model->insert_event($event_data);   
        
        if($event_id > 0)
        {
            $event_images=$_FILES["images"];  
            if($event_images["name"][0]!="")
            { 
                for($i=0;$i<count($event_images["name"]);$i++)
                {
                    $num1=rand(1000,9999);
                    $num2=rand(1000,9999); 
                    $finalnum=$num1."".$num2; 
                    $name= "e_".$school_id."_".$event_id."_".$finalnum;  
    			    $filename = $_FILES['images']['name'][$i];  
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $finalname = $name.".".$ext; 
                    
                    $_FILES['file']['name'] = $_FILES['images']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['images']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['images']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['images']['size'][$i];
                     
                    $config['upload_path']  = './assets/uploadimages/eventimages/';
        			$config['allowed_types'] = 'gif|jpg|png'; 
                    $config['file_name'] = $finalname;
        			$this->upload->initialize($config); 
        			$this->load->library('upload', $config);
        			$this->upload->do_upload('file');
        			$upload_data = $this->upload->data(); 
        			
        			// image compression 
        			$file_size =  $_FILES['images']['size'][$i]; 
                    $percentage = image_compress_quality($file_size);  
        			$config1['image_library'] = 'gd2';
        			$config1['file_permissions'] = 0644;
                    $config1['source_image'] = './assets/uploadimages/eventimages/'.$finalname;   
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
                
                $event_image_data['event_images'] =  $documents; 
                $event_image_data['total_images'] =  $total_document;    
                $this->event_model->update_event($event_image_data,$event_id);
                
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
    	            $event_user_data['event_id'] = $event_id;
    	            $event_user_data['user_id'] = $user_id; 
                    $this->event_model->insert_event_user_delivery($event_user_data); 
                    
                    // insert into notifications
                    $notification_data['school_id'] = $school_id; 
    	            $notification_data['payload_id'] = $event_id;
    	            $notification_data['payload_type'] = 'E'; 
    	            $notification_data['title'] = $this->input->post('title', TRUE); 
    	            $notification_data['description'] = $this->input->post('desc', TRUE);  
    	            $notification_data['user_id'] = $userid->user_id; 
                    $this->cron_model->insert_notification($notification_data); 
        	    }
        	    
                $update_event_data['sending_list'] =  'all';  
                $this->event_model->update_event($update_event_data,$event_id); 
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
    	            $event_user_data['event_id'] = $event_id;
    	            $event_user_data['user_id'] = $user_id; 
                    $this->event_model->insert_event_user_delivery($event_user_data); 
                    
                    // insert into notifications
                    $notification_data['school_id'] = $school_id; 
    	            $notification_data['payload_id'] = $event_id;
    	            $notification_data['payload_type'] = 'E'; 
    	            $notification_data['title'] = $this->input->post('title', TRUE); 
    	            $notification_data['description'] = $this->input->post('desc', TRUE);  
    	            $notification_data['user_id'] = $userid->user_id; 
                    $this->cron_model->insert_notification($notification_data); 
        	    } 
                $class_register_id_list = implode(',',$class_register_ids); 
                $update_event_data['sending_list'] =  $class_register_id_list;  
                $this->event_model->update_event($update_event_data,$event_id); 
            } 
        } 
        
        if($is_image_order == 1)
        {
           redirect('event-image-order/'.base64_encode($event_id), 'refresh'); 
        }
        else
        { 
            
            if (!empty($event_id)) 
            {
                send_notification();
                $sdata['success'] = 'Student added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('events-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('events-list', 'refresh');
            }
        }
	}
	
	public function updateEvent()
	{ 
	    $event_id = base64_decode($this->uri->segment('2'));
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['event_time_lists'] = $this->event_model->get_event_time();  
		
		$data['event_id'] = $this->uri->segment('2');
	    $data['event_info'] = $this->event_model->get_event_info($event_id); 
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('update-event',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	public function updateEventProcess()
	{    
	    $documents = $this->input->post('event_images',true);
	    // update event
        $school_id = $this->input->cookie('school_id',true);
        $event_id =$this->input->post('event_id', TRUE); 
        $image_count =$this->input->post('image_count', TRUE); 
        $is_image_upload =$this->input->post('is_image_upload', TRUE); 
        
        if($is_image_upload != 1)
        {
            $event_data['title'] = $this->input->post('title', TRUE);
            $event_data['description'] = $this->input->post('desc', TRUE); 
            
            $event_data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date', TRUE))); 
            $event_data['start_time'] = $this->input->post('start_time', TRUE);  
            $event_data['end_time'] = $this->input->post('end_time', TRUE);  
            $event_data['last_updated'] = $this->session->userdata('current_date_time');  
            $this->event_model->update_event($event_data,$event_id);   
        }
        
        $event_images=$_FILES["images"];  
        if($event_images["name"][0]!="")
        { 
            for($i=0;$i<count($event_images["name"]);$i++)
            {
                $num1=rand(1000,9999);
                $num2=rand(1000,9999); 
                $finalnum=$num1."".$num2; 
                $name= "e_".$school_id."_".$event_id."_".$finalnum;  
			    $filename = $_FILES['images']['name'][$i];  
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $finalname = $name.".".$ext; 
                
                $_FILES['file']['name'] = $_FILES['images']['name'][$i];
                $_FILES['file']['type'] = $_FILES['images']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['images']['error'][$i];
                $_FILES['file']['size'] = $_FILES['images']['size'][$i];
                 
                $config['upload_path']  = './assets/uploadimages/eventimages/';
    			$config['allowed_types'] = 'gif|jpg|png'; 
                $config['file_name'] = $finalname;
    			$this->upload->initialize($config); 
    			$this->load->library('upload', $config);
    			$this->upload->do_upload('file');
    			$upload_data = $this->upload->data(); 
    			
    			// image compression 
    			$file_size =  $_FILES['images']['size'][$i]; 
                $percentage = image_compress_quality($file_size);  
    			$config1['image_library'] = 'gd2';
    			$config1['file_permissions'] = 0644;
                $config1['source_image'] = './assets/uploadimages/eventimages/'.$finalname;   
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
            $event_data['event_images'] =  $documents; 
            $event_data['total_images'] =  $total_document;     
            $this->event_model->update_event($event_data,$event_id);
            
            $is_image_order = 1;
        }
        else
        {
            $is_image_order = 0;
        }
        
        
        if($is_image_order == 1)
        {
           redirect('event-image-order/'.$event_id, 'refresh'); 
        }
        else
        { 
            send_notification();
            if (!empty($event_id)) 
            {
                $sdata['success'] = 'Event sent successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('event-image-order/'.$event_id, 'refresh');
                //redirect('events-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('events-list', 'refresh');
            }
        }
	}
	
	public function eventImageOrder()
	{ 
	    $event_id = base64_decode($this->uri->segment('2'));
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    $data['event_id'] = base64_decode($this->uri->segment('2'));  
	    $data['event_date'] = $this->event_model->get_event_info($event_id);     
	   
	    $this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('event-image-order',$data); 
		$this->load->view('include/right_sidebar');
          
	} 
	
	public function eventImageOrderProcess()
	{ 
	   
	    $imagestring = implode(',',$this->input->post('image_names', TRUE)); 
	    $image_names = explode(',',$imagestring);  
        $event_id = $this->input->post('event_id', TRUE);   
	    $documents = NULL;
	    for($i=0;$i<count($image_names);$i++)
        {  
            $new_document_id = $i + 1 ; 
            $documents .= "$new_document_id|$image_names[$i];"; 
        }      
        $documents = substr($documents, 0, -1);   
        $event_data['event_images'] = $documents;   
	    $this->event_model->update_event($event_data,$event_id);
	    send_notification();
	}
	
	public function uploadEventImages()
	{ 
	    $event_id = $this->uri->segment('2');
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['event_time_lists'] = $this->event_model->get_event_time();  
		
		$data['event_id'] = $this->uri->segment('2'); 
	    $data['event_info'] = $this->event_model->get_event_info($event_id);  
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('upload-event-images',$data); 
		$this->load->view('include/right_sidebar');
	}
	
	
	public function deleteEventImage()
	{ 
	    $str = explode('-',$this->uri->segment('2'));
	    $event_id=$str[0];
	    $event_image_id=$str[1]; 
	     
	    $event_info = $this->event_model->get_event_info($event_id);
	    
	    $total_images =  $event_info['total_images'];
        $images = $event_info['event_images']; 
        $document_array = explode(';',$event_info['event_images']); 
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0]; 
            $document_name = $string_array[1]; 
            
            if($event_image_id == $current_document_id)
            {
               unlink('./assets/uploadimages/eventimages/'.$string_array[1]);  
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
        
        $event_data['event_images'] = $documents;  
        $event_data['total_images'] = $total_images - 1; 
	    $student_update = $this->event_model->update_event($event_data,$event_id);
	    
	    redirect('event-image-order/'.$event_id, 'refresh'); 
	}
	
	 
	// delete event
	public function deleteEvent()
	{  
	    $event_id = $this->uri->segment('2');   
        
        $this->cron_model->delete_notification($event_id,'E');   
        
	    $event_info = $this->event_model->get_event_info($event_id); 
        $images = $event_info['event_images']; 
        $document_array = explode(';',$event_info['event_images']); 
	    $new_document_id = 1;
	    $documents = NULL;
	    for($i=0;$i<count($document_array);$i++)
        { 
            $string_array = explode('|',$document_array[$i]); 
            $current_document_id = $string_array[0]; 
            $document_name = $string_array[1];  
            if($string_array[1] != '')
            { 
                unlink('./assets/uploadimages/eventimages/'.$string_array[1]);  
            } 
            
        }   
         
        $delete_event = $this->event_model->delete_event($event_id); 
        
        
        if (!empty($delete_event)) 
        {
            $sdata['success'] = 'Event deleted successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('events-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('events-list', 'refresh');
        }  
	}
	
	
	// create event pdf
	public function event_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['event_lists'] = $this->event_model->get_event_list($this->input->cookie('school_id',true)); 
		
		
		
		$filename = md5($this->input->cookie('school_id',true))."_event_list.pdf";  
        $html = $this->load->view('event_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/event/".$filename, "F");
        $filepath = base_url()."assets/pdfs/event/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
	 
}
