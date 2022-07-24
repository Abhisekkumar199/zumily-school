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

class Holiday_model extends CI_Model {
 
    private $_table = 'holidays';  
      
    //insert subject 
    public function insert_holiday($data)
    {
        $this->db->insert($this->_table, $data); 
        //echo $this->db->last_query();
		//die();
		return $this->db->affected_rows();  
    }
    
    //update subject		
	public function update_holiday($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("holiday_id", $id); 
		$this->db->update($this->_table, $data); 
		
		//echo $this->db->last_query();
		//die();
		return $this->db->affected_rows();  
	} 
	
	// get subject info
    public function get_holiday_info($holidayId)
    { 
        $result = $this->db->get_where($this->_table, array('holiday_id' => $holidayId));
        return $result->row_array(); 
    } 
    public function get_holiday_list($session_id,$school_id)
    {
        if($session_id != '')
        {
            $condition = "h.session_id =" . "'" . $session_id . "'  and h.school_id=$school_id "; 
        }
        else
        {
            $condition = "h.school_id=$school_id ";
        }
	       
		$this->db->select('*,h.is_active as displayflag1,s.is_active as is_active_session');
        $this->db->from('holidays as h')->join('sessions as s', 'h.session_id = s.session_id');
		$this->db->where($condition); 
        $this->db->order_by('h.holiday_start_date','asc');    
        $query =  $this->db->get();
        //echo $this->db->last_query();
        //die();
        $res =  $query->result();
        return $res;
    } 
    
    // checking holiday exist or not
	public function check_holiday_by_name($school_id,$holidayId,$session_id,$holiday_name) 
	{ 
	     
        $condition = "   school_id='".$school_id."'  and session_id='".$session_id."' and holiday_name = '".$holiday_name."'" ;
	     
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		 // $this->db->last_query();
       // die();
        return $query->num_rows(); 
	}
	
	public function check_holiday_by_date($school_id,$holidayId,$session_id,$holiday_start_date,$holiday_end_date) 
	{ 
	    if($holiday_end_date == '')
	    {
	        $condition = "   school_id='".$school_id."'  and session_id='".$session_id."' and  holiday_start_date='".$holiday_start_date."'  " ;
	     
	    }
	    else
	    {
	        $condition = "   school_id='".$school_id."'  and session_id='".$session_id."' and  holiday_start_date='".$holiday_start_date."' and holiday_end_date='".$holiday_end_date."' " ;
	     
	    }
        
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		// echo $this->db->last_query();
        //die();
        return $query->num_rows(); 
	}
	
	//delete holiday		
	public function delete_holiday($id) 
	{  
	    $this->db->where('holiday_id', $id);
        $this->db->delete($this->_table); 
		return $this->db->affected_rows();  
	} 
	
    
}
