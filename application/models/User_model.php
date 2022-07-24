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

class User_model extends CI_Model {
 
    private $_table = 'users';  
      
    //insert user 
    public function insert_user($data)
    {
        $this->db->insert($this->_table, $data); 
        return $this->db->insert_id();
    }
    
    //update user		
	public function update_user($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("user_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	// get user info
    public function get_user_info($user_id)
    { 
        $result = $this->db->get_where($this->_table, array('user_id' => $user_id));
       return $result->row(); 
    } 
    
    // get user info by email
    public function get_user_info_by_email($email_id)
    { 
        $result = $this->db->get_where($this->_table, array('email_id' => $email_id));
       return $result->row(); 
    } 
    
    // get user info by mobile
    public function get_user_info_by_mobile($mobile)
    { 
        $result = $this->db->get_where($this->_table, array('mobile_no' => $mobile));
         
        return $result->row_array(); 
    } 
     
	// get user list
    public function get_user_list($school_id)
    {
        $this->db->from($this->_table);   
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('user_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // checking user email exist or not
	public function check_if_user_email_exist($email_id) 
	{  
        $condition = "email_id =" . "'" . $email_id . "'"; 
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}
	
	// checking user mobile exist or not
	public function check_if_user_mobile_exist($mobile_no) 
	{  
        $condition = "mobile_no =" . "'" . $mobile_no . "'"; 
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		  $this->db->last_query(); 
		 
        return $query->num_rows(); 
	}
	
	// checking user exist or not
	public function check_if_user_exist($mobile_no,$first_name,$last_name) 
	{  
        $condition = "mobile_no =" . "'" . $mobile_no . "' and first_name='" . $first_name . "' and last_name='" . $last_name . "'"; 
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		  $this->db->last_query(); 
		 
        return $query->num_rows(); 
	}
	
	//verify user email	 	
	public function verifyUser($data,$emailid) 
	{ 
		$this->db->set($data); 
		$this->db->where("email_id", $emailid); 
		$this->db->update($this->_table, $data);
	 
		return $this->db->affected_rows();  
	} 
	
	
	// checking if user xref exist or not
	public function check_if_user_student_xref_exist($user_id,$student_id) 
	{  
        $condition = "user_id =" . "'" . $user_id . "' and student_id = '" . $student_id . "'  "; 
		$this->db->select('*');
		$this->db->from('student_user_xref');
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}
	
	
	// checking if teacher xref exist or not
	public function check_if_user_teacher_xref_exist($user_id,$teacher_id) 
	{  
        $condition = "user_id =" . "'" . $user_id . "' and teacher_id = '" . $teacher_id . "'  "; 
		$this->db->select('*');
		$this->db->from('teacher_user_xref');
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}
	
	//copy old user data to new user	
	public function copy_old_user_data_to_new_user($new_user_id,$old_user_id) 
	{ 
		$message_delivery_query = $this->db->query("insert into message_user_delivery(user_id, message_id, read_status, read_datetime, delivery_datetime) select $new_user_id , message_id, read_status, read_datetime, delivery_datetime from message_user_delivery  where user_id = $old_user_id and message_id not in (select message_id from message_user_delivery where user_id= $new_user_id)");
		
		$event_delivery_query = $this->db->query("insert into event_user_delivery(user_id, event_id, read_status, read_datetime, delivery_datetime,sameday_reminder_text,twohour_reminder_text) select $new_user_id , event_id, read_status, read_datetime, delivery_datetime,sameday_reminder_text,twohour_reminder_text from event_user_delivery  where user_id = $old_user_id  and event_id not in (select event_id from event_user_delivery where user_id = $new_user_id)");
		
		$notifications_query = $this->db->query("insert into notifications( school_id, payload_id, payload_type, title, description, user_id, read_status, read_datetime, sent_status, sent_datetime, sent_error, date_created) select school_id, payload_id, payload_type, title, description, $new_user_id, read_status, read_datetime, sent_status, sent_datetime, sent_error, date_created from notifications  where user_id = $old_user_id  and (payload_id,payload_type) not in (select payload_id,payload_type from notifications where user_id = $new_user_id)");
	} 
    
}
