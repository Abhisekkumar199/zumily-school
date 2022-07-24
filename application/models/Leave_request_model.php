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

class Leave_request_model extends CI_Model {
 
    private $_table = 'student_leave_requests';  
    
    //update leave requests		
	public function update_leave_request($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("student_leave_request_id", $id); 
		$this->db->update($this->_table, $data); 
		
		//echo $this->db->last_query();
		//die();
		return $this->db->affected_rows();  
	} 
	
	// get leave requests info
    public function get_leave_request_info($id)
    { 
        $this->db->select('s.*,t.first_name as teacher_first_name,t.last_name as teacher_last_name,s1.first_name as student_first_name,s1.last_name as student_last_name,s1.profile_picture ,s1.address as student_address,s.comment,s.request_status,s.read_by,s.approved_by');
        $this->db->from('student_leave_requests as s')->join('teachers as t', 's.class_teacher_id = t.teacher_id')->join('students as s1', 's.student_id = s1.student_id');
        $this->db->where('s.student_leave_request_id',$id); 
        $query =  $this->db->get(); 
         
        return $query->row_array(); 
    } 
    
  
    
    // get leave requests images
    public function get_leave_request_images($id)
    { 
        $this->db->select('image_name,student_leave_request_id');
        $this->db->from('student_leave_request_images');
        $this->db->where('student_leave_request_id',$id); 
        $query =  $this->db->get(); 
        $res =  $query->result();  
        return $res; 
    } 
    
    public function get_leave_request_list($session_id,$class_register_id,$status,$is_session_changed)
    { 
		$this->db->select('s.*,s1.first_name,s1.last_name,s1.profile_picture');
        $this->db->from('student_leave_requests as s')->join('teachers as t', 's.class_teacher_id = t.teacher_id');
        $this->db->join('students s1', "s.student_id = s1.student_id");  
	    $this->db->where("s.session_id", $session_id);   
	    
        if($class_register_id != '' and $is_session_changed == 0)
        {
		    $this->db->where("s.class_register_id", $class_register_id);   
        }
        
        if($status != '')
        {
		    $this->db->where("s.request_status", $status);  
        } 
        $this->db->order_by('s.start_date','desc');    
        $query =  $this->db->get(); 
        return $query->result();  
    }  
    
    
    public function get_unread_leave_request_list($school_id)
    {
         
        $school_id = "s.school_id=$school_id ";
         
		$this->db->select('s.student_leave_request_id,s.class_name,s.request_title,s1.first_name,s1.last_name,s1.profile_picture,s.read_by,TIMESTAMPDIFF(MINUTE, s.date_created, now()) as minute_ago,TIMESTAMPDIFF(HOUR, s.date_created, now()) as hour_ago,TIMESTAMPDIFF(DAY, s.date_created, now()) as day_ago,TIMESTAMPDIFF(MONTH, s.date_created, now()) as month_ago,TIMESTAMPDIFF(YEAR, s.date_created, now())  as year_ago');
        $this->db->from('student_leave_requests s')->join('students as s1', 's.student_id = s1.student_id');
        $this->db->where($school_id);  
        $this->db->where('request_status','2');  
        $this->db->order_by('s.start_date','desc');    
        $query =  $this->db->get(); 
        $res =  $query->result();
        //echo $this->db->last_query();
		//die();
        return $res;
    }  
	
	//delete leave requests		
	public function delete_leave_request($id) 
	{  
	    $this->db->where('student_leave_request_id', $id);
        $this->db->delete($this->_table); 
		return $this->db->affected_rows();  
	} 
	
    
}
