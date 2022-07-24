 
<script>
$(document).ready(function(){ 
    $(".savesession").click(function(){
        var session_year = $('#session_year_id').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val(); 
         
        var full_year = new Date(startDate); 
        var year = full_year.getFullYear(); 
        var month = full_year.getMonth(); 
        var day = full_year.getDate() - 1; 
        
        
        var max_limit_date = new Date(year + 1, month, day);  
        
        
        if(session_year == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select  session year</div>");
            $('#session_year_id').css("border","1px solid red");
    		$('#session_year_id').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#session_year_id').css("border","1px solid #c9c9c9");
        }
 
        if(startDate == '')
        {
            $('#errorMsg1').html("<div class='alert alert-danger'>Please enter start date</div>");
            $('#startDate').css("border","1px solid red");
    		$('#startDate').focus();
    		return false;
        }
        else
        {
            $('#errorMsg1').html("");
            $('#startDate').css("border","1px solid #c9c9c9");
        }

        if(endDate == '')
        {
            $('#errorMsg1').html("<div class='alert alert-danger'>Please enter end date</div>");
            $('#endDate').css("border","1px solid red");
    		$('#endDate').focus();
    		return false;
        }
        else
        {
            $('#errorMsg1').html("");
            $('#endDate').css("border","1px solid #c9c9c9");
        }

         
        if ((Date.parse(endDate) <= Date.parse(startDate)))
        {

    	   $('#errorMsg1').html("<div class='alert alert-danger'>End date should be greater than Start date!</div>");
            $('#endDate').css("border","1px solid red");

        	$('#endDate').focus();
    	   return false;
        }
        else
        {
           $('#endDate').css("border","1px solid c9c9c9");
    	   $('#errorMsg1').html(" ");
        }
        
        if ((Date.parse(endDate) > Date.parse(max_limit_date)))
        {

    	   $('#errorMsg1').html("<div class='alert alert-danger'>Session dates are only allowed within one year. Please check the dates!</div>");
            $('#endDate').css("border","1px solid red");

        	$('#endDate').focus();
    	   return false;
        }
        else
        {
           $('#endDate').css("border","1px solid c9c9c9");
    	   $('#errorMsg1').html(" ");
        }
        
        
        
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();
     

    });

    $("#session_year_id").change(function(){
        var session_year = $(this).val();
        var sessionId = $("#sessionId").val();
        $.ajax({
            type: "POST",
            url: "https://localhost/project/zumilyschool/check-session",
            data:{session_year:session_year,sessionId:sessionId},
            success:function(response){ 
        	    if(response > 0)
        	    {

                    $('#errorMsg').html("<div class='alert alert-danger'>This session year already exists</div>");
                    $('#session_year_id').css("border","1px solid red");
                    $(".check1").attr("disabled", true);
                   return false;
        	    }
        	    else
        	    {
        	        $('#errorMsg').html("");
                    $('#session_year_id').css("border","1px solid #c9c9c9");
                    $(".check1").attr("disabled", false);
        	    }
                }
            });
        });
        
        
    $(".start_date").change(function(){  
        var start_date1 = $(this).val();   
        var full_year = new Date(start_date1); 
        var year = full_year.getFullYear(); 
        var month =  ("0" + (full_year.getMonth() + 1)).slice(-2);
        var day =   ("0" + full_year.getDate()).slice(-2); 
        
        
        
        var start_date = year +"-"+ month+"-"+ day; 
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-session-start-date",  
            data:{start_date:start_date},  
            success:function(response){  
                    if(response > 0)
            	    {
    
                        $('#errorMsg').html("<div class='alert alert-danger'>Current session dates are already being used in existing session. Please check the dates.</div>");
                        $('#session_year_id').css("border","1px solid red");
                        $(".check1").attr("disabled", true);
                       return false;
            	    }
            	    else
            	    {
            	        $('#errorMsg').html("");
                        $('#session_year_id').css("border","1px solid #c9c9c9");
                        $(".check1").attr("disabled", false);
            	    }
                 
                }
            }); 
        });     
        
      
     
        
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;

    console.log(sd);
    $('#startDate').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY",  
      todayBtn: true
    });

    $('#endDate').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY", 
      todayBtn: true
    });

    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#formCheck"), 'startDate', 'endDate');


});

</script> 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$session_info['session_year_id'] != '') { echo "Edit"; }else { echo "Add New";} ?> Session  
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4>
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                <form id="formCheck" action="<?php echo base_url();?>/add-session-process" method="POST" enctype="multipart/form-data"
                id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);">
                    <input type="hidden" name="sessionId" id="sessionId" value="<?php echo @$session_info['session_id']; ?>">
                    <div class="col-sm-12" style="margin-top:10px;">
                    	<span id="errorMsg" style="color:red;"></span>
                    	<span id="errorMsg1" style="color:red;"></span>
                    </div>
                    <div class="col-md-12" >
                        <div class="form-group">
                            <select class="form-control session_year test"  name="session_year_id" id="session_year_id" <?php  if(@$session_info['session_year_id'] > 0) { ?>disabled <?php } ?> data-toggle="tooltip" data-placement="top" title="Session" >
                                <option value="">Select Session </option>
                                <?php foreach($session_years as $session_year) { ?>
                                <option value="<?php echo $session_year->session_year_id; ?>" <?php if($session_year->session_year_id == @$session_info['session_year_id']) { echo "selected=selected"; } ?>><?php echo $session_year->session_year; ?></option>
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
                                <div class="form-group col-sm-6">
                                    <label>Starts from </label>
                                    <input type="text" class="test start_date" name="start_date" id="startDate" readonly placeholder="Start Date" data-toggle="tooltip" data-placement="top" title="Session start date" value="<?php if(@$session_info['start_date'] != '') { echo date("D, M d, Y",strtotime(@$session_info['start_date'])); } ?>"/>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Ends on </label>
                                    <input type="text" class="test" name="end_date" id="endDate" readonly placeholder="End Date" data-toggle="tooltip" data-placement="top" title="Session end date" value="<?php if(@$session_info['end_date'] != '') { echo date("D, M d, Y",strtotime(@$session_info['end_date'])); } ?>">
                                </div>
                                <div class="form-group col-sm-12">
                                    <input class="  " style="display: none;position: fixed;" name="is_saturday_off" type="checkbox" id="is_saturday_off" value="1" <?php if(@$session_info['is_saturday_off'] == 1) { echo "checked"; } ?>><label for="is_saturday_off">Is saturday off? </label>

                                </div>
                            </div>
                            <div class="row" style="margin-bottom:20px;">
                                <div class="col-md-6 col-md-offset-3">
                                    <input type="submit" class="check1 btn btn-success col-md-12 savesession"    id="  signup" name="update" value="Submit">
                                </div>
                            </div>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add Session</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Here, you can add a Session with start & end dates.</li>
                  <li >If your school is 5 days a week, means remains close on Saturday then CHECK the box otherwise leave it UNCHECKED.</li>
                  <li >Make sure, selected dates are correct because this application will restrict every process within these DATES for this Session-Year.</li>
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
 