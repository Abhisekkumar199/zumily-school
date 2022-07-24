<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_controller extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// set current date
	public function setCurrentdate()
	{   
        $current_date = $this->input->post('current_date', TRUE);
        $current_time = $this->input->post('current_time', TRUE);
        $current_date_time = $this->input->post('current_date_time', TRUE); 
        $day_of_month = $this->input->post('day_of_month', TRUE);
        $minutes = $this->input->post('minutes', TRUE);
        $dayOfWeek = $this->input->post('dayOfWeek', TRUE);
	    $session_data = array(
    			'current_date' => $current_date,
    			'current_time' => $current_time, 
    			'current_date_time' => $current_date_time, 
    			'day_of_month' => $day_of_month, 
    			'current_minute' => $minutes, 
    			'current_dayofweek' => $dayOfWeek,  
    			); 
    			
	    $this->session->set_userdata($session_data); 
	   echo $this->session->userdata('current_minute'); 
	    
	} 
 
	// get search result
	public function get_search_result()
	{
	    $output="";  
        
        $school_id = $this->input->cookie('school_id',true); 
	    $search_text = $this->input->post('searchtext');
        $search_result_lists = $this->global_model->get_search_result_list($school_id,$search_text);
        $output .="<div id='top-select-searchautocomplete-list' class='autocomplete-items'>"; 
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                $type = $search_result->pointer_type;
                if($type == 'T')
                {
                    $directory = 'teacherimages';
                }
                else
                {
                    $directory = 'studentimages';
                }
                if(!empty($search_result->profile_picture))
                {
                    $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                }
                else
                {
                    $src = base_url().'assets/images/name.png';
                }
               $output.="<a href='".base_url()."search-result/".base64_encode($search_result->searchable_data_id)."'>
                            <div class='dropdowndiv' style='border-right: 1px solid #d2cdcd;'>
                            <img src='$src' style='width:25px; height:25px;' class='img-circle'>  
                            ".$search_result->searchable_data."
                            </div>
                        </a>";
            $x++;  
            } 
        }
        echo $output;
	}
	
	// student search
	public function student_result()
	{
	    $output="";  
        
        $school_id = $this->input->cookie('school_id',true); 
	    $search_text = $this->input->post('searchtext');
	    $classregisterid = $this->input->post('classregisterid');
	    $class_section_name =  $this->input->post('class_section_name');
	    
        $search_result_lists = $this->global_model->get_student_result_list($school_id,$search_text);
        $output .="<div id='top-select-searchautocomplete-list' class='autocomplete-items'>"; 
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                 
                $directory = 'studentimages';
                 
                if(!empty($search_result->profile_picture))
                {
                    $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                }
                else
                {
                    $src = base_url().'assets/images/name.png';
                }
               $output.="<a href='".base_url()."add-class-register-students/".$search_result->student_id."-".$classregisterid."-".$class_section_name."'>
                            <div class='dropdowndiv' style='border-right: 1px solid #d2cdcd;'>
                            <i style = 'color: #35d235;' class='fa fa-plus' aria-hidden='true'></i>&nbsp;
                            <img src='$src' style='width:25px; height:25px;' class='img-circle'>  
                            ".$search_result->searchable_data."
                            </div>
                        </a>";
            $x++;  
            } 
        }
        echo $output;
	}
	
	// teacher search
	public function teacher_result()
	{
	    $output="";  
        
        $school_id = $this->input->cookie('school_id',true); 
	    $search_text = $this->input->post('searchtext');
	    $classregisterid = $this->input->post('classregisterid');
	    $session_id = $this->input->post('session_id');
        $search_result_lists = $this->global_model->get_teacher_result_list($school_id,$search_text,$classregisterid);
        $output .="<div id='top-select-searchautocomplete-list' class='autocomplete-items'>"; 
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                 
                $directory = 'teacherimages';
                 
                if(!empty($search_result->profile_picture))
                {
                    $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                }
                else
                {
                    $src = base_url().'assets/images/name.png';
                }
               $output.="<a href='".base_url()."add-class-register-subject-teacher/".$search_result->teacher_id."-".$classregisterid."-".$session_id."'>
                            <div class='dropdowndiv' style='border-right: 1px solid #d2cdcd;'>
                            <i style = 'color: #35d235;' class='fa fa-plus' aria-hidden='true'></i>&nbsp;
                            <img src='$src' style='width:25px; height:25px;' class='img-circle'>  
                            ".$search_result->searchable_data."
                            </div>
                        </a>";
            $x++;  
            } 
        }
        echo $output;
	}
	
    //  search result
	public function search_result()
	{
        $search_id = base64_decode($this->uri->segment('2')); 
	    
	    if($search_id != '')
	    { 
	        $is_search_by_id = 1 ;  
	    }
	    else
	    {
	        $string = $this->input->post('search');  
	    } 
	    
        $school_id = $this->input->cookie('school_id',true); 
        
          
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
        if($is_search_by_id == 1)
        {
            $search_result_lists = $this->global_model->get_search_result_by_id($school_id,$search_id); 
        }
        else
        { 
            $search_result_lists = $this->global_model->get_search_result_list($school_id,$string);
        }
        $output = '';
        
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                $type = $search_result->pointer_type;
                if($type == 'T')
                {
                    $directory = 'teacherimages';
                    
                    if(!empty($search_result->profile_picture))
                    {
                        $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                    }
                    else
                    {
                        $src = base_url().'assets/images/name.png';
                    }
                    
                    $teacher_id = $search_result->pointer_id;
                    $teacher_info = $this->teacher_model->get_teacher_info($teacher_id);
                    
                    $output.="<div class='home-list-pop list-spac list-spac-1'>  
                                <div class='col-md-2 searchimage  list-image-spac' style='padding-right: 0px!important;width:16%!important;'> 
                        		    <img src='".$src."' class='img-circle' style='width:50px; height:50px;'>
                                </div> 
                                <div class='col-md-8 home-list-pop-desc inn-list-pop-desc' style='padding-left: 0px!important;'> 
                                    <a href='https://www.zumily.com/business-flyer?businessId=1'>
                                        <h3 style='padding-bottom:0px;'>
                                        ".$teacher_info['first_name']." ".$teacher_info['last_name']."";
                                        if($teacher_info['designation']!= '')
                                        {
                                            $output.=" (".$teacher_info['designation'].")";
                                        }
                                    $output.="</h3></a> 
                                     
                                    <p style='margin-top:10px;'>
                                    <b><i class='fa fa-phone' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; </b> ".$teacher_info['mobile_no']." &nbsp;&nbsp;&nbsp;&nbsp;";
                                    if($teacher_info['email_id']!= '')
                                    {
                                        $output.="<b> <i class='fa fa-envelope' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; </b> ".$teacher_info['email_id']."";
                                    }
                                    $output.="</p> 
                                    <p style='margin-top:5px;'><b><i class='fa fa-map-marker' aria-hidden='true' style='font-size:16px;'></i><a target='_blank' href='http://maps.google.com/?q=Sector 62, Noida, Uttar Pradesh, India'> &nbsp;&nbsp;</a></b><a target='_blank' href='http://maps.google.com/?q=".$teacher_info['address']."'>".$teacher_info['address']."</a></p> 
                                    <p style='margin-top:5px;'> <b><i class='fa fa-book' style='font-size:16px;' aria-hidden='true'></i></b> &nbsp;&nbsp; 
                                    ".$teacher_info['subject1']."";
                                    if($teacher_info['subject2']!= '')
                                    {
                                        $output.=", ".$teacher_info['subject2']."";
                                    }
                                    if($teacher_info['subject3']!= '')
                                    {
                                        $output.=", ".$teacher_info['subject3'].""; 
                                    }
                                    $output.="</p>       
                                </div>
                                <div class='col-md-2' style='padding-top: 20px;'> ";
                                $output.="<a href='https://localhost/project/zumilyschool/update-teacher/".base64_encode($teacher_info['teacher_id'])."' title='Edit this Teacher'><i class='fa fa-edit' style='font-size:20px;'></i></a>";
                            	$output.="</div>
                    </div> ";
                }
                else
                {
                    $directory = 'studentimages';
                    
                    if(!empty($search_result->profile_picture))
                    {
                        $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                    }
                    else
                    {
                        $src = base_url().'assets/images/name.png';
                    }
                    $student_id = $search_result->pointer_id;
                    $student_info = $this->student_model->get_student_all_info($student_id);
                    
                    $output.="<div class='home-list-pop list-spac list-spac-1'>  
                        <div class='col-md-2 searchimage  list-image-spac' style='padding-right: 0px!important;width:16%!important;'> 
                		    <img src='".$src."' class='img-circle' style='width:50px; height:50px;'>
                        </div> 
                        <div class='col-md-8 home-list-pop-desc inn-list-pop-desc' style='padding-left: 0px!important;'> 
                            <a href='https://www.zumily.com/business-flyer?businessId=1'><h3 style='padding-bottom:0px;'>".$student_info['first_name'].' '.$student_info['middle_name'].' '.$student_info['last_name'];
                            if($student_info['registration_no']!= '')
                            {
                                $output.=" (".$student_info['registration_no'].")";
                            }
                        
                            $output.="</h3></a>"; 
                            
                            if($student_info['class_name'] != '')
                            { 
                                $output.="<p style='margin-top:5px;'><b><i class='fa fa-address-card-o' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; Class </b> - ".$student_info['class_name']."".$student_info['section']." &nbsp;&nbsp;&nbsp;&nbsp; <b>Session </b> - ".$student_info['session_year']."  </p>";  
                            }
                            if($student_info['mobile_no'] != '')
                            { 
                                $output.="<p style='margin-top:10px;'><b><i class='fa fa-phone' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; Student </b> - ".$student_info['mobile_no']." &nbsp;&nbsp;&nbsp;&nbsp; <b> Parent </b> - ".$student_info['parent_mobile_no']."</p>";  
                            }
                                $output.="<p style='margin-top:5px;'><b><i class='fa fa-user' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; Father </b> - ".$student_info['father_name']." &nbsp;&nbsp;&nbsp;&nbsp; ";
                                if($student_info['mother_name'] != '')
                                {
                                $output.="<b>Mother </b> - ".$student_info['mother_name'];
                                }
                                $output.="</p>";  
                           
                            if($student_info['address'] != '')
                            { 
                                $output.="<p style='margin-top:5px;'><b><i class='fa fa-map-marker' aria-hidden='true' style='font-size:18px;'></i><a target='_blank' href='http://maps.google.com/?q=Sector 62, Noida, Uttar Pradesh, India'> &nbsp;&nbsp;</a></b><a target='_blank' href='http://maps.google.com/?q=".$student_info['address']."'>".$student_info['address']."</a></p>";  
                            }
                            $output.=" <p style='margin-top:10px;'>";
                            if($student_info['teacher_fname'] != '')
                            {
                                $output.="<b><i class='fa fa-user' style='font-size:16px;' aria-hidden='true'></i>&nbsp;&nbsp; Class Teacher </b> - ".$student_info['teacher_fname']." ".$student_info['teacher_lname']." &nbsp;&nbsp;&nbsp;&nbsp;";
                            }
                            if($student_info['teacher_mobile_no'] != '')
                            {
                                $output.="<i class='fa fa-phone' style='font-size:16px;' aria-hidden='true'></i> ".$student_info['teacher_mobile_no']; 
                            }
                            $output.="</p>
                        </div>
                        <div class='col-md-2' style='padding-top: 20px;'> ";
                        $output.="<a href='https://localhost/project/zumilyschool/update-student/".base64_encode($student_info['student_id'])."' title='Edit this Student'><i class='fa fa-edit' style='font-size:20px;'></i></a>";
                    	$output.="</div>
                    </div> ";
                    
                }
                
                
            $x++;  
            } 
        }
        else
        {
            $output="<p style='color:red;margin-top:30px;text-align: center;'><strong>*** No search data found ***</strong></p>";
        }
        
	    $data['result'] = $output;
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('search-result',$data);
		$this->load->view('include/right_sidebar'); 
         
	}
	
	// student search
	public function student_result_for_fee_concession()
	{
	    $output="";  
        
        $school_id = $this->input->cookie('school_id',true); 
	    $search_text = $this->input->post('searchtext');  
	    
        $search_result_lists = $this->global_model->get_student_list_for_fee_concession($school_id,$search_text);
        $output .="<div id='top-select-searchautocomplete-list' class='autocomplete-items'>"; 
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                 
                $directory = 'studentimages';
                 
                if(!empty($search_result->profile_picture))
                {
                    $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                }
                else
                {
                    $src = base_url().'assets/images/name.png';
                }
               $output.="<a href='".base_url()."fee-concessions/".base64_encode($search_result->class_register_student_id)."'>
                            <div class='dropdowndiv' style='border-right: 1px solid #d2cdcd;'>
                            &nbsp;
                            <img src='$src' style='width:25px; height:25px;' class='img-circle'>  
                            ".$search_result->searchable_data." (".$search_result->class_name_section.")
                            </div>
                        </a>";
            $x++;  
            } 
        }
        echo $output;
	}
	
	
	// student search for additional fee
	public function student_result_for_additional_fee()
	{
	    $output="";  
        
        $school_id = $this->input->cookie('school_id',true); 
	    $search_text = $this->input->post('searchtext');  
	    
        $search_result_lists = $this->global_model->get_student_list_for_fee_concession($school_id,$search_text);
        $output .="<div id='top-select-searchautocomplete-list' class='autocomplete-items'>"; 
        if(count($search_result_lists) > 0) 
        {  
            $x = 1; 
            foreach($search_result_lists as $search_result) 
            {  
                 
                $directory = 'studentimages';
                 
                if(!empty($search_result->profile_picture))
                {
                    $src = base_url().'assets/uploadimages/'.$directory.'/'.$search_result->profile_picture;
                }
                else
                {
                    $src = base_url().'assets/images/name.png';
                }
               $output.="<a href='".base_url()."students-additional-fee/".base64_encode($search_result->class_register_student_id)."'>
                            <div class='dropdowndiv' style='border-right: 1px solid #d2cdcd;'>
                            &nbsp;
                            <img src='$src' style='width:25px; height:25px;' class='img-circle'>  
                            ".$search_result->searchable_data." (".$search_result->class_name_section.")
                            </div>
                        </a>";
            $x++;  
            } 
        }
        echo $output;
	}
	 
}
