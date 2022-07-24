 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>Student Leave Request View</h4>
        <div class="db-list-com tz-db-table">
            <div id="snackbar">Profile updated Successfully!</div> 
            <form action="<?php echo base_url();?>update-leave-request" method="POST"> 
            <table class="responsive-table bordered" style="width:100%">
                <tbody> 
                    <tr> 
                        <td style="width:75px;" >
                            <?php if($leave_request_info['profile_picture']) { ?> 
                            <img src="<?php echo base_url();?>assets/uploadimages/studentimages/<?php echo $leave_request_info['profile_picture']; ?>" style="width:75px; height:75px;" class="img-circle"/>
                            <?php } else { ?>
                            <img src="<?php echo base_url();?>assets/images/name.png" style="width:75px; height:75px;" class="img-circle"/>
                            <?php } ?>
                            
                        </td> 
                        <td colspan="2" >
                             <strong><font color="red"><?php echo $leave_request_info['student_first_name']." ".$leave_request_info['student_last_name']; ?></font></strong> <br>
                             <?php echo $leave_request_info['student_address']; ?> <br>  
                            <strong><?php echo $leave_request_info['teacher_first_name']." ".$leave_request_info['teacher_last_name']; ?></strong> (Class Teacher) <br> 
                        </td>    
                    </tr> 
                    <tr style="border-bottom:none;">
                        <td colspan="2" >
                            
                            <strong><?php echo $leave_request_info['request_title']; ?></strong> <hr style="margin-top:5px;margin-bottom:5px;">
                            <?php echo $leave_request_info['request_reason']; ?>  <br><hr style="margin-top:5px;margin-bottom:5px;">
                            <strong>Leave Date(s):</strong> <?php echo date("M d, Y",strtotime($leave_request_info['start_date'])) ; ?> <?php if($leave_request_info['start_date'] != $leave_request_info['end_date'] and $leave_request_info['end_date'] != '') { echo "<strong>to</strong> ".date("M d, Y",strtotime($leave_request_info['end_date'])); } ?>
                            <span class="pull-right" style="font-size: 15px;"><strong>Requested on:</strong> <?php echo date("M d, Y",strtotime($leave_request_info['date_created'])) ; ?>  </span>
                            <br><br>
                            
                            <div class="clearfix"></div>
                            <div class="preview col">   
                                <div class="app-figure" id="zoom-fig">
                                <?php
                                if($leave_request_info['leave_requests_images'] !=  '')
                                { 
                                    ?>
                                    <div id="myCarousel<?php echo $leave_request_id; ?>" class="carousel slide" data-ride="carousel"> 
                                    <!-- Indicators -->
                                    <div class="carousel-inner">
                                    <?php  
                                    $document_array = explode(';',$leave_request_info['leave_requests_images']);   
                                    for($i=0;$i<count($document_array);$i++)
                                    { 
                                        $string_array = explode('|',$document_array[$i]);
                                    ?>  
                                        <div class="item <?php if($i == 0){ ?>active <?php } ?> "> <a id="Zoom-<?php echo $leave_request_id; ?>" class="MagicZoom"  href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                        <img data-animation="animated zoomInLeft" src="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"> </a> </div>
                                        <?php
                                        if($i>0)  
                                        {
                                        ?>
                                            <a class="left carousel-control" href="#myCarousel<?php echo $leave_request_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 140px 0px;
                                            font-size: 28px;background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a> 
                                            
                                            <a class="right carousel-control" href="#myCarousel<?php echo $leave_request_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 140px 0px; font-size: 28px;
                                            background-color: rgba(0,0,0,0.5);border-radius: 50%;height: 50px;width: 50px;text-align: center;line-height: 51px;"></i></a>
                                        <?php }  ?>
                                        <div class="selectors">
                                        <a data-zoom-id="Zoom-<?php echo $leave_request_id; ?>" href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"
                                        data-image="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>" >
                                        <img srcset="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                        </a>
                                        </div> 
                                    <?php   }  ?>   
                                    </div>
                                    </div>
                                <?php }  ?> 
                                </div>
                            </div> 
                            <div class="clearfix"></div> 
                            
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="2" >
                            <p><strong><?php if($leave_request_info['request_status'] == '0') { echo "<font color='red'>Denied</font>"; } else { echo "<font color='green'>Approved</font>";} ?> (by <?php if($leave_request_info['approved_by'] == 'T'){ echo "Teacher";} else{ echo "Admin";} ?>)</strong></p>
                            <p><strong>Remarks:</strong> <?php echo $leave_request_info['comment']; ?></p>
                        </td>
                    </tr>
                    
                </tbody> 
            </table>  
            </form>
        </div> 
    </div> 
</div>  