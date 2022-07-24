<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title>Student - Fee Concession List</title>  
    </head> 
    <body>  
            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tbody> 
                    <tr>
                        <td colspan="3"> 
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
                        <td align="center" colspan="5" style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" > Student - Fee Concession</font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td colspan="5">
                            <p> <?php echo $student_details; ?></p> 
                        </td> 
                    </tr> 
                    <tr> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" >Amount</th>
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" >Type</th> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" >Frequency</th> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" >Date Created</th>  
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" >Status</th>  
                    </tr> 
                    
                    <?php  foreach($student_fee_concession_list as $fee_concession)
        	        {
        	        ?>  
            	     <tr >
                		<td style="font-size:12px;"> <strong><?php echo $fee_concession->concession_amount;  ?></strong> </td> 
                		<td style="font-size:12px;"><?php  echo $fee_concession->concession_type; ?></td>  
                		<td style="font-size:12px;"><?php  echo $fee_concession->concession_frequency; ?></td>  
                		<td style="font-size:12px;"><?php echo date("M d, Y",strtotime(@$fee_concession->date_created)) ; ?></td> 
                		<td style="font-size:12px;"><?php    if($fee_concession->status == '1') { echo "Active"; } else if($fee_concession->status == '0') { echo "Disabled"; }else { echo "Used";}  ?></td>  
	                </tr>
            	    <?php  }  ?> 
	            
                        <tr ><td colspan="5">&nbsp;</td></tr>
                        <tr><td colspan="5" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 