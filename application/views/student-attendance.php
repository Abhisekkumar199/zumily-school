<script>
$(document).ready(function(){ 
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;

    console.log(sd);
    $('#attendance_date1').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY",
      defaultDate: sd, 
      todayBtn: true
    }); 
    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#formCheck"), 'attendance_date1'); 
});
 
$(document).ready(function(){
    
    $("#attendance_date").val($("#attendance_date1").val());
    
    $('#attendance_date1').on('change', function() { 
        var attendance_date = $(this).val();
        
        $("#attendance_date").val($(this).val());
        var class_register_id = $('#class_register_id').val();
        var is_class_active = $('#is_class_active').val();
        $.ajax({
            type: "POST", 
            url:"<?php echo base_url(); ?>get-student-attendance",
            data:{attendance_date:attendance_date, class_register_id:class_register_id, is_class_active:is_class_active}, 
            success:function(response){ 
                var jd = JSON.parse(response);  
                $("#updated_date").html(jd.updated_date);  
			    $("#attendance_data").html(jd.attendance_list); 
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        });
    });
    
    
    $(".check1").click(function(){ 
        var memberids = $('#memberids').val();  
	   
      
        
        if(memberids =='')
        {
            $('#errorMsg').html("Please enter date of birth"); 
            $('#memberids').css("border","1px solid red");
    		$('#memberids').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
            $('#memberids').css("border","1px solid #c9c9c9");
        }  
         $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
    }); 
     
    });
    
</script>
 
 
<div class="tz-2 mainContant zumily_mainContent"  >
    <div class="tz-2-com tz-2-main"> 
        <h4  >Class Attendance  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        
        <form id="date_form" method="POST"> 
        
        <div class="form-group col-sm-8" style="margin-top:6px;">
        	<span id="errorMsg" style="color:red;"></span>
        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
            <br>
            <div id="updated_date">
		    <strong>Attendance taken on:</strong> <?php if(count($is_attendance_exist) == 0) { echo "<span class='label label-danger'>No attendance taken yet!</span>";} else {  echo "<span class='label label-primary mono-font '>".date('D, d M, Y h:i',strtotime($is_attendance_exist['last_updated']))."</span>"; } ?>
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Taken By:</strong> <?php if(count($is_attendance_exist) == 0) {  echo "<span class='label label-danger'>None</span>";} else { if($is_attendance_exist['done_by'] == 'T') {   echo "<span class='label label-primary mono-font '>Class Teacher </span>"; } else {echo "<span class='label label-primary mono-font '>Admin</span>"; } } ?>
		    </div>
        </div>
        <div class="form-group col-sm-4" style="margin-top:6px;"> 
            <p><strong>Date:</strong>&nbsp;<input type="text" name="attendance_date" id="attendance_date1" value="<?php if($selected_date != '') {  echo date('D, d M , Y',strtotime($selected_date)); } ?>"   readonly value="" style="width: 60%!important;background-color: #ffffff!important;border: 1px solid #d8d7d7!important;"  /> </p>
        </div>
        </form>
        <form id="formCheck" action="<?php echo base_url();?>/student-attendance-process" method="POST"  autocomplete="off" onsubmit="return Validate(this);"> 
        <input type="hidden" name="totalstudent" value="<?php echo count($class_student_attendance_lists); ?>" />
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <input type="hidden" name="is_class_active" id="is_class_active" value="<?php echo $classregister_info['is_class_register_active']; ?>" />
        <input type="hidden" name="attendance_date" id="attendance_date"   />
        <input type="hidden" name="previous_url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
        <div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	    <?php if($classregister_info['is_class_register_active'] == '0'){ ?>
                	    <table class="table table-hover">
                        	<thead>
                            	<td  style="width: 260px;"  ><span ><a href="javascript:void(0)"  >Student&nbsp;name   </a></span></td> 
                            	<td  style="width: 160px;" class="text-center" ><span ><a href="javascript:void(0)"  >Leave </a></span></td>      
                            	<td  style="width: 160px;" class="text-center" ><span ><a href="javascript:void(0)"  >Absent </a></span></td>      
                            	<td  style="width: 160px;"class="text-center"  ><span ><a href="javascript:void(0)"  >Present </a></span></td>   
                        	</thead>
                        	<tbody id="attendance_data">  
                        	        <?php $x = 1; foreach($class_student_attendance_lists as $class_student_attendance_list) { ?>
                            	    <input type="hidden" name="class_register_student_ids[]" value="<?php echo $class_student_attendance_list->class_register_student_id; ?>" />
                            	    <input type="hidden" name="student_attendance_ids[]" value="<?php echo $class_student_attendance_list->student_attendance_id; ?>" />
                            	     <tr class=" "   >
                                		<td class="business_list_">
                                		     <?php if(!empty($class_student_attendance_list->profile_picture)) { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $class_student_attendance_list->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } else { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } ?>&nbsp;
                                		    <?php echo $class_student_attendance_list->first_name." ".$class_student_attendance_list->middle_name." ".$class_student_attendance_list->last_name; ?>
                                		    
                                		</td> 
                                		<td class="business_list_ text-center">  <?php   if($class_student_attendance_list->attendance_day== 'L') {?> <i class="fa fa-check" aria-hidden="true" style="background-color:#f0ad4e;color: #ffffff;padding: 5px 6px;" title="Presents"></i> <?php } ?>  </td>  
                                		<td class="business_list_ text-center"> <?php   if($class_student_attendance_list->attendance_day== 'A') {?><i class="fa fa-times label-danger" aria-hidden="true" style="background-color:#d9534f;color: #ffffff;padding: 5px 6px;" title="Presents"></i> <?php } ?> </td> 
                                		<td class="business_list_ text-center"> <?php   if($class_student_attendance_list->attendance_day== 'PL') {?><i class="fa fa-check" aria-hidden="true" style="background-color:#5cb85c;color: #ffffff;padding: 5px 6px;" title="Presents"></i><?php } ?> </td>  
                            		</tr>
                            	    <?php $x++; }  ?>
                                
                    	    </tbody>
                    	</table>
                	    
                	    <?php } else { ?>
                    	<table class="table table-hover">
                        	<thead>
                            	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name   </a></span></td> 
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Leave </a></span></td>      
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Absent </a></span></td>      
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Present </a></span></td>   
                        	</thead>
                        	<tbody id="attendance_data">  
                        	        <?php $x = 1; foreach($class_student_attendance_lists as $class_student_attendance_list) { ?>
                            	    <input type="hidden" name="class_register_student_ids[]" value="<?php echo $class_student_attendance_list->class_register_student_id; ?>" />
                            	    <input type="hidden" name="student_attendance_ids[]" value="<?php echo $class_student_attendance_list->student_attendance_id; ?>" />
                            	     <tr class=" "   >
                                		<td class="business_list_">
                                		    <?php if(!empty($class_student_attendance_list->profile_picture)) { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $class_student_attendance_list->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } else { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } ?>&nbsp;
                                		    <?php echo $class_student_attendance_list->first_name." ".$class_student_attendance_list->middle_name." ".$class_student_attendance_list->last_name; ?>
                                		    
                                		</td> 
                                		<td class="business_list_"><input type="radio" class="form-control" name="status<?php echo $x; ?>" value="L" <?php   if($class_student_attendance_list->attendance_day== 'L') { echo "checked";} ?> /> </td>  
                                		<td class="business_list_"><input type="radio" class="form-control" name="status<?php echo $x; ?>" value="A" <?php   if($class_student_attendance_list->attendance_day== 'A') { echo "checked";} ?> /> </td> 
                                		<td class="business_list_"><input type="radio" class="form-control" name="status<?php echo $x; ?>" value="P" <?php  if($class_student_attendance_list->attendance_day== 'P' or count($is_attendance_exist) == 0) { echo "checked";} ?>  /> </td>  
                            		</tr>
                            	    <?php $x++; }  ?>
                                
                    	    </tbody>
                    	</table>
                    	<?php } ?>
                	</div>
            	</div> 
    		</div>
    	</div>  
    	
    	<?php if($classregister_info['is_class_register_active'] == '0'){ } else { ?>
    	<div class="row" style="margin-bottom:20px;">  
            <div class="col-md-6 col-md-offset-3"> 
                <input type="submit" class="check1 btn btn-success col-md-12 save_attendance" id="save_attendance" name="save_attendance" value="Save Attendance"> 
            </div> 
        </div> 
        <?php } ?>
        </form>
    </div> 
</div> 
</div>
</div>
 
  
