<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feecollection extends CI_Controller { 
    public function __construct() 
    {
        parent::__construct();   
		$this->load->database();           
    }
  
	
	// fee collection details
	public function school_fee_collection()
	{ 
	    
        $data['user_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true)); 
        $start_date = date('Y-m-01');
        $end_date = $this->session->userdata('current_date');
  
        $fee_list = $this->schoolfeepayment_model->get_daily_fee($this->input->cookie('school_id',true),$start_date,$end_date);  
	   
        $i = 1;	 
        $previous_date = ''; 
        $cash = 0;
        $bank = 0;
        $cheque = 0;
        
        $cashtotal = 0 ; 
        $banktotal = 0 ; 
        $chequetotal = 0 ; 
        $grandtotal = 0 ; 
		foreach($fee_list as $fee)
		{ 
		    
		    if($i == 1) 
	        {
                $rows .= "<tr><td>$fee->payment_date</td>"; 
	        }
	        else
	        { 
    	        if($fee->payment_date != $previous_date) 
    	        { 
    	            $rows .="<td class='text-right'>$cash</td>";
    	            $rows .="<td class='text-right'>$bank</td>";
    	            $rows .="<td class='text-right'>$cheque</td>";
    	            $rows .="<td class='text-right'>$total</td>"; 
    	            $cash = 0;
                    $bank = 0;
                    $cheque = 0; 
    	            $rows .= "</tr><tr><td>$fee->payment_date</td>";  
    	        } 
	        }
		    
		    
		    
		    
		    if($fee->payment_mode == "Cash")
		    { 
		        $cashtotal = $cashtotal + $fee->total_fee; 
		        $cash = $fee->total_fee;  
		        $total = $cash + $bank + $cheque ;  
		        
		        
		        $grandtotal = $grandtotal + $cash;
		    }
		    else if($fee->payment_mode == "Bank")
		    { 
		        $banktotal = $banktotal + $fee->total_fee;
		        $bank = $fee->total_fee;
		        $total = $cash + $bank + $cheque ;  
		        $grandtotal = $grandtotal + $bank;
		    }
		    else
		    { 
		        $chequetotal = $chequetotal + $fee->total_fee;
	            $cheque = $fee->total_fee;
		        $total = $cash + $bank + $cheque ;  
		        $grandtotal = $grandtotal + $cheque;
		    } 
		    
		    
		    
		    $i ++;
		    $previous_date = $fee->payment_date; 
		}
		
		if($i > 1)
		{
    	    $rows .="<td class='text-right'>$cash</td>";
            $rows .="<td class='text-right'>$bank</td>";
            $rows .="<td class='text-right'>$cheque</td>";
            $rows .="<td class='text-right'>$total</td></tr>";
            
            $rows .="<tr><th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>Grand Total:</th>
                    <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
            $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
            $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
            $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
		}
		else
		{
		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
		} 
		
	    $data['payments'] = $rows; 
	    
		
		$data['classregister_info'] = $this->classregister_model->get_classregister_info2(base64_decode($str[1]));   
	 	$class_register_fee_setuped_month = $this->schoolfeepayment_model->class_register_fee_setuped_month(base64_decode($str[1])); 
	 	
	 
        $schoolid = $this->input->cookie('school_id',true); 
		$data['setuped_month'] = $setuped_month;   
    
        
		$data['receipt_no'] = $maxid;  
		$this->load->view('include/header_merchant',$data);
		$this->load->view('include/left_home');
	    $this->load->view('fee_collection',$data);  
		$this->load->view('include/right_sidebar'); 
	} 
	
 
    // monthly fee collection 
	public function school_monthly_fee_collection()
	{ 
        $type = $this->input->post('type', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $start_month = $this->input->post('start_month', TRUE);
        $end_month = $this->input->post('end_month', TRUE);
	    
	    if($start_date != '')
	    {
	        $start_date = date('Y-m-d',strtotime($start_date)); 
	    }
	    else
	    { 
	        $start_date = date('Y-m-01');
	    }
	    
	    if($end_date != '')
	    {
	        $end_date = date('Y-m-d',strtotime($end_date)); 
	    }
	    else
	    { 
	        $end_date = $this->session->userdata('current_date');
	    }
	    
	    if($type == 1)
	    { 
            $fee_list = $this->schoolfeepayment_model->get_daily_fee($this->input->cookie('school_id',true),$start_date,$end_date);  
    	   
            $i = 1;	 
            $previous_date = ''; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
            $dailydata = '';
    		foreach($fee_list as $fee)
    		{ 
    		    
    		    if($i == 1) 
    	        {
                    $dailydata .= "<tr><td>$fee->payment_date</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->payment_date != $previous_date) 
        	        { 
        	            $dailydata .="<td class='text-right'>$cash</td>";
        	            $dailydata .="<td class='text-right'>$bank</td>";
        	            $dailydata .="<td class='text-right'>$cheque</td>";
        	            $dailydata .="<td class='text-right'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $dailydata .= "</tr><tr><td>$fee->payment_date</td>";  
        	        } 
    	        }
    		    
    		    
    		    
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    } 
    		    
    		    
    		    
    		    $i ++;
    		    $previous_date = $fee->payment_date; 
    		}
    		
    		if($i > 1)
    		{
        	    $dailydata .="<td class='text-right'>$cash</td>";
                $dailydata .="<td class='text-right'>$bank</td>";
                $dailydata .="<td class='text-right'>$cheque</td>";
                $dailydata .="<td class='text-right'>$total</td></tr>";
                
                $dailydata .="<tr><th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>Grand Total:</th>
                        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $dailydata .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $dailydata .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $dailydata .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $dailydata .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		} 
    		
    		echo $dailydata; 
    		exit();
    		
	    }
	    else if($type == 2)
	    { 
	        if($start_month != '')
    	    {
    	        $start_month = $start_month; 
    	    }
    	    else
    	    { 
    	        $start_month = date('Ym');
    	    }
    	    
    	    if($end_month != '')
    	    {
    	        $end_month = $end_month;
    	    }
    	    else
    	    { 
    	        $end_month = date('Ym',strtotime($this->session->userdata('current_date')));
    	    }
      
            $fee_list = $this->schoolfeepayment_model->get_monthly_fee($this->input->cookie('school_id',true),$start_month,$end_month);  
    	   
            $i = 1;	 
            $previous_month = 0; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
    		foreach($fee_list as $fee)
    		{ 
    		    
    		    if($i == 1) 
    	        {
                    $rows .= "<tr><td>$fee->payment_month</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->payment_month != $previous_month) 
        	        { 
        	            $rows .="<td class='text-right'>$cash</td>";
        	            $rows .="<td class='text-right'>$bank</td>";
        	            $rows .="<td class='text-right'>$cheque</td>";
        	            $rows .="<td class='text-right'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $rows .= "</tr><tr><td>$fee->payment_month</td>";  
        	        } 
    	        } 
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    } 
    		    
    		    
    		    
    		    $i ++;
    		    $previous_month = $fee->payment_month; 
    		}
    		
    		if($i > 1)
    		{
        	    $rows .="<td class='text-right'>$cash</td>";
                $rows .="<td class='text-right'>$bank</td>";
                $rows .="<td class='text-right'>$cheque</td>";
                $rows .="<td class='text-right'>$total</td></tr>";
                
                $rows .="<tr><th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>Grand Total:</th>
                        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		}   
    		echo $rows; 
    		exit();
	    }
	    else if($type == 3)
	    { 
            $fee_list = $this->schoolfeepayment_model->get_class_wise_fee($this->input->cookie('school_id',true),$start_date,$end_date);  
    	   
            $i = 1;	 
            $previous_class = ''; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
    		foreach($fee_list as $fee)
    		{ 
    		    
    		    if($i == 1) 
    	        {
                    $rows .= "<tr><td>$fee->class_name_section</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->class_name_section != $previous_class) 
        	        { 
        	            $rows .="<td class='text-right'>$cash</td>";
        	            $rows .="<td class='text-right'>$bank</td>";
        	            $rows .="<td class='text-right'>$cheque</td>";
        	            $rows .="<td class='text-right'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $rows .= "</tr><tr><td>$fee->class_name_section</td>";  
        	        } 
    	        } 
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    } 
    		    
    		    
    		    
    		    $i ++;
    		    $previous_class = $fee->class_name_section; 
    		}
    		
    		if($i > 1)
    		{
        	    $rows .="<td class='text-right'>$cash</td>";
                $rows .="<td class='text-right'>$bank</td>";
                $rows .="<td class='text-right'>$cheque</td>";
                $rows .="<td class='text-right'>$total</td></tr>";
                
                $rows .="<tr><th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>Grand Total:</th>
                        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $rows .="<th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		} 
    		
    		echo $rows;
	    } 
	} 
 
    
	// create fee collection pdf
	public function create_fee_collection_pdf()
	{    
	    $string = $this->uri->segment('2');
	    $data = explode('-',$string); 
	    $type = $data[0];
        $start_date = str_replace("%20"," ",$data[1]);
        $end_date = str_replace("%20"," ",$data[2]);
        $start_month = $data[3];
        $end_month = $data[4];
        
        if($start_date != '')
	    {
	        $start_date = date('Y-m-d',strtotime($start_date)); 
	    }
	    else
	    { 
	        $start_date = date('Y-m-01');
	    }
	    
	    if($end_date != '')
	    {
	        $end_date = date('Y-m-d',strtotime($end_date)); 
	    }
	    else
	    { 
	        $end_date = $this->session->userdata('current_date');
	    } 
	    
	    
	    
	    $data['school_info'] = $this->school_model->get_school_info($this->input->cookie('school_id',true));  
	    
	    if($type == 1)
	    {
	     
            $fee_list = $this->schoolfeepayment_model->get_daily_fee($this->input->cookie('school_id',true),$start_date,$end_date);   
            $i = 1;	 
            $previous_date = ''; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
    		foreach($fee_list as $fee)
    		{  
    		    if($i == 1) 
    	        {
                    $rows .= "<tr><td>$fee->payment_date</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->payment_date != $previous_date) 
        	        { 
        	            $rows .="<td class='text-right' style='text-align:right;'>$cash</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$bank</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$cheque</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $rows .= "</tr><tr><td>$fee->payment_date</td>";  
        	        } 
    	        } 
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    }  
    		    $i ++;
    		    $previous_date = $fee->payment_date; 
    		}
    		
    		if($i > 1)
    		{
        	    $rows .="<td class='text-right' style='text-align:right;'>$cash</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$bank</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$cheque</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$total</td></tr>";
                
                $rows .="<tr><th style='text-align:left;'>Grand Total:</th>
                <th  style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $rows .="<th   style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $rows .="<th  style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		} 
    		 
	    } 
	    else if($type == 2)
	    { 
	        if($start_month != '')
    	    {
    	        $start_month = $start_month; 
    	    }
    	    else
    	    { 
    	        $start_month = date('Ym');
    	    }
    	    
    	    if($end_month != '')
    	    {
    	        $end_month = $end_month;
    	    }
    	    else
    	    { 
    	        $end_month = date('Ym',strtotime($this->session->userdata('current_date')));
    	    }
      
            $fee_list = $this->schoolfeepayment_model->get_monthly_fee($this->input->cookie('school_id',true),$start_month,$end_month);  
    	   
            $i = 1;	 
            $previous_month = 0; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
    		foreach($fee_list as $fee)
    		{ 
    		    
    		    if($i == 1) 
    	        {
                    $rows .= "<tr><td>$fee->payment_month</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->payment_month != $previous_month) 
        	        { 
        	            $rows .="<td class='text-right' style='text-align:right;'>$cash</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$bank</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$cheque</td>";
        	            $rows .="<td class='text-right' style='text-align:right;'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $rows .= "</tr><tr><td>$fee->payment_month</td>";  
        	        } 
    	        } 
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    } 
    		    
    		    
    		    
    		    $i ++;
    		    $previous_month = $fee->payment_month; 
    		}
    		
    		if($i > 1)
    		{
        	    $rows .="<td class='text-right' style='text-align:right;'>$cash</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$bank</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$cheque</td>";
                $rows .="<td class='text-right' style='text-align:right;'>$total</td></tr>";
                
                $rows .="<tr><th style='text-align:left;'>Grand Total:</th>
                        <th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		}    
	    }
	    else if($type == 3)
	    { 
            $fee_list = $this->schoolfeepayment_model->get_class_wise_fee($this->input->cookie('school_id',true),$start_date,$end_date);  
    	   
            $i = 1;	 
            $previous_class = ''; 
            $cash = 0;
            $bank = 0;
            $cheque = 0;
            
            $cashtotal = 0 ; 
            $banktotal = 0 ; 
            $chequetotal = 0 ; 
            $grandtotal = 0 ; 
    		foreach($fee_list as $fee)
    		{ 
    		    
    		    if($i == 1) 
    	        {
                    $rows .= "<tr><td>$fee->class_name_section</td>"; 
    	        }
    	        else
    	        { 
        	        if($fee->class_name_section != $previous_class) 
        	        { 
        	            $rows .="<td style='text-align:right;'>$cash</td>";
        	            $rows .="<td style='text-align:right;'>$bank</td>";
        	            $rows .="<td style='text-align:right;'>$cheque</td>";
        	            $rows .="<td style='text-align:right;'>$total</td>"; 
        	            $cash = 0;
                        $bank = 0;
                        $cheque = 0; 
        	            $rows .= "</tr><tr><td>$fee->class_name_section</td>";  
        	        } 
    	        } 
    		    
    		    if($fee->payment_mode == "Cash")
    		    { 
    		        $cashtotal = $cashtotal + $fee->total_fee; 
    		        $cash = $fee->total_fee;  
    		        $total = $cash + $bank + $cheque ;  
    		        
    		        
    		        $grandtotal = $grandtotal + $cash;
    		    }
    		    else if($fee->payment_mode == "Bank")
    		    { 
    		        $banktotal = $banktotal + $fee->total_fee;
    		        $bank = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $bank;
    		    }
    		    else
    		    { 
    		        $chequetotal = $chequetotal + $fee->total_fee;
    	            $cheque = $fee->total_fee;
    		        $total = $cash + $bank + $cheque ;  
    		        $grandtotal = $grandtotal + $cheque;
    		    } 
    		    
    		    
    		    
    		    $i ++;
    		    $previous_class = $fee->class_name_section; 
    		}
    		
    		if($i > 1)
    		{
        	    $rows .="<td style='text-align:right;'>$cash</td>";
                $rows .="<td style='text-align:right;'>$bank</td>";
                $rows .="<td style='text-align:right;'>$cheque</td>";
                $rows .="<td style='text-align:right;'>$total</td></tr>";
                
                $rows .="<tr><th style='text-align:left;'>Grand Total:</th>
                        <th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$cashtotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$banktotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$chequetotal</th>";
                $rows .="<th style='text-align:right;'><i class='fa fa-inr' aria-hidden='true'></i>$grandtotal</th></tr>"; 
    		}
    		else
    		{
    		    $rows .="<tr><td colspan='4' style='padding-top:15px;padding-bottom:15px;text-align:center;'>There is no Fee data to generate report.</td></tr>";
    		} 
    		 
	    } 
		
		 
		
	    $data['payments'] = $rows; 
	    $data['type'] = $type;  
	    
		$filename = md5($this->input->cookie('school_id',true))."_school_fee_collection.pdf";  
        $html = $this->load->view('school_fee_collection_pdf',$data,true); 
         
        $this->load->library('M_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        //download it D save F. 
        $this->m_pdf->pdf->Output("./assets/pdfs/feecollection/".$filename, "F");
        $filepath = base_url()."assets/pdfs/feecollection/".$filename; 
        clearstatcache();
        
        header("Content-Type: application/pdf");
        header("Content-disposition: inline; filename=".basename($filename));
        //header('Content-Disposition: attachment; filename="downloaded.pdf"'); // feel free to change the suggested filename
        readfile($filepath); 
        
	}
 
}
