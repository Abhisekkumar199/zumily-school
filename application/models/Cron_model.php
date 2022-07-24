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

class Cron_model extends CI_Model {
    
    
    // get system created user whose password is null 
    public function get_user_where_password_null()
    { 
		$this->db->select('s.school_name,u.user_id,u.mobile_no,u.is_teacher,u.total_reminders_sent');
        $this->db->from('users u');     
        $this->db->join('schools as s', 'u.created_by_school_id = s.school_id');
		$this->db->where("u.password", ''); 
		$this->db->where("u.total_reminders_sent", 0); 
	    $query =  $this->db->get(); 
        $res =  $query->result();
        return $res; 
    } 
    
    
    // get system created user whose password is null with interval 
    public function get_user_where_password_null_with_interval()
    { 
        $last_remider_date = date('Y-m-d',strtotime("-7 days"));
		$this->db->select('s.school_name,u.user_id,u.mobile_no,u.is_teacher,u.total_reminders_sent');
        $this->db->from('users u');     
        $this->db->join('schools as s', 'u.created_by_school_id = s.school_id');
		$this->db->where("u.password", ''); 
		$this->db->where("u.last_reminder_sent <=", $last_remider_date); 
		$this->db->where("u.total_reminders_sent <", "3"); 
	    $query =  $this->db->get(); 
        $res =  $query->result();
        return $res; 
    } 
      
    //insert system  created account reminder
    public function insert_system_created_ac_reminder($data)
    {
        $this->db->insert('system_created_ac_reminders', $data); 
		return $this->db->affected_rows();  
    }
    
    //update system  created account reminder
    public function update_system_created_ac_reminder($data,$id)
    {
        $this->db->set($data); 
		$this->db->where("user_id", $id); 
		$this->db->update('system_created_ac_reminders', $data);  
		return  $this->db->affected_rows(); 
    }
    
    
    // get notification 
    public function get_notification($rand_number)
    { 
		$this->db->select('n.notification_id,n.payload_id,n.title,n.payload_type,n.description,u.fcm_key,s.school_logo,n.is_updated');
        $this->db->from('notifications as n');     
        $this->db->join('schools as s', 'n.school_id = s.school_id'); 
        $this->db->join('users as u', 'n.user_id = u.user_id'); 
		$this->db->where("n.sent_status", $rand_number); 
	    $query =  $this->db->get();  
        $res =  $query->result(); 
        return $res; 
    } 
    
    // get leave request notification for parent
    public function get_leave_request_notification_for_parent($rand_number)
    { 
		$this->db->select('slr.request_status,slr.notification_to_teacher,slr.notification_to_parent,slr.student_leave_request_id,slr.request_title,slr.request_reason,u.fcm_key,s.school_logo,slr.comment');
        $this->db->from('student_leave_requests as slr');     
        $this->db->join('schools as s', 'slr.school_id = s.school_id'); 
        $this->db->join('users as u', 'slr.user_id = u.user_id'); 
		$this->db->where("slr.notification_to_parent", $rand_number); 
		$this->db->where("slr.request_status !=", '2'); 
	    $query =  $this->db->get(); 
        $res =  $query->result(); 
        return $res; 
    }
    
    // get leave request notification for teacher
    public function get_leave_request_notification_for_teacher($rand_number)
    { 
		$this->db->select('slr.request_status,slr.notification_to_teacher,slr.notification_to_parent,slr.student_leave_request_id,slr.request_title,slr.request_reason,u.fcm_key,s.school_logo,slr.comment');
        $this->db->from('student_leave_requests as slr');     
        $this->db->join('schools as s', 'slr.school_id = s.school_id'); 
        $this->db->join('teacher_user_xref as tux', 'slr.class_teacher_id = tux.teacher_id');
        $this->db->join('users as u', 'tux.user_id = u.user_id');   
		$this->db->where("slr.notification_to_teacher", $rand_number); 
		$this->db->where("slr.request_status", '2'); 
	    $query =  $this->db->get(); 
        $res =  $query->result(); 
        return $res; 
    } 
    
    //insert notification
    public function insert_notification($data)
    {
        $this->db->insert('notifications', $data); 
		return $this->db->affected_rows();  
    }
    
    // update homework notification 
    public function update_homework_notification($notification_data,$payload_type,$payload_id)
    {
        $this->db->set($notification_data); 
		$this->db->where("payload_id", $payload_id); 
		$this->db->where("payload_type", $payload_type); 
		$this->db->update('notifications', $notification_data);  
		return  $this->db->affected_rows(); 
    }
    
    
    // update notification random number
    public function update_notification_rand_number($data)
    {
        $this->db->set($data); 
		$this->db->where("sent_status", '0'); 
		$this->db->update('notifications', $data);  
		return  $this->db->affected_rows(); 
    }
    
    // update notification random number for parent leave request
    public function update_notification_rand_number_for_parent($data)
    {
        $this->db->set($data); 
		$this->db->where("notification_to_parent", '0'); 
		$this->db->where("request_status !=", '2'); 
		$this->db->update('student_leave_requests', $data);  
		return  $this->db->affected_rows(); 
    }
    
    // update notification random number for teacher leave request
    public function update_notification_rand_number_for_teacher($data)
    {
        $this->db->set($data); 
		$this->db->where("notification_to_teacher", '0'); 
		$this->db->where("request_status", '2'); 
		$this->db->update('student_leave_requests', $data);  
		return  $this->db->affected_rows(); 
    }
    
    // update notification
    public function update_notification($data,$id)
    {
        $this->db->set($data); 
		$this->db->where("notification_id", $id); 
		$this->db->update('notifications', $data);  
		return  $this->db->affected_rows(); 
    }
    
     // update notification leave request
    public function update_leave_request_notification($data,$id)
    {
        $this->db->set($data); 
		$this->db->where("student_leave_request_id", $id); 
		$this->db->update('student_leave_requests', $data);  
		return  $this->db->affected_rows(); 
    }
    
    // checking searchable data exist or not
	public function check_seachable_data($school_id,$student_id,$type) 
	{  
        $result = $this->db->select('searchable_data_id')->get_where('searchable_data', array('school_id' => $school_id,'pointer_id' => $student_id,'pointer_type' => $type));
        $this->db->last_query();
        return $result->row_array();  
	}
	
	//insert seachable data
    public function insert_seachable_data($data)
    {
        $this->db->insert('searchable_data', $data); 
		return $this->db->affected_rows();  
    }
	
	// update seachable data
    public function update_seachable_data($data,$id)
    {
        $this->db->set($data); 
		$this->db->where("searchable_data_id", $id); 
		$this->db->update('searchable_data', $data);  
		return  $this->db->affected_rows(); 
    } 
    
    //insert cron monitoring
    public function insert_cron_monitoring($data)
    {
        $this->db->insert('monitoring_crons', $data); 
		return $this->db->affected_rows();  
    }
    
    // delete notification
    public function delete_notification($payload_id,$payload_type)
    { 
        $this -> db -> where('payload_id', $payload_id);
        $this -> db -> where('payload_type', $payload_type);
        $this -> db -> delete('notifications');
    }  
    
}
