<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title>Class Register Fee By Month</title>  
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
                        <td align="center" colspan="2" style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" > Class Register Fee By Month </font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td colspan="2">
                            	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
            
                        </td> 
                    </tr> 
                    <tr> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="15%">Month Year</th>
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="65%">Fee</th>  
                    </tr> 
                    <?php  
        	        $month_array[] = array();
        	        $x = 1;
        	        foreach($class_register_fee_lists as $class_register_fee)
        	        {
        	            if($x == 1)
        	            {
        	                $month_array[] = $class_register_fee->yyyymm;
	                ?>
                    <tr>
                        <td style="font-size:12px;"> <strong> <?php echo $class_register_fee->yyyymm; ?> --</strong> </td>
	                    <td style="font-size:12px;"> 
	                <?php           
        	            }  
        	            if(in_array($class_register_fee->yyyymm, $month_array))
            	 	    {
            	 	        echo  "<strong>".$class_register_fee->fee_type.":</strong> ".$class_register_fee->amount."&nbsp;&nbsp;"; 
            	 	    }
            	 	    else
            	 	    { 
    	 	        ?>
        	 	        </td>
    	 	        </tr>
    	 	        <tr>
                        <td style="font-size:12px;"> <strong> <?php echo $class_register_fee->yyyymm; ?> --</strong>  </td>
                        <td style="font-size:12px;"> 
            	 	        <?php
            	 	        echo  "<strong>".$class_register_fee->fee_type.":</strong> ".$class_register_fee->amount."&nbsp;&nbsp;"; 
            	 	    } 
        	        ?>   
            	        <?php $month_array[] = $class_register_fee->yyyymm; $x++;  }  ?> 
            	        </td>
	                 </tr>
                        <tr ><td colspan="2">&nbsp;</td></tr>
                        <tr><td colspan="2" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 