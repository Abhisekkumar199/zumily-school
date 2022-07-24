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

class Feetype_model extends CI_Model {
 
    private $_table = 'students_fee_types';  
      
    //insert fee type 
    public function insert_fee_type($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update fee type		
	public function update_fee_type($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("students_fee_type_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	// get fee type info
    public function get_fee_type_info($fee_type_id)
    { 
        $result = $this->db->get_where($this->_table, array('students_fee_type_id' => $fee_type_id));
        return $result->row_array(); 
    } 
    
    public function get_fee_types_list($school_id)
    {
        $this->db->select('students_fee_type_id, fee_type, description');
        $this->db->from('students_fee_types');   
		$this->db->where('school_id', $school_id); 
        $this->db->order_by('fee_type','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
     
    //delete fee type		
	public function delete_fee_type($id) 
	{ 
		$this -> db -> where('students_fee_type_id', $id);
        $this -> db -> delete('students_fee_types'); 
	} 
}
