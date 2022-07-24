<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportcard extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	  
	// grades list
	public function grades_list()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['grade_lists'] = $this->report_card_model->grades_list($this->input->cookie('school_id',true));  
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('grade-list',$data);  
	}  
	
	// add grade process
	public function add_grade_process()
	{   
	    $str = explode('-',$this->input->post('grade', TRUE));
	    $grade = $str[0];
	    $description = $str[1]; 
	     
        $grade_id = $this->input->post('grade_id', TRUE); 
        if($grade_id != '')
        {
            $data['grade'] = $grade;
            $data['description'] = $description; 
            $data['min_marks'] = $this->input->post('minimum_marks', TRUE); 
            $data['max_marks'] = $this->input->post('maximum_marks', TRUE);     
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_insert = $this->report_card_model->update_grade($data,$grade_id);   
        }
        else
        {
	        $data['grade'] = $grade;
            $data['description'] = $description; 
            $data['min_marks'] = $this->input->post('minimum_marks', TRUE);
            $data['school_id'] = $this->input->cookie('school_id',true);
            $data['max_marks'] = $this->input->post('maximum_marks', TRUE);  
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_insert = $this->report_card_model->insert_grade($data);    
        } 
 
        redirect('grades-list', 'refresh'); 
	} 
	 
	// check_if_grade_exist
	public function check_if_grade_exist()
	{   
	    $str = explode('-',$this->input->post('grade', TRUE));
	    $grade = $str[0]; 
        $school_id = $this->input->cookie('school_id',true);
        echo $status = $this->report_card_model->check_if_grade_exist($grade,$school_id); 
         
	}
	
	// edit grade view
	public function update_grade()
	{
        $grade_id = base64_decode($this->uri->segment('2')); 
        $data['grade_info'] = $this->report_card_model->get_grade_info($grade_id); 
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['grade_lists'] = $this->report_card_model->grades_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('grade-list',$data); 
	} 
	
	// delete grade
	public function delete_grade()
	{  
	    $grade_id = $this->input->post('grade_id', TRUE);  
        $this->report_card_model->delete_grade($grade_id); 
        redirect('grades-list', 'refresh'); 
	}
	
	
	// class register list view 
	public function class_register_list()
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
		$data['current_date'] =$current_date;
		
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('class-register-list-for-periods',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// add reporting period
	public function add_reporting_period()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));   
	    $class_register_id =  base64_decode($this->uri->segment('2')); 
	    $data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
		$data['class_register_id'] =$class_register_id;
		$this->load->view('include/header_merchant',$data); 
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true));
		$this->load->view('include/left_home');
	    $this->load->view('add-reporting-periods',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	
	// add period process
	public function add_period_process()
	{    
	     
        $period_id = $this->input->post('reporting_period_id', TRUE); 
        $class_register_id = $this->input->post('class_register_id', TRUE); 
        $exam_name = $this->input->post('exam_name', TRUE); 
        $start_date = $this->input->post('start_date', TRUE); 
        $end_date = $this->input->post('end_date', TRUE); 
        $subjects = $this->input->post('subjects', TRUE); 
        $marks = $this->input->post('marks', TRUE); 
        $subjects_marks = '';
        if(count($subjects) > 0)
        {
            for($i=0;$i<count($subjects);$i++)
            {
                if($i == 0)
                {
                    $subjects_marks .= $subjects[$i]."|".$marks[$i];
                }
                else
                { 
                    $subjects_marks .= ";".$subjects[$i]."|".$marks[$i];
                }
            }
        }
        
        if($period_id != '')
        { 
            $data['exam_name'] = $this->input->post('exam_name', TRUE);
            $data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date', TRUE)));
            $data['end_date'] = date("Y-m-d",strtotime($this->input->post('end_date', TRUE)));
            $data['subjects_marks'] = $subjects_marks; 
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_insert = $this->report_card_model->update_reporting_period($data,$period_id);   
        }
        else
        {  
            $data['school_id'] = $this->input->cookie('school_id',true);
            $data['class_register_id'] = $class_register_id;  
            $data['exam_name'] = $this->input->post('exam_name', TRUE);
            $data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date', TRUE)));
            $data['end_date'] = date("Y-m-d",strtotime($this->input->post('end_date', TRUE)));
            $data['subjects_marks'] = $subjects_marks;
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $class_insert = $this->report_card_model->insert_reporting_period($data);    
        }
        
        
 
        redirect('reporting-periods', 'refresh'); 
	}  
	
	
	// update reporting period
	public function update_reporting_period()
	{ 
	    $reporting_period_id =  base64_decode($this->uri->segment('2'));  
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['subject_lists'] = $this->subject_model->get_subject_list($this->input->cookie('school_id',true));  
	    $data['period_info'] = $this->report_card_model->get_period_info($reporting_period_id);  
		$data['reporting_period_id'] =$reporting_period_id;
		
		$this->load->view('include/header_merchant',$data); 
		$this->load->view('include/left_home');
	    $this->load->view('update-reporting-period',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// report card classes
	public function report_card_classes()
	{  
	    $current_date = date('Y-m-d'); 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
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
	    $this->load->view('report-card-classes',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// class register fee details
	public function report_card_class_register_students()
	{ 
	  
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $class_register_id = base64_decode($this->uri->segment('2')); 
        
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2($class_register_id); 
        $data['class_register_id'] = $class_register_id; 
		$data['class_student_list'] = $this->class_register_student_model->get_class_register_student_list($class_register_id);  
	    $class_section_name = $data['classregister_info']['class_name']." ".$data['classregister_info']['section']; 
		 
        $data['class_section_name'] = $class_section_name; 
		//$data['student_lists'] = $this->student_model->get_unallocated_student_list($this->input->cookie('school_id',true)); 
	 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('report-card-class-register-students',$data); 
		$this->load->view('include/right_sidebar'); 
	    
	}
	
	
	// update class register additional fee 
	public function update_class_register_report_card()
	{  
	    
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $str = explode('-',$this->uri->segment('2')); 
        $current_date = $this->session->userdata('current_date');
        
        $class_register_student_id = base64_decode($str[0]); 
	    $class_register_id = base64_decode($str[1]);
        $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);   
        $data['reporting_periods_list'] = $this->report_card_model->class_register_reporting_periods_list($class_register_id,$current_date);  
         
        $reporting_cr_period_id = $data['reporting_periods_list'][0]->reporting_cr_period_id;
        $reporting_periods_info = $this->report_card_model->get_period_info($reporting_cr_period_id);  
        $subjects = $reporting_periods_info['subjects_marks'];
        $subject_ids = '';
        $marks = '';
        $output = '';
        $str = explode(";",$subjects);
        for($i=0;$i<count($str);$i++)
        { 
            $str1 = explode("|",$str[$i]); 
             
            if($i==0)
            { 
                $subject_ids .= $str1[0];
                $marks .= $str1[1];
            }
            else
            { 
                $subject_ids .= ",".$str1[0];
                $marks .= ",".$str1[1];
            } 
        }  
        
        $marks_array = explode(",",$marks);
        $subject_array = explode(",",$subject_ids);
        
        $subject_list = $this->report_card_model->get_report_card_subject_list($reporting_cr_period_id,$subject_array,$this->input->cookie('school_id',true));
        $i = 1; 
        $output='<input type="hidden"  id="total_subject" value="'.count($subject_list).'"   />';
        foreach($subject_list as $subject)
        {   
            $index = array_search($subject->subject_id,$subject_array);
            if(array_search($subject->subject_id,$subject_array) >= 0)
            {
                $maximum_marks = $marks_array[$index];
            }
            else
            {
                $maximum_marks = '';
            }
            
            $output .='<div class="row"> 
                <div class="col-sm-3" style="margin-top:10px;"> 
                    <label>'.$subject->subject_name.': </label> 
                </div> 
                <div class="col-sm-2" style="margin-top:10px; ">  
                '.$maximum_marks.' 
                </div>
                <div class="col-sm-2" style="margin-top:10px; "> 
                    <input type="hidden"  name="subject_ids[]"   value="'.$subject->subject_id.'"   />
                    <input type="hidden"  name="maximum_marks[]" id="maximum_marks'.$i.'" value="'.$maximum_marks.'"   />
	                <input type="text" class="form-control " id="obtained_marks'.$i.'"  name="obtained_marks[]" value="'.$subject->marks_obtained.'"   style=" float:left;margin-right:8px;background-color:#ffffff;height: 30px;width: 70px;" placeholder="" />
                </div>  
            </div>';
            
            $i++;
        }
        $output .='<div class="col-md-12 text-center" style="margin-top:40px;margin-bottom:30px;">  
                    <input type="submit" class="check1 btn btn-success col-md-3 text-center "   value="Submit">&nbsp;&nbsp;
                    <a href="'.base_url().'class-register-student-report-card-pdf/'.base64_encode($class_register_student_id).'-'.base64_encode($class_register_id).'-'.base64_encode($reporting_cr_period_id).'"  class="check1 btn btn-success col-md-3 text-center "  target="_blank" style="margin-left:50px;"  value="">Print Report Card</a>
                </div>';
         
        $data['output'] = $output;
	    
        $data['class_register_student_id'] = $class_register_student_id;
	    $data['class_register_id'] = $class_register_id;  
		$data['class_name'] = $student_info['class_name_section'];
		$data['student_name'] = $student_info['first_name']." ".$student_info['last_name'];
		$data['course_stream'] =$student_info['course_stream'];
		$data['registration_no'] =$student_info['registration_no'];
		$data['date_of_birth'] =$student_info['date_of_birth'];
		$data['father_name'] = $student_info['father_name'];
		$data['profile_picture'] =''; 
		$data['student_id'] = $student_info['student_id']; 
		
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home'); 
	    $this->load->view('update-class-register-student-report-card',$data); 
	    
	} 
	
	// update class register additional fee 
	public function get_reporting_class_period_subjects()
	{
	    $reporting_cr_period_id = $this->input->post('reporting_cr_period_id', TRUE);
	    $class_register_student_id = $this->input->post('class_register_student_id', TRUE);
	    $class_register_id = $this->input->post('class_register_id', TRUE);
        $reporting_periods_info = $this->report_card_model->get_period_info($reporting_cr_period_id);  
        $subjects = $reporting_periods_info['subjects_marks'];
        $subject_ids = '';
        $marks = '';
        $output = '';
        $str = explode(";",$subjects);
        for($i=0;$i<count($str);$i++)
        { 
            $str1 = explode("|",$str[$i]); 
             
            if($i==0)
            { 
                $subject_ids .= $str1[0];
                $marks .= $str1[1];
            }
            else
            { 
                $subject_ids .= ",".$str1[0];
                $marks .= ",".$str1[1];
            } 
        }  
        
        $marks_array = explode(",",$marks);
        $subject_array = explode(",",$subject_ids);
        
        $subject_list = $this->report_card_model->get_report_card_subject_list($reporting_cr_period_id,$subject_array,$this->input->cookie('school_id',true));
        $i = 1; 
        
        $output='<input type="hidden"  id="total_subject" value="'.count($subject_list).'"   />';
        
        foreach($subject_list as $subject)
        {   
            $index = array_search($subject->subject_id,$subject_array);
            if(array_search($subject->subject_id,$subject_array) >= 0)
            {
                $maximum_marks = $marks_array[$index];
            }
            else
            {
                $maximum_marks = '';
            }
            
            $output .='<div class="row"> 
                <div class="col-sm-3" style="margin-top:10px;"> 
                    <label>'.$subject->subject_name.': </label> 
                </div> 
                <div class="col-sm-2" style="margin-top:10px; ">  
                '.$maximum_marks.' 
                </div>
                <div class="col-sm-2" style="margin-top:10px; "> 
                    <input type="hidden"  name="subject_ids[]" value="'.$subject->subject_id.'"   />
                    <input type="hidden" id="maximum_marks'.$i.'" name="maximum_marks[]" value="'.$maximum_marks.'"   />
	                <input type="text" class="form-control " id="obtained_marks'.$i.'"   name="obtained_marks[]" value="'.$subject->marks_obtained.'"   style=" float:left;margin-right:8px;background-color:#ffffff;height: 30px;width: 70px;" placeholder="" />
                </div>  
            </div>';
            
            $i++;
        }
        
        
        $output .='<div class="col-md-12 text-center" style="margin-top:30px;">  
                    <input type="submit" class="check1 btn btn-success col-md-3 text-center "   value="Submit">&nbsp;&nbsp;
                    <a href="'.base_url().'class-register-student-report-card-pdf/'.base64_encode($class_register_student_id).'-'.base64_encode($class_register_id).'-'.base64_encode($reporting_cr_period_id).'"  class="check1 btn btn-success col-md-3 text-center " target="_blank"  style="margin-left:50px;"  value="">Print Report Card</a>
                </div>';
        
         echo  $output;
        
	}
	
	
	
	// update class register additional fee 
	public function update_class_register_report_card_process()
	{ 
        $subject_ids = $this->input->post('subject_ids', TRUE);
        $maximum_marks = $this->input->post('maximum_marks', TRUE);
        $obtained_marks = $this->input->post('obtained_marks', TRUE);
        $class_register_id = $this->input->post('class_register_id', TRUE);
        $class_register_student_id = $this->input->post('class_register_student_id', TRUE);
        $reporting_cr_period_id = $this->input->post('reporting_cr_period_id', TRUE);
        
            $date_created = $this->session->userdata('current_date_time');  
            $last_updated = $this->session->userdata('current_date_time'); 
	    for($i=0;$i<count($subject_ids);$i++) 
	    {
            $subject_id = $subject_ids[$i];
            $maximum_mark = $maximum_marks[$i];
            $obtained_mark = $obtained_marks[$i];
            $class_insert = $this->report_card_model->insert_update_reporting_class_register_student_marks($class_register_student_id,$reporting_cr_period_id,$subject_id,$maximum_mark,$obtained_mark,$date_created,$last_updated);  
	    } 
	     
        redirect('report-card-class-students/'.base64_encode($class_register_id), 'refresh'); 
	}
	
	
	 // create class_register_student_report_card_pdf
	public function class_register_student_report_card_pdf()
	{   
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
	    
	    $str = explode("-",$this->uri->segment('2')); 
	    $class_register_student_id = base64_decode($str[0]);   
	    $class_register_id = base64_decode($str[1]);   
	    $reporting_cr_period_id = base64_decode($str[2]);   
	    
	     $student_info = $this->class_register_student_model->get_student_info($class_register_student_id);  
	    
		$data['class_name'] = $student_info['class_name_section'];
		$data['student_name'] = $student_info['first_name']." ".$student_info['last_name'];
		$data['registration_no'] =$student_info['registration_no'];
		$data['date_of_birth'] =$student_info['date_of_birth'];
		$data['father_name'] = $student_info['father_name'];   
	     
		
		$reporting_periods_info = $this->report_card_model->get_period_info($reporting_cr_period_id);  
        $subjects = $reporting_periods_info['subjects_marks'];
        $subject_ids = '';
        $marks = '';
        $output = '';
        $str = explode(";",$subjects);
        for($i=0;$i<count($str);$i++)
        { 
            $str1 = explode("|",$str[$i]); 
             
            if($i==0)
            { 
                $subject_ids .= $str1[0];
                $marks .= $str1[1];
            }
            else
            { 
                $subject_ids .= ",".$str1[0];
                $marks .= ",".$str1[1];
            } 
        }  
        
        $marks_array = explode(",",$marks);
        $subject_array = explode(",",$subject_ids);
        
        $subject_list = $this->report_card_model->get_report_card_subject_list($reporting_cr_period_id,$subject_array,$this->input->cookie('school_id',true));
       
        $output .='<tr> 
                <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Subjects</th> 
                <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Maximum Marks</th>  
                <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Obtained Marks</th>   
            </tr>';
        
        
        foreach($subject_list as $subject)
        {   
            $index = array_search($subject->subject_id,$subject_array);
            if(array_search($subject->subject_id,$subject_array) >= 0)
            {
                $maximum_marks = $marks_array[$index];
            }
            else
            {
                $maximum_marks = '';
            }
            
            $output .='<tr>   
                        <td> '.$subject->subject_name.'</td> 
                        <td> '.$maximum_marks.'</td> 
                        <td> '.$subject->marks_obtained.'</td>  
            </tr>';  
        }  
        
        $data['output'] = $output; 
		
	 
        $filename = time()."_classregister_reportcard.pdf"; 
        $html = $this->load->view('classregister_student_reportcard_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/classregisterstudentreportcard/".$filename, "F");
        $filepath = base_url()."assets/pdfs/classregisterstudentreportcard/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
	
	
}
