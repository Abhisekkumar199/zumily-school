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

class Student_model extends CI_Model {
 
    private $_table = 'students';   
    public function is_student_exist($student_id,$school_id,$first_name,$last_name,$father_name,$date_of_birth)
    {
        if($student_id > 0)
        {
            $condition = "student_id != " . "'" . $student_id . "' and first_name =" . "'" . $first_name . "' and last_name='".$last_name."'  and school_id='".$school_id."'  and father_name='".$father_name."' and date_of_birth='".$date_of_birth."'";
        }
        else
        {
            $condition = "first_name =" . "'" . $first_name . "' and last_name='".$last_name."'  and school_id='".$school_id."'  and father_name='".$father_name."' and date_of_birth='".$date_of_birth."'";
        }
        $this->db->select('*');
		$this->db->from('students');
		$this->db->where($condition); 
		$query = $this->db->get(); 
	 
        return $query->num_rows();
    }  
    
    //insert student  
    public function insert_student($data)
    {
        $this->db->insert($this->_table, $data); 
		return $this->db->insert_id();  
    } 
    
    //insert student  userxref
    public function student_user_xref($data)
    {
        $this->db->insert('student_user_xref', $data); 
		return $this->db->insert_id();  
    }
    
    //get all user ids for selected students 
    public function get_students_user_list($student_ids)
    {
        
        $this->db->distinct();
        $this->db->select('user_id');
		$this->db->from('student_user_xref'); 
		$this->db->where_in('student_id', $student_ids); 
		$query = $this->db->get(); 
		 
        $res =  $query->result();
        return $res;
	   
    }
    //get all user ids for selected students 
    public function get_student_details($student_id)
    {
        $this->db->select('crs.student_id, crs.course_stream, cr.class_name_section, cr.session_year, cr.room_no, t.first_name, t.last_name, t.mobile_no, t.profile_picture');
        $this->db->from('class_register_students  as crs');    
        $this->db->join('class_registers as cr', 'crs.class_register_id  = cr.class_register_id');  
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id');    
		$this->db->where("crs.student_id", $student_id); 
        $this->db->order_by('cr.class_register_id','asc'); 
        $query = $this->db->get();  
        $res =  $query->result();
        return $res;   
    }
    
    //update student		
	public function update_student($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("student_id", $id); 
		$this->db->update($this->_table, $data); 
		
		 //$this->db->last_query(); 
		 //die();
		return $this->db->affected_rows();  
	} 
	
	
	//insert attendance monitoring 
    public function insert_attendance_monitoring($data)
    {
        $this->db->insert('attendance_monitoring', $data); 
        //echo $this->db_last_query();
        //die();
		return $this->db->affected_rows();  
    }
    
    //update attendance monitoring		
	public function update_attendance_monitoring($data,$class_register_id,$attendance_date) 
	{ 
		$this->db->set($data); 
		$this->db->where("class_register_id", $class_register_id); 
		$this->db->where("attendance_date", $attendance_date); 
		$this->db->update('attendance_monitoring', $data); 
		
		//  echo $this->db->last_query(); 
		return $this->db->affected_rows();  
	} 
	
	
	// get student info
    public function get_student_info($student_id)
    { 
        $result = $this->db->get_where($this->_table, array('student_id' => $student_id));
        return $result->row_array(); 
    } 
    
    
    // get  student all info
    public function get_student_all_info($student_id)
    { 
		$this->db->select('s.student_id,s.first_name,s.middle_name,s.last_name,s.mobile_no,s.father_name,s.mother_name,s.parent_mobile_no,s.registration_no,s.address,c.class_name,c.section,ss.session_year,t.first_name as teacher_fname,t.last_name as teacher_lname,t.mobile_no as teacher_mobile_no');
        $this->db->from('students as s');    
        $this->db->join('class_registers as cr', 's.current_class_register_id = cr.class_register_id','left'); 
        $this->db->join('classes as c', 'cr.class_id = c.class_id','left');
        $this->db->join('sessions as ss', 'cr.session_id = ss.session_id','left');  
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id','left');    
		$this->db->where("s.student_id", $student_id);  
        $query =  $this->db->get();
         
        return $query->row_array();  
    }
    
    
     
	// get student list
    public function get_student_list($school_id)
    { 
		$this->db->select('*');
        $this->db->from('students');    
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('first_name,last_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    
    // get unassigned student list
    public function unassigned_student_lists($school_id)
    { 
		$this->db->select('*');
        $this->db->from('students');    
		$this->db->where("school_id", $school_id); 
		$this->db->where("current_class_register_id", NULL); 
        $this->db->order_by('first_name,last_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
     // get student list for specific class
    public function get_student_list_for_specific_class($class_register_id)
    { 
		$this->db->select('s.student_id,s.first_name, s.middle_name, s.last_name, s.registration_date, s.registration_no, s.date_of_birth, s.profile_picture, s.father_name, s.parent_mobile_no, 
	crs.class_name_section, crs.course_stream');
        $this->db->from('students as s');    
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');  
		$this->db->where("crs.class_register_id", $class_register_id);  
        $this->db->order_by('crs.class_name_section,s.first_name,s.last_name');    
        $query =  $this->db->get(); 
        return $query->result();
    }
    
     // get student list for specific session
    public function get_student_list_for_specific_session($session_id)
    { 
		$this->db->select('s.student_id,s.first_name, s.middle_name, s.last_name, s.registration_date, s.registration_no, s.date_of_birth, s.profile_picture, s.father_name, s.parent_mobile_no, 
	crs.class_name_section, crs.course_stream');
        $this->db->from('students as s');    
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');  
        $this->db->join('class_registers   as cr', 'crs.class_register_id  = cr.class_register_id '); 
		$this->db->where("cr.session_id ", $session_id);  
        $this->db->order_by('crs.class_name_section,s.first_name,s.last_name');    
        $query =  $this->db->get(); 
        return $query->result();
    }
    
    // get searchable data student list
    public function get_searchable_data_student_list()
    {   
        
		$this->db->select('school_id,first_name,last_name,student_id,mobile_no,profile_picture,father_name,mother_name,parent_mobile_no');
        $this->db->from('students');     
		$this->db->where("is_search_data_updated", '0');   
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // get unallocated student list 
    public function get_class_register_unassigned_student_list($class_register_id,$school_id)
    { 
		$this->db->select('student_id,first_name,middle_name,last_name,profile_picture,registration_no,registration_date,date_of_birth,father_name ');
        $this->db->from('students');       
		$this->db->where("current_class_register_id", NULL); 
		$this->db->where("school_id", $school_id); 
        $this->db->order_by('first_name,middle_name,last_name','asc');    
        $query =  $this->db->get(); 
        $res =  $query->result();
        return $res;
    }
    
    // get unallocated student list
    public function get_allocated_student_list_by_class_register_id($class_register_id)
    { 
		$this->db->select('student_id,first_name,middle_name,last_name,father_name,parent_mobile_no');
        $this->db->from('students');     
		$this->db->where("current_class_register_id", $class_register_id); 
        $this->db->order_by('first_name,last_name','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    } 
    
    // checking student email exist or not
	public function check_student_email($student_email,$student_id,$school_id) 
	{ 
	    if($teacher_id != '')
	    {
	        $condition = "email_id =" . "'" . $student_email . "' and school_id='".$school_id."' and student_id != $student_id";
	    }
	    else
	    {
	        $condition = "email_id =" . "'" . $student_email . "' and school_id='".$school_id."'";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	// checking student exist or not
	public function check_if_student_exist($first_name,$last_name,$date_of_birth,$father_name,$student_id,$school_id) 
	{ 
	    if($student_id > 0)
        {
            $condition = "student_id != " . "'" . $student_id . "' and first_name =" . "'" . $first_name . "' and last_name='".$last_name."'  and school_id='".$school_id."' and date_of_birth='".$date_of_birth."'";
        }
        else
        {
            $condition = "first_name =" . "'" . $first_name . "' and last_name='".$last_name."'  and school_id='".$school_id."'  and date_of_birth='".$date_of_birth."'";
        }
        if($father_name!='')
        {
            $condition .= "and father_name='".$father_name."'";
        }
        
        
        $this->db->select('*');
		$this->db->from('students');
		$this->db->where($condition); 
		$query = $this->db->get(); 
	    //echo $this->db->last_query();
        ///die();
        return $query->num_rows();
	}
	
    // checking student mobile exist or not
	public function check_student_mobile($mobile_no,$student_id,$school_id) 
	{ 
	    if($student_id != '')
	    {
	        $condition = "mobile_no =" . "'" . $mobile_no . "' and school_id='".$school_id."' and student_id != $student_id";
	    }
	    else
	    {
	        $condition = "mobile_no =" . "'" . $mobile_no . "' and school_id='".$school_id."'";
	    }
	    
		$this->db->select('*');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
		//echo $this->db->last_query();
        //die();
        return $query->num_rows(); 
	}
	
	// checking student email exist or not
	public function check_student_attendance_is_exist($class_register_id,$class_register_student_id,$year_month) 
	{ 
	     
        $condition = "class_register_id =" . "'" . $class_register_id . "' and attendance_year_month =" . "'" . $year_month . "' and class_register_student_id='".$class_register_student_id."'"; 
		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	// checking class attendance exist or not
	public function check_class_attendance_is_exist($class_register_id) 
	{ 
        $condition = "class_register_id =" . "'" . $class_register_id . "'"; 
		$this->db->select('*');
		$this->db->from('student_attendance');
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	// checking attendance exist
	public function check_attendance_exist($class_register_id,$attendance_date) 
	{ 
        $condition = "class_register_id =" . "'" . $class_register_id . "' and attendance_date = '".$attendance_date."'"; 
		$this->db->select('done_by,last_updated');
		$this->db->from('attendance_monitoring');
		$this->db->where($condition); 
		$query = $this->db->get();    
        return $query->row_array();  
	}
	
	// checking attendance monitoring exist or not
	public function check_attendance_monitoring_is_exist($class_register_id,$attendance_date) 
	{ 
        $condition = "class_register_id =" . "'" . $class_register_id . "' and attendance_date=" . "'" . $attendance_date . "'"; 
		$this->db->select('*');
		$this->db->from('attendance_monitoring');
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	}
	
	// get student attendance list
    public function get_student_attendance_list($class_register_id,$year_month,$column)
    {  
		$this->db->select("s1.$column as attendance_day,s3.first_name,s3.middle_name,s3.last_name,s2.class_register_student_id,s1.student_attendance_id,s3.profile_picture");
           
        $this->db->from('class_register_students s2');    
        $this->db->join('student_attendance as s1', "(s2.class_register_student_id = s1.class_register_student_id and s1.attendance_year_month='".$year_month."')",'left outer');
        $this->db->join('students as s3', 's2.student_id = s3.student_id');
		$this->db->where("s2.class_register_id", $class_register_id);  
        $this->db->order_by('s3.first_name,s3.middle_name,s3.last_name','asc');    
        $query =  $this->db->get();
         
        $res =  $query->result();
        return $res;
    } 
	
	
	// get class section name
    public function get_class_section($class_register_id)
    {  
		$this->db->select('c.class_name,c.section');
        $this->db->from('class_registers cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id'); 
		$this->db->where("cr.class_register_id", $class_register_id);      
        $query =  $this->db->get();  
        return $query->row_array(); 
    } 
	
	
	
	//insert student attendance
    public function insert_student_attendance($data)
    {
        $this->db->insert('student_attendance', $data); 
	    $query = $this->db->last_query();   
    }
    //update student attendance
    public function update_student_attendance($data,$id)
    {
        $this->db->set($data); 
		$this->db->where("student_attendance_id", $id); 
		$this->db->update('student_attendance', $data);
		return $this->db->affected_rows();   
    }
    
    
     // insert update searchable data
    public function insert_update_student_searchable_data($school_id,$student_id,$profile_picture,$searchable_data,$last_updated)
    { 
        $result = $this->db->query("INSERT INTO searchable_data (school_id, pointer_id, pointer_type, profile_picture, searchable_data, last_updated ) VALUES ('$school_id','$student_id','S','$profile_picture','$searchable_data','$last_updated')
  ON DUPLICATE KEY UPDATE searchable_data ='$searchable_data',profile_picture ='$profile_picture', last_updated='$last_updated'"); 
  
      
    } 
    
     
    
}
