<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessionyear extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();   
    }
	 
    // session list 
	public function sessionList()
	{   
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['session_lists'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));
		$data['totalrecord'] =count($data['session_lists']);
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('session-list',$data); 
		$this->load->view('include/right_sidebar'); 
	}
	
	// add session view
	public function addSession()
	{ 
	    $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
	    
	    $current_year = date('Y'); 
	    $previous_year = $current_year - 1;
	    
		$data['session_years'] = $this->session_model->get_session_year($current_year,$previous_year);
	    
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-session');
		$this->load->view('include/right_sidebar'); 
	}
	
	// edit session view
	public function editSession()
	{
	    $current_year = date('Y'); 
	    $previous_year = $current_year - 1;
        $session_id = base64_decode($this->uri->segment('2'));  
        $data['session_info'] = $this->session_model->get_session_info($session_id); 
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
		$data['session_years'] = $this->session_model->get_session_year($current_year,$previous_year);
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('add-session',$data);
		$this->load->view('include/right_sidebar');
	    
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
	
	// add and edit session process
	public function addSessionProcess()
	{  
	    $sessionId = $this->input->post('sessionId', TRUE);   
        if($sessionId == '')
        {
            $school_id = $this->input->cookie('school_id',true);
            $session_year_id = $this->input->post('session_year_id', TRUE);
            
            $session_year_data = $this->session_model->get_session_year_info($session_year_id); 
            
            $session_year = $session_year_data['session_year'];
            $session_start_year = $session_year_data['session_start_year'];
            
            $data['session_year_id'] = $this->input->post('session_year_id', TRUE);
            $data['session_year'] = $session_year;
            $data['session_start_year'] = $session_start_year;
            $data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date')));
            $data['end_date'] = date("Y-m-d",strtotime($this->input->post('end_date')));
            $data['is_saturday_off'] = $this->input->post('is_saturday_off', TRUE);
            $data['school_id'] = $school_id;
            $data['date_created'] = $this->session->userdata('current_date_time');  
            $data['last_updated'] = $this->session->userdata('current_date_time'); 
            
            
            $start    = new DateTime($this->input->post('start_date'));
            $end      = new DateTime($this->input->post('end_date'));
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
            
            $year_month = '';
            
            foreach ($period as $dt) {
                  if($year_month == '')
                  {
                      $year_month =$dt->format("Ym");
                }
                else
                {
                    $year_month .= ",".$dt->format("Ym");
                    } 
            }
            
            $data['session_year_months'] = $year_month;    
                  
           $session_insert = $this->session_model->insert_session($data);  
            for($j=1;$j<=2;$j++)
            {  
                for($i=1;$i<=12;$i++)
                {
                    if(strlen($i) == 1)
                    {
                        $i = "0".$i;
                    }
                    
                    $year_month = $session_start_year.$i;  
                    $check_if_year_month_exist = $this->calendar_model->check_school_calendar($school_id,$year_month);  
                    
                    if($check_if_year_month_exist < 1)
                    {
                        for($k=1;$k<=31;$k++)
                        {
                            if(strlen($k) == 1)
                            {
                                $k = "0".$k;
                            }
                            $day  = "day_".$k;
                            $calendar_data[$day] = "";
                        }
                         
                        foreach ($this->getSundays($session_start_year, $i) as $sunday) 
                        {
                            $day = "day_".$sunday->format("d");
                            $calendar_data[$day] = "O,Sunday Off";
                        }
                        
                        if($this->input->post('is_saturday_off', TRUE) == 1)
                        {
                            foreach ($this->getSaturdays($session_start_year, $i) as $saturday) 
                            {
                                $day = "day_".$saturday->format("d");
                                $calendar_data[$day] = "O,Saturday Off";
                            }
                        } 
                        
                        $calendar_data['school_id'] = $school_id;
                        $calendar_data['YYYYMM'] = $year_month;  
                        
                        $calendar_insert = $this->calendar_model->insert_school_calendar($calendar_data); 
                        
                        
                    }
                } 
                $session_start_year = $session_start_year + 1; 
            } 
            
            
	        if (!empty($session_insert)) 
            {
                $sdata['success'] = 'Session added successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('sessions-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-session', 'refresh');
            } 
        }
        else
        {  
            $data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date')));
            $data['end_date'] = date("Y-m-d",strtotime($this->input->post('end_date')));
            $data['is_saturday_off'] = $this->input->post('is_saturday_off', TRUE); 
            $data['last_updated'] = $this->session->userdata('current_date_time');  
            $session_update = $this->session_model->update_session($data,$sessionId); 
            if (!empty($session_update)) 
            {
                $sdata['success'] = 'Session updated successfully. '; 
                $this->session->set_userdata($sdata);
                redirect('sessions-list', 'refresh');
            } 
            else 
            {
                $sdata['exception'] = 'Something went wrong!! Please try again.';  
                $this->session->set_userdata($sdata);
                redirect('add-session', 'refresh');
            } 
        }
         
	}
	
	// enable session
	public function enableSession()
	{  
	    $sessionId = $this->uri->segment('2');  
        $data['is_active'] = 1; 
        $data['last_updated'] = $this->session->userdata('current_date_time');  
         
        $session_insert = $this->session_model->update_session($data,$sessionId); 
        if(!empty($session_insert)) 
        {
            $sdata['success'] = 'Session enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('sessions-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('sessions-list', 'refresh');
        }  
         
	}
	
	// disable session
	public function disableSession()
	{  
	    $sessionId = $this->uri->segment('2');  
        $data['is_active'] = 0; 
        $data['last_updated'] = date('Y-m-d H:i:s'); 
         
        $subject_insert = $this->session_model->update_session($data,$sessionId); 
        if (!empty($subject_insert)) 
        {
            $sdata['success'] = 'Session enabled successfully. '; 
            $this->session->set_userdata($sdata);
            redirect('sessions-list', 'refresh');
        } 
        else 
        {
            $sdata['exception'] = 'Something went wrong!! Please try again.';  
            $this->session->set_userdata($sdata);
            redirect('sessions-list', 'refresh');
        }  
	}
	
	// check session  
	public function checkSession()
	{  
	     $session_year = $this->input->post('session_year', TRUE); 
	     $sessionId = $this->input->post('sessionId', TRUE);  
	     $schoolId = $this->input->cookie('school_id',true);
        echo $check_session = $this->session_model->check_session($session_year,$schoolId,$sessionId);
	    
	}
	
	// check session start date 
	public function checkSessionStartDate()
	{  
        $start_date =  $this->input->post('start_date', TRUE);   
        $schoolId = $this->input->cookie('school_id',true);
        echo $previous_session_end_date = $this->session_model->check_session_start_date($start_date,$schoolId);
        
	    
	}
	
	
	// create subject pdf
	public function create_session_pdf()
	{  
	      
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));
		$data['session_lists'] = $this->session_model->get_session_list($this->input->cookie('school_id',true));
		$filename = md5($this->input->cookie('school_id',true))."_session_list.pdf";   
        $html = $this->load->view('session_pdf',$data,true); 
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/session/".$filename, "F");
        $filepath = base_url()."assets/pdfs/session/".$filename;
        
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath);
        
        
        
	}
	
	 
}
