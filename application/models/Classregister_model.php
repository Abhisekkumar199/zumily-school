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

class Classregister_model extends CI_Model {
 
    private $_table = 'class_registers';  
      
    //insert class register 
    public function insert_classregister($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    //update class register		
	public function update_classregister($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("class_register_id", $id); 
		$this->db->update($this->_table, $data); 
		
		//  echo $this->db->last_query(); 
		return $this->db->affected_rows();  
	} 
	
	//update class register by one		
	public function update_classregister_for_total_students($class_register_id) 
	{ 
	    
	    $this->db->query("update class_registers cr set cr.total_students = (select count(*) from class_register_students crs where crs.class_register_id =$class_register_id) where cr.class_register_id =$class_register_id"); 
	}  
 
	
	// get class register info
    public function get_classregister_info($class_register_id)
    {  
        $this->db->select('*,cr.is_active as is_class_register_active ');
        
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id', 'left outer');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id', 'left outer');
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id', 'left outer');
		$this->db->where("cr.class_register_id", $class_register_id);  
	    $query =  $this->db->get();
        return $query->row_array(); 
    } 
    
    // get class register info
    public function get_classregister_info2($class_register_id)
    { 
        $this->db->select('*,cr.is_active as is_class_register_active ');
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id', 'left outer');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id', 'left outer');
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id', 'left outer');
		$this->db->where("cr.class_register_id", $class_register_id); 
	    $query =  $this->db->get();
	     
        return $query->row_array(); 
    } 
    
    
    // get class register dropdown list
    public function get_classregister_dropdown_list($session_id)
    { 
		$this->db->select('class_name_section ,class_register_id');
        $this->db->from('class_registers');      
		$this->db->where("session_id", $session_id); 
        $this->db->order_by('class_name_section asc');    
        $query =  $this->db->get();  
        $res =  $query->result();
        
        //echo $this->db->last_query();
	    //die();
        return $res;
    }
    
     
	// get class register list
    public function get_classregister_list($school_id)
    { 
		$this->db->select('cr.is_active,cr.session_id,cr.class_name_section,s.session_year,cr.room_no,cr.total_students,t.first_name,t.last_name,cr.class_register_id,cr.class_register_id,cr.subject_teachers,cr.class_teacher_id');
        $this->db->from('class_registers as cr');     
        $this->db->join('sessions as s', 'cr.session_id = s.session_id', 'left outer');
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id', 'left outer');
		$this->db->where("cr.school_id", $school_id); 
        $this->db->order_by('cr.class_name_section asc,s.session_year desc');    
        $query =  $this->db->get(); 
        
        $res =  $query->result();
        return $res;
    }
    
    // get class register list
    public function get_classregister_list_by_session_id($school_id,$session_id)
    { 
		$this->db->select('cr.is_active,cr.session_id,cr.class_name_section,s.session_year,cr.room_no,cr.total_students,t.first_name,t.last_name,cr.class_register_id,cr.class_register_id,cr.subject_teachers,cr.class_teacher_id');
        $this->db->from('class_registers as cr');     
        $this->db->join('sessions as s', 'cr.session_id = s.session_id', 'left outer');
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id', 'left outer');
		$this->db->where("cr.school_id", $school_id); 
		$this->db->where("cr.session_id", $session_id); 
        $this->db->order_by('cr.class_name_section asc ');    
        $query =  $this->db->get(); 
        $res =  $query->result();
        return $res;
    }
    
    // get class register subject teachers list
    public function get_class_register_subject_teacher_list($class_register_id,$session_id)
    {  
        $this->db->select('t.teacher_id,t.first_name,t.last_name,t.mobile_no,t.subject1,t.subject2,t.subject3,t.profile_picture,cr.class_register_sub_teacher_id,cr.sub_teacher_id,cr.session_id,ttc.sub_class_name_sections');
        $this->db->from('teachers as t');    
        $this->db->join('class_register_sub_teachers as cr', 't.teacher_id = cr.sub_teacher_id'); 
        $this->db->join('teacher_teaching_classes as ttc', "(t.teacher_id = ttc.teacher_id and ttc.session_id = $session_id)"); 
		$this->db->where("cr.class_register_id", $class_register_id);  
	    $query =  $this->db->get(); 
        return $res =  $query->result();
    } 
    
    // get message class register list
    public function get_messages_class_registers($school_id)
    { 
		$this->db->select('cr.class_register_id,c.class_name,c.section,s.session_year,t.first_name,t.last_name');
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id');
        $this->db->join('teachers as t', 'cr.class_teacher_id = t.teacher_id');
		$this->db->where("cr.school_id", $school_id); 
		$this->db->where("cr.is_active", '1'); 
        $this->db->order_by('c.class_name,c.section,s.session_year','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    // get  sent message class register list
    public function get_sent_message_class_registers($class_register_ids)
    { 
		$this->db->select('cr.class_register_id,c.class_name,c.section,s.session_year');
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id'); 
		$this->db->where_in('cr.class_register_id', $class_register_ids); 
        $this->db->order_by('c.class_name,c.section,s.session_year','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    
    
    // get  sent event class register list
    public function get_sent_event_class_registers($class_register_ids)
    { 
		$this->db->select('cr.class_register_id,c.class_name,c.section,s.session_year');
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id');
        $this->db->join('sessions as s', 'cr.session_id = s.session_id'); 
		$this->db->where_in('cr.class_register_id', $class_register_ids); 
        $this->db->order_by('c.class_name,c.section,s.session_year','asc');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
     
    
    // get class register list
    public function get_classregister_list_message($school_id)
    { 
		$this->db->select('cr.class_register_id');
        $this->db->from('class_registers as cr');    
        $this->db->join('classes as c', 'cr.class_id = c.class_id'); 
		$this->db->where("cr.school_id", $school_id);    
		$this->db->where("cr.is_active", '1');  
        $query =  $this->db->get();
        // $query->row_array(); 
        $array1 = array();
        foreach($query->result() as $row)
        {
            $array1[] = $row->class_register_id;  
        }
         
        return $array1;
         
    } 
     
    public function get_class_register_sub_teacher_ids($class_register_id)
    { 
		$this->db->select('sub_teacher_id');
        $this->db->from('class_register_sub_teachers');     
		$this->db->where("class_register_id", $class_register_id);  
        $query =  $this->db->get(); 
        return $query->result(); 
         
    } 
    
    public function get_teacher_class_register_ids($subject_teacher_id,$session_id)
    { 
		$this->db->select('t.class_register_id,c.class_name_section');
        $this->db->from('class_register_sub_teachers t');     
        $this->db->join('class_registers as c', 't.class_register_id = c.class_register_id'); 
		$this->db->where("t.sub_teacher_id", $subject_teacher_id);  
		$this->db->where("t.session_id", $session_id);  
        $this->db->order_by('c.class_name_section','asc');    
        $query =  $this->db->get(); 
       
        return $query->result(); 
         
    } 
    
    //insert class register subject teacher
    public function insert_class_register_sub_teachers($data)
    {
        $this->db->insert('class_register_sub_teachers', $data); 
		return $this->db->affected_rows();  
    }
    
    //delete class register subject teacher
	public function delete_class_register_subject_teacher($class_register_sub_teacher_id)
	{
        $this -> db -> where('class_register_sub_teacher_id', $class_register_sub_teacher_id);
        $this -> db -> delete('class_register_sub_teachers');
    } 
    
    
    public function insert_update_class_teacher_teaching_classes($class_teacher_id,$session_id,$class_register_id=NULL,$class_name_section=NULL,$updated_date_time) 
	{  
	    if($class_register_id == '')
	    {
	        $this->db->query("INSERT INTO teacher_teaching_classes (teacher_id,session_id,class_teacher_class_register_id,class_teacher_class_register_info,last_updated) VALUES ($class_teacher_id,$session_id,NULL,NULL,'$updated_date_time') ON DUPLICATE KEY UPDATE class_teacher_class_register_id=NULL,class_teacher_class_register_info=NULL, last_updated='$updated_date_time'"); 
        }
	    else
	    { 
            $this->db->query("INSERT INTO teacher_teaching_classes (teacher_id,session_id,class_teacher_class_register_id,class_teacher_class_register_info,last_updated) VALUES ($class_teacher_id,$session_id,$class_register_id,'$class_name_section','$updated_date_time') ON DUPLICATE KEY UPDATE class_teacher_class_register_id=$class_register_id,class_teacher_class_register_info='$class_name_section', last_updated='$updated_date_time'"); 
	    }   
	    
	}
	
	
	
	
	public function update_teacher_types_in_users($class_teacher_id)
	{
	    $this->db->query("update users u, teacher_user_xref tux, sessions s, teacher_teaching_classes ttc 
	        set u.teacher_types = concat_ws(',',
	        case WHEN ttc.class_teacher_class_register_id !='' then 'CT' end,
            case WHEN ttc.sub_class_register_ids !='' then 'ST' end)
            where u.user_id=tux.user_id
            and tux.is_active=1 
            and now() <= s.end_date
            and now() >= s.start_date
            and tux.teacher_id = ttc.teacher_id
            and s.session_id = ttc.session_id
            and ttc.teacher_id = $class_teacher_id;");
            
        //echo $this->db->last_query();
	    //die();
	}
    
    
    public function insert_update_teacher_teaching_classes($subject_teacher_id,$session_id,$class_register_ids=NULL,$class_section_names=NULL,$classregisterids=NULL,$updated_date_time) 
	{  
	    if($class_register_ids == '')
	    {
	        $this->db->query("INSERT INTO teacher_teaching_classes (teacher_id,session_id,sub_class_register_ids,sub_class_name_sections,sub_class_registers_info,last_updated) VALUES ($subject_teacher_id,$session_id,NULL,NULL,NULL,'$updated_date_time') ON DUPLICATE KEY UPDATE sub_class_register_ids= NULL,sub_class_name_sections=NULL,sub_class_registers_info=NULL, last_updated='$updated_date_time'"); 
	    }
	    else
	    {
	        $this->db->query("INSERT INTO teacher_teaching_classes (teacher_id,session_id,sub_class_register_ids,sub_class_name_sections,sub_class_registers_info,last_updated) VALUES ($subject_teacher_id,$session_id,'$class_register_ids','$class_section_names','$classregisterids','$updated_date_time') ON DUPLICATE KEY UPDATE sub_class_register_ids='$class_register_ids',sub_class_name_sections='$class_section_names',sub_class_registers_info='$classregisterids', last_updated='$updated_date_time'"); 
	    } 
	    
	    //echo $this->db->last_query();
	    //die();
	    
	}
	
	
	//delete class register subject teacher
	public function delete_class_register($class_register_id)
	{
        $this -> db -> where('class_register_id', $class_register_id);
        $this -> db -> delete('class_registers');
    } 
    
    // get subject info
    public function get_session_year($class_register_id)
    { 
        $this->db->select('session_year');
        $this->db->from('class_registers');       
		$this->db->where("class_register_id", $class_register_id); 
        $query =  $this->db->get();  
        return $query->result(); 
          
    }
    
    
    //insert class register  additional fee
    public function insert_classregister_additional_fee($data)
    {
        $this->db->insert('cr_additional_fee', $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    
    public function class_registe_additional_fee($class_register_id)
    { 
		$this->db->select('cr_additional_fee_id,yyyymm,course_stream,additional_fee_amount,fee_type');
        $this->db->from('cr_additional_fee');     
		$this->db->where("class_register_id", $class_register_id);  
        $this->db->order_by('cr_additional_fee_id','desc');    
        $query =  $this->db->get();  
        return $query->result();  
    } 
    
    
    // get additional fee info
    public function get_additional_fee_info($cr_additional_fee_id)
    {  
        $this->db->select('*'); 
        $this->db->from('cr_additional_fee');     
		$this->db->where("cr_additional_fee_id", $cr_additional_fee_id);  
	    $query =  $this->db->get();
        return $query->row_array(); 
    } 
    
    //update class register	additional fee 	
	public function update_classregister_additional_fee($data,$id) 
	{ 
		$this->db->set($data); 
		$this->db->where("cr_additional_fee_id", $id); 
		$this->db->update('cr_additional_fee', $data);  
		return $this->db->affected_rows();  
	} 
	
	
}
