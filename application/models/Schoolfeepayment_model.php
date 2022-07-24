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

class Schoolfeepayment_model extends CI_Model {
 
    private $_table = 'students_fee_payments';  
      
    //insert fee concession  
    
    public function insert_fee($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    public function insert_fee_concession($data)
    {
        $this->db->insert($this->_table, $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    public function insert_additional_fee($data)
    {
        $this->db->insert("students_additional_fee", $data); 
		$insert_id = $this->db->insert_id(); 
        return  $insert_id;
    }
    
    public function insert_student_late_fee_reminder($data)
    {
        $this->db->insert("students_late_fee_reminders", $data); 
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
	
	//update additional fee  		
	public function update_student_additional_fee($data,$id) 
	{ 
	    $condition = "class_register_student_id ='" . $id . "' and students_fee_payment_id=".NULL;
		$this->db->set($data); 
		$this->db->where($condition); 
		$this->db->update('students_additional_fee', $data); 
		//echo $this->db->last_query(); 
		return $this->db->affected_rows();  
	} 
	
	
	// get month schoolfee info
    public function get_month_schoolfee_info($class_register_id,$year_month)
    {  
        $this->db->select('monthly_fee_info'); 
        $this->db->from('students_cr_fees');     
		$this->db->where("class_register_id", $class_register_id);  
		$this->db->where("yyyymm", $year_month);  
	    $query =  $this->db->get();
        return $query->row_array();  
    } 
    
    
    // get student additional fee info
    public function get_student_additional_fee_info($class_register_student_id)
    {  
        $this->db->select('students_additional_fee_id,fee_type,additional_fee_amount'); 
        $this->db->from('students_additional_fee');     
		$this->db->where("class_register_student_id", $class_register_student_id); 
		$this->db->where("students_fee_payment_id", NULL);   
	    $query =  $this->db->get();
        return $query->row_array();  
    } 
    
    // checking teacher mobile exist or not
	public function check_if_active_additional_fee($class_register_student_id) 
	{  
	    $condition = "class_register_student_id ='" . $class_register_student_id . "' and students_fee_payment_id=".NULL;
		$this->db->select('students_additional_fee_id');
		$this->db->from('students_additional_fee');
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	}  
	
	// get fee concession r info
    public function class_register_fee_payment($class_register_student_id)
    {  
        $this->db->select('*'); 
        $this->db->from('students_fee_payments');     
		$this->db->where("class_register_student_id", $class_register_student_id);  
        $this->db->order_by('students_fee_payment_id','desc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
    
   
    // checking teacher mobile exist or not
	public function check_if_is_active_concession($class_register_student_id) 
	{  
	    $condition = "class_register_student_id ='" . $class_register_student_id . "' and is_active='1'";
		$this->db->select('students_fee_concession_id');
		$this->db->from($this->_table);
		$this->db->where($condition); 
		$query = $this->db->get(); 
        return $query->num_rows(); 
	} 
	
	
	
	// get fee concession r info
    public function class_register_fee($class_register_id)
    {  
        $this->db->select('yyyymm,students_cr_fee_id,monthly_fee_info'); 
        $this->db->from('students_cr_fees');     
		$this->db->where("class_register_id", $class_register_id);  
        $this->db->order_by('yyyymm','asc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
	
	// get fee concession  info
    public function month_fee_details($paid_month,$class_register_id)
    {  
        $paid_month_array = explode(",",$paid_month); 
        $this->db->select('yyyymm,students_cr_fee_id,fee_type,amount'); 
        $this->db->from('students_cr_fees');     
		$this->db->where_not_in("yyyymm", $paid_month_array);  
		$this->db->where("class_register_id", $class_register_id);  
        $this->db->order_by('yyyymm','asc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
	
	// get fee concession info
    public function class_register_fee_setuped_month($class_register_id)
    {   
        $this->db->select('yyyymm'); 
        $this->db->from('students_cr_fees');      
		$this->db->where("class_register_id", $class_register_id);    
        $this->db->group_by('yyyymm');    
        $this->db->order_by('yyyymm','asc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
	
	
	// get fee concession info
    public function get_month_fee_amount($class_register_id,$months,$course_stream,$class_register_student_id)
    {   
       $months = implode(',',$months);  
        $query =  $this->db->query("select fees.fee_type as fee_type, sum(fees.fee_amount) as fee_amount from(SELECT fee_type, sum(additional_fee_amount) fee_amount from cr_additional_fee where class_register_id = '$class_register_id' and yyyymm in ($months) and course_stream = '$course_stream' group by fee_type UNION SELECT fee_type, sum(amount) fee_amount from students_cr_fees where class_register_id = '$class_register_id' and yyyymm in ($months) group by fee_type UNION SELECT fee_type, sum(additional_fee_amount) fee_amount from students_additional_fee where class_register_student_id= '$class_register_student_id' and students_fee_payment_id is null group by fee_type ) fees group by fees.fee_type order by fees.fee_type;");   
         return  $query->result();
    } 
    
    // get class total year fee
    public function class_total_year_fee($class_register_id)
    {    
        $this->db->select('sum(amount) as total_fee_amount'); 
        $this->db->from('students_cr_fees');      
		$this->db->where("class_register_id", (int)$class_register_id);  
	    $query =  $this->db->get();  
        return  $query->result();
    } 
	
	public function insert_update_class_register_fee($school_id,$class_register_id,$year_month=NULL,$monthly_fee_info=NULL,$date_created=NULL,$last_updated=NULL) 
	{   
	        $this->db->query("INSERT INTO students_cr_fees (school_id, class_register_id, yyyymm, monthly_fee_info, date_created, last_updated) VALUES ($school_id, $class_register_id, $year_month, '$monthly_fee_info', '$date_created', '$last_updated')
  ON DUPLICATE KEY UPDATE monthly_fee_info='$monthly_fee_info', last_updated='$last_updated'");  
	}
	
	// get late fee students list for specific class register
    public function student_list_for_late_fee_for_specific_class($months,$class_register_id)
    {    
        $str = "crs.last_fee_payment_yyyymm  is NULL";
        $this->db->select('s.student_id, s.first_name,s.last_name,s.date_of_birth, s.father_name,s.parent_mobile_no,crs.class_register_student_id, crs.class_name_section, crs.last_fee_payment_yyyymm '); 
        $this->db->from('students s'); 
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');     
		$this->db->where("crs.class_register_id", (int)$class_register_id); 
		$this->db->where("(crs.last_fee_payment_yyyymm < $months or $str)");     
        $this->db->order_by('s.first_name,s.last_name','asc');    
	    $query =  $this->db->get(); 
	    //echo $this->db->last_query();
	    //die();
        return  $query->result();
    } 
    
	// get late fee students list for all class registers for a specific session year
    public function student_list_for_late_fee_for_all_class($months,$sessionid)
    {      
        $str = "crs.last_fee_payment_yyyymm  is NULL";
        $this->db->select('s.student_id, s.first_name,s.last_name,s.date_of_birth, s.father_name,s.parent_mobile_no,crs.class_register_student_id, crs.class_name_section, crs.last_fee_payment_yyyymm '); 
        $this->db->from('students s'); 
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id '); 
        $this->db->join('class_registers as cr', 'crs.class_register_id  = cr.class_register_id');   
		$this->db->where("cr.session_id ", (int)$sessionid);       
		$this->db->where("(crs.last_fee_payment_yyyymm < $months or $str)");        
        $this->db->order_by('s.first_name,s.last_name','asc');    
	    $query =  $this->db->get(); 
	    //echo $this->db->last_query();
	    //die();
        return  $query->result();
    } 
    
    // get students additional fee list 
    public function student_additional_fee_list($session_id,$class_register_id)
    {    
        $this->db->select('s.student_id, s.first_name,s.last_name,s.profile_picture, s.father_name,s.parent_mobile_no,sfp.payment_months,sfp.payment_date,caf.fee_type,caf.additional_fee_amount ,crs.class_register_student_id, caf.class_name_section, crs.last_fee_payment_yyyymm '); 
        $this->db->from('students s'); 
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');  ;    
        $this->db->join('students_additional_fee as caf', 'crs.class_register_student_id  = caf.class_register_student_id'); 
        $this->db->join('students_fee_payments as sfp', 'caf.students_fee_payment_id  = sfp.students_fee_payment_id','left outer');    
		$this->db->where("caf.session_id ", (int)$session_id);     
		if($class_register_id != '')
		{     
		    $this->db->where("caf.class_register_id", $class_register_id);  
		}
        $this->db->order_by('s.first_name,s.last_name','asc');    
	    $query =  $this->db->get();  
        return  $query->result();
    } 
    
    // checking teacher mobile exist or not
	public function check_if_is_active_additional_fee($class_register_student_id) 
	{  
	    $condition = "class_register_student_id ='" . $class_register_student_id . "' and students_fee_payment_id  is null";
		$this->db->select('students_additional_fee_id');
		$this->db->from('students_additional_fee');
		$this->db->where($condition); 
		$query = $this->db->get();  
        return $query->num_rows(); 
	} 
    
    // get additional fee students list for all class registers for a specific session year
    public function student_additional_fee_list_for_specific_student($class_register_student_id)
    {    
        $this->db->select('s.student_id, s.first_name,s.last_name,s.profile_picture, s.father_name,s.parent_mobile_no,sfp.payment_months,sfp.payment_date,caf.fee_type,caf.additional_fee_amount ,crs.class_register_student_id, crs.class_name_section, crs.last_fee_payment_yyyymm '); 
        $this->db->from('students s'); 
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');    
        $this->db->join('students_additional_fee as caf', 'crs.class_register_student_id  = caf.class_register_student_id');  
        $this->db->join('students_fee_payments as sfp', 'caf.students_fee_payment_id  = sfp.students_fee_payment_id','left outer');  
		$this->db->where("caf.class_register_student_id", (int)$class_register_student_id);     
        $this->db->order_by('s.first_name,s.last_name','asc');    
	    $query =  $this->db->get(); 
	    //echo $this->db->last_query();
	    //die();
        return  $query->result();
    } 
    
    // get fee concession r info
    public function late_fee_reminder_list($session_id)
    {  
        $this->db->select('*'); 
        $this->db->from('students_late_fee_reminders');  
	    $this->db->where("session_id", $session_id); 
        $this->db->order_by('students_late_fee_reminder_id','desc');    
	    $query =  $this->db->get();
        return  $query->result();
    } 
    
    // get late fee students list for all class registers for a specific session year
    public function get_late_fee_reminder_students_details($class_register_students_ids)
    {  
        $class_register_students_ids = explode(',',$class_register_students_ids);
        $this->db->select('s.first_name,s.last_name,s.date_of_birth,s.date_of_birth, s.father_name,s.parent_mobile_no,crs.class_name_section'); 
        $this->db->from('students s'); 
        $this->db->join('class_register_students  as crs', 's.student_id  = crs.student_id ');  
		$this->db->where_in("crs.class_register_student_id ", $class_register_students_ids);     
        $this->db->order_by('s.first_name,s.last_name','asc');    
	    $query =  $this->db->get(); 
        return  $query->result();
    } 
    
    
    // get daily fee  
    public function get_daily_fee($school_id,$start_date,$end_date)
    {  
        $this->db->select('payment_date, payment_mode, sum(total_fee) as total_fee'); 
        $this->db->from('students_fee_payments');     
		$this->db->where("payment_date  >=", $start_date);  
		$this->db->where("payment_date  <=", $end_date);   
		$this->db->where("school_id", $school_id);  
		$this->db->group_by("payment_date, payment_mode");      
        $this->db->order_by('payment_date','asc');    
	    $query =  $this->db->get();
	    
        return $query->result();  
    } 
    
    // get monthly fee  
    public function get_monthly_fee($school_id,$start_month,$end_month)
    {  
        $this->db->select('yyyymm as payment_month, payment_mode, sum(total_fee) as total_fee '); 
        $this->db->from('students_fee_payments');     
		$this->db->where("yyyymm  >=", $start_month);  
		$this->db->where("yyyymm  <=", $end_month);   
		$this->db->where("school_id", $school_id);  
		$this->db->group_by("yyyymm, payment_mode");      
        $this->db->order_by('payment_date','asc');    
	    $query =  $this->db->get(); 
 
        return $query->result();  
    } 
    
    // get class wise fee  
    public function get_class_wise_fee($school_id,$start_date,$end_date)
    {  
        $this->db->select('crs.class_name_section, sfp.payment_mode, sum(sfp.total_fee)  as total_fee'); 
        $this->db->from('students_fee_payments sfp');      
        $this->db->join('class_register_students  as crs', 'sfp.class_register_student_id   = crs.class_register_student_id ');  
		$this->db->where("sfp.payment_date   >=", $start_date);  
		$this->db->where("sfp.payment_date   <=", $end_date);   
		$this->db->where("sfp.school_id", $school_id);  
		$this->db->group_by("crs.class_name_section, sfp.payment_mode");      
        $this->db->order_by('crs.class_name_section','asc');    
	    $query =  $this->db->get(); 
	     
        return $query->result();  
    } 
    
    // get  student fee receipt info
    public function get_student_fee_receipt_info($receipt_number,$school_id)
    {  
        $this->db->select('s.first_name,s.last_name,s.date_of_birth,s.father_name,s.registration_no,s.parent_mobile_no,crs.class_name_section, sfp.payment_months, sfp.total_fee, sfp.late_fee, sfp.received_amount, sfp.received_amount,sfp.fee_breakup_info,sfp.concession,sfp.payment_date'); 
        $this->db->from('students_fee_payments sfp');     
        $this->db->join('students  as s', 'sfp.student_id   = s.student_id ');  
        $this->db->join('class_register_students  as crs', 'sfp.class_register_student_id   = crs.class_register_student_id '); 
		$this->db->where("sfp.receipt_number", $receipt_number);   
		$this->db->where("sfp.school_id", $school_id);         
	    $query =  $this->db->get();  
        return $query->result();  
    } 
    
}
