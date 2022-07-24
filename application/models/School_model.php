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

class School_model extends CI_Model {
 
    private $_users = 'schools';  
      
    // checking email exist or not
	public function emailCheck($data) 
	{ 
	    $condition = "email_id =" . "'" . $data['email_id'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	
	// checking school email exist or not
	public function check_school_email($email_id,$school_id) 
	{  
        $condition = "email_id =" . "'" . $email_id . "' and school_id !='".$school_id."'"; 
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}
	
	// checking mobile exist or not
	public function mobileCheck($data) 
	{ 
	    $condition = "phone =" . "'" . $data['phone'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
    public function store_school($data)
    {
        $this->db->insert($this->_users, $data);
        return $this->db->insert_id();
    }
    
    // insert school payment reminder
    public function school_payment_reminder($data)
    {
        $this->db->insert('school_payment_reminders', $data);
        return $this->db->insert_id();
    }
    
    //update user		
	public function updateSchool($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("school_id", $id); 
		$this->db->update($this->_users, $data); 
	     
		return  $this->db->affected_rows();  
	} 
	
	//verify school email	 	
	public function verifySchool($data,$emailid) 
	{ 
		$this->db->set($data); 
		$this->db->where("email_id", $emailid); 
		$this->db->update($this->_users, $data); 
		return $this->db->affected_rows();  
	} 
	
	//verify school	mobile 	
	public function verifyMobile($data,$mobileno) 
	{ 
		$this->db->set($data); 
		$this->db->where("phone", $mobileno); 
		$this->db->update($this->_users, $data); 
		return $this->db->affected_rows();  
	}  
	
	//verify school	mobile 	
	public function check_old_password($old_password,$school_id) 
	{ 
		$condition = "password =" . "'" . md5($old_password) . "' and school_id =" . "'" . $school_id . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//die();
        return $query->num_rows();  
	}
	
	// checking username and password for login
	public function login($data) 
	{ 
	    $condition = "(email_id =" . "'" . $data['email_id'] . "' OR phone = " . "'" . $data['email_id'] . "') AND " . "password =" . "'" . $data['password'] . "'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
       return $query->row(); 
	}
	
	// checking username and password for login
	public function is_school_verified($data) 
	{ 
	    $condition = "(email_id =" . "'" . $data['email_id'] . "' OR phone =" . " '" . $data['email_id'] . "' ) AND " . "password =" . "'" . $data['password'] . "' AND is_verified='1'";
		$this->db->select('*');
		$this->db->from($this->_users);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//die();
       return $query->row(); 
	}
    
    public function get_school_info($school_id)
    { 
        $result = $this->db->get_where($this->_users, array('school_id' => $school_id));
        return $result->row_array(); 
    } 
    public function get_school_info_by_email($email_id)
    { 
        $result = $this->db->get_where($this->_users, array('email_id' => $email_id));
        return $result->row_array(); 
    } 
    
    public function get_school_info_by_mobile($mobile)
    { 
        $result = $this->db->get_where($this->_users, array('phone' => $mobile));
        return $result->row(); 
    } 
}
