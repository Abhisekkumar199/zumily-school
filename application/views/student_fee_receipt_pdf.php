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
                        <td  > 
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
                        <td   align="right" valign="middle" style="padding:0px">
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
                        <td colspan="2" align="center" style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" >Student Fee Receipt</font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td  > 
                            <p>
                        	    <strong>Student Name:</strong> <?php echo $student_fee_receipt_info[0]->first_name." ".$student_fee_receipt_info[0]->last_name; ?> (<?php echo $student_fee_receipt_info[0]->class_name_section; ?>)&nbsp;&nbsp; 
                        	    <br>
                        	    <strong>Registration No.:</strong> <?php echo $student_fee_receipt_info[0]->registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp;  
                        	</p> 
                        </td> 
                        <td  > 
                            <p>
                            <strong>DOB:</strong> <?php echo $student_fee_receipt_info[0]->date_of_birth; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
                            <br>
                    	    <strong>Father Name:</strong> <?php echo $student_fee_receipt_info[0]->father_name; ?>&nbsp;&nbsp;
                            </p> 
                        </td>
                    </tr> 
                    <tr ><td colspan="2" >&nbsp;</td></tr>

                    <tr> 
                        <td colspan="2">
                             
                        <table class="table table-hover"> 
                        	<tbody id="attendance_data">  
                    	        <?php   
                    	        
                    	        if(count($student_fee_receipt_info) > 0)
                    	        { 
                    	        ?>  
                        	        <tr class=" " style="background-color:#ffffff;"  >
                        	            <td style=" width:30%;">
                        	                <table>
                        	                    <tr> 
                        	                        <td style="font-size:12px;padding-bottom: 0; ">
                    	                            <table>
                                            	        <tr>
                                            	            <td align="right" style="padding-bottom: 0;text-align:right;"><strong>Month:</strong> </td>
                                            	            <td align="right" style="padding-bottom: 0;width:100px;text-align:left;"><?php echo $student_fee_receipt_info[0]->payment_months; ?></td> 
                                        	            </tr>
                                        	        </table>
                        	                        </td> 
                    	                        </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;">
                                            	        <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:left;"> <strong>Receipt no:</strong></td> 
                                            	            <td align="right" style="padding-bottom: 0;width:100px;text-align:left;"><?php echo $receipt_no; ?> </td>
                                        	           </tr>
                                        	            </table>
                                            	    </td> 
                                        	    </tr> 
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;">
                                            	        <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:left;"> <strong>Payment Date:</strong> </td>
                                            	            <td align="right" style="padding-bottom: 0;width:100px;text-align:left;"><?php echo $student_fee_receipt_info[0]->payment_date; ?> </td>
                                        	            </tr>
                                        	            </table>
                                            	    </td> 
                                        	    </tr> 
                                    		</table>
                            		    </td>
                            		    <td style=" width:28%;">
                        	                <table> 
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	    <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:right;"><strong>Total Fee:</strong> </td>
                                            	            <td align="right" style="padding-bottom: 0;width:48px;text-align:right;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->total_fee; ?> </td>
                                            	        </tr>
                                            	    </table>
                                            	    </td>  
                                        	    </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	    <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:right;"><strong>Late Fee:</strong> </td>
                                            	            <td align="right" style="padding-bottom: 0;width:48px;text-align:right;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->late_fee; ?> </td>  
                                	                    </tr>
                                            	    </table>
                                            	    </td>  
                                	            </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	        <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:right;"><strong>Concession:</strong> </td>
                                            	            <td align="right" style="padding-bottom: 0;width:48px;text-align:right;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->concession; ?> </td>  
                                        	            </tr>
                                        	            </table>
                                            	    </td>  
                                	            </tr>
                                        	    <tr> 
                                        	        <td style="font-size:12px;padding-bottom: 0;" >
                                        	        <table>
                                            	        <tr>
                                            	            <td style="padding-bottom: 0;text-align:right;"><strong>Received Amount:</strong> </td>
                                        	                <td align="right" style="padding-bottom: 0;width:48px;text-align:right;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->received_amount; ?> </td>  
                                    	                </tr> 
                                	                </table> 
                                            	    </td>  
                                	            </tr>
                        	                </table>
                        		        </td>
                            		    <td style=" width:40%;">
                            		        <table>
                            		            <tr><th style='border-top:none;  padding-bottom: 5px;font-weight: 700;background-color: #ffffff;text-align:right;text-decoration: underline;' >Fee Breakup</th></tr>
                            		            
                                        	    <?php
                                        	    $fee_breakup_string = explode(';',$student_fee_receipt_info[0]->fee_breakup_info);
                                        	    
                                        	    for($i=0;$i<count($fee_breakup_string);$i++)
                                        	    { 
                                        	        $fee_breakup = explode('|',$fee_breakup_string[$i]); 
                                        	    ?>
                                                <tr >
                                                    <td style="font-size:12px;padding-bottom: 0;" >
                                        	        <table>
                                            	        <tr>
                                                            <td style="padding-bottom: 0;text-align:right;"><strong><?php echo ucwords(strtolower($fee_breakup[0])); ?></strong>:</td>
                                                            <td align="right" style='padding-bottom: 0;width:48px;text-align:right;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $fee_breakup[1]; ?></td>  
                                                        </tr> 
                                	                </table> 
                                            	    </td>  
                                            	</tr>    
                                                <?php } ?>
                            		        </table>
                            		    </td>
                            		</tr>  
                        	    <?php } else {  ?> 
                    	            <tr><td colspan="7"><p style="color:red;">Invalid Receipt number, Please check the number!</p></td></tr> 
                    	        <?php } ?>
                    	    </tbody>
                    	</table>  
                        </td>
                    </tr> 
                    
                  <tr ><td colspan="2"  >&nbsp;</td></tr>
	                
	                <tr><td colspan="2" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 