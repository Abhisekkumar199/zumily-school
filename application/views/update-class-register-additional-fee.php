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
    
    
    });
    
</script>
 
<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
	    var stream = parseInt($('input[name="stream"]:checked').length); 
        var fee_year_month = $('#fee_year_month').val();  
        var fee_type = $('#fee_type').val();  
        var amount = $('#amount').val();   
        
        if(stream <= 0)
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select stream</div>"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        } 
        
        if(fee_year_month == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select year month</div>");
            $('#fee_year_month').css("border","1px solid red");
    		$('#fee_year_month').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#fee_year_month').css("border","1px solid #c9c9c9");
        }
        if(fee_type == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select fee type</div>");
            $('#fee_type').css("border","1px solid red");
    		$('#fee_type').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#fee_type').css("border","1px solid #c9c9c9");
        }
        if(amount == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter amount</div>");
            $('#amount').css("border","1px solid red");
    		$('#amount').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#amount').css("border","1px solid #c9c9c9");
        }
        
    }); 
      
    
     
       
    });
    
</script> 
 
<div class="tz-2 mainContant zumily_mainContent"  >
    <div class="tz-2-com tz-2-main" style="min-height:500px;"> 
        <h4>Update Additional Fee  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i>
            <a href="<?php echo base_url(); ?>create-class-register-fee-pdf/<?php echo base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        </h4>
        <form id="date_form" method="POST" action="<?php echo base_url();?>update-class-register-additional-fee-process">  
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <input type="hidden" name="additional_fee_id" id="additional_fee_id" value="<?php echo $additional_fee_id; ?>" />
        <div class="form-group col-sm-12" style="margin-top:6px;">
        	<span id="errorMsg" style="color:red;"></span>
        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
            <br>
            <span id="errorMsg"></span>
            <div class="row">
                <div class="col-sm-12"  style="margin-top:15px;">
                    <span>Course Stream </span>
                    <input type="radio" name="stream" value="A" required <?php if($additional_fee_info['course_stream'] == 'A'){ echo "checked"; } ?> > <strong>Arts</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="S" required <?php if($additional_fee_info['course_stream'] == 'S'){ echo "checked"; } ?> > <strong>Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="B" required <?php if($additional_fee_info['course_stream'] == 'B'){ echo "checked"; } ?> > <strong>Biology</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="H" required <?php if($additional_fee_info['course_stream'] == 'H'){ echo "checked"; } ?> > <strong>Home Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="M" required <?php if($additional_fee_info['course_stream'] == 'M'){ echo "checked"; } ?> > <strong>Mathematics</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </div>  
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>Year Month</span>
                    <select class="form-control fee_year_month" name="fee_year_month"  id="fee_year_month"  style="  font-family: monospace!important;" required>
                        <option value="">Select</option>
                        <?php 
                            if($classregister_info['session_year_months'] != '')
                	        { 
                	            $session_year_months = explode(',',$classregister_info['session_year_months']);  
                	            for($x=0;$x < count($session_year_months);$x++) 
            	                {
                	   ?>
                        <option value="<?php echo $session_year_months[$x]; ?>" <?php if($session_year_months[$x] == $additional_fee_info['yyyymm']){ echo "selected"; } ?>><?php echo $session_year_months[$x]; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>Fee Type</span>
                    <select class="form-control fee_type" name="fee_type"  id="fee_type"  style="  font-family: monospace!important;" required>
                        <option value="">Select</option>
                        <?php 
    		            foreach($fee_types_lists as $fee_type)
    		            {
                	   ?>
                        <option value="<?php echo $fee_type->fee_type; ?>" <?php if($fee_type->fee_type == $additional_fee_info['fee_type']){ echo "selected"; } ?> ><?php echo $fee_type->fee_type; ?></option>
                        <?php }   ?>
                    </select>
                </div>  
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>Amount</span>
                    <input type="text" name="amount" id="amount" value="<?php echo $additional_fee_info['additional_fee_amount']; ?>" class="form-control" style="background-color:#ffffff;" > 
                </div> 
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>&nbsp;</span>
                    <input type="submit" class="check1 btn btn-success col-md-12 save_fee" id="save_fee" name="save_fee" value="Submit">
                </div>
            </div>
        </div> 
        </form>  
         
    	 
    	    
    </div> 
</div> 
</div>
</div>
 
  
