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

class Report_card_model extends CI_Model {
 
    private $_table = 'reporting_grades';  
      
    //insert grade 
    public function insert_grade($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->affected_rows();  
    }
    
    //update grade		
	public function update_grade($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("reporting_grade_id", $id); 
		$this->db->update($this->_table, $data); 
		return $this->db->affected_rows();  
	} 
	
	// get grade info
    public function get_grade_info($reporting_grade_id)
    { 
        $result = $this->db->get_where($this->_table, array('reporting_grade_id' => $reporting_grade_id));
        return $result->row_array(); 
    } 
    
    public function grades_list($school_id)
    {
        $this->db->select('*');
        $this->db->from('reporting_grades');   
		$this->db->where('school_id', $school_id); 
        $this->db->order_by('grade','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    public function check_if_grade_exist($grade,$school_id)
    {
        $this->db->select('reporting_grade_id');
        $this->db->from('reporting_grades');   
		$this->db->where('grade', $grade); 
		$this->db->where('school_id', $school_id); 
        $this->db->order_by('grade','asc');     
		$query = $this->db->get(); 
        return $query->num_rows(); 
    } 
	
	//delete grade		
	public function delete_grade($reporting_grade_id) 
	{ 
		$this -> db -> where('reporting_grade_id', $reporting_grade_id);
        $this -> db -> delete('reporting_grades'); 
	}
	
	//insert reporting period 
    public function insert_reporting_period($data)
    {
        $this->db->insert('reporting_cr_periods', $data); 
		return $this->db->affected_rows();  
    }
    
    
    //update reporting period		
	public function update_reporting_period($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("reporting_cr_period_id", $id); 
		$this->db->update('reporting_cr_periods', $data); 
		return $this->db->affected_rows();  
	} 
    
    public function class_register_reporting_periods_list($class_register_id,$current_date)
    {
        $this->db->select('*');
        $this->db->from(' reporting_cr_periods');   
		$this->db->where('class_register_id', $class_register_id); 
		$this->db->where('start_date <=', $current_date); 
        $this->db->order_by('start_date','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // get period info
    public function get_period_info($reporting_period_id)
    { 
        $result = $this->db->get_where('reporting_cr_periods', array('reporting_cr_period_id' => $reporting_period_id));
        return $result->row_array(); 
    } 
    
    // 
    public function get_report_card_subject_list($reporting_cr_period_id,$subject_ids,$school_id)
    {
        $this->db->select('s.subject_id, s.subject_name,  rcm1.marks_obtained');
        $this->db->from('subjects   as s');    
        $this->db->join('reporting_crs_marks  as rcm1', 's.subject_id  = rcm1.subject_id   and rcm1.reporting_cr_period_id ='.$reporting_cr_period_id,'left');   
		$this->db->where("s.school_id ", $school_id);    
		$this->db->where_in("s.subject_id ", $subject_ids); 
        $this->db->order_by('s.subject_name','asc'); 
        $query = $this->db->get();  
        $res =  $query->result();
        return $res;   
    }
    
    	//insert reporting period 
    public function insert_update_reporting_class_register_student_marks($class_register_student_id,$reporting_cr_period_id,$subject_id,$maximum_marks,$obtained_marks,$date_created,$last_updated)
    {
         $this->db->query("INSERT INTO reporting_crs_marks(class_register_student_id, reporting_cr_period_id, subject_id, max_marks, marks_obtained, date_created, last_updated) VALUES ($class_register_student_id,$reporting_cr_period_id,$subject_id,'$maximum_marks','$obtained_marks','$date_created','$last_updated') ON DUPLICATE KEY UPDATE max_marks=$maximum_marks,marks_obtained=$obtained_marks, last_updated ='$last_updated'");  
         //echo $this->db->last_query();
    }
    
}
