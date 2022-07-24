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

class Teacher_model extends CI_Model {
 
    private $_table = 'teachers';  
     
    // checking teacher email exist or not
	public function check_teacher_email($teacher_email,$teacher_id,$school_id) 
	{ 
	    if($teacher_id != '')
	    {
	        $condition = "email_id =" . "'" . $teacher_email . "' and school_id='".$school_id."' and is_active='1' and teacher_id != $teacher_id";
	    }
	    else
	    {
	        $condition = "email_id =" . "'" . $teacher_email . "' and school_id='".$school_id."' and is_active='1'";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		 
        return $query->num_rows(); 
	}
	
    // checking teacher mobile exist or not
	public function check_teacher_mobile($mobile_no,$teacher_id,$school_id) 
	{ 
	    if($teacher_id != '')
	    {
	        $condition = "mobile_no =" . "'" . $mobile_no . "' and school_id='".$school_id."' and is_active='1' and teacher_id != $teacher_id";
	    }
	    else
	    {
	        $condition = "mobile_no =" . "'" . $mobile_no . "' and school_id='".$school_id."' and is_active='1'";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
    //insert teacher 
    public function insert_teacher($data)
    {
        $this->db->insert($this->_table, $data);  
		return $this->db->insert_id();   
    }
    
    //update teacher		
	public function update_teacher($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("teacher_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	}   
	
	// get teacher info
    public function get_teacher_info($teacher_id)
    { 
        $result = $this->db->get_where($this->_table, array('teacher_id' => $teacher_id));
        return $result->row_array(); 
    } 
     
    // teacher list
    public function teacher_list($school_id)
    {
        $this->db->select('t.teacher_id,t.first_name,t.last_name,t.subject1,t.mobile_no,t.subject2,t.subject3,t.designation,t.joining_date,t.profile_picture');
        $this->db->from('teachers as t');    
		$this->db->where("t.school_id", $school_id);  
		$this->db->where("t.is_active",'1'); 
        $this->db->order_by('t.first_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
     
	// get teacher list
    public function get_teacher_list($school_id,$session_id)
    {
        $this->db->select('t.teacher_id,t.first_name,t.last_name,t.subject1');
        $this->db->from('teachers as t');   
        $this->db->join('teacher_teaching_classes as ttc', 't.teacher_id = ttc.teacher_id');
		$this->db->where("t.school_id", $school_id); 
		$this->db->where("ttc.session_id", $session_id); 
		$this->db->where("ttc.sub_class_registers_info !=", ''); 
		$this->db->where("t.is_active",'1'); 
        $this->db->order_by('t.first_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    // get class teacher list
    public function get_unallocated_class_teacher_list($session_id,$school_id)
    {
        $this->db->select('t.teacher_id,t.first_name,t.last_name,t.subject1');
        $this->db->from('teachers as t');    
		$this->db->where("t.school_id", $school_id);  
		$this->db->where('t.teacher_id NOT IN (select class_teacher_id from class_registers where class_teacher_id = t.teacher_id and session_id='.$session_id.' )',NULL,FALSE); 
        $this->db->order_by('first_name','asc');    
        $query =  $this->db->get();
       
        $array1 = array();
        $result = '<option value="">Select Class Teacher</option>';
        foreach($query->result() as $row)
        { 
              $result .= '<option value="'.$row->teacher_id.'"  >'.$row->first_name.' '.$row->last_name.' ('.$row->subject1.')</option>';
        } 
        return $result;
        
    }  
    
    // get class teacher list
    public function get_unallocated_class_teacher_list2($session_id,$school_id)
    {
        $this->db->select('t.teacher_id,t.first_name,t.last_name,t.subject1');
        $this->db->from('teachers as t');    
		$this->db->where("t.school_id", $school_id);  
		$this->db->where("t.is_active", '1');  
		$this->db->where('t.teacher_id NOT IN (select class_teacher_id from class_registers where class_teacher_id = t.teacher_id and session_id='.$session_id.' )',NULL,FALSE); 
        $this->db->order_by('t.first_name','asc');    
        $query =  $this->db->get(); 
        return $query->result();  
    } 
    
    // get unallocated subject teacher list
    public function get_unallocated_subject_teacher_list($class_register_id,$school_id)
    { 
		$this->db->select('t.teacher_id,t.first_name,t.last_name,t.subject1');
        $this->db->from('teachers t');    
		$this->db->where("school_id", $school_id); 
		$this->db->where('t.teacher_id NOT IN (select crst.sub_teacher_id from class_register_sub_teachers crst where class_register_id='.$class_register_id.')',NULL,FALSE);  
        $this->db->order_by('first_name,last_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    
     // get searchable data teacher list
    public function get_searchable_data_teacher_list()
    {    
		$this->db->select('school_id,first_name,last_name,teacher_id,mobile_no,profile_picture,subject1,subject2,subject3');
        $this->db->from('teachers');     
		$this->db->where("is_search_data_updated", '0');   
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // terminated teacher list
    public function get_terminated_teacher_list($school_id)
    {
        $this->db->from($this->_table);   
		$this->db->where("school_id", $school_id); 
		$this->db->where("is_active",'0'); 
        $this->db->order_by('first_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
	
	//insert teacher  user xref
    public function teacher_user_xref($data)
    {
        $this->db->insert('teacher_user_xref', $data); 
		return $this->db->insert_id();  
    } 
    
    
    //update teacher		
	public function update_teacher_user_xref($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("teacher_id", $id); 
		$this->db->update('teacher_user_xref', $data); 
		return $this->db->affected_rows();  
	}   
	
	// get teacher info
    public function teacher_subject_teaching_classes($teacher_id,$session_id)
    { 
        $result = $this->db->select('sub_class_registers_info')->get_where('teacher_teaching_classes', array('teacher_id' => $teacher_id,'session_id' => $session_id));
        //echo $this->db->last_query();
        //die();
        return $result->row_array(); 
    } 
    
    // insert update searchable data
    public function insert_update_teacher_searchable_data($school_id,$teacher_id,$profile_picture,$searchable_data,$last_updated)
    { 
        $result = $this->db->query("INSERT INTO searchable_data (school_id, pointer_id, pointer_type, profile_picture, searchable_data, last_updated ) VALUES ('$school_id','$teacher_id','T','$profile_picture','$searchable_data','$last_updated')
  ON DUPLICATE KEY UPDATE searchable_data ='$searchable_data',profile_picture ='$profile_picture', last_updated='$last_updated'"); 
  
      
    } 
    
    // get teacher teaching classes
    public function get_teacher_teaching_classes($teacher_id)
    { 
    	$this->db->select('s.session_year, ttc.class_teacher_class_register_info, ttc.sub_class_name_sections');
        $this->db->from('teacher_teaching_classes  ttc');     
        $this->db->join('sessions as s', 'ttc.session_id = s.session_id'); 
		$this->db->where("ttc.teacher_id", $teacher_id);  
        $this->db->order_by('s.session_year','desc');    
        $query =  $this->db->get();  
        return $query->result(); 
        
        //echo $this->db->last_query();
        //die();
    } 
}
