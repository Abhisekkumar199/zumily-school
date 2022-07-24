<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title>Student Fee Booklet</title>  
    </head> 
    <body>  
            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tbody> 
                    <tr>
                        <td colspan="5"> 
                            <table>
                                <tr> 
                                    <td>
                                        <?php if($school_info['school_logo']) { ?> 
                                        <img src="<?php echo base_url();?>assets/uploadimages/schoolimages/<?php echo $school_info['school_logo']; ?>" style="width:75px; height:75px;border-radius: 40%;" class="img-circle"/>
                                        <?php } else { ?>
                                        <img src="<?php echo base_url();?>assets/images/name.png" style="width:75px; height:75px;border-radius: 40%;" class="img-circle"/>
                                        <?php } ?> 
                                    </td> 
                                    <td   >
                                         <strong><font color="red" style="font-size:18px;" > <?php echo $school_info['school_name']; ?> </font></strong> <br>
                                         <span style="font-size:14px;"><?php echo $school_info['school_address']; ?> </span><br>   
                                        <span style="font-size:14px;"><?php if($school_info['phone'] != ''){ ?><?php echo $school_info['phone']; ?><?php } ?> <?php if($school_info['email_id'] != ''){ ?><?php echo "; ".$school_info['email_id']; ?> <?php } ?></span>
                                    </td>    
                                </tr>
                            </table>
                        </td>
                        <td colspan="2"  align="right" valign="middle" style="padding:0px">
                            <table style="width:100%">
                                <tbody>
                                    <tr>
                                        <td   align="center" valign="middle"  >  
                                                <img style="max-width:150px;" src="https://localhost/project/zumilyschool/assets/images/zumily-logo-new.png" class="CToWUd">  
                                                <br><br>
                                             <p style="font-size:14px;"><strong>Date:</strong> <?php echo date("M d, Y",strtotime(date("Y-m-d"))) ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr> 
                    <tr>
                        <td align="center" colspan="7" style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" >Student Fee Booklet</font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td colspan="3"> 
                            <p>
                        	    <strong>Student Name:</strong> <?php echo urldecode($student_name); ?> (<?php echo urldecode($class_name) ; ?>)&nbsp;&nbsp; 
                        	    <strong>Registration No.:</strong> <?php echo $registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp;  
                        	</p> 
                        </td> 
                        <td colspan="4"> 
                            <p>
                            <strong>DOB:</strong> <?php echo urldecode($date_of_birth); ?>&nbsp;&nbsp;&nbsp;&nbsp; 
                            <br>
                    	    <strong>Father Name:</strong> <?php echo urldecode($father_name); ?>&nbsp;&nbsp;
                            </p> 
                        </td>
                    </tr> 
                 <tr ><td colspan="7">&nbsp;</td></tr>

                    <tr> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Month</th> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Pay Mode</th>  
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Pay Date</th>  
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Receipt no.</th> 
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Total Fee</th> 
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="14%">Late Fee</th>  
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="16%">Received Amt</th> 
                    </tr> 
                    
                    <?php  
                    
        	        $grand_total_fee = 0;
        	        $grand_late_fee = 0;
        	        $grand_received_amount = 0;
                    foreach($class_register_fee_payment_list as $payment)
        	        {
        	            
        	            $grand_total_fee  = $grand_total_fee + $payment->total_fee;
        	            $grand_late_fee  = $grand_late_fee + $payment->late_fee;
        	            $grand_received_amount  = $grand_received_amount + $payment->received_amount;
        	        ?>  
            	     <tr >
                		<td style="font-size:12px;">
                		      <?php echo $payment->payment_months; ?>
                		</td> 
                		<td style="font-size:12px;">
                		      <?php echo $payment->payment_mode; ?>
                		</td> 
                		<td style="font-size:12px;">
                		      <?php echo $payment->payment_date; ?>
                		</td> 
                		<td style="font-size:12px;text-align:right;">
                		      <?php echo $payment->receipt_number; ?>
                		</td> 
                		<td style="font-size:12px;text-align:right;">
                		      <?php echo $payment->total_fee; ?>
                		</td> 
                		<td style="font-size:12px;text-align:right;">
                		      <?php echo $payment->late_fee; ?>
                		</td> 
                		<td style="font-size:12px;text-align:right;">
            		        <?php echo $payment->received_amount; ?>
                		</td> 
                		
            		</tr>
            	    <?php  }  ?> 
	                <tr>
            	        <th align="left" colspan="4" style='border-top: 1px solid #ddd;padding-top: 10px; padding-bottom: 10px;font-size:14px;background-color: #ffffff;'>Grand Total:</th> 
                        <th style='border-top: 1px solid #ddd;padding-top: 10px; padding-bottom: 10px;font-size:14px;background-color: #ffffff;text-align:right;'  ><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_total_fee; ?></th>
                        <th style='border-top: 1px solid #ddd;padding-top: 10px; padding-bottom: 10px;font-size:14px;background-color: #ffffff;text-align:right;' ><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_late_fee; ?></th>
                        <th style='border-top: 1px solid #ddd;padding-top: 10px; padding-bottom: 10px;font-size:14px;background-color: #ffffff;text-align:right;'  ><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_received_amount; ?></th>
                    </tr>
                    <tr ><th colspan="4" style="border-top:none;background-color: #ffffff;"></th><th style='border-top:none;padding-top: 15px; padding-bottom: 5px;font-size:14px;background-color: #ffffff;text-align:right;'  colspan="3">Total Session-year Fee:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $total_year_fee; ?></th></tr>
                    <tr ><th colspan="4" style="border-top:none;background-color: #ffffff;"></th><th style='padding-top: 5px;border-top:none; padding-bottom: 5px;font-size:14px;background-color: #ffffff;text-align:right;'  colspan="3">Total Received Fee:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_total_fee; ?></th></tr>
                    <tr ><th colspan="4" style="border-top:none;background-color: #ffffff;"></th><th style='padding-top: 5px;padding-bottom: 5px;font-size:14px;background-color: #ffffff;text-align:right;'  colspan="3">Remaining Balance:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $total_year_fee - $grand_total_fee; ?></th></tr>
                    <tr ><td colspan="7">&nbsp;</td></tr>
	                
	                <tr><td colspan="7" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 