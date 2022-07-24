 
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
        <h4>Student Fee Payment  
            <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i>
            <a href="<?php echo base_url(); ?>class-register-student-fee-pdf/<?php echo base64_encode($class_register_student_id)."-".base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        
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
        
        <form id="date_form" method="POST" action="<?php echo base_url();?>school-fee-payment-process">   
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
            <input type="hidden" name="concession_amount" id="concession_amount" value="<?php echo $class_register_active_concession['concession_amount']; ?>">
            <input type="hidden" name="student_fee_concession_id"  value="<?php echo $class_register_active_concession['students_fee_concession_id']; ?>">
            <input type="hidden" name="concession_frequency"  value="<?php echo $class_register_active_concession['concession_frequency']; ?>">
            
            
           
            <input type="hidden" name="fee_breakup_info" id="fee_breakup_info" value="">
            <div class="form-group col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span> 
                <span id="errorMsg"></span>
                <div class="row">
                    <?php 
                        $paid_month = explode(",",$paid_month);
                        $setuped_month = explode(",",$setuped_month);
                        if($classregister_info['session_year_months'] != '')
            	        { 
            	            $session_year_months = explode(',',$classregister_info['session_year_months']);  
            	            for($x=0;$x < count($session_year_months);$x++) 
        	                {
        	                    if (in_array($session_year_months[$x], $paid_month)) 
        	                    {} 
        	                    else 
        	                    {
        	                        if (in_array($session_year_months[$x], $setuped_month))
        	                        { 
            	    ?>
                        <div class="col-sm-2"  style="margin-top:10px;">
                            <input type="checkbox" onclick="get_month_fee(<?php echo $session_year_months[$x]; ?>)" class=" fee_year_month"  name="fee_year_month[]"  id="fee_year_month<?php echo $session_year_months[$x]; ?>" value="<?php echo $session_year_months[$x]; ?>"     /> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $session_year_months[$x]; ?>
                        </div>
                    <?php } } } } ?> 
                    <div class="clearfix"></div>
                    
                    
                    <div class="col-sm-12" id="show_fee_breakup" style="margin-top:10px;" > 
                         
                    </div>
                    <div class="col-sm-12 loader_class" style="text-align: left; display: none;"><span style=""><img style="height:20px;width:20px;text-align-center;" src="<?php echo base_url(); ?>/assets/images/loader.gif"></span></div>
                    <div class="clearfix"></div>
                    
                    <div class="col-sm-2" style="margin-top:10px;"> 
                        <label>Receipt No.: </label>&nbsp;<?php echo $receipt_no + 1; ?>
    	                <input type="hidden" class="form-control" name="receipt_number" id="receipt_number"   value="<?php echo $receipt_no + 1; ?>" />
	                </div> 
	                 
                    <input type="hidden" class="form-control total_fee"   name="total_fee"    id="total_fee"       />
	                
	                <div class="col-sm-2" style="margin-top:10px;width:16%;"> 
    	                <input type="number" class="form-control late_fee"   name="late_fee"    id="late_fee"     style=" float:left;margin-right:8px;background-color:#ffffff;" placeholder="Late Fee" />
	                </div> 
	                
	                <div class="col-sm-2" style="margin-top:10px;width:16%;"> 
    	                <input type="number" class="form-control received_amount"   name="received_amount"    id="received_amount"     style=" float:left;margin-right:8px;background-color:#ffffff;" placeholder="Received Amt" />
	                </div> 
	                
	                <div class="col-sm-2" style="margin-top:10px;width:16%;"> 
    	                <select id="payment_mode" name="payment_mode" class="form-control payment_mode">
    	                    <option value="">Pay Mode</option> 
    	                    <option value="Cash">Cash</option> 
    	                    <option value="Bank">Bank</option> 
    	                    <option value="Check/DD">Check/DD</option> 
    	                </select>
	                </div> 
                   <div class="col-sm-2" style="margin-top:10px;width:16%;"> 
                        <input type="text" class="  form-control"  name="received_date" id="received_date" style="background-color:#ffffff;"  value="<?php echo date("M d, Y",strtotime($this->session->userdata('current_date'))); ?>"  placeholder="Received Date"   />   
	                </div>    
                    <input type="hidden" id="is_value" value="0" />
                    <div class="col-sm-2"  style="margin-top:10px;width:16%;">
                        <input type="submit" class="check1 btn btn-success col-md-12 save_fee" id="save_fee" name="save_fee" value="Submit">
                    </div>
                </div>
            </div> 
        </form>  

        <div class="col-sm-12 fullWidth-tab" style="min-height:400px;"> 
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
    	            <div class="table-responsive tab-inn ad-tab-inn" id="active">
                        <table class="table table-hover">
                        	<thead>
                            	<td     ><span ><a href="javascript:void(0)"  >Month</a></span></td>  
                            	<td   ><span ><a href="javascript:void(0)"  >Receipt Number</a></span></td> 
                            	<td   ><span ><a href="javascript:void(0)"  >Payment Mode</a></span></td> 
                            	<td   ><span ><a href="javascript:void(0)"  >Payment Date</a></span></td> 
                            	<td  class='text-right'  ><span ><a href="javascript:void(0)"  >Total Fee</a></span></td>
                            	<td  class='text-right'  ><span ><a href="javascript:void(0)"  >Late Fee</a></span></td>
                            	<td  class='text-right'  ><span ><a href="javascript:void(0)"  >Received Amount</a></span></td>
                        	</thead>
                        	<tbody id="attendance_data">  
                    	        <?php  
                    	        $grand_total_fee = 0;
                    	        $grand_late_fee = 0;
                    	        $grand_received_amount = 0;
                    	        if(count($class_register_fee_payment_list) > 0)
                    	        {
                    	        foreach($class_register_fee_payment_list as $payment)
                    	        {
                    	            $grand_total_fee  = $grand_total_fee + $payment->total_fee;
                    	            $grand_late_fee  = $grand_late_fee + $payment->late_fee;
                    	            $grand_received_amount  = $grand_received_amount + $payment->received_amount;
                    	            
                    	        ?> 
                    	         
                        	     <tr class=" " style="background-color:#ffffff;"  >
                            		<td style="font-size:12px;"> <?php echo $payment->payment_months; ?> </td> 
                            		<td style="font-size:12px;"> <?php echo $payment->receipt_number; ?> </td> 
                            		<td style="font-size:12px;"> <?php echo $payment->payment_mode; ?> </td> 
                            		<td style="font-size:12px;"> <?php echo $payment->payment_date; ?> </td> 
                            		<td  class='text-right' style="font-size:12px;"> <?php echo $payment->total_fee; ?> </td> 
                            		<td  class='text-right' style="font-size:12px;"> <?php echo $payment->late_fee; ?> </td> 
                            		<td  class='text-right' style="font-size:12px;"> <?php echo $payment->received_amount; ?> </td> 
                        		</tr>
                        	    <?php  }  ?> 
                        	    
                        	    <tr>
                        	        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>Grand Total:</th>
                        	        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>&nbsp;</th>
                        	        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>&nbsp;</th> 
                        	        <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;'>&nbsp;</th> 
                                    <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_total_fee; ?></th>
                                    <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_late_fee; ?></th>
                                    <th style='padding-top: 10px; padding-bottom: 10px;font-weight: 700;background-color: #ffffff;' class='text-right'><i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_received_amount; ?></th>
                                </tr>
                                <tr ><th colspan="5" style="border-top:none;background-color: #ffffff;"></th><th style='border-top:none;padding-top: 15px; padding-bottom: 5px;font-weight: 700;background-color: #ffffff;' class='text-right' colspan="2">Total Session-year Fee:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $total_year_fee; ?></th></tr>
                                <tr ><th colspan="5" style="border-top:none;background-color: #ffffff;"></th><th style='padding-top: 5px;border-top:none; padding-bottom: 5px;font-weight: 700;background-color: #ffffff;' class='text-right' colspan="2">Total Received Fee:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $grand_total_fee; ?></th></tr>
                                <tr ><th colspan="5" style="border-top:none;background-color: #ffffff;"></th><th style='padding-top: 5px;padding-bottom: 5px;font-weight: 700;background-color: #ffffff;' class='text-right' colspan="2">Remaining Balance:&nbsp;&nbsp;<i class='fa fa-inr' aria-hidden='true'></i><?php echo $total_year_fee - $grand_total_fee; ?></th></tr>
                    	    
                    	        <?php } else { ?>
                    	        
                    	          <tr ><th colspan="7" style="border-top:none;background-color: #ffffff;" class="text-center"><p style="margin-top:40px; color:red;"><strong>*** No Payment has been received from this STUDENT yet. ***</strong></p></th> </tr>
                    	    
                    	        <?php } ?>
                    	    </tbody>
                    	</table> 
                    </div> 
                </div> 
            </div> 
        </div> 
                    <br> 
    </div>
</div>  
<script type="text/javascript">

function get_month_fee(id)
{     name=""
    var class_register_id = $('#class_register_id').val();
    var concession_amount = $('#concession_amount').val();
    var fee_type = $('#fee_type').val();
    var course_stream = $('#course_stream').val(); 
    var additional_fee_amount = $('#additional_fee_amount').val(); 
    var class_register_student_id = $('#class_register_student_id').val(); 
    var months = [];
    $(':checkbox:checked').each(function(i){
      months[i] = $(this).val();
    }); 
    
    $("#show_fee_breakup").html(''); 
	$(".loader_class").show();
    $.ajax({
        type: "POST", 
        url:"<?php echo base_url(); ?>get-month-fee-amount",
        data:{months:months,class_register_id:class_register_id,course_stream:course_stream,concession_amount:concession_amount,fee_type:fee_type,class_register_student_id:class_register_student_id}, 
        success:function(response){
            console.log(response);
	        $(".loader_class").hide();
		    if(response != '')
            {
                var var1 = response.split("|"); 
                var amounts = var1[0];
                var fee_types = var1[1]; 
                var fee_breakup_info = var1[2].toString(); 
                    $("#show_fee_breakup").html(fee_types); 
                    $("#total_fee").val(amounts); 
                    $("#fee_breakup_info").val(fee_breakup_info); 
                
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
          
	var fee_year_month = $('input[name="fee_year_month[]"]:checked').length; 
    var receipt_number = $('#receipt_number').val();   
    var total_fee = $('#total_fee').val();   
    var payment_mode = $('#payment_mode').val();   
    var received_amount = $('#received_amount').val();  
    
    if(fee_year_month == 0)
    {
        $('#errorMsg').html("Please select at least a month!"); 
		return false;
    }
    else
    {
        $('#errorMsg').html(""); 
    } 
    
    if(receipt_number == '')
    {
        $('#errorMsg').html("Please enter receipt number!");
        $('#receipt_number').css("border","1px solid red");
		$('#receipt_number').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#receipt_number').css("border","1px solid #c9c9c9");
    } 
    
  
    
    
    
    if(received_amount == '')
    {
        $('#errorMsg').html("Please enter received amount");
        $('#received_amount').css("border","1px solid red");
		$('#received_amount').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#received_amount').css("border","1px solid #c9c9c9");
    } 
    
    if(payment_mode == '')
    {
        $('#errorMsg').html("Please select payment mode");
        $('#payment_mode').css("border","1px solid red");
		$('#payment_mode').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#payment_mode').css("border","1px solid #c9c9c9");
    } 
    
    }); 
   
  </script> 
 
 
 