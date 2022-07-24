 
<script>
$(document).ready(function(){ 
    
    var today = new Date().toDateString("MMM DD, YYYY"); 
    var sd = today;
    var ed = new Date();

    console.log(sd);
    $('#received_date').datetimepicker({
      pickTime: false,
      format: "MMM DD, YYYY",
      defaultDate: today, 
      maxDate: ed,
      todayBtn: true
    });
 
    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#date_form"), 'received_date');

     
}); 
</script>
 
 <div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
        <h4>Student Report Card Update  
            <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i>
        </h4>
        <div class="col-sm-12" style="padding-top:10px;background: #ffffff;"> 
        	<p><strong>Class:</strong> <?php echo urldecode($class_name) ; ?>&nbsp;&nbsp; &nbsp;&nbsp; 
        	    <strong>Student Name:</strong> <?php echo urldecode($student_name); ?>&nbsp;&nbsp; 
        	    <strong>Course Stream:</strong> <?php echo urldecode($course_stream); ?>&nbsp;&nbsp; 
        	    
        	    
        	    <strong>Registration No.:</strong> <?php echo $registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>DOB:</strong> <?php echo urldecode($date_of_birth); ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>Father Name:</strong> <?php echo urldecode($father_name); ?>&nbsp;&nbsp;
        	</p> 
        </div>
        
        <form id="date_form" method="POST" action="<?php echo base_url();?>update-class-register-student-report-card-process">   
            <input type="hidden" name="class_register_student_id" id="class_register_student_id" value="<?php echo $class_register_student_id; ?>">
            <input type="hidden" id="class_register_id" name="class_register_id" value="<?php echo $class_register_id; ?>">
            <input type="hidden" name="class" value="<?php echo urldecode($class_name); ?>">
            <input type="hidden" name="course_stream" id="course_stream" value="<?php echo $course_stream; ?>">
            <input type="hidden" name="student_name" value="<?php echo urldecode($student_name); ?>">
            <input type="hidden" name="registration_no" value="<?php echo $registration_no; ?>">
            <input type="hidden" name="dob" value="<?php echo urldecode($date_of_birth); ?>">
            <input type="hidden" name="father_name" value="<?php echo urldecode($father_name); ?>">
            <input type="hidden" name="profile_picture" value="<?php echo urldecode($profile_picture); ?>">
            <input type="hidden" name="student_id" value="<?php echo urldecode($student_id); ?>"> 
            
            
           
            <input type="hidden" name="fee_breakup_info" id="fee_breakup_info" value="">
            <div class="form-group col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span> 
                <span id="errorMsg"></span>
                <div class="row">  
                    <?php
                    $x = 1;
                    foreach($reporting_periods_list as $reporting_period)
                    {
                    ?>
                
                    <div class="col-sm-3"  style="margin-top:10px;">
                        <input type="radio" class=" reporting_cr_period_id"  name="reporting_cr_period_id" onchange="get_subjects(<?php echo $reporting_period->reporting_cr_period_id; ?>);"  value="<?php echo $reporting_period->reporting_cr_period_id; ?>"   <?php if($x == 1){ ?> checked <?php } ?>  /> <?php echo $reporting_period->exam_name; ?>
                        <br>
                        <span><?php echo date("d-m-Y",strtotime($reporting_period->start_date)); ?></span>&nbsp;to&nbsp;<span><?php echo date("d-m-Y",strtotime($reporting_period->end_date)); ?></span>              
                    </div> 
                    <?php $x++; } ?>
                    <div class="clearfix"></div>
                </div>   
                
                <div class="row"> 
                    <div class="col-sm-3" style="margin-top:15px;"> 
                        <strong>Subjects</strong> 
	                </div>  
	                <div class="col-sm-2" style="margin-top:15px; ">  
                        <strong>Maximum Marks</strong> 
                    </div>  
	                <div class="col-sm-2" style="margin-top:15px; ">  
                        <strong>Obtained Marks</strong> 
                    </div>
                </div>
                <span id="show_subject">
                   <?php echo $output; ?> 
                </span> 
                
                
                
                </div>
            </div> 
        </form>  
 
                    <br> 
    </div>
</div>  
<script type="text/javascript">

function get_subjects(id)
{    
    
	var class_register_student_id = $("#class_register_student_id").val(); 
	var class_register_id = $("#class_register_id").val(); 
    $("#show_fee_breakup").html(''); 
	$(".loader_class").show();
    $.ajax({
        type: "POST", 
        url:"<?php echo base_url(); ?>get-reporting-class-period-subjects",
        data:{reporting_cr_period_id:id,class_register_student_id:class_register_student_id,class_register_id:class_register_id}, 
        success:function(response){
            console.log(response);
	        $(".loader_class").hide();
		    if(response != '')
            { 
                $("#show_subject").html(response);   
            }
        },
        error:function (xhr, ajaxOptions, thrownError){
            alert(thrownError);
        }
    });
   
}
</script>

<script>
    $(".check1").click(function(){  
              
    	var reporting_cr_period_id = $('input[name="reporting_cr_period_id"]:checked').length;  
    	
    	var total_subject = $("#total_subject").val(); 
        if(reporting_cr_period_id == 0)
        {
            $('#errorMsg').html("Please select reporting period!"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        } 
        
        for(var x=1;x<=total_subject;x++)
        { 
    	    var maximum_marks = parseInt($("#maximum_marks"+x).val()); 
    	    var obtained_marks = parseInt($("#obtained_marks"+x).val());  
            if(obtained_marks  > maximum_marks)
            {
                $('#errorMsg').html("Marks obtained cannot be greater than maximum marks"); 
        		return false;
            }
            else
            {
                $('#errorMsg').html(""); 
            }  
        }
        
    }); 
   
  </script> 
 
 
 