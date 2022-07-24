 
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
 
<div class="tz-2 mainContant  " style="min-height: 400px;background-color:#ffffff;"  >
    <div class="tz-2-com tz-2-main"> 
        <h4>Student Fee Receipt  
            <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i>
            <a href="<?php echo base_url(); ?>student-fee-receipt-pdf/<?php echo base64_encode($receipt_no); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        
        </h4>
        
        
        <form id="date_form" method="POST" action="<?php echo base_url();?>student-fee-receipt">   
            <div class="form-group col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span>  
                <div class="row"> 
                    
                    <div class="col-sm-2" style="margin-top:10px;"> 
                        <label>Receipt No.: </label>&nbsp; 
    	                <input type="text" class="form-control" name="receipt_number" id="receipt_number" style="background-color:#ffffff;"  value="<?php echo $receipt_no; ?>" />
	                </div>  
	                
                    <input type="hidden" id="is_value" value="0" />
                    <div class="col-sm-2"  style="margin-top:10px;width:16%;">
                        <label>&nbsp;</label>
                        <input type="submit" class="check1 btn btn-success col-md-12 save_fee" id="save_fee" name="save_fee" value="Submit">
                    </div>
                </div>
            </div> 
        </form>  
        <?php   
                    	        
        if(count($student_fee_receipt_info) > 0)
        { 
        ?> 
        <div class="col-sm-12" style="padding-top:10px;background: #ffffff;"> 
            <p><strong>Student Name:</strong>&nbsp;<?php echo $student_fee_receipt_info[0]->first_name." ".$student_fee_receipt_info[0]->last_name; ?> (<?php echo $student_fee_receipt_info[0]->class_name_section; ?>)&nbsp;&nbsp; 
        	    <strong>Registration No.:</strong>&nbsp;<?php echo $student_fee_receipt_info[0]->registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>DOB:</strong>&nbsp;<?php echo $student_fee_receipt_info[0]->date_of_birth; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>Father Name:</strong>&nbsp;<?php echo $student_fee_receipt_info[0]->father_name; ?>&nbsp;&nbsp;
        	</p>
        </div>
        <?php } ?>
        <div class="col-sm-12 fullWidth-tab"> 
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
    	            <div class="table-responsive tab-inn ad-tab-inn" id="active">
                        <table class="table table-hover"> 
                        	<tbody id="attendance_data">  
                    	        <?php   
                    	        
                    	        if(count($student_fee_receipt_info) > 0)
                    	        { 
                    	        ?>  
                        	        <tr class=" " style="background-color:#ffffff;"  >
                        	            <td style=" width:30%;">
                        	                <table>
                        	                    <tr> 
                        	                        <td style="font-size:12px;padding-bottom: 0; ">
                    	                            <table>
                                            	        <tr>
                                            	            <td class="text-left" style="padding-bottom: 0;"><strong>Month:</strong> </td>
                                            	            <td class="text-left" style="padding-bottom: 0;width:100px;"><?php echo $student_fee_receipt_info[0]->payment_months; ?></td> 
                                        	            </tr>
                                        	        </table>
                        	                        </td> 
                    	                        </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;">
                                            	        <table>
                                            	        <tr>
                                            	            <td class="text-left" style="padding-bottom: 0;"> <strong>Receipt no:</strong></td> 
                                            	            <td class="text-left" style="padding-bottom: 0;width:100px;"><?php echo $receipt_no; ?> </td>
                                        	           </tr>
                                        	            </table>
                                            	    </td> 
                                        	    </tr> 
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;">
                                            	        <table>
                                            	        <tr>
                                            	            <td class="text-left" style="padding-bottom: 0;"> <strong>Payment Date:</strong> </td>
                                            	            <td class="text-left" style="padding-bottom: 0;width:100px;"><?php echo $student_fee_receipt_info[0]->payment_date; ?> </td>
                                        	            </tr>
                                        	            </table>
                                            	    </td> 
                                        	    </tr> 
                                    		</table>
                            		    </td>
                            		    <td style=" width:28%;">
                        	                <table> 
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	    <table>
                                            	        <tr>
                                            	            <td class="text-right" style="padding-bottom: 0;"><strong>Total Fee:</strong> </td>
                                            	            <td class="text-right" style="padding-bottom: 0;width:48px;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->total_fee; ?> </td>
                                            	        </tr>
                                            	    </table>
                                            	    </td>  
                                        	    </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	    <table>
                                            	        <tr>
                                            	            <td class="text-right" style="padding-bottom: 0;"><strong>Late Fee:</strong> </td>
                                            	            <td class='text-right' style="padding-bottom: 0;width:48px;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->late_fee; ?> </td>  
                                	                    </tr>
                                            	    </table>
                                            	    </td>  
                                	            </tr>
                                            	<tr> 
                                            	    <td style="font-size:12px;padding-bottom: 0;" >
                                            	        <table>
                                            	        <tr>
                                            	            <td class="text-right" style="padding-bottom: 0;"><strong>Concession:</strong> </td>
                                            	            <td class='text-right' style="padding-bottom: 0;width:48px;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->concession; ?> </td>  
                                        	            </tr>
                                        	            </table>
                                            	    </td>  
                                	            </tr>
                                        	    <tr> 
                                        	        <td style="font-size:12px;padding-bottom: 0;" >
                                        	        <table>
                                            	        <tr>
                                            	            <td class="text-right" style="padding-bottom: 0;"><strong>Received Amount:</strong> </td>
                                        	                <td class='text-right' style="padding-bottom: 0;width:48px;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $student_fee_receipt_info[0]->received_amount; ?> </td>  
                                    	                </tr> 
                                	                </table> 
                                            	    </td>  
                                	            </tr>
                        	                </table>
                        		        </td>
                            		    <td style=" width:40%;">
                            		        <table>
                            		            <tr><th style='border-top:none;  padding-bottom: 5px;font-weight: 700;background-color: #ffffff;text-align:right;text-decoration: underline;' >Fee Breakup</th></tr>
                            		            
                                        	    <?php
                                        	    $fee_breakup_string = explode(';',$student_fee_receipt_info[0]->fee_breakup_info);
                                        	    
                                        	    for($i=0;$i<count($fee_breakup_string);$i++)
                                        	    { 
                                        	        $fee_breakup = explode('|',$fee_breakup_string[$i]); 
                                        	    ?>
                                                <tr >
                                                    <td style="font-size:12px;padding-bottom: 0;" >
                                        	        <table>
                                            	        <tr>
                                                            <td class="text-right" style="padding-bottom: 0;"><strong><?php echo ucwords(strtolower($fee_breakup[0])); ?></strong>:</td>
                                                            <td class='text-right' style="padding-bottom: 0;width:48px;"><i class='fa fa-inr' aria-hidden='true'></i><?php echo $fee_breakup[1]; ?></td>  
                                                        </tr> 
                                	                </table> 
                                            	    </td>  
                                            	</tr>    
                                                <?php } ?>
                            		        </table>
                            		    </td>
                            		</tr>  
                        	    <?php } else { 
                        	        if($receipt_no != '')
                        	        {
                        	        ?> 
                    	            <tr><td colspan="7"><p style="color:red;">Invalid Receipt number, Please check the number!</p></td></tr> 
                    	        <?php } } ?>
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
{     
    var class_register_id = $('#class_register_id').val();
    var concession_amount = $('#concession_amount').val();
    var months = [];
    $(':checkbox:checked').each(function(i){
      months[i] = $(this).val();
    }); 
    
    $("#show_fee_breakup").html(''); 
	$(".loader_class").show();
    $.ajax({
        type: "POST", 
        url:"<?php echo base_url(); ?>get-month-fee-amount",
        data:{months:months,class_register_id:class_register_id,concession_amount:concession_amount}, 
        success:function(response){   
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
        var receipt_number = $('#receipt_number').val();   
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
    });  
  </script> 
 
 
 