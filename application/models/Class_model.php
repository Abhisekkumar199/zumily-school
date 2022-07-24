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

class Class_model extends CI_Model {
 
    private $_table = 'classes';  
      
    //insert class 
    public function insert_class($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update class		
	public function update_class($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("class_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	// get class info
    public function get_class_info($class_id)
    { 
        $result = $this->db->get_where($this->_table, array('class_id' => $class_id));
        return $result->row_array(); 
    } 
    public function get_class_list($school_id)
    {
        $this->db->select('class_id, class_name , section, (select count(*) from class_registers cr where cr.school_id=c.school_id and c.class_id = cr.class_id) total_class_connected ');
        $this->db->from('classes  c');   
		$this->db->where('c.school_id', $school_id); 
        $this->db->order_by('c.class_name, c.section','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    
    public function get_unallocated_class_list($session_id,$school_id)
    { 
        $query =$this->db->select(array(
        'c.class_id as class_id',
        'c.class_name',
        'c.section'))
        ->from('classes as c')
        ->where('c.school_id',$school_id)  
        ->where('c.class_id NOT IN (select class_id from class_registers where school_id='.$school_id.' and session_id='.$session_id.' )',NULL,FALSE)
        ->order_by('c.class_name,c.section asc')->get(); 
         
        $array1 = array();
        $result = '<option value="">Select Class</option>';
        foreach($query->result() as $row)
        { 
              $result .= '<option value="'.$row->class_id.'"  >'.$row->class_name.' '.$row->section.'</option>';
        } 
        return $result;
    }
    
    // checking class name exist or not
	public function check_classname($classname,$section,$class_id,$school_id) 
	{ 
	    if($class_id != '')
	    {
	        $condition = "class_name =" . "'" . $classname . "' and section='".$section."' and school_id= '".$school_id."' and class_id != '".$class_id."'";
	    }
	    else
	    {
	        $condition = "class_name =" . "'" . $classname . "' and section='".$section."' and school_id= '".$school_id."'";
	    }
	     
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		
		  $this->db->last_query(); 
        return $query->num_rows(); 
	}
	
	//delete subject		
	public function delete_class($id) 
	{ 
		$this -> db -> where('class_id', $id);
        $this -> db -> delete('classes'); 
	}
    
}
