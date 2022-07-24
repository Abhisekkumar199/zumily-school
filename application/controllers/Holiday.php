<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	 
	// holiday list  
 	public function holidayList()
	{ 
	    $selected_session_id = base64_decode($this->input->get('session_year', TRUE));
	   
	    $current_date = date('Y-m-d');
	    
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	    $current_session_year = $session_data[0]->session_year; 
	     
		if($selected_session_id != '')
		{
		    $session_id = $selected_session_id;  
		    $data['selected_session'] = $selected_session_id;
		}
		else
		{
		    $session_id = $current_session_id;
		    $data['selected_session'] = $current_session_id; 
		}
		 
		 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['holiday_lists'] = $this->holiday_model->get_holiday_list($session_id,$this->input->cookie('school_id',true));
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true)); 
		$data['totalrecord'] =count($data['holiday_lists']);
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('holiday-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	
	// add holiday view
	public function addHoliday()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['session_years'] = $this->session_model->get_active_session_list($this->input->cookie('school_id',true)); 
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home',$data);
	    $this->load->view('add-holiday');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit holiday view
	public function editHoliday()
	{
        $session_id = $this->uri->segment('2'); 
        $data['session_info'] = $this->holiday_model->get_holiday_info($session_id); 
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['session_years'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-holiday',$data);
		$this->load->view('include/right_sidebar');
	    
	}
	
	// add and edit holiday process
	public function addHolidayProcess()
	{   
        $school_id = $this->input->cookie('school_id',true);
        
        $holidayId = $this->input->post('holiday_id', TRUE); 
        $session_id = $this->input->post('session_year', TRUE); 
        
        $session_info = $this->session_model->get_session_info($session_id); 
        $is_saturday_off = $session_info['is_saturday_off'];
        
        $holiday_start_date= date("Y-m-d",strtotime($this->input->post('holiday_start_date', TRUE)));
        if($this->input->post('holiday_end_date', TRUE) == '')
        { 
            $holiday_end_date = ''; 
        }
        else
        {
            $holiday_end_date = date("Y-m-d",strtotime($this->input->post('holiday_end_date', TRUE)));  
        }
        $holiday_name = ltrim(rtrim($this->input->post('holiday_name', TRUE),' '),' ');
         
        $check_holiday = $this->holiday_model->check_holiday_by_name($school_id,$holidayId,$session_id,$holiday_name);
         
        if($check_holiday == 0)
        {
            $check_holiday_by_date = $this->holiday_model->check_holiday_by_date($school_id,$holidayId,$session_id,$holiday_start_date,$holiday_end_date); 
            if($check_holiday_by_date == 0)
            {
                if($holidayId == '')
                {
                    $data['session_id'] = $this->input->post('session_year', TRUE);
                    if($this->input->post('holiday_start_date') != '')
                    { 
                        $data['holiday_start_date'] = date("Y-m-d",strtotime($this->input->post('holiday_start_date')));
                    }
                    if($this->input->post('holiday_end_date') != '')
                    {
                        $data['holiday_end_date'] = date("Y-m-d",strtotime($this->input->post('holiday_end_date'))); 
                    }
                    else
                    {
                        $data['holiday_end_date'] = date("Y-m-d",strtotime($this->input->post('holiday_start_date'))); 
                    }
                    $data['holiday_name'] = ucwords(ltrim(rtrim($this->input->post('holiday_name', TRUE),' '),' '));
                    $data['school_id'] = $school_id;
                    $data['date_created'] = $this->session->userdata('current_date_time');  
                    $data['last_updated'] = $this->session->userdata('current_date_time');  
                    $holiday_insert = $this->holiday_model->insert_holiday($data); 
                    
                    
                    if($this->input->post('holiday_start_date') == $this->input->post('holiday_end_date'))
                    {
                        if(date('l', strtotime($this->input->post('holiday_start_date'))) != 'Sunday')
                        {
                            if($is_saturday_off != 1)
                            {
                                $year_month = date("Ym",strtotime($this->input->post('holiday_start_date')));
                                $day = "day_".date("d",strtotime($this->input->post('holiday_start_date')));
                                $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE); 
                                $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$year_month,$school_id);
                            }
                            else
                            {
                                if(date('l', strtotime($this->input->post('holiday_start_date'))) != 'Saturday')
                                {
                                    $year_month = date("Ym",strtotime($this->input->post('holiday_start_date')));
                                    $day = "day_".date("d",strtotime($this->input->post('holiday_start_date')));
                                    $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE); 
                                    $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$year_month,$school_id);
                                }
                            }
                        }
                    }
                    else
                    {
                        $start_date = new DateTime(date("Y-m-d",strtotime($this->input->post('holiday_start_date')))); 
                        $end_date = new DateTime(date('Y-m-d', strtotime($this->input->post('holiday_end_date') . ' +1 day'))); 
                        $daterange = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
                        $current_year_month = '';
                        foreach($daterange as $date)
                        {
                            if(date('l', strtotime($date->format("Y-m-d"))) != 'Sunday')
                            {
                                if($is_saturday_off != 1)
                                {
                                    $year_month = $date->format("Ym"); 
                                    if($current_year_month == $year_month or $current_year_month == '')
                                    {
                                        $day = "day_".$date->format("d");
                                        $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE);
                                    }
                                    else
                                    {  
                                        $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id);
                                        
                                        $calendar_data = (array) null; 
                                        
                                        $day = "day_".$date->format("d");
                                        $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE); 
                                    }  
                                }
                                else
                                {
                                    if(date('l', strtotime($date->format("Y-m-d"))) != 'Saturday')
                                    {
                                        $year_month = $date->format("Ym"); 
                                        if($current_year_month == $year_month or $current_year_month == '')
                                        {
                                            $day = "day_".$date->format("d");
                                            $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE);
                                        }
                                        else
                                        {  
                                            $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id);
                                            
                                            $calendar_data = (array) null; 
                                            
                                            $day = "day_".$date->format("d");
                                            $calendar_data[$day] = "H,".$this->input->post('holiday_name', TRUE); 
                                        }
                                    }
                                }  
                                $current_year_month = $year_month;  
                            }
                        } 
                        
                        $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id);
                         
                    }
                     
                    if (!empty($holiday_insert)) 
                    { 
                        echo  'added';  
                    } 
                    else 
                    {
                        echo 'Something went wrong!! Please try again.';   
                    } 
                }
                else
                { 
                    $data['session_id'] = $this->input->post('session_year', TRUE);
                    if($this->input->post('holiday_start_date') != '')
                    { 
                        $data['holiday_start_date'] = date("Y-m-d",strtotime($this->input->post('holiday_start_date')));
                    }
                    if($this->input->post('holiday_end_date') != '')
                    {
                        $data['holiday_end_date'] = date("Y-m-d",strtotime($this->input->post('holiday_end_date'))); 
                    }
                    $data['holiday_name'] = ucwords(ltrim(rtrim($this->input->post('holiday_name', TRUE),' '),' ')); 
                    $data['last_updated'] = $this->session->userdata('current_date_time');   
                    $session_update = $this->holiday_model->update_holiday($data,$holidayId); 
                    if (!empty($session_update)) 
                    {
                        //$sdata['success'] = 'Holiday updated successfully. '; 
                        //$this->session->set_userdata($sdata);
                        
                        echo 'updated'; 
                         
                    } 
                    else 
                    {
                        echo 'Something went wrong!! Please try again.';  
                         
                    } 
                }
            }
            else
            {
                echo "<div class='alert alert-danger'>These holiday-dates have already been used by different holiday-name for this session year.</div>";
            } 
        }
        else
        {
            echo "<div class='alert alert-danger'>This holiday name has already been used for this session year.</div>";
        }
        
         
	}
	
	// enable holiday
	public function enableHoliday()
	{  
	    $holidayId = $this->uri->segment('2');  
        $data['is_active'] = '1'; 
        $data['last_updated'] = $this->session->userdata('current_date_time');   
         
        $holiday_update = $this->holiday_model->update_holiday($data,$holidayId); 
        if(!empty($holiday_update)) 
        {
            $sdata['success'] = 'Holiday enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        }  
         
	}
	
	// disable holiday
	public function disableHoliday()
	{  
	    $holidayId = $this->uri->segment('2');  
        $data['is_active'] = '0'; 
        $data['last_updated'] = $this->session->userdata('current_date_time');   
         
        $subject_insert = $this->holiday_model->update_holiday($data,$holidayId); 
        if (!empty($subject_insert)) 
        {
            $sdata['success'] = 'Holiday enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        }  
	}
	
	// delete holiday
	public function deleteHoliday()
	{  
	    $holidayId = $this->uri->segment('2');   
        
        $holiday_info = $this->holiday_model->get_holiday_info($holidayId);  
        
        $school_id = $holiday_info['school_id'];
        $holiday_start_date = $holiday_info['holiday_start_date'];
        $holiday_end_date = $holiday_info['holiday_end_date']; 
        $session_id = $holiday_info['session_id']; 
        
        // getting session info 
        $session_info = $this->session_model->get_session_info($session_id); 
        $is_saturday_off = $session_info['is_saturday_off'];  
        
        
        // update school calendar days to null for the deleting holiday
        
        if($holiday_start_date == $holiday_end_date)
        {
            if(date('l', strtotime($holiday_start_date)) != 'Sunday')
            {
                if($is_saturday_off != 1)
                {
                    $year_month = date("Ym",strtotime($holiday_start_date));
                    $day = "day_".date("d",strtotime($holiday_start_date));
                    $calendar_data[$day] = NULL; 
                    $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$year_month,$school_id);
                }
                else
                {
                    if(date('l', strtotime($holiday_start_date)) != 'Saturday')
                    {
                        $year_month = date("Ym",strtotime($holiday_start_date));
                        $day = "day_".date("d",strtotime($holiday_start_date));
                        $calendar_data[$day] = NULL; 
                        $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$year_month,$school_id);
                    }
                }
            }
        }
        else
        {
            $start_date = new DateTime(date("Y-m-d",strtotime($holiday_start_date))); 
            $end_date = new DateTime(date('Y-m-d', strtotime($holiday_end_date . ' +1 day'))); 
            $daterange = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
            $current_year_month = '';
            foreach($daterange as $date)
            {
                if(date('l', strtotime($date->format("Y-m-d"))) != 'Sunday')
                {
                    if($is_saturday_off != 1)
                    {
                        $year_month = $date->format("Ym"); 
                        if($current_year_month == $year_month or $current_year_month == '')
                        {
                            $day = "day_".$date->format("d");
                            $calendar_data[$day] = NULL; 
                        }
                        else
                        {  
                            $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id); 
                            $calendar_data = (array) null;  
                            $day = "day_".$date->format("d");
                            $calendar_data[$day] = NULL; 
                        }  
                    }
                    else
                    {
                        if(date('l', strtotime($date->format("Y-m-d"))) != 'Saturday')
                        {
                            $year_month = $date->format("Ym"); 
                            if($current_year_month == $year_month or $current_year_month == '')
                            {
                                $day = "day_".$date->format("d");
                                $calendar_data[$day] = NULL; 
                            }
                            else
                            {  
                                $calendar_update = $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id); 
                                $calendar_data = (array) null;  
                                $day = "day_".$date->format("d");
                                $calendar_data[$day] = NULL; 
                            }
                        }
                    }  
                    $current_year_month = $year_month;  
                }
            } 
            
            $this->calendar_model->update_school_calendar($calendar_data,$current_year_month,$school_id); 
        } 
      
        $delete_holiday = $this->holiday_model->delete_holiday($holidayId);   
        
        if (!empty($delete_holiday)) 
        {
            $sdata['success'] = 'Holiday deleted successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('holidays-list', 'refresh');
        }  
	}
	
	
	// get all sunday of a month
	public function getSundays($y, $m)
    {
        return new DatePeriod(
        new DateTime("first sunday of $y-$m"),
        DateInterval::createFromDateString('next sunday'),
        new DateTime("last day of $y-$m")
        );
    }
    
    // get all saturday of a month
	public function getSaturdays($y, $m)
    {
        return new DatePeriod(
        new DateTime("first saturday of $y-$m"),
        DateInterval::createFromDateString('next saturday'),
        new DateTime("last day of $y-$m")
        );
    }
	
	// check holiday  
	public function checkHoliday()
	{  
	     $session_id = $this->input->post('session_year', TRUE); 
	     $data['session_info'] = $this->session_model->get_session_info($session_id); 
	     //print_r($data['session_info']);
         $start_date = $data['session_info']['start_date'];
	     $end_date = $data['session_info']['end_date'];
	     
	     $holidayId = $this->input->post('holiday_id', TRUE);  
	     $schoolId = $this->input->cookie('school_id',true);
          //  $check_holiday = $this->holiday_model->check_holiday($session_id,$schoolId,$holidayId);
         echo $start_date.",".$end_date;
	} 
	
	// create holiday pdf
	public function create_holiday_pdf()
	{  
	     
	   
	    $current_date = date('Y-m-d');
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$session_data = $this->session_model->get_current_session($current_date,$this->input->cookie('school_id',true)); 
	    $current_session_id = $session_data[0]->session_id;
	  
	      
		$data['holiday_lists'] = $this->holiday_model->get_holiday_list($current_session_id,$this->input->cookie('school_id',true)); 
		$filename = md5($this->input->cookie('school_id',true))."_holiday_list.pdf";   
        $html = $this->load->view('holiday_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/holiday/".$filename, "F");
        $filepath = base_url()."assets/pdfs/holiday/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
}
