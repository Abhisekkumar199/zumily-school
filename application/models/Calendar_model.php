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

class Calendar_model extends CI_Model {
 
    private $_table = 'school_calendars';  
      
    //insert school calendar 
    public function insert_school_calendar($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update school calendar 		
	public function update_school_calendar($calendar_data,$year_month,$school_id) 
	{ 
		$this->db->set($calendar_data); 
		$this->db->where("YYYYMM", $year_month); 
		$this->db->where("school_id", $school_id);
		$this->db->update($this->_table, $calendar_data); 
		return $this->db->affected_rows();  
	} 
	
	// get calendar info
    public function get_calendar_info($id)
    { 
        $result = $this->db->get_where($this->_table, array('school_calendar_id' => $id));
        return $result->row_array(); 
    }
    
    // get calendar info
    public function check_school_calendar($school_id,$year_month)
    { 
        $query = $this->db->get_where($this->_table, array('school_id' => $school_id,'YYYYMM' => $year_month));
        return $query->num_rows(); 
    }
    
    
     
    
}
