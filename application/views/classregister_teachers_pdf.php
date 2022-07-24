<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <title>Class - Subject Teachers List</title>  
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
                        <td colspan="1"  align="right" valign="middle" style="padding:0px">
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
                        <td align="center" colspan="4" style="border-bottom: 1px solid #ddd; margin-top:10px;">
                           <strong><font color="red" style="font-size:20px; text-decoration: underline;" > Class - Subject Teachers </font></strong>
                        </td> 
                    </tr> 
                    <tr> 
                        <td colspan="4">
                            <p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	    <strong>Total Students:</strong> <?php echo $classregister_info['total_students']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	    <strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>
                        	</p>
                        </td> 
                    </tr> 
                    <tr> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="10%">Teacher&nbsp;name</th>
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="10%">Mobile No.</th> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="10%">Subjects</th> 
                        <th align="left" style="border-bottom: 1px solid #ddd;font-size:14px;padding:5px" width="10%">Teaching in classes</th>  
                    </tr> 
	                <?php 
                    	foreach($class_subject_teacher_list as $teacher)
                    	{
            	    ?>
                    <tr >
                        <td style="font-size:12px;"><?php echo $teacher->first_name." ".$teacher->last_name; ?></td>
                        <td style="font-size:12px;"><?php echo $teacher->mobile_no; ?></td> 
                        <td style="font-size:12px;"><?php if($teacher->subject1!= '') {echo $teacher->subject1; } if($teacher->subject2!= '') {echo ", ".$teacher->subject2; } if($teacher->subject3!= '') {echo ", ".$teacher->subject3; }  ?></td> 
                        <td style="font-size:12px;"><?php echo $teacher->sub_class_name_sections; ?></td>  
                    </tr> 
                    <?php } ?>  
                        <tr ><td colspan="4">&nbsp;</td></tr>
                        <tr><td colspan="4" style="text-align:center;">--------------------End of the Report--------------------</td></tr>
                </tbody>
            </table> 
    </body>
</html> 