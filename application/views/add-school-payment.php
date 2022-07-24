 
<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
        
	    var payment_type = parseInt($('input[name="payment_type"]:checked').length); 
        var utr_number = $('#utr_number').val();  
        var check_draft_number = $('#check_draft_number').val();  
        var bank_name = $('#bank_name').val();  
        var bank_branch_name = $('#bank_branch_name').val();   
        var payment_type1 = $('#payment_type1').val();   
        
     
        if(payment_type1 == '' || payment_type1 == 2)
        {
            if(utr_number == '')
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please enter UTR number</div>");
                $('#utr_number').css("border","1px solid red");
        		$('#utr_number').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#utr_number').css("border","1px solid #c9c9c9");
            } 
        }
        else
        {
            if(check_draft_number == '')
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please enter check draft number</div>");
                $('#check_draft_number').css("border","1px solid red");
        		$('#check_draft_number').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#check_draft_number').css("border","1px solid #c9c9c9");
            } 
        }
        
        if(bank_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter bank name</div>");
            $('#bank_name').css("border","1px solid red");
    		$('#bank_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#bank_name').css("border","1px solid #c9c9c9");
        } 
        
        if(bank_branch_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter bank branch name</div>");
            $('#bank_branch_name').css("border","1px solid red");
    		$('#bank_branch_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#bank_branch_name').css("border","1px solid #c9c9c9");
        } 
         
    });  
    
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;

    console.log(sd);
    $('#date_of_birth').datetimepicker({
      pickTime: false,
      maxDate: ed,
      format: "ddd, MMM DD, YYYY", 
      todayBtn: true
    });
    
    bindDateRangeValidation($("#formCheck"), 'date_of_birth');
}); 
function check_payment_type(pay_type)
{
    if(pay_type == "Chque/Demand Draft")
    {
        $(".showchque").show();
        $(".showutr").hide();
        $("#payment_type1").val(1);
    }
    else
    { 
        $(".showutr").show();
        $(".showchque").hide();
        $("#payment_type1").val(2);
    }
}
</script> 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 >Payment - Invoice Summary  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-school-payment-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  aautocomplete="off" onsubmit="return Validate(this);"> 
                        <?php
                        $success = $this->session->userdata('success'); 
                        if (!empty($success)) 
                        {
                            echo  $success ;
                            $this->session->unset_userdata('success');
                        }
                        ?>
                        <input type="hidden" name="payment_id" id="payment_id" value="<?php echo @$student_info['school_payment_transaction_id']; ?>"> 
                        <input type="hidden"  name="total_student"    value="<?php echo $total_students; ?>"  />
                        <input type="hidden"  name="rate_student_permonth"   value="<?php echo $rate_per_month['rate_student_permonth']; ?>"  />
                        <input type="hidden"  name="discount_percentage"   value="<?php echo round($discount); ?>"  />
                        <input type="hidden"  name="amount_paid"   value="<?php echo round($amount_due); ?>"  /> 
                        <input type="hidden"  name="valid_until"   value="<?php echo $valid_until; ?>"  />
                        <input type="hidden"  name="total_months"   value="<?php echo $total_month; ?>"  />  
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        
                        <div class="form-group col-md-12">
                            <div style="margin-top:10px;"></div>
                            Total Students:  <strong><?php echo $total_students; ?></strong>&nbsp; &nbsp; &nbsp;&nbsp;
                            Total Months:  <strong><?php echo $total_month; ?></strong>&nbsp; &nbsp;&nbsp;&nbsp;
                            Rate/Student/mo: <strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $rate_per_month['rate_student_permonth']; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
                            Valid until: <strong><?php   echo date("M d, Y",strtotime($valid_until)); ?></strong>
                            <br>
                            <style>
                                table.bordered > thead > tr, table.bordered > tbody > tr {
                                    border-bottom: none!important;
                                }
                            </style>
                            <table class="responsive-table bordered pull-right" style="width:40%;margin-top:15px;">
								<tbody>
								    <tr>
										<th style="font-size: 1.4rem;"><strong>Invoice Summary</strong></th> 
										<th> </th>
									</tr>
									<tr>
										<td>Amount:</td> 
										<td class="pull-right"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($total_amount); ?>.00</td>
									</tr>
									<tr style="border-bottom: 1px solid #d0d0d0!important;">
										<td>Discount <?php echo round($discount); ?>%:</td> 
										<td class="pull-right"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($discount_amount); ?>.00</td>
									</tr> 
									<tr>
										<td style="font-size:16px;color:red;"><strong>Amount due:</strong></td> 
										<td class="pull-right" style="font-size:16px;color:red;"><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo round($amount_due); ?>.00</strong></td>
									</tr>
									 
								</tbody>
							</table>
										
                                
                        </div>
                            
                      
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="online" onclick = "check_payment_type(this.value);"  name="payment_type"   value="Bank Transfer"  checked    > 
                                <label for="online">Bank Transfer</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;" id="offline"  onclick = "check_payment_type(this.value);"  name="payment_type"   value="Chque/Demand Draft"  <?php if(@$student_info['payment_type'] == 'Chque/Demand Draft' ) { echo "checked";} ?> >
                                <label for="offline">Chque/Demand Draft</label> 
                            </div>
                        </div>
                        <input type="hidden"  id="payment_type1"   value=""  />
                            
                        <div class="col-md-12 showutr">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="utr_number"  name="utr_number" placeholder="UTR Number" data-toggle="tooltip" data-placement="top" title="UTR Number" value="<?php echo @$student_info['utr_number'];  ?>" maxlength="50"   autocomplete="off" >
                            </div> 
                        </div>
                        <div class="col-md-12 showchque" style="display:none;">
                            <div class="form-group"> 
                                <input type="text" class="form-control test  " id="check_draft_number"  name="check_draft_number" placeholder="Check Draft Number" data-toggle="tooltip" data-placement="top" title="Check Draft Number" value="<?php echo @$student_info['check_draft_number'];  ?>"  autocomplete="off" >
                            </div> 
                        </div>   
                        
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="text" class="form-control  test " id="bank_name"  name="bank_name" placeholder="Bank Name" data-toggle="tooltip" data-placement="top" title="Bank Name" value="<?php echo @$student_info['bank_name'];  ?>" maxlength="100" autocomplete="off" >
                            </div> 
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">  
                                <input type="text" class="form-control test " id="bank_branch_name"  name="bank_branch_name" placeholder="Bank Branch Name" data-toggle="tooltip" data-placement="top" title="Bank Branch Name" value="<?php echo @$student_info['bank_branch_name'];  ?>" maxlength="50"   autocomplete="off" >
                            </div> 
                        </div> 
                        
                        
                          
                       
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  class" name="update" value="Pay Now"> 
                                </div> 
                            </div>  
                        </div> 
                    </form>
                </div>  
            </div>
        </div>
    </div> 
</div> 
</div>
</div>
 
 
