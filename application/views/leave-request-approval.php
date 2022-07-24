 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>Student Leave Request Approval</h4>
        <div class="db-list-com tz-db-table">
            <div id="snackbar">Profile updated Successfully!</div> 
            <form id="formCheck" action="<?php echo base_url();?>update-leave-request" method="POST"> 
            <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
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
                                        <div class="item <?php if($i == 0){ ?>active <?php } ?>"> <a id="Zoom-<?php echo $leave_request_id; ?>" class="MagicZoom"  href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                        <img data-animation="animated zoomInLeft" src="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"> </a> </div>
                                        <?php
                                        if($i>1)  
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
                                    <?php  }  ?>   
                                    </div>
                                    </div>
                                <?php }  ?> 
                                </div>
                            </div>
                            
                            <div class="clearfix"></div>
                            <br><br>
                            
                            
                        </td> 
                    </tr>
                    <tr style="border-bottom:none;">
                        <td colspan="2" style="padding:0px;">
                            <div class="btn-group form-group">  
                            	<input type="radio" class="sent_to" id="radio1" name="request_status" value="1" checked="checked"> 
                            	<label for="radio1" style="font-size:14px;">&nbsp; Approve</label>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            	<input type="radio" class="sent_to" id="radio3" name="request_status" value="0"> 
                            	<label for="radio3" style="font-size:14px;">&nbsp; Deny</label>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            </div>
                        </td>
                    </tr>
                    <tr style="border-bottom:none;">
                        
                        <td colspan="2" style="padding:0px;">
                            <label>Please enter comments here</label>
                            <textarea   name="comment" id="elm1" class="form-control"  style="height:150px;width: 581px;background-color:#ffffff;" required > </textarea>
                            <input type="hidden" name="leave_request_id"  value="<?php echo $leave_request_id; ?>" /> 
                        </td>
                    </tr>
                     
                </tbody> 
            </table> 
            <span class="col-md-3" style="margin-top:10px;" id="error_msg_comment"></span>
            <div class="db-mak-pay-bot col-md-6 col-md-offset-3"> 
                    <input type="submit" class="check1 btn btn-success col-md-12" id="  signup" name="update" value="Submit"  /> 
            </div> 
            </form>
        </div> 
    </div> 
</div>  
<script>
    $(".check1").click(function(){ 
           
        
        var editors = textboxio.get('#elm1');
        var editor = editors[0];
        var flyer_desc = editor.content.get(); 
        if(flyer_desc == '<p><br /></p>' || flyer_desc == '' || flyer_desc == ' ')
        {
            $('#error_msg_comment').html("<div class='alert alert-danger'>Please enter comment!</div>");
            $('#comment').css("border","1px solid red");
    		$('#comment').focus();
    		return false;
        }
        else
        {
            $('#error_msg_comment').html("");
            $('#comment').css("border","1px solid #c9c9c9");
        }
       
         $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
        $("#preloader").show();
        return false;
    });
  </script> 