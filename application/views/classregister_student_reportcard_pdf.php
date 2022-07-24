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
                        <td align="center" colspan="2"  style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" >Student Report Card</font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td  > 
                            <p>
                        	    <strong>Student Name:</strong> <?php echo urldecode($student_name); ?> (<?php echo urldecode($class_name) ; ?>)&nbsp;&nbsp; 
                            <br>
                        	    <strong>Registration No.:</strong> <?php echo $registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp;  
                        	</p> 
                        </td> 
                        <td  > 
                            <p>
                            <strong>DOB:</strong> <?php echo urldecode($date_of_birth); ?>&nbsp;&nbsp;&nbsp;&nbsp; 
                            <br>
                    	    <strong>Father Name:</strong> <?php echo urldecode($father_name); ?>&nbsp;&nbsp;
                            </p> 
                        </td>
                    </tr> 
                    <tr ><td colspan="2"  >&nbsp;</td></tr>
                    <tr>
                        <td colspan="2">
                            <table>
                                <?php echo $output; ?> 
                            </table>
                        </td>
                    </tr>
	                 <tr ><td  colspan="2" >&nbsp;</td></tr>
	                
	                <tr><td colspan="2"  style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 