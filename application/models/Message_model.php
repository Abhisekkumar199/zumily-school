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

class Message_model extends CI_Model {
 
    private $_table = 'messages';  
      
    //insert message  
    public function insert_message($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //update message		
	public function update_message($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("message_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
    
    
    //insert message user delivery 
    public function insert_message_user_delivery($data)
    {
        $this->db->insert('message_user_delivery', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //insert message student 
    public function insert_message_image($data)
    {
        $this->db->insert('message_images', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    } 
    
    //update message image		
	public function update_message_image($message_image_data,$message_image_id) 
	{ 
		$this->db->set($message_image_data); 
		$this->db->where("message_image_id", $message_image_id); 
		$this->db->update('message_images', $message_image_data); 
		return $this->db->affected_rows();  
	} 
	
	// get message info
    public function get_message_info($message_id)
    { 
        $result = $this->db->get_where($this->_table, array('message_id' => $message_id));
        return $result->row_array(); 
    } 
     
	// get message list
    public function get_message_list($school_id)
    { 
		$this->db->select('*,m.date_created as message_date_created');
        $this->db->from('messages m');  
        $this->db->join('message_types as mt', 'm.message_type_id = mt.message_type_id'); 
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('message_id','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
    
    
    // get message images list
    public function get_message_images($message_id)
    { 
		$this->db->select('*');
        $this->db->from('message_images');   
		$this->db->where("message_id", $message_id); 
        $this->db->order_by('display_order','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }  
    
    // delete message images list
    public function delete_message_images($message_image_id)
    { 
		 $this -> db -> where('message_image_id', $message_image_id);
        $this -> db -> delete('message_images');
    }  
    
    // get message type list
    public function get_message_type_list()
    { 
		$this->db->select('*');
        $this->db->from('message_types');     
        $this->db->order_by('message_type_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    //delete message		
	public function delete_message($id) 
	{    
        $this->db->where('message_id', $id);
        $this->db->delete('message_user_delivery'); 
        
        $this->db->where('message_id', $id);
        $this->db->delete('message_images');  
        
        $this->db->where('message_id', $id);
        $this->db->delete($this->_table);  
        
	}  
}
