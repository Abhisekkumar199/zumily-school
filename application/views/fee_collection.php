 
<script>
$(document).ready(function(){  
    var date = new Date();
    
    var month_first_day = new Date(date.getFullYear(), date.getMonth(), 1).toDateString("MMM DD, YYYY"); 
    var today = new Date().toDateString("MMM DD, YYYY"); 
    var sd = today;
    var ed = new Date();
  
    console.log(sd);
    $('#start_date').datetimepicker({
      pickTime: false,
      format: "MMM DD, YYYY",  
      maxDate: ed,
      todayBtn: true
    });
     $('#end_date').datetimepicker({
      pickTime: false,
      format: "MMM DD, YYYY",
      defaultDate: today, 
      maxDate: ed,
      todayBtn: true
    });
 
    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#date_form"), 'start_date', 'end_date');

     
}); 

function get_payment()
{ 
	var radio1=$('input[name="radio1"]:checked').val();  
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val(); 
    var start_month = $("#start_month").val(); 
    var end_month = $("#end_month").val();  
    
    $(".pdf_url").attr("href", "<?php echo base_url(); ?>fee-collection-pdf/"+radio1+"-"+start_date+"-"+end_date+"-"+start_month+"-"+end_month);
    
    if ((Date.parse(end_date) < Date.parse(start_date))) 
    { 
        
	    $("#error_msg").show();
	    $('.error_msg').html("<font color='red'>End Date should be greater or equals to Start Date!</font>"); 
        $('#end_date').css("border","1px solid red"); 
    	$('#end_date').focus();
	    return false; 
    }
    else
    {
       $('#end_date').css("border","1px solid #c9c9c9"); 
	   $('.error_msg').html(""); 
    }   
	
    $(".show_fee_data").html('');
	$(".loader_class").show();
	$.ajax({
	url : "<?php echo base_url(); ?>monthly-fee-collection",
	type : "POST",
    	data : {type:radio1,start_date:start_date,end_date:end_date,start_month:start_month,end_month:end_month},
	success : function(data1) { 
	    if(radio1 == 1)
	    { 
	        $("#title").html("Date"); 
	        $(".change_title_start").html("Start Date"); 
	        $(".change_title_end").html("End Date"); 
	        $("#start_date").show(); 
	        $("#end_date").show(); 
	        $("#start_month").hide(); 
	        $("#end_month").hide(); 
	    }
	    else if(radio1 == 2)
	    {
	        $("#title").html("Month");  
	        $(".change_title_start").html("Start Month"); 
	        $(".change_title_end").html("End Month"); 
	        $("#start_date").hide(); 
	        $("#end_date").hide(); 
	        $("#start_month").show(); 
	        $("#end_month").show(); 
	    }
	    else if(radio1 == 3)
	    {
	        $("#title").html("Class"); 
	        $(".change_title_start").html("Start Date"); 
	        $(".change_title_end").html("End Date"); 
	        $("#start_date").show(); 
	        $("#end_date").show(); 
	        $("#start_month").hide(); 
	        $("#end_month").hide(); 
	    }
	    
        $(".loader_class").hide();
	    $(".show_fee_data").html(data1);
	}
	});
	return false;
}

function get_payment_by_date()
{ 
	var fee_type =$('input[name="radio1"]:checked').val(); 
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var start_month = $("#start_month").val(); 
    var end_month = $("#end_month").val(); 
    
    $(".pdf_url").attr("href", "<?php echo base_url(); ?>fee-collection-pdf/"+fee_type+"-"+start_date+"-"+end_date+"-"+start_month+"-"+end_month);
      
    
      
    if ((Date.parse(end_date) < Date.parse(start_date))) 
    { 
	    $("#error_msg").show();
	    $('.error_msg').html("<font color='red'>End Date should be greater or equals to Start Date!</font>"); 
        $('#end_date').css("border","1px solid red"); 
    	$('#end_date').focus();
	    return false; 
    }
    else
    {
       $('#end_date').css("border","1px solid #c9c9c9"); 
	   $('.error_msg').html(""); 
    }    
    $(".show_fee_data").html('');
	$(".loader_class").show();
	$.ajax({
    	url : "<?php echo base_url(); ?>monthly-fee-collection",
    	type : "POST",
    	data : {type:fee_type,start_date:start_date,end_date:end_date,start_month:start_month,end_month:end_month},
    	success : function(data1) { 
    	     
    	    if(radio1 == 1)
    	    { 
    	        $("#title").html("Date");
    	    }
    	    else if(radio1 == 2)
    	    {
    	        $("#title").html("Month"); 
    	    }
    	    else if(radio1 == 3)
    	    {
    	        $("#title").html("Class"); 
    	    }
    	    
            $(".loader_class").hide();
    	    $(".show_fee_data").html(data1);
    	}
	});
	return false;
}

function get_payment_by_start_month(val)
{ 
	var fee_type =$('input[name="radio1"]:checked').val(); 
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var start_month = val; 
    var end_month = $("#end_month").val();  
    
    $(".pdf_url").attr("href", "<?php echo base_url(); ?>fee-collection-pdf/"+fee_type+"-"+start_date+"-"+end_date+"-"+start_month+"-"+end_month);
     
    if(start_month != '')
    {
        var regexnumber = /^\d{6}$/;
        if(!regexnumber.test(start_month)) 
        {
            $('#start_month').css("border","1px solid red");
    		$('#start_month').focus(); 
    		$("#error_msg").show();
    		$('.error_msg').html("<font color='red'>Invalid year month. Correct format id YYYYMM </font>");
    		return false;
        }
        else
        {
           $('#start_month').css("border","1px solid #bdb9b9"); 
           $('#error_msg').html("");
        }
    }
    
    if(end_month != '')
    {
        var regexnumber = /^\d{6}$/;
        if(!regexnumber.test(end_month)) 
        {
            $('#end_month').css("border","1px solid red");
    		$('#end_month').focus(); 
    		$("#error_msg").show();
    		$('.error_msg').html("<font color='red'>Invalid year month. Correct format id YYYYMM </font>");
    		return false;
        }
        else
        {
           $('#end_month').css("border","1px solid #bdb9b9"); 
           $('#error_msg').html("");
        }
    } 
     
    if (end_month < start_month && end_month != '') 
    { 
        
	    $("#error_msg").show();
	    $('.error_msg').html("<font color='red'>End Month should be greater or equals to Start Month!</font>"); 
        $('#end_month').css("border","1px solid red"); 
    	$('#end_month').focus();
	    return false; 
    }
    else
    {
       $('#end_month').css("border","1px solid #c9c9c9"); 
	   $('.error_msg').html(""); 
    }    
    
    
        
    $(".show_fee_data").html('');
	$(".loader_class").show();
	$.ajax({
    	url : "<?php echo base_url(); ?>monthly-fee-collection",
    	type : "POST",
    	data : {type:fee_type,start_date:start_date,end_date:end_date,start_month:start_month,end_month:end_month},
    	success : function(data1) { 
    	     
    	    if(radio1 == 1)
    	    { 
    	        $("#title").html("Date");
    	    }
    	    else if(radio1 == 2)
    	    {
    	        $("#title").html("Month"); 
    	    }
    	    else if(radio1 == 3)
    	    {
    	        $("#title").html("Class"); 
    	    }
    	    
            $(".loader_class").hide();
    	    $(".show_fee_data").html(data1);
    	}
	});
	return false;
}
function get_payment_by_end_month(val)
{ 
	var fee_type =$('input[name="radio1"]:checked').val(); 
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var start_month = $("#start_month").val(); 
    var end_month = val;  
    $(".pdf_url").attr("href", "<?php echo base_url(); ?>fee-collection-pdf/"+fee_type+"-"+start_date+"-"+end_date+"-"+start_month+"-"+end_month);
      
    if(start_month != '')
    {
        var regexnumber = /^\d{6}$/;
        if(!regexnumber.test(start_month)) 
        {
            $('#start_month').css("border","1px solid red");
    		$('#start_month').focus(); 
    		$("#error_msg").show();
    		$('.error_msg').html("<font color='red'>Invalid year month. Correct format id YYYYMM </font>");
    		return false;
        }
        else
        {
           $('#start_month').css("border","1px solid #bdb9b9"); 
           $('#error_msg').html("");
        }
    }
    
    if(end_month != '')
    {
        var regexnumber = /^\d{6}$/;
        if(!regexnumber.test(end_month)) 
        {
            $('#end_month').css("border","1px solid red");
    		$('#end_month').focus(); 
    		$("#error_msg").show();
    		$('.error_msg').html("<font color='red'>Invalid year month. Correct format id YYYYMM </font>");
    		return false;
        }
        else
        {
           $('#end_month').css("border","1px solid #bdb9b9"); 
           $('#error_msg').html("");
        }
    }  
      
    if (end_month < start_month && end_month != '') 
    { 
        
	    $("#error_msg").show();
	    $('.error_msg').html("<font color='red'>End Month should be greater or equals to Start Month!</font>"); 
        $('#end_month').css("border","1px solid red"); 
    	$('#end_month').focus();
	    return false; 
    }
    else
    {
       $('#end_month').css("border","1px solid #c9c9c9"); 
	   $('.error_msg').html(""); 
    }  
    
    
    
    $(".show_fee_data").html('');
	$(".loader_class").show();
	$.ajax({
    	url : "<?php echo base_url(); ?>monthly-fee-collection",
    	type : "POST",
    	data : {type:fee_type,start_date:start_date,end_date:end_date,start_month:start_month,end_month:end_month},
    	success : function(data1) { 
    	     
    	    if(radio1 == 1)
    	    { 
    	        $("#title").html("Date");
    	    }
    	    else if(radio1 == 2)
    	    {
    	        $("#title").html("Month"); 
    	    }
    	    else if(radio1 == 3)
    	    {
    	        $("#title").html("Class"); 
    	    }
    	    
            $(".loader_class").hide();
    	    $(".show_fee_data").html(data1);
    	}
	});
	return false;
}
</script>
 
 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>Fee Collection
            <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i>
            <a class="pdf_url" href="<?php echo base_url(); ?>fee-collection-pdf/1-" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        </h4>
        <div class="col-sm-12 "  style="margin-top:10px; " > 
            <p class="error_msg"></p> 
		</div>
        <div class="col-sm-12" style="padding-top:0px;background: #ffffff;"> 
        	 <div class="panel-heading">
				<div class="btn-group col-md-6" > 
				    <div class="radioWrap">
					    <input type="radio" id="radio1" name="radio1"  checked="checked" onclick = "get_payment()" value="1"  />
					    <label for="radio1" style="font-size:14px;">&nbsp; Daily  </label>
					</div> 
					<div class="radioWrap">
					    <input type="radio" id="radio2"  name="radio1"  onclick = "get_payment()" value="2" />
					    <label for="radio2" style="font-size:14px;">&nbsp; Monthly</label>
					</div>
					
					<div class="radioWrap">
					    <input type="radio" id="radio3"   name="radio1"  onclick = "get_payment()" value="3" />
					    <label for="radio3" style="font-size:14px;">&nbsp; Class Wise</label>
					</div>  
				</div>
				<div class="col-sm-3" > 
                    <label class="change_title_start">Start Date</label>
                    <input type="text" class="form-control"  name="start_date" id="start_date" style="background-color:#ffffff;" onchange = "get_payment_by_date()"  value="<?php echo date("M d, Y",strtotime(date('01-m-Y'))); ?>"  placeholder="Received Date"   />   
                    <input type="text" class="form-control" style="display:none;background-color:#ffffff;" name="start_month" id="start_month" style="background-color:#ffffff;" onkeyup = "get_payment_by_start_month(this.value)" value="<?php echo date('Ym'); ?>"   placeholder="YYYYMM" maxlength="6"   />  
                </div>   
                <div class="col-sm-3"  > 
                    <label class="change_title_end">End Date</label>
                    <input type="text" class="form-control"  name="end_date" id="end_date" style="background-color:#ffffff;"  onchange = "get_payment_by_date()" value="<?php echo date("M d, Y",strtotime($this->session->userdata('current_date'))); ?>"  placeholder="Received Date"   />   
                    <input type="text" class="form-control" style="display:none;background-color:#ffffff;" name="end_month" id="end_month" style="background-color:#ffffff;" onkeyup = "get_payment_by_end_month(this.value)" value="<?php echo date('Ym'); ?>"    placeholder="YYYYMM" maxlength="6"   /> 
                </div>  
				
			</div>  
        </div>  

        <div class="col-sm-12 fullWidth-tab"> 
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
    	            <div class="table-responsive tab-inn ad-tab-inn" id="active">
                        <table class="table table-hover">
                        	<thead>
                        	    <tr>
                            	<td  ><span ><a href="javascript:void(0)" id="title"  >Date</a></span></td>  
                            	<td class='text-right'><span ><a href="javascript:void(0)"  >Cash</a></span></td>
                            	<td class='text-right'><span ><a href="javascript:void(0)"  >Bank</a></span></td>
                            	<td class='text-right'><span ><a href="javascript:void(0)"  >Cheque/DD</a></span></td>
                            	<td class='text-right'><span ><a href="javascript:void(0)"  >Total</a></span></td> 
                            	</tr>
                        	</thead >
                        	<tbody class="show_fee_data">   
                    	        <?php echo $payments; ?> 
                    	    </tbody>
                    	    <tbody >  
                        	    <tr style="display:none;" class="loader_class"><td  colspan="5" style="padding-top:10px;padding-bottom:10px;" class="text-center"><img style="height:20px;width:20px;text-align-center;" src="<?php echo base_url(); ?>/assets/images/loader.gif"></td></tr>  
                    	    </tbody>
                    	</table> 
                    </div> 
                </div> 
            </div> 
        </div> 
        <br> 
    </div>
</div>  
 
 