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

class Batch_model extends CI_Model { 
    
    // create batch   
    public function student_upload_batch($data)
    {
        $this->db->insert('student_upload_batch', $data); 
		return $this->db->affected_rows();  
    }  
    
    // insert into taging
    public function insert_student_staging($data)
    {
        $this->db->insert('student_upload_staging', $data); 
		return $this->db->affected_rows();  
    }  
    
    // get all row of a batch from staging 
    public function get_batch_students_from_staging($batch_id)
    { 
		$this->db->select('*');
        $this->db->from('student_upload_staging');    
		$this->db->where("batch_id", $batch_id); 
        $this->db->order_by('student_upload_staging_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    // update batch status
    public function update_batch_status($batch_data,$id)
    { 
		$this->db->set($batch_data); 
		$this->db->where("student_upload_staging_id", $id); 
		$this->db->update('student_upload_staging', $batch_data); 
		
		//  echo $this->db->last_query(); 
		return $this->db->affected_rows();  
    }
     
    // total batch student count
    public function total_batch_students_count($batch_id,$school_id)
    {
        $condition = "batch_id =" . "'" . $batch_id . "' and school_id='".$school_id."'";
        $this->db->select('*');
		$this->db->from('student_upload_staging');
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
        return $query->num_rows();
    } 
    
    // total success student batch process
    public function total_success_batch_process_count($batch_id,$school_id)
    {
        $condition = "batch_id =" . "'" . $batch_id . "' and school_id='".$school_id."' and status !='Failed'";
        $this->db->select('*');
		$this->db->from('student_upload_staging');
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
        return $query->num_rows();
    } 
    
    // total failed student batch process
    public function total_batch_error_count($batch_id,$school_id)
    {
        $condition = "batch_id =" . "'" . $batch_id . "' and school_id='".$school_id."' and status='Failed'";
        $this->db->select('*');
		$this->db->from('student_upload_staging');
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
        return $query->num_rows();
    }  
    
    // update batch status
    public function update_student_upload_batch($update_batch_data,$batch_id,$school_id)
    { 
		$this->db->set($update_batch_data); 
		$this->db->where("batch_id", $batch_id); 
		$this->db->where("school_id", $school_id); 
		$this->db->update('student_upload_batch', $update_batch_data); 
		
		//  echo $this->db->last_query(); 
		return $this->db->affected_rows();  
    } 
    
    
    // get batch list
    public function get_batch_list($school_id)
    { 
		$this->db->select('*');
        $this->db->from('student_upload_batch');    
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('date_created','desc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
}
