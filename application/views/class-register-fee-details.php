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
        var fee_year_month = $('#fee_year_month').val(); 
        var is_value = parseInt($('#is_value').val());   
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
        
        if(is_value < 1)
        {
            $('#errorMsg').html("<div class='alert alert-danger'>You cannot leave all FEE TYPES blank. Please assign minimum one FEE TYPE for this year-month combination.</div>");
            
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        }  
    }); 
     
    $(".fee_type_value").change(function(){   
       var counter = parseInt($("#is_value").val());  
       if($(this).val() == '')
       { 
           var new_value = counter - 1 ;
            $("#is_value").val(new_value);  
       }
       else
       {  
           var new_value = counter + 1 ;
            $("#is_value").val(new_value); 
       }
    });
    
    
    $(".fee_year_month").change(function(){   
        var year_month = $(this).val();   
        var class_register_id = $("#class_register_id").val(); 
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/get-month-schoolfee",  
        data:{year_month:year_month,class_register_id:class_register_id},  
        success:function(response){    
            $(".fee_type_value").val(""); 
            if(response == 1)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>You are not allowed to change fees for this month because it has already passed. You can only change fees for current OR future months.</div>");
                
                $(".check1").attr("disabled", true);
    		    return false;
            }
            else
            {
                $(".check1").attr("disabled", false);
                $('#errorMsg').html("");
                if(response != '')
                {
                    var var1 = response.split(";"); 
                    var amounts = var1[0];
                    var ids = var1[1];  
                    var class_register_fee_ids = var1[2];  
                    var var2 = amounts.split("|");  
                    var var3 = ids.split("|");  
                    var var4 = class_register_fee_ids.split("|"); 
                    
                    var count = var2.length;
                    for(a=0;a<count;a++)
                    {   
                        $("#fee_type_"+var3[a]).val(var2[a]); 
                        $("#students_cr_fee_id_"+var3[a]).val(var4[a]); 
                    } 
                    
                    $("#is_value").val(count); 
                }
            }
            
     
        }
        }); 
    }); 
       
    });
    
</script> 
 
<div class="tz-2 mainContant zumily_mainContent "  style="min-height: 500px;background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main"> 
        <h4>Class Register Fee Setup  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>create-class-register-fee-pdf/<?php echo base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        </h4>
        <form id="date_form" method="POST" action="<?php echo base_url();?>class-register-fee-process">  
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <div class="form-group col-sm-12" style="margin-top:6px;">
        	<span id="errorMsg" style="color:red;"></span>
        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?></p>
            <br>
            <span id="errorMsg"></span>
            <div class="row">
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
                <input type="hidden" id="total_fee_type" value="<?php echo count($fee_types_lists); ?>" />
            	<?php
            	$j = 1;
        		foreach($fee_types_lists as $fee_type)
	            {
                ?>
                    <div class="col-sm-2" style="margin-top:15px;">
                        <span><?php echo $fee_type->fee_type; ?></span>
	                    <input type="hidden"   value="<?php echo $fee_type->students_fee_type_id; ?>" name="fee_type_id[]"   />
	                    <input type="hidden"   value="<?php echo $fee_type->fee_type; ?>" name="fee_type[]"   />
    	                <input type="number" class="form-control fee_type_value"   name="fee_type_value[]"    id="fee_type_<?php echo $fee_type->students_fee_type_id; ?>"     style=" float:left;margin-right:15px;background-color:#ffffff;" placeholder="" />
    	                
    	                <input type="hidden" class="form-control fee_type_value"   name="students_cr_fee_id[]"    id="students_cr_fee_id_<?php echo $fee_type->students_fee_type_id; ?>" />
	                </div> 
                <?php $j++; } ?>  
                <input type="hidden" id="is_value" value="0" />
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
                	    <?php  
                	        if($classregister_info['session_year_months'] != '')
                	        {
                	            $session_year_months = explode(',',$classregister_info['session_year_months']); 
        	            ?>
                	    <table class="table table-hover">
                        	<thead>
                            	<td    ><span ><a href="javascript:void(0)"  >Month Year</a></span></td>   
                            	<td    ><span ><a href="javascript:void(0)"  >Fee</a></span></td>   
                             
                        	</thead>
                        	<tbody id="attendance_data">  
                    	        <?php  
                    	        $month_array[] = array();
                    	        $x = 1;
                    	        foreach($class_register_fee_lists as $class_register_fee)
                    	        {
                    	            if($x == 1)
                    	            {
                    	                $month_array[] = $class_register_fee->yyyymm;
                    	                ?>
                    	                <tr class=" " style="background-color:#ffffff;"  >
                    	                    <td class="business_list_" style="  font-family: monospace!important;font-size:14px;">
                                    		     <strong> <?php echo $class_register_fee->yyyymm; ?> --</strong> </td><td> 
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
                        	 	        <tr class=" " style="background-color:#ffffff;"  >
                    	                    <td class="business_list_" style="width: 100px; font-family: monospace!important;font-size:14px;">
                                    		     <strong> <?php echo $class_register_fee->yyyymm; ?> --</strong>  </td><td> 
                        	 	        <?php
                        	 	        echo  "<strong>".$class_register_fee->fee_type.":</strong> ".$class_register_fee->amount."&nbsp;&nbsp;"; 
                        	 	    } 
                    	        ?>   
                        	    <?php $month_array[] = $class_register_fee->yyyymm; $x++;  }  ?> 
                    	    </tbody>
                    	</table> 
                	    <?php } else { ?> 
                    	<?php } ?>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Class Register Fee Setup</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page lists Fee Setup for all the months for the above selected CLASS.</li>
                  <li >Select a YYYYMM from the drop-down and populate FEE amount, you want to collect from this class's student for this selected month. </li>
                  <li >Make sure to select correct FEE-TYPE and amount before you save it.</li>
                  <li >This is one time setup to add for all the classes. However, you can always modify if created wrong.</li>           
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

