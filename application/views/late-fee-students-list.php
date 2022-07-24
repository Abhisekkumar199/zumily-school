<script type="text/javascript"> 
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
  
}); 
</script> 
<script type="text/javascript">
$(document).ready(function(){  
    var selected_session_year = $("#session_year option:selected").text();
    $('#session_year_name').val(selected_session_year);
    $(".view-homework").click(function() {
        $('.showhomeworkdetail').html('');
        var homework_id=$(this).attr("homework_id"); 
    	$.ajax({
    			type: "POST",
    			data: { homework_id: homework_id },
    			url:"https://localhost/project/zumilyschool/homework-details",
    			success: function(response){  
    			    $('.showhomeworkdetail').html(response);
    			}
    		});
    }); 
}); 
</script> 
<script>  
function deletehomework(val1)
{  
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Remember, if you delete this homework, all recipients will not be able to see it on the app.<br> Are you sure, you want to delete it?", function (e) 
    { 
        if (e) 
        { 
            var homework_id = val1;  
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-homework/"+homework_id,
        	type : "POST", 
        	success : function(data) {
        	location.reload();
        	}
        	});
        	return false;
        } 
        else 
        { 
        }
    }); 
      
} 
</script>
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
    
        <form method="get" action="<?php echo base_url(); ?>late-fee-reminder-students-list" >
    	<div class="row" style="background: #151f31;" >
    		<div class="col-md-6 col-xs-3" > 
    			<h4>Late Fee - Students List </h4>
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
    	
	    <form method="post" action="<?php echo base_url(); ?>school-late-fee-reminder-process" >
        <input type="hidden" name="session_year" id="session_year_name" value="" />
    	<div class="hom-cre-acc-left hom-cre-acc-right " style="min-height:500px;">
    	    <div class="col-sm-12 fullWidth-tab">
        		<div class="panel panel-bd lobidrag"> 
                	<div class="panel-body" id="result" > 
                    	<div class="table-responsive tab-inn ad-tab-inn active" id="active" style="max-height: 270px; overflow-y: scroll;" >
                        	<table class="table table-hover"  >
                            	<thead>
                                	<td style="width:250px;">Student Name</td> 
                                	<td style="width:60px;">Class</td> 
                                	<td>DOB</td> 
                                	<td>Father Name</td> 
                                	<td>Parent Mobile No.</td>
                                	<td>Last Paid Month</td> 
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
                            	<td class="business_list_"><?php echo $student->first_name." ".$student->last_name; ?></td>  
                            	<td class="business_list_"><?php echo $student->class_name_section; ?></td>  
                            	<td class="business_list_"><?php  echo date('D, M d, Y', strtotime($student->date_of_birth));  ?></td>  
                            	<td class="business_list_"><?php echo $student->father_name;     ?></td> 
                            	<td class="business_list_"><?php echo $student->parent_mobile_no;     ?></td> 
                            	<td class="business_list_"><?php echo $student->last_fee_payment_yyyymm; ?></td>  
                        	</tr>   
                        	<?php } }  else { ?>
                        	<tr>
                        		<td colspan="2"  class="business_list_">No Record Found</td>
                        	</tr>
                        	<?php } ?>
                        	</tbody> 
                        	</table>
                    	</div>
                	</div> 
        	    </div>
        	    <br>
        	    <?php 
            	if(count($student_lists) > 0) 
            	{ 
        	    ?> 
    		        <input type="hidden" name="session_id" id="session_id" value="<?php echo $selected_session; ?>" />
    		        <input type="hidden" name="selected_year" id="selected_year" value="<?php echo $selected_session_year; ?>" />
    		        <input type="hidden" name="selected_class" id="selected_class" value="<?php echo $selected_class; ?>" />
            	    <div class="form-group"> 
                        <textarea rows="3"   name="desc" id="elm1"   placeholder="Description"  style="width: 100%; height: 180px;" > 
                        Dear Parent, <br>
                        This is just a friendly reminder to make the payment for your child’s fee which is not paid yet. You can contact school if you have any questions.<br> 
                        Please ignore it, if you have already paid it. <br>
                        Thank you very much!<br>
                        School Admin
                        </textarea> 
                        <span id="errorMsg1" style="color:red;"></span> 
                    </div>  
            	    <div style="margin-bottom:10px;" class="col-md-6 col-md-offset-3">
                        <input type="submit" class="check1   btn btn-success col-md-12  " name="Save" value="Send Reminder" style="margin-bottom:10px;"> 
                    </div>
                <?php } ?>
    	    </div>	
    	</div>
        </form>
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

