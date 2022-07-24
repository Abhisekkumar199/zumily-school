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

class Homework_model extends CI_Model {
 
    private $_table = 'homework';  
      
    //insert homework  
    public function insert_homework($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //update homework		
	public function update_homework($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("homework_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
    
    
    //insert homework completed documents
    public function insert_homework_completed_documents($data)
    {
        $this->db->insert('homework_completed_documents', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //insert homework user delivery 
    public function insert_homework_user_delivery($data)
    {
        $this->db->insert('homework_user_delivery', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //insert homework student 
    public function insert_homework_document($data)
    {
        $this->db->insert('homework_documents', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //update homework image		
	public function update_homework_document($homework_document_data,$homework_document_id) 
	{ 
		$this->db->set($homework_document_data); 
		$this->db->where("homework_document_id", $homework_document_id); 
		$this->db->update('homework_documents', $homework_document_data); 
		return $this->db->affected_rows();  
	} 
	
	// get homework info
    public function get_homework_info($homework_id)
    { 
        $result = $this->db->get_where($this->_table, array('homework_id' => $homework_id));
        return $result->row_array(); 
    } 
     
	// get homework list
    public function get_homework_list($session_id,$class_register_id,$is_session_changed)
    {  
        
        if($class_register_id != '' and $is_session_changed == 0)
        {
            $this->db->select('h.homework_id,h.description,h.title,h.homework_type,h.homework_documents_images,h.class_name_section,h.due_date,h.total_views,h.date_created,h.teacher_name'); 
            $this->db->from('homework h');  
		    $this->db->where("h.class_register_id", $class_register_id);  
            $this->db->order_by('h.homework_id','desc');    
            $query =  $this->db->get(); 
            $res =  $query->result();
            return $res;
        } 
        else 
        { 
            $this->db->select('h.homework_id,h.description,h.title,h.homework_type,h.homework_documents_images,h.class_name_section,h.due_date,h.total_views,h.date_created,h.teacher_name'); 
            $this->db->from('homework h');  
            $this->db->join('class_registers as cr', 'cr.class_register_id = h.class_register_id'); 
		    $this->db->where("cr.session_id", $session_id);  
            $this->db->order_by('h.homework_id','desc');    
            $query =  $this->db->get(); 
            $res =  $query->result();
            return $res; 
        } 
    }  
    
    
    // get homework documents list
    public function get_homework_documents($homework_id)
    { 
		$this->db->select('*');
        $this->db->from('homework_documents');   
		$this->db->where("homework_id", $homework_id); 
        $this->db->order_by('display_order','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
    
    // get student homework documents list
    public function get_student_homework_documents($homework_id,$student_id)
    { 
		$this->db->select('h.*,s.first_name as student_first_name,s.last_name as student_last_name,s.profile_picture ,s.address as student_address');
        $this->db->from('homework_completed_documents h');
        $this->db->join('students as s', 'h.student_id = s.student_id');  
		$this->db->where("h.homework_id", $homework_id);   
		$this->db->where("h.student_id", $student_id);  
        $query =  $this->db->get();
        return $query->row_array();  
    }  
    
    // delete homework documents list
    public function delete_homework_documents($homework_document_id)
    { 
		 $this -> db -> where('homework_document_id', $homework_document_id);
        $this -> db -> delete('homework_documents');
    }  
   
    
    //delete homework		
	public function delete_homework($id) 
	{    
        $this->db->where('homework_id', $id);
        $this->db->delete('homework_user_delivery'); 
         
        $this->db->where('homework_id', $id);
        $this->db->delete($this->_table);  
        
	}  
	
	// get homework student list
    public function get_homework_student_list($class_register_id)
    { 
		$this->db->select('s.first_name,s.middle_name,s.last_name,s.profile_picture,cr.class_register_student_id, cr.student_id, (select count(*) from student_attendance sa where sa.class_register_student_id = cr.class_register_student_id) total_attendance_records');
        $this->db->from('class_register_students as cr');    
        $this->db->join('students as s', 'cr.student_id = s.student_id');    
		$this->db->where("cr.class_register_id", $class_register_id); 
        $this->db->order_by('s.first_name,s.middle_name,s.last_name','asc');    
        $query =  $this->db->get();
        
        $res =  $query->result();
        return $res;
    }
    
    //update homework		
	public function update_student_homework_status($data,$homework_id,$student_id) 
	{ 
		$this->db->set($data); 
		$this->db->where("homework_id", $homework_id); 
		$this->db->where("student_id", $student_id); 
		$this->db->update('homework_completed_documents', $data); 
		return $this->db->affected_rows();  
	} 
}
