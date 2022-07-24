<script>
$(document).ready(function(){ 
    $("#session_year").change(function(){  
        var session_year = $(this).val();  
        var holiday_id = $("#holiday_id").val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-holiday",  
            data:{session_year:session_year,holiday_id:holiday_id},  
            success:function(response){ 
                var str = response.split(',');
                var start_date = str[0];
                var end_date = str[1]; 
                $("#session_end_date").val(end_date);
        	    if(response == 1)
        	    { 
        	       
                    $('#errorMsg').html("This session year already exists"); 
                    $('#session_year').css("border","1px solid red");  
                    $(".check1").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#errorMsg').html(""); 
                    $('#session_year').css("border","1px solid #c9c9c9");  
                    $(".check1").attr("disabled", false);
        	    }
        	    
        	    
        	    var startdate = new Date(start_date).toDateString("ddd, MMM DD, YYYY"); 
        	    var end_date = new Date(end_date).toDateString("ddd, MMM DD, YYYY"); 
        	    
                var sd = startdate;
                var ed = end_date;
             
                $('#holiday_start_date').datetimepicker({
                  pickTime: false,
                  format: "ddd, MMM DD, YYYY", 
                  minDate:sd,
                  maxDate:ed,
                  todayBtn: true
                }); 
                
                $('#holiday_end_date').datetimepicker({
                  pickTime: false,
                  format: "ddd, MMM DD, YYYY",
                  minDate:sd,
                  maxDate:ed,
                  todayBtn: true
                }); 
        	    
                }
            }); 
        }); 
   
    $(".check1").click(function(){   
        var session_year = $('#session_year').val(); 
        var holiday_name = $('#holiday_name').val(); 
        var holiday_start_date = $('#holiday_start_date').val(); 
        var holiday_end_date = $('#holiday_end_date').val();   
        var holiday_id = $('#holiday_id').val();   
	    
         
        if(session_year == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select session year</div>");
            $('#session_year').css("border","1px solid red");
    		$('#session_year').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#session_year').css("border","1px solid #c9c9c9");
        }
        
        if(holiday_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter holiday name</div>");
            $('#holiday_name').css("border","1px solid red");
    		$('#holiday_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#holiday_name').css("border","1px solid #c9c9c9");
        }
        
        if(holiday_start_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select start date</div>");
            $('#holiday_start_date').css("border","1px solid red");
    		$('#holiday_start_date').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#holiday_start_date').css("border","1px solid #c9c9c9");
        } 
            
        if(holiday_end_date != '')
        {
            if(Date.parse(holiday_end_date) < Date.parse(holiday_start_date))
            { 
                $('#errorMsg').html("<div class='alert alert-danger'>Holiday end date can't be earlier than holiday start date</div>");
                $('#holiday_end_date').css("border","1px solid red");
        		$('#holiday_end_date').focus();
        		return false;
            }
            else
            { 
                $('#errorMsg').html("");
                $('#holiday_end_date').css("border","1px solid #c9c9c9"); 
            } 
        } 
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/add-holiday-process",  
            data:{session_year:session_year,holiday_id:holiday_id,holiday_start_date:holiday_start_date,holiday_end_date:holiday_end_date,holiday_name:holiday_name},  
            success:function(response){  
                
                if(response == "added" || response == "updated")
                {
                    window.location.href="https://localhost/project/zumilyschool/holidays-list"; 
                }
                else
                {
                    $("#errorMsg").html(response);
                }
            }
        });
        
        
    });  
     
    bindDateRangeValidation($("#formCheck"), 'holiday_start_date', 'holiday_end_date');
}); 
</script>
<input type="hidden" id="session_end_date" value="">
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 > <?php if(@$session_info['holiday_id'] != '') { echo "Edit"; }else { echo "Add New";} ?> Holiday  
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck"  method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="holiday_id" id="holiday_id" value="<?php echo @$session_info['holiday_id']; ?>">  
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <select class="form-control session_year test"  name="session_year" id="session_year" data-toggle="tooltip" data-placement="top" title="Session year" >
                                    <option value="">Select Session </option>
                                    <?php foreach($session_years as $session_year) { ?>
                                    <option value="<?php echo $session_year->session_id; ?>" <?php if($session_year->session_id == @$session_info['session_id']) { echo "selected=selected"; } ?>><?php echo $session_year->session_year; ?></option>
                                    <?php } ?>
                                </select> 
                            </div> 
                            <div class="demo-div mt20px">
                                <div class="row">
                                    <div class="col-sm-12">
                                    	<span id="errorMsg1" style="color:red;"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label>Holiday Name</label>
                                        <input type="text" name="holiday_name" id="holiday_name" class="form-control test"  placeholder="Holiday Name" data-toggle="tooltip" data-placement="top" title="Holiday name" value="<?php   echo  @$session_info['holiday_name'];  ?>" > 
                                    </div>  
                                    <div class="form-group col-sm-6">
                                        <label>Holiday Start Date</label>
                                        <input type="text" class="test" name="holiday_start_date" id="holiday_start_date" data-toggle="tooltip" data-placement="top" title="Holiday start date" readonly placeholder="Holiday Start Date" value="<?php if(@$session_info['holiday_start_date'] != '') { echo date("D, M d, Y",strtotime(@$session_info['holiday_start_date'])); } ?>"   /> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Holiday End Date</label>
                                        <input type="text" class="test" name="holiday_end_date" id="holiday_end_date" readonly placeholder="Holiday End Date" data-toggle="tooltip" data-placement="top" title="Holiday end date" value="<?php if(@$session_info['holiday_end_date'] != '') { echo date("D, M d, Y",strtotime(@$session_info['holiday_end_date'])); } ?>"   /> 
                                    </div>
                                     
                                </div>
                                <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                    <div class="col-md-6 col-md-offset-3"> 
                                        <button type="button" class="check1 btn btn-success col-md-12 " id="signup" name="update" value="Submit">Submit</button> 
                                    </div> 
                                </div>
                            </div> 
                        </div>  
                    </form>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add New Holiday</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Here, you add Holidays for a specific Session-Year.</li>
                  <li >Make sure, to type correct name and dates before you save it because no EDIT allowed. </li>
                  <li >A holiday can be deleted only if it is in future date(s).</li>
                  <li >This is one time setup to add all the Holidays at the start of the Session-Year. However, you can always add one if missed out.</li>           
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
