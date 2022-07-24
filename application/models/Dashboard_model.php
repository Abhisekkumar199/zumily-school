<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* #********************************************#
  #                   ClusterCoding             #
  #*********************************************#
  #      Author:     ClusterCoding              #
  #      Email:      info@clustercoding.com     #
  #      Website:    http://clustercoding.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2017 - ClusterCoding   #
  #                                             #
  #*********************************************# */

class Dashboard_model extends CI_Model {
 
    private $_users = 'schools';  
      
    // school attendance daywise
    public function school_attendance_daywise($school_id,$attendance_date)
    {  
//		$this->db->select(' cr.class_register_id, cr.total_students, am.class_name_section, cr.room_no, am.done_by,am.last_updated, am.total_presents, am.total_absents, am.total_leaves');
		$this->db->select(' cr.class_register_id, cr.total_students, cr.class_name_section, cr.room_no, am.done_by,am.last_updated, am.total_presents, am.total_absents, am.total_leaves');
        $this->db->from('class_registers cr');     
        $this->db->join('attendance_monitoring am', "(cr.class_register_id = am.class_register_id and am.attendance_date = '".$attendance_date."')", 'left outer'); 
		$this->db->where("cr.school_id", $school_id); 
		$this->db->where("cr.is_active", '1');  
        $this->db->order_by('cr.class_name_section','asc');      
	    $query =  $this->db->get();  
        $res =  $query->result();
        return $res; 
    }  
    
    // dashboard leave request list
    public function dashboard_leave_request_list($school_id,$start_date,$end_date)
    {  
        $condition = "((start_date >='" . $start_date . "' and start_date <='".$end_date."') or (start_date <='" . $end_date . "' and end_date >='".$start_date."'))"; 
        
		$this->db->select('slr.leave_requests_images,slr.request_reason,slr.student_leave_request_id,slr.date_created,s.profile_picture, s.first_name, s.last_name, slr.class_name, slr.start_date, slr.end_date,
	 slr.request_title, slr.request_status, slr.approved_by');
        $this->db->from('student_leave_requests slr');     
        $this->db->join('students s', "slr.student_id = s.student_id"); 
		$this->db->where("slr.school_id", $school_id); 
		$this->db->where($condition);   
        $this->db->order_by('slr.start_date','desc');      
	    $query =  $this->db->get();  
        $res =  $query->result();
        return $res; 
    }  
    
    // dashboard holiday list
    public function dashboard_holidays_list($school_id,$start_date,$end_date)
    {  
        $condition = "((holiday_start_date >='" . $start_date . "' and holiday_start_date <='".$end_date."') or (holiday_start_date <='" . $end_date . "' and holiday_end_date >='".$start_date."'))"; 
		$this->db->select('holiday_start_date, holiday_end_date, holiday_name');
        $this->db->from('holidays');       
		$this->db->where("school_id", $school_id); 
		$this->db->where($condition);   
        $this->db->order_by('holiday_start_date','desc');      
	    $query =  $this->db->get();  
        $res =  $query->result();
        return $res; 
    } 
    
    // dashboard message list
    public function dashboard_message_list($school_id,$start_date,$end_date)
    {  
        $end_date = $end_date." 23:59:59";
        $condition = "(m.date_created  >='" . $start_date . "' and m.date_created <= '".$end_date."')"; 
        
		$this->db->select('m.message_id,m.description,m.title, m.date_created, m.total_views, m.message_type_display_name,m.is_createdby_teacher,m.sending_to,m.message_images');
        $this->db->from('messages m');      
		$this->db->where("m.school_id", $school_id); 
		$this->db->where($condition);   
        $this->db->order_by('m.date_created','desc');      
	    $query =  $this->db->get();  
	     
        $res =  $query->result();
        return $res; 
    } 
    
    // dashboard message list
    public function dashboard_event_list($school_id,$start_date,$end_date)
    {   
        $condition = "(e.start_date  >='" . $start_date . "' and e.start_date <= '".$end_date."')"; 
        
		$this->db->select('e.event_id,e.description,e.title,e.date_created, e.start_date, e.start_time,e.end_time, e.total_views,e.is_createdby_teacher,e.sending_to,e.event_images');
        $this->db->from('events e');      
		$this->db->where("e.school_id", $school_id); 
		$this->db->where($condition);   
        $this->db->order_by('e.start_date','desc');      
	    $query =  $this->db->get();   
        $res =  $query->result();
        
        //echo $this->db->last_query();
        //die();
        return $res; 
    } 
      
    // checking email exist or not
	public function emailCheck($data) 
	{ 
	    $condition = "email_id =" . "'" . $data['email_id'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	
	// checking school email exist or not
	public function check_school_email($email_id,$school_id) 
	{  
        $condition = "email_id =" . "'" . $email_id . "' and school_id !='".$school_id."'"; 
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}
	
	// checking mobile exist or not
	public function mobileCheck($data) 
	{ 
	    $condition = "phone =" . "'" . $data['phone'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
    public function store_school($data)
    {
        $this->db->insert($this->_users, $data);
        return $this->db->insert_id();
    }
    
    // insert school payment reminder
    public function school_payment_reminder($data)
    {
        $this->db->insert('school_payment_reminders', $data);
        return $this->db->insert_id();
    }
    
    //update user		
	public function updateSchool($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("school_id", $id); 
		$this->db->update($this->_users, $data); 
	     
		return  $this->db->affected_rows();  
	} 
	
	//verify school email	 	
	public function verifySchool($data,$emailid) 
	{ 
		$this->db->set($data); 
		$this->db->where("email_id", $emailid); 
		$this->db->update($this->_users, $data); 
		return $this->db->affected_rows();  
	} 
	
	//verify school	mobile 	
	public function verifyMobile($data,$mobileno) 
	{ 
		$this->db->set($data); 
		$this->db->where("phone", $mobileno); 
		$this->db->update($this->_users, $data); 
		return $this->db->affected_rows();  
	}  
	
	//verify school	mobile 	
	public function check_old_password($old_password,$school_id) 
	{ 
		$condition = "password =" . "'" . md5($old_password) . "' and school_id =" . "'" . $school_id . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//die();
        return $query->num_rows();  
	}
	
	// checking username and password for login
	public function login($data) 
	{ 
	    $condition = "(email_id =" . "'" . $data['email_id'] . "' OR phone = " . "'" . $data['email_id'] . "') AND " . "password =" . "'" . $data['password'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
       return $query->row(); 
	}
	
	// checking username and password for login
	public function is_school_verified($data) 
	{ 
	    $condition = "(email_id =" . "'" . $data['email_id'] . "' OR phone =" . " '" . $data['email_id'] . "' ) AND " . "password =" . "'" . $data['password'] . "' AND is_verified='1'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//die();
       return $query->row(); 
	}
    
    public function get_school_info($school_id)
    { 
        $result = $this->db->get_where($this->_users, array('school_id' => $school_id));
        return $result->row_array(); 
    } 
    public function get_school_info_by_email($email_id)
    { 
        $result = $this->db->get_where($this->_users, array('email_id' => $email_id));
        return $result->row_array(); 
    } 
    
    public function get_school_info_by_mobile($mobile)
    { 
        $result = $this->db->get_where($this->_users, array('phone' => $mobile));
        return $result->row(); 
    } 
}
