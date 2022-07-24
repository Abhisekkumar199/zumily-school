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

class Global_model extends CI_Model {
 
    
	// get student list
    public function get_search_result_list($school_id,$search_data)
    { 
        if(!empty($search_data))
        {
    		$this->db->select('*');
            $this->db->from('searchable_data');    
    		$this->db->where("school_id", $school_id);  
    		$this->db->like('searchable_data', $search_data);
            $this->db->order_by('searchable_data','asc');    
            $query =  $this->db->get();
            $res =  $query->result();
            //echo $this->db->last_query();
            //die();
            return $res;
        }
    } 
    
    public function get_search_result_by_id($school_id,$search_id)
    { 
         
    		$this->db->select('*');
            $this->db->from('searchable_data');    
    		$this->db->where("school_id", $school_id);  
    		$this->db->where('searchable_data_id', $search_id); 
            $query =  $this->db->get();
            $res =  $query->result(); 
            return $res; 
    } 
    
    // get student list
    public function get_student_result_list($school_id,$search_data)
    { 
        if(!empty($search_data))
        {
            $this->db->select('student_id,searchable_data');
            $this->db->from('students');    
    		$this->db->where("school_id", $school_id); 
    		$this->db->like('searchable_data', $search_data);
    		$this->db->where("current_class_register_id", NULL); 
            $this->db->order_by('first_name,last_name','asc');    
            $query =  $this->db->get();
            $res =  $query->result();
            return $res; 
        }
    } 
    
    
    // get teacher list
    public function get_teacher_result_list($school_id,$search_data,$class_register_id)
    { 
        if(!empty($search_data))
        {
            
            $this->db->select('t.teacher_id,t.searchable_data');
            $this->db->from('teachers t');    
    		$this->db->where("t.school_id", $school_id); 
		    $this->db->where("t.is_active", '1');  
    		$this->db->where('t.teacher_id NOT IN (select crst.sub_teacher_id from class_register_sub_teachers crst where class_register_id='.$class_register_id.')',NULL,FALSE);  
            $this->db->order_by('t.first_name,t.last_name','asc');  
    		$this->db->like('t.searchable_data', $search_data);  
            $query =  $this->db->get();
            $res =  $query->result();
            return $res; 
        }
    } 
    
    // get student list
    public function get_student_list_for_fee_concession($school_id,$search_data)
    { 
        if(!empty($search_data))
        {
        	$this->db->select('cr.class_name_section, cr.session_year, cr.is_active, s.profile_picture, s.first_name, s.middle_name, s.last_name, s.father_name, s.parent_mobile_no, crs.class_register_student_id, s.student_id,s.searchable_data');
            $this->db->from('class_registers as cr');     
            $this->db->join('class_register_students  as crs', 'cr.class_register_id  = crs.class_register_id');
            $this->db->join('students  as s', 'crs.student_id = s.student_id');
    		$this->db->where("cr.school_id", $school_id); 
    		$this->db->like('s.searchable_data', $search_data);
            $this->db->order_by('s.first_name, s.father_name, crs.class_register_student_id desc');    
            $query =  $this->db->get();
            $res =  $query->result();
            return $res;
        }
    } 
    
}
