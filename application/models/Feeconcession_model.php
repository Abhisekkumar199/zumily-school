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

class Feeconcession_model extends CI_Model {
 
    private $_table = 'students_fee_concessions';  
      
    //insert fee concession  
    public function insert_fee_concession($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    //update fee concession		
	public function update_fee_concession($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("students_fee_concession_id", $id); 
		$this->db->update($this->_table, $data); 
		//$this->db->last_query(); 
		return $this->db->affected_rows();  
	} 
	
	// get fee concession r info
    public function student_feeconcession_list($class_register_student_id)
    {  
        $this->db->select('s.first_name,s.last_name,s.profile_picture, s.father_name,sfc.class_name_section,sfc.students_fee_concession_id,sfc.concession_frequency,sfc.concession_type,sfc.concession_amount,sfc.reason_for_concession,sfc.concession_document,sfc.date_created,sfc.status'); 
        $this->db->from('students_fee_concessions sfc');    
        $this->db->join('students  as s', 'sfc.student_id  = s.student_id ');  
		$this->db->where("sfc.class_register_student_id", $class_register_student_id);  
        $this->db->order_by('sfc.students_fee_concession_id','desc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
    
    
    // get fee concession for session info
    public function student_feeconcession_list_for_session($session_id,$class_register_id)
    {  
        $this->db->select('s.first_name,s.last_name,s.profile_picture, s.father_name,sfc.class_name_section,sfc.students_fee_concession_id,sfc.concession_frequency,sfc.concession_type,sfc.concession_amount,sfc.reason_for_concession,sfc.concession_document,sfc.date_created,sfc.status'); 
        $this->db->from('students_fee_concessions sfc');  
        $this->db->join('students  as s', 'sfc.student_id  = s.student_id ');  
		$this->db->where("sfc.session_id", $session_id);  
		if($class_register_id != '')
		{     
		    $this->db->where("sfc.class_register_id", $class_register_id);  
		}
		
        $this->db->order_by('sfc.students_fee_concession_id','desc');    
	    $query =  $this->db->get();
	    //echo $this->db->last_query();
	    //die();
        return  $query->result();
    } 
   
    // checking teacher mobile exist or not
	public function check_if_is_active_concession($class_register_student_id) 
	{  
	    $condition = "class_register_student_id ='" . $class_register_student_id . "' and status='1'";
		$this->db->select('students_fee_concession_id');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	} 
	
	// get_class_register_active_concession
	public function get_class_register_active_concession($class_register_student_id) 
	{  
	    $condition = "class_register_student_id ='" . $class_register_student_id . "' and status='1'";
		$this->db->select('students_fee_concession_id,concession_frequency,concession_type,concession_amount');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		 
        return $query->row_array();  
	} 
	
	// get month schoolfee info
    public function get_month_schoolfee_info($class_register_id,$year_month)
    {  
        $this->db->select('*'); 
        $this->db->from('students_cr_fees');     
		$this->db->where("class_register_id", $class_register_id);  
		$this->db->where("yyyymm", $year_month);  
	    $query =  $this->db->get();
        return  $query->result();
    } 
	
	// get fee concession r info
    public function class_register_fee($class_register_id)
    {  
        $this->db->select('*'); 
        $this->db->from('students_cr_fees');     
		$this->db->where("class_register_id", $class_register_id);  
        $this->db->order_by('yyyymm,fee_type','asc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
	
	public function delete_class_register_fee($students_cr_fee_id) 
	{      
        $this->db->query("DELETE from students_cr_fees where students_cr_fee_id='$students_cr_fee_id'");  
	}
	
	public function insert_update_class_register_fee($school_id,$class_register_id,$year_month=NULL,$students_fee_type_id=NULL,$fee_type=NULL,$amount=NULL,$date_created=NULL,$last_updated=NULL) 
	{     
        $this->db->query("INSERT INTO students_cr_fees (school_id, class_register_id, yyyymm, students_fee_type_id, fee_type, amount, date_created, last_updated) VALUES ($school_id, $class_register_id, $year_month, $students_fee_type_id, '$fee_type',$amount, '$date_created', '$last_updated')
  ON DUPLICATE KEY UPDATE amount=$amount, last_updated='$last_updated'"); 
   
	}
    
}
