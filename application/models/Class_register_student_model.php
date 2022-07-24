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

class Class_register_student_model extends CI_Model {
 
    private $_table = 'class_register_students';  
      
    //insert class register student
    public function insert_class_register_student($data)
    {
        $this->db->insert('class_register_students', $data); 
		return $this->db->affected_rows();  
    }
    
    //update class register	student	
	public function update_class_register_student($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("class_register_student_id", $id); 
		$this->db->update($this->_table, $data); 
		
		//  echo $this->db->last_query(); 
		return $this->db->affected_rows();  
	}  
	
    //delete class register	student	
	public function delete_class_register_student($class_register_student_id)
	{
        $this -> db -> where('class_register_student_id', $class_register_student_id);
        $this -> db -> delete('class_register_students');
    } 
    
    //  total class register students
    public function total_class_register_students($school_id)
    { 
		$this->db->select('crs.student_id');
        $this->db->from('class_registers cr');  
        $this->db->join('class_register_students as crs', 'cr.class_register_id = crs.class_register_id');  
		$this->db->where("cr.is_active", '1'); 
		$this->db->where("cr.school_id", $school_id);
        $query =  $this->db->get();
        return $query->num_rows(); 
    }  
	
	// get class register student info
    public function get_class_register_student_info($class_register_student_id)
    { 
        $result = $this->db->get_where($this->_table, array('class_register_student_id' => $class_register_student_id));
        return $result->row_array(); 
    } 
    
    // get class register student list
    public function get_class_register_student_list($class_register_id)
    { 
		$this->db->select('cr.student_id,cr.course_stream,cr.last_fee_payment_yyyymm,s.first_name,s.middle_name,s.last_name,s.profile_picture,s.registration_no,s.registration_date,s.date_of_birth,s.father_name,cr.class_register_student_id, cr.student_id,cr.total_documents, (select count(*) from student_attendance sa where sa.class_register_student_id = cr.class_register_student_id) total_attendance_records');
        $this->db->from('class_register_students as cr');    
        $this->db->join('students as s', 'cr.student_id = s.student_id');    
		$this->db->where("cr.class_register_id", $class_register_id); 
        $this->db->order_by('s.first_name,s.middle_name,s.last_name','asc');    
        $query =  $this->db->get();
        
        $res =  $query->result();
        return $res;
    }
    
    
    
    
    
    // get class register student info
    public function get_student_info($class_register_student_id)
    { 
		$this->db->select('cr.class_register_id,cr.class_name_section,cr.course_stream,cr.student_id,s.first_name,s.middle_name,s.last_name,s.profile_picture,s.registration_no,s.date_of_birth,s.father_name,cr.class_register_student_id, cr.student_id  ');
        $this->db->from('class_register_students as cr');    
        $this->db->join('students as s', 'cr.student_id = s.student_id');  
		$this->db->where("cr.class_register_student_id", $class_register_student_id); 
        $this->db->order_by('s.first_name,s.middle_name,s.last_name','asc');    
        $query =  $this->db->get(); 
        return $query->row_array();   
    }
    
    // get class register list
    public function get_class_student_list($class_register_id)
    { 
		$this->db->select('student_id');
        $this->db->from('class_register_students');  
		$this->db->where("class_register_id", $class_register_id); 
        $this->db->order_by('student_id','asc');    
        $query =  $this->db->get();
        $res =  $query->result_array();
        return $res;
    }  
    
    // get class register teacher list
    public function get_class_register_teacher_list($class_register_ids)
    { 
		$this->db->select('class_teacher_id,subject_teachers');
        $this->db->from('class_registers');      
		$this->db->where_in("class_register_id", $class_register_ids);      
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // get message class register student list
    public function get_message_class_register_student_list($school_id)
    { 
        $this->db->distinct();
		$this->db->select('sux.user_id');
        $this->db->from('class_registers as cr');    
        $this->db->join('class_register_students as crs', 'cr.class_register_id = crs.class_register_id');  
        $this->db->join('student_user_xref as sux', 'crs.student_id = sux.student_id');   
		$this->db->where("cr.school_id", $school_id);  
		$this->db->where("cr.is_active", '1');  
		$query1 = $this->db->get_compiled_select(); 
		
		$this->db->distinct();
		$this->db->select('user_id');    
        $this->db->from('teacher_user_xref');  
		$this->db->where("school_id", $school_id);  
		$this->db->where("is_active", '1');  
		$query2 = $this->db->get_compiled_select(); 
		
        $res =  $this->db->query($query1." UNION ".$query2)->result(); 
        return $res;
    }
    
    // get selected class register list
    public function get_selected_class_student_list($class_register_ids,$teacher_ids)
    {  
        $this->db->distinct();
		$this->db->select('sux.user_id');
        $this->db->from('class_register_students crs');   
        $this->db->join('student_user_xref as sux', 'crs.student_id = sux.student_id');    
		$this->db->where_in("crs.class_register_id", $class_register_ids); 
		$query1 = $this->db->get_compiled_select(); 
		
		$this->db->distinct();
		$this->db->select('user_id');   
        $this->db->from('teacher_user_xref'); 
		$this->db->where_in("teacher_id", $teacher_ids); 
		$this->db->where("is_active", '1');  
		$query2 = $this->db->get_compiled_select(); 
		
		$res =  $this->db->query($query1." UNION ".$query2)->result();
        return $res;
    } 
    
    
    // get selected list for homework
    public function get_student_list_for_homework($class_register_ids)
    {  
        $this->db->distinct();
		$this->db->select('sux.user_id,crs.student_id');
        $this->db->from('class_register_students crs');   
        $this->db->join('student_user_xref as sux', 'crs.student_id = sux.student_id');    
		$this->db->where_in("crs.class_register_id", $class_register_ids);  
	    $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    // get user list for student
    public function get_user_list_for_student($student_id)
    {  
        $this->db->distinct();
		$this->db->select('sux.user_id');
        $this->db->from('students s');   
        $this->db->join('student_user_xref as sux', 's.student_id = sux.student_id');    
		$this->db->where("sux.student_id", $student_id);  
	    $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    
    // get message class register student list
    public function get_class_register_active_session_student_list($school_id)
    { 
		$this->db->select('*');
        $this->db->from('class_registers as cr');    
        $this->db->join('class_register_students as crs', 'cr.class_register_id = crs.class_register_id'); 
        $this->db->join('classes as c', 'cr.class_id = c.class_id');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id');
        $this->db->join('students as ss', 'crs.student_id = ss.student_id'); 
		$this->db->where("cr.school_id", $school_id);  
		$this->db->where("cr.is_active", '1');  
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    
    // get sent message student list
    public function get_sent_message_student_list($student_ids)
    { 
		$this->db->select('*');
        $this->db->from('class_registers as cr');    
        $this->db->join('class_register_students as crs', 'cr.class_register_id = crs.class_register_id'); 
        $this->db->join('classes as c', 'cr.class_id = c.class_id');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id');
        $this->db->join('students as ss', 'crs.student_id = ss.student_id'); 
		$this->db->where_in("crs.student_id", $student_ids);   
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    
    
     
 
}
