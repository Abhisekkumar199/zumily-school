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

class Session_model extends CI_Model {
 
    private $_table = 'sessions';  
      
    //insert subject 
    public function insert_session($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update subject		
	public function update_session($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("session_id", $id); 
		$this->db->update($this->_table, $data); 
		$this->db->last_query();
	 
		return $this->db->affected_rows();  
	} 
	
	// get subject info
    public function get_session_info($session_id)
    { 
        $result = $this->db->get_where($this->_table, array('session_id' => $session_id));
        return $result->row_array(); 
    }
    
    
    
    public function get_session_list($school_id)
    {  
        $this->db->select('*');
        $this->db->from('sessions');
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('session_id','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    public function get_active_session_list($school_id)
    {  
        $this->db->select('*,s.session_id as school_session_id,s.is_active as session_is_active');
        $this->db->from('sessions as s')->join('session_years as sy', 's.session_year_id = sy.session_year_id');
		$this->db->where("s.school_id", $school_id); 
		$this->db->where("s.is_active", '1'); 
        $this->db->order_by('s.session_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    public function get_session_year($current_year,$previous_year)
    {
        $condition = "session_start_year =" . "'" . $current_year . "'  or session_start_year= $previous_year ";
        
        $this->db->from('session_years');   
		$this->db->where($condition);  
        $this->db->order_by('session_year','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // checking session exist or not
	public function check_session($session_year_id,$schoolId,$sessionId) 
	{ 
	    if($sessionId != '')
	    {
	        $condition = "session_year_id =" . "'" . $session_year_id . "'  and school_id=$schoolId and session_year_id != $sessionId";
	    }
	    else
	    {
	        $condition = "session_year_id =" . "'" . $session_year_id . "' and school_id=$schoolId";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
        return $query->num_rows(); 
	}
	
	
	// checking session exist or not
	public function check_session_start_date($start_date,$school_id) 
	{   
		$this->db->select('session_id');
		$this->db->from($this->_table);
		$this->db->where("school_id", $school_id); 
		$this->db->where("end_date >=", $start_date);  
		$query = $this->db->get(); 
		return $query->num_rows(); 
	}
	
	public function get_current_session($current_date,$schoolId) 
	{ 
        $condition = "start_date <=" . "'" . $current_date . "' and end_date >=" . "'" . $current_date . "' and school_id=$schoolId "; 
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		$res =  $query->result();
        return $res; 
	}
	
	
	
	// get session year   info
    public function get_session_year_info($session_year_id)
    { 
        $result = $this->db->get_where('session_years', array('session_year_id' => $session_year_id));
        return $result->row_array(); 
    } 
    
}
