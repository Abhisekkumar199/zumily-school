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

class Schoolpayments_model extends CI_Model {
 
    private $_table = 'school_payment_transactions';   
    
    //insert student  
    public function insert_payment($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->insert_id();  
    }  
	
	// get payment info
    public function get_payment_info($payment_id)
    { 
        $result = $this->db->get_where($this->_table, array('school_payment_transaction_id' => $student_id));
        return $result->row_array(); 
    }   
     
	// get payment list
    public function get_payment_list($school_id)
    { 
		$this->db->select('*');
        $this->db->from('school_payment_transactions');    
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('school_payment_transaction_id','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
     
    
    
    // get rate student per month
    public function rate_student_permonth($total_student)
    { 
		$this->db->select('rate_student_permonth');
        $this->db->from('school_payment_rates');    
		$this->db->where("min_student <=", $total_student); 
		$this->db->where("max_student >=", $total_student);   
        $query =  $this->db->get();
        return  $query->row_array(); 
    } 
      
}
