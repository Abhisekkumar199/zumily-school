<script> 
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
    $(document).ready(function(){  
        $("#student-search").keyup(function(){ 
               
            var val = this.value;  
            var url = "<?php echo base_url();?>/student-search-for-additional-fee";
            var pass_data = { 'searchtext' : val}; 
            $.ajax({
            type: "POST",
            url:  url,
            data: pass_data,
               
            success: function(data)
            {       
            $("#showstudents").html(data);  
            }               
            }); 
              return false;
        });  
    }); 
</script> 
 <style>
    .student-search-wrap #top-select-searchautocomplete-list, .student-search-wrap #top-select-searchautocomplete-list div
    {
        width: 597px!important;
        position: relative !important;
        left: 0px!important;
    }
    .studentautocomplete 
    {
        position: absolute!important;
        display: inline-block;
    }
    .student-form div:nth-child(3) 
    {
        width: 15%;
        float: right!important;
    }
 </style>  
 
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
        <form method="get" action="<?php echo base_url(); ?>students-additional-fee" >
    	<div class="row" style="background: #151f31;" >
    		<div class="col-md-6 col-xs-3" > 
    			<h4>Students Additional Fee </h4>
    		</div>
    		<div class="col-md-6 col-xs-9" >
		        <input type="hidden" value= "0" name="is_session_changed" id="is_session_changed" />
    		    <div class="row">
    		        <div class="col-md-3"   >
    		            <?php ?>
            		    <select id="session_id" class="form-control  " name="session_id" required=""  style="border: 1px solid rgb(189, 185, 185);height:30px;  margin: 7px; " onchange="session_event();this.form.submit()">
                            <option value="" disabled>Select session year  </option> 
                            <?php foreach($session_years as $session_year) { ?>
                            <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                            <?php } ?>
                        </select> 
                    </div> 
                    <div class="col-md-3"   > 
            		    <select id="class_register_id" class="form-control  " name="class_register_id"   style="border: 1px solid rgb(189, 185, 185);  margin: 7px; height:30px;" onchange="this.form.submit()">
                            <option value="">All Classes</option> 
                            <?php foreach($classregister_lists as $class) { ?>
                            <option value="<?php echo base64_encode($class->class_register_id); ?>" <?php if($selected_class == $class->class_register_id ) { ?>selected <?php } ?>  ><?php echo $class->class_name_section; ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                       
                    <div class="col-md-4"  style="padding-right: 0px;" >  
                        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url(); ?>late-fee-reminder-students-list-pdf/<?php echo base64_encode($selected_session); ?>|<?php echo base64_encode($selected_class); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
                        
                    </div>
    			</div>
    		</div>
    	</div>  
		</form>
    
 
	    <div class="col-sm-12" style="margin-top:6px;">
        	<span id="message" style="color:red;"></span>
        </div> 
        <div class="col-sm-12">
            <div class="col-sm-2" style="    padding-left: 0px;"></div>
            <div class="col-sm-10" style="    padding-left: 0px;">
                <form action="<?php echo base_url(); ?>search-result" method="post" class="student-form tourz-search-form tourz-top-search-form searchform" style="width: 597px; display:inline-block">
                    <div class="input-field"></div>
                    <div class="input-field autocomplete studentautocomplete search-wrap student-search-wrap" >
                        <input style="border: 1px solid #ddd;background-color: #ffffff;height: 34px;width: 573px;" type="text" id="student-search"   name="search"   class="typeahead form-control"    placeholder="Search Student Name OR Reg# to add Additional Fee" autocomplete="off">
                        
                        <span id="showstudents"  ></span> 
                    </div>
                    <div class="input-field" style="width:8%;">
                    <i class="waves-effect waves-light tourz-top-sear-btn waves-input-wrapper"> 
                    <input type="submit" name="find" id="find" value="" class="waves-button-input" style="float:left; line-height:0"></i> 
                    </div>
                </form>  
            </div>
        </div>
        <?php if($student_details != '') { ?>
        <div class="col-sm-10" style="margin-top:20px;">
            <p><strong>Student Detail:</strong> <?php echo $student_details; ?></p> 
        </div> 
     
	    <?php if($is_active_additional_fee < 1 )  {?>
        <div class="col-sm-12 addressshow" >
	    <form id="formCheck"    method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);"> 
            <input type="hidden" name="fee_type_id" id="fee_type_id" value="<?php echo @$fee_info['students_additional_fee_id']; ?>"> 
            
            <input type="hidden" id="class_register_student_id" name="class_register_student_id" value="<?php echo $class_register_student_id; ?>" /> 
            <input type="hidden" name="first_name"   value="<?php echo $first_name; ?>" />
            <input type="hidden" name="middle_name"   value="<?php echo $middle_name; ?>" />
            <input type="hidden" name="last_name"   value="<?php echo $last_name; ?>" />
            <input type="hidden" name="father_name"   value="<?php echo $father_name; ?>" /> 
            <input type="hidden" id="class_name_section" name="class_name_section"   value="<?php echo $class_name_section; ?>" />
            <input type="hidden" id="session_id" name="session_id"   value="<?php echo $session_id; ?>" />
            <input type="hidden" id="class_register_id" name="class_register_id"   value="<?php echo $class_register_id; ?>" />
            <input type="hidden" id="student_id" name="student_id"   value="<?php echo $student_id; ?>" />
            
            <div class="col-md-4" style="padding-left: 0px;">
                <div class="form-group"> 
                     <select class="form-control  test" id="fee_type"  name="fee_type" data-toggle="tooltip" data-placement="top" >
                        <option value="">Select Fee Type</option>
                        <?php
                        foreach($fee_types_lists as $fee_type)
        	            {
    	                ?>
                            <option value="<?php echo $fee_type->fee_type; ?>" <?php if(@$fee_info['fee_type'] == $fee_type->fee_type)  { echo "selected";} ?>><?php echo $fee_type->fee_type ; ?></option>
                        <?php } ?> 
                    </select> 
                </div>  
            </div> 
            <div class="col-md-4">
                <div class="form-group"> 
                    <input type="text" class="form-control   test" id="amount"  name="amount" placeholder="Additional Amount" style="background-color: #ffffff;" value="<?php echo @$fee_type_info['total_fee'];  ?>" data-toggle="tooltip" data-placement="top" title="Additional Amount" required="true" autocomplete="off" >
                </div>
            </div> 
            <div class="col-md-9" style="padding-left: 0px!important;">
                <div class="form-group"> 
                    <input type="text" class="form-control   test" id="reason"  name="reason" placeholder="Reason" style="background-color: #ffffff;" value="<?php echo @$fee_type_info['total_fee'];  ?>" data-toggle="tooltip" data-placement="top" title="Reason" required="true" autocomplete="off" >
                </div>
            </div> 
            <div class="col-md-3"> 
                <div class="form-group">  
                    <input type="button" class="check1 btn btn-success col-md-8  "  id="  signup" name="update" value="Submit"> 
                </div>  
            </div> 
        </form>
	    </div> 
	    <?php } ?>
        <?php } ?>  
        <input type="hidden" name="session_year" id="session_year_name" value="" /> 
	    <div class="col-sm-12 fullWidth-tab" style="min-height:500px;">
    		<div class="panel panel-bd lobidrag"> 
            	<div class="panel-body" id="result" > 
                	<div class="table-responsive tab-inn ad-tab-inn active" id="active" style="max-height: 270px; overflow-y: scroll;" >
                    	<table class="table table-hover"  >
                        	<thead>
                            	<td style="width:250px;">Student Name</td> 
                            	<td style="width:60px;">Class</td>  
                            	<td>Father Name</td> 
                            	<td>Parent Mobile No.</td>
                            	<td>Fee Type</td> 
                            	<td>Amount</td> 
                            	<td>Recv. Months</td> 
                            	<td>Payment Date</td> 
                        	</thead>
                            <tbody>
                    	<?php 
                    	if(count($student_lists) > 0) 
                    	{
                        	foreach($student_lists as $student)
                        	{
                    	?> 
                        <input type="hidden" name="student_ids[]" value="<?php echo $student->student_id; ?>" />
                        <input type="hidden" name="class_register_student_ids[]" value="<?php echo $student->class_register_student_id; ?>" />
                    	<tr      >
                        	<td class="business_list_">
                        	    <?php if(!empty($student->profile_picture)) { ?>
                    		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $students->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                    		    <?php } else { ?>
                    		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                    		    <?php } ?>
                        	    <?php echo $student->first_name." ".$student->last_name; ?>
                        	</td>  
                        	<td class="business_list_"><?php echo $student->class_name_section; ?></td>    
                        	<td class="business_list_"><?php echo $student->father_name;     ?></td> 
                        	<td class="business_list_"><?php echo $student->parent_mobile_no;     ?></td> 
                        	<td class="business_list_"><?php echo $student->fee_type; ?></td>  
                        	<td class="business_list_"><?php echo $student->additional_fee_amount; ?></td>  
                        	<td class="business_list_"><?php echo $student->payment_months; ?></td>  
                        	<td class="business_list_"><?php echo $student->payment_date; ?></td>  
                    	</tr>   
                    	<?php } }  else { ?>
                    	<tr>
                    		<td colspan="8"  class="business_list_"><p style="color:red;text-align:center;"><strong>*** No Record Found ***</strong></p></td>
                    	</tr>
                    	<?php } ?>
                    	</tbody> 
                    	</table>
                	</div>
            	</div> 
    	    </div>
    	    <br>
    	     
	    </div> 
    </div> 
</div>
 
</div>
</section>

<style>
.business_list_dropdown{ display:none;} 
</style>
<script type="text/javascript">
function showhide2(id) {
$(".login2"+id).toggle();  
}
function imageevent(){ 
    $('.bottomMenu ').css('position','inherit');
}
</script> 
 
 
 
 
<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Late Fee - Students List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This is the page, you find the list of all STUDENTS who have not paid yet their FEES and running behind.</li>
                  <li >You can filter to find list of STUDENTS by Session-Year and/or Class.</li>
                  <li >Once you get list of STUDENTS, you have option to call PARENTS and remind them, DOWNLOAD report and call later, OR send NOTIFICATION to all STUDENTS & their PARENTS in realtime.</li>
                  <li >Before you send a NOTIFICATION to all of these STUDENTS, you can modify REMINDER MESSAGE TEXT if you want otherwise send as is.</li>
                  <li >Remember, this NOTIFICATION will deliver on ZUMILY-SCHOOL App only. If STUDENTS/PARENTS haven't downloaded yet, ask them to do it and login with their MOBILE NUMBER provided to school.</li>
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
<script>
    $(document).ready(function(){
    $('.check1').click(function(){ 
	var fee_type = $('#fee_type').val(); 
	var amount = $('#amount').val(); 
	var reason = $('#reason').val(); 
	var class_register_student_id = $('#class_register_student_id').val(); 
	var class_name_section = $('#class_name_section').val(); 
	var session_id = $('#session_id').val(); 
	var class_register_id = $('#class_register_id').val();  
	var student_id = $('#student_id').val(); 
	if(fee_type == '')
	{  
        $('#message').html("<div class='alert alert-danger'>Please select a Fee Type.</div>"); 
		$('#fee_type').css("border","1px solid red");
		$('#fee_type').focus();
		return false;
	}
	else
	{ 
		$('#fee_type').css("border","1px solid #bdb9b9"); 
	} 
	if(amount == '')
	{  
        $('#message').html("<div class='alert alert-danger'>Please enter Additional Fee Amount.</div>"); 
		$('#amount').css("border","1px solid red");
		$('#amount').focus();
		return false;
	}
	else if(amount < 1)
	{  
        $('#message').html("<div class='alert alert-danger'>Entered amount should be greater than Zero(0).</div>"); 
		$('#amount').css("border","1px solid red");
		$('#amount').focus();
		return false;
	}
	else
	{ 
		$('#amount').css("border","1px solid #bdb9b9"); 
	} 
  
	$.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/add-additional-fee-process',
        data: { fee_type: fee_type,amount: amount,reason: reason,class_register_student_id: class_register_student_id,session_id: session_id,class_register_id: class_register_id,class_name_section: class_name_section,student_id: student_id},
        success:function(msg){  
            if(msg == 1)
            {
                window.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
            } 
            else
            {
                $('#message').html(msg);
            }
            
        }
    });
	 
});
	 
});
</script>
