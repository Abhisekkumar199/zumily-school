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
            $('#errorMsg').html("<div class='alert alert-danger'>Please select a course stream.</div>"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        } 
        
        if(fee_year_month == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select year month (YYYYMM).</div>");
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
            $('#errorMsg').html("<div class='alert alert-danger'>Please select a fee type.</div>");
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
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter additional amount.</div>");
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
<div class="tz-2 mainContant zumily_mainContent "  style="min-height: 500px;background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main"> 
        <h4>Additional Fee Setup for a Class  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>create-class-register-fee-pdf/<?php echo base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        </h4>
        <form id="date_form" method="POST" action="<?php echo base_url();?>class-register-additional-fee-process">  
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <div class="form-group col-sm-12" style="margin-top:6px;">
        	<span id="errorMsg" style="color:red;"></span>
        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
            <br>
            <span id="errorMsg"></span>
            <div class="row">
                <div class="col-sm-12"  style="margin-top:15px;">
                    <span>Course Stream </span> &nbsp;&nbsp;
                    <input type="radio" name="stream" value="A" required > <strong>Arts</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="S" required > <strong>Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="B" required > <strong>Biology</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="H" required > <strong>Home Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="stream" value="M" required > <strong>Mathematics</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                        <option value="<?php echo $session_year_months[$x]; ?>"><?php echo $session_year_months[$x]; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                
                <div class="col-sm-3"  style="margin-top:15px;">
                    <span>Fee Type</span>
                    <select class="form-control fee_type" name="fee_type"  id="fee_type"  style="  font-family: monospace!important;" required>
                        <option value="">Select</option>
                        <?php 
        		            foreach($fee_types_lists as $fee_type)
        		            {
                	   ?>
                        <option value="<?php echo $fee_type->fee_type; ?>"><?php echo $fee_type->fee_type; ?></option>
                        <?php }   ?>
                    </select>
                </div>  
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>Amount</span>
                    <input type="text" name="amount" id="amount" class="form-control" style="background-color:#ffffff;" > 
                </div> 
                <div class="col-sm-2"  style="margin-top:15px;">
                    <span>&nbsp;</span>
                    <input type="submit" class="check1 btn btn-success col-md-12 save_fee" id="save_fee" name="save_fee" value="Submit">
                </div>
            </div>
        </div> 
        </form>  
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <input type="hidden" name="is_class_active" id="is_class_active" value="<?php echo $classregister_info['is_class_register_active']; ?>" /> 
        <div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	  
                	    <table class="table table-hover">
                        	<thead>
                            	<td ><span ><a href="javascript:void(0)"  >Month Year</a></span></td>   
                            	<td ><span ><a href="javascript:void(0)"  >Course Stream </a></span></td>   
                            	<td  ><span ><a href="javascript:void(0)"  >Fee Type</a></span></td>   
                            	<td    ><span ><a href="javascript:void(0)"  >Additional Fee Amount</a></span></td>   
                            	<td    ><span ><a href="javascript:void(0)"  >Action</a></span></td>   
                             
                        	</thead>
                        	<tbody id="attendance_data">  
                    	        <?php   
                    	        foreach($class_registe_additional_fee as $additional_fee)
                    	        {
                    	            ?>
                    	                
                    	                <tr class=" " style="background-color:#ffffff;"  >
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;">   <?php echo $additional_fee->yyyymm; ?>  </td> 
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;">   <?php echo $additional_fee->course_stream ; ?>   </td> 
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;">   <?php echo $additional_fee->fee_type; ?>  </td> 
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;">  <?php echo $additional_fee->additional_fee_amount; ?>   </td> 
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;"> <a href="https://localhost/project/zumilyschool//update-class-register-additional-fee/<?php echo base64_encode($class_register_id)."-".base64_encode($additional_fee->cr_additional_fee_id); ?>"><i class="fa fa-pencil" style="center; font-size:20px;color:#151f31;"></i></a> </td> 
                    	              
                	 	        <?php } ?>    
                    	    </tbody>
                    	</table>  
                	</div>
            	</div> 
    		</div>
    	</div>  
    	 
    	    
    </div> 
</div> 
</div>
</div>
 
  


<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Additional Fee Setup for a Class</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists all the additional fee to be collected from a specific Course-Stream from a class for the listed session-year.</li>
                  <li >For example, if your school collects additional Rs500 from 11D class for MATH students for the January month of the session year. In this situation, Select 01 month, specfic FEE-TYPE, and Rs500 and save it. </li>
                  <li >once you set this up and collect FEE from 11D for 01 month and MATH student, it will automatically add Rs500 with defined FEE-TYPE to the total amount.</li>
                  <li >This will help you not to forget to collect Additional Fee from students.</li>           
                </ul> 
            </div> 
        </div> 
    </div>
</div>
<style> 

.popup li::before {
  content: "\2022";
  color: red;
  font-weight: bold; 
  width: 1em;font-size: 25px;
  margin-left: -1em;
  margin-right: 10px;
}
</style>


