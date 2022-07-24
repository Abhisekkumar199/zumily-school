<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title>Late Fee Reminder List</title>  
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
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" ><?php if($type == 1) {  echo "Daily"; } else if($type == 2) { echo "Monthly"; } else { echo "Class Wise"; } ?> Fee Collection</font></strong>
                        </td> 
                    </tr> 
                 
                    <tr> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px;width:140px;"  ><?php if($type == 1) {  echo "Date"; } else if($type == 2) { echo "Month"; } else { echo "Class"; } ?></th>
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px;text-align:right;" >Cash</th> 
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px;text-align:right;" >Bank</th>  
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px;text-align:right;" >Cheque/DD</th>  
                        <th align="right" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px;text-align:right;" >Total</th> 
                    </tr> 
	                <?php echo $payments; ?>  
	                
	                <tr ><td colspan="5">&nbsp;</td></tr>
	                <tr><td colspan="5" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 