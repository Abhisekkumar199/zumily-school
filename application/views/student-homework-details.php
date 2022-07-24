 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>Student Homework Details</h4>
        <div class="db-list-com tz-db-table">
            <div id="snackbar">Profile updated Successfully!</div> 
            <form action="<?php echo base_url();?>update-student-homework-status" method="POST"> 
            <table class="responsive-table bordered" style="width:100%">
                <tbody> 
                    <tr> 
                        <td style="width:90px;" >
                            <?php if($student_homework['profile_picture']) { ?> 
                            <img src="<?php echo base_url();?>assets/uploadimages/studentimages/<?php echo $student_homework['profile_picture']; ?>" style="width:90px; height:90px;" class="img-circle"/>
                            <?php } else { ?>
                            <img src="<?php echo base_url();?>assets/images/name.png" style="width:65px; height:65px;" class="img-circle"/>
                            <?php } ?>
                            
                        </td> 
                        <td colspan="2" style="vertical-align: inherit;" >
                             <strong><font color="red"><?php echo $student_homework['student_first_name']." ".$student_homework['student_last_name']; ?></font></strong> <br>
                             <?php echo $student_homework['student_address']; ?> <br>  
                            <!--<strong><?php echo $student_homework['teacher_first_name']." ".$student_homework['teacher_last_name']; ?></strong> (Class Teacher) <br> -->
                        </td>    
                    </tr> 
                    <tr style="border-bottom:none;">
                        <td colspan="2" >
                            
                            <strong><?php echo $homework_info['title']; ?></strong> <hr style="margin-top:5px;margin-bottom:5px;">
                            <?php echo $homework_info['description']; ?>  <br><hr style="margin-top:5px;margin-bottom:5px;">
                            <strong>Due Date:</strong> <?php echo date("M d, Y",strtotime($homework_info['due_date'])) ; ?> 
                            <span class="pull-right" style="font-size: 15px;"><strong>Sent on:</strong> <?php echo date("M d, Y",strtotime($homework_info['date_created'])) ; ?>  </span>
                            <br><br>
                            
                            <div class="clearfix"></div>
                            <?php   if($student_homework['completed_documents_info'] != '') { ?>
                            <div class="preview col">   
                                <div class="app-figure" id="zoom-fig">
                                <?php
                                $documents_array = explode(';',$student_homework['completed_documents_info']); 
                                if(count($documents_array) > 0)
                                { 
                                    ?>
                                    <div id="myCarousel<?php echo $homework_id; ?>" class="carousel slide" data-ride="carousel"> 
                                    <!-- Indicators -->
                                    <div class="carousel-inner">
                                    <?php   
                                    for($a=0;$a<count($documents_array);$a++)
                                    { 
                                        
                                        $string_array = explode('|',$documents_array[$a]);
                                        if($a==0) {  $is_active = 'active';  } else { $is_active ='';} 
                                    ?>  
                                        <div class="item <?php echo $is_active; ?>"> 
                                            <a id="Zoom-<?php echo $homework_id; ?>" class="MagicZoom"  href="<?php echo base_url(); ?>/assets/uploadimages/homeworkcompletedimages/<?php echo $string_array[1]; ?>">
                                                <img data-animation="animated zoomInLeft" src="<?php echo base_url(); ?>/assets/uploadimages/homeworkcompletedimages/<?php echo $string_array[1]; ?>"> 
                                            </a> 
                                        </div>
                                       
                                            <a class="left carousel-control" href="#myCarousel<?php echo $homework_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 140px 0px;
                                            font-size: 28px;background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a> 
                                            
                                            <a class="right carousel-control" href="#myCarousel<?php echo $homework_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 140px 0px; font-size: 28px;
                                            background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a>
                                       
                                        <div class="selectors">
                                        <a data-zoom-id="Zoom-<?php echo $homework_id; ?>" href="<?php echo base_url(); ?>/assets/uploadimages/homeworkcompletedimages/<?php echo $string_array[1]; ?>"
                                        data-image="<?php echo base_url(); ?>/assets/uploadimages/homeworkcompletedimages/<?php echo $string_array[1]; ?>" >
                                        <img srcset="<?php echo base_url(); ?>/assets/uploadimages/homeworkcompletedimages/<?php echo $string_array[1]; ?>">
                                        </a>
                                        </div> 
                                    <?php   }  ?>   
                                    </div>
                                    </div>
                                <?php }  ?> 
                                </div>
                            </div> 
                            
                            <?php } ?>
                            <div class="clearfix"></div> 
                            
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <p><strong><?php if($student_homework['teacher_status'] == '0') { echo "<font color='red'>incomplete</font>"; } else if($student_homework['teacher_status'] == '1') { echo "<font color='green'>Approved</font>";}  else if($student_homework['teacher_status'] == '2') { echo "<font color='green'>Pending</font>"; } ?>  </strong></p>
                            <p><strong>Remarks:</strong> <?php echo $student_homework['teacher_comments']; ?></p>
                        </td>
                    </tr> 
                    
                    <?php if($student_homework['teacher_status'] != '1') {   ?>
                    <tr style="border-bottom:none;">
                        <td colspan="2" style="padding:0px;">
                            <div class="btn-group form-group">  
                            	<input type="radio" class="sent_to" id="radio1" name="status" value="0" <?php if($student_homework['teacher_status'] == '0') { echo "checked"; } ?> > 
                            	<label for="radio1" style="font-size:14px;">&nbsp; Incomplete</label>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            	<input type="radio" class="sent_to" id="radio2" name="status" value="1"> 
                            	<label for="radio2" style="font-size:14px;">&nbsp; Approved</label>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            	<input type="radio" class="sent_to" id="radio3" name="status" value="2" <?php if($student_homework['teacher_status'] == '2') { echo "checked"; } ?>> 
                            	<label for="radio3" style="font-size:14px;">&nbsp; Pending</label>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            </div>
                        </td>
                    </tr>
                    <tr style="border-bottom:none;">
                        <td colspan="2" style="padding:0px;">
                            <label>Please enter comments here</label>
                            <textarea   name="comment" class="form-control"  style="height:150px;width: 581px;background-color:#ffffff;"   ><?php  echo $student_homework['teacher_comments']; ?></textarea> 
                            <input type="hidden" name="homework_id"  value="<?php echo $homework_id; ?>" /> 
                            <input type="hidden" name="student_id"  value="<?php echo $student_homework['student_id']; ?>" />  
                        </td>
                    </tr>
                    <?php } ?> 
                </tbody> 
            </table> 
            <?php if($student_homework['teacher_status'] != '1') {   ?>
                <div class="db-mak-pay-bot col-md-6 col-md-offset-3"> 
                    <input type="submit" class="btn btn-success col-md-12" id="  signup" name="update" value="Submit"  /> 
                </div> 
            <?php } ?> 
            </form>
        </div> 
    </div> 
</div>  