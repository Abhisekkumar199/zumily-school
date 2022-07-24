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

class Subject_model extends CI_Model {
 
    private $_table = 'subjects';  
      
    //insert subject 
    public function insert_subject($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update subject		
	public function update_subject($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("subject_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	// get subject info
    public function get_subject_info($subject_id)
    { 
        $result = $this->db->get_where($this->_table, array('subject_id' => $subject_id));
        return $result->row_array(); 
    } 
    
    public function get_subject_list($school_id)
    {
        $this->db->select('subject_id, subject_name, description, (select count(*) from teachers t where school_id= s.school_id and (s.subject_name = t.subject1 OR s.subject_name = t.subject2 OR s.subject_name = t.subject3)) total_subjects_connected');
        $this->db->from('subjects s');   
		$this->db->where('s.school_id', $school_id); 
        $this->db->order_by('subject_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // checking subject name exist or not
	public function check_subjectname($subjectname,$subjectId,$school_id) 
	{ 
	    if($subjectId != '')
	    {
	        $condition = "subject_name =" . "'" . $subjectname . "'and school_id = $school_id and subject_id != $subjectId";
	    }
	    else
	    {
	        $condition = "subject_name =" . "'" . $subjectname . "' and school_id = $school_id";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
    
    
    //delete subject		
	public function delete_subject($id) 
	{ 
		$this -> db -> where('subject_id', $id);
        $this -> db -> delete('subjects'); 
	} 
}
