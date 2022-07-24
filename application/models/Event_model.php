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

class Event_model extends CI_Model {
 
    private $_table = 'events';  
      
    //insert event  
    public function insert_event($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    //update event		
	public function update_event($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("event_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	
    //insert event student 
    public function insert_event_user_delivery($data)
    {
        $this->db->insert('event_user_delivery', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //insert event student 
    public function insert_event_image($data)
    {
        $this->db->insert('event_images', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //update event image		
	public function update_event_image($event_image_data,$event_image_id) 
	{ 
		$this->db->set($event_image_data); 
		$this->db->where("event_image_id", $event_image_id); 
		$this->db->update('event_images', $event_image_data); 
		return $this->db->affected_rows();  
	}
	
	// get event info
    public function get_event_info($event_id)
    { 
        $result = $this->db->get_where($this->_table, array('event_id' => $event_id));
        return $result->row_array(); 
    } 
     
	// get event list
    public function get_event_list($school_id)
    { 
		$this->db->select('*');
        $this->db->from('events');    
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('event_id','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
    
    // get event time  
    public function get_event_time()
    { 
		$this->db->select('timing,format');
        $this->db->from('hours');     
        $this->db->order_by('hour_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // get event images list
    public function get_event_images($event_id)
    { 
		$this->db->select('*');
        $this->db->from('event_images');   
		$this->db->where("event_id", $event_id); 
        $this->db->order_by('display_order','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
    
    // delete event images list
    public function delete_event_images($event_image_id)
    { 
		 $this -> db -> where('event_image_id', $event_image_id);
        $this -> db -> delete('event_images');
    }  
    
    //delete event		
	public function delete_event($id) 
	{    
        $this->db->where('event_id', $id);
        $this->db->delete('event_user_delivery'); 
        
        $this->db->where('event_id', $id);
        $this->db->delete('event_images');  
        
        $this->db->where('event_id', $id);
        $this->db->delete($this->_table);  
        
	} 
}
