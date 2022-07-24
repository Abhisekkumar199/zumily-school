<script type="text/javascript">  
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

function session_event()
{ 
    $("#is_session_changed").val(1); 
}
</script>
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
    	<div class="row" style="background: #151f31;" >
    		<div class="col-md-3 col-xs-3" > 
    			<h4>Late Fee Reminders List </h4>
    		</div>
    		<div class="col-md-9 col-xs-9" >
    		    <form method="get" action="<?php echo base_url(); ?>late-fee-reminder-list" >
    		    <div class="row">
    		        
                    <div class="col-md-4"   >  
                    </div>
    		        <div class="col-md-3"  >
    		            <?php ?>
            		    <select id="session_year" class="form-control  " name="session_year" required=""  style="border: 1px solid rgb(189, 185, 185);height:30px;  margin: 7px;width: 135px;   " onchange="session_event();this.form.submit()">
                            <option value="" disabled>Select session year  </option> 
                            <?php foreach($session_years as $session_year) { ?>
                            <option value="<?php echo $session_year->session_id; ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                            <?php } ?>
                        </select> 
                    </div>  
                    <div class="col-md-3"  > 
                        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url(); ?>late-fee-reminder-pdf/<?php echo base64_encode($selected_session); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        
                    </div>  
    			</div>
    			</form>
    		</div>
    	</div> 
	
    	
	    <form method="post" action="<?php echo base_url(); ?>school-late-fee-reminder-process" >
        <input type="hidden" name="session_year" id="session_year_name" value="" />
    	<div class="hom-cre-acc-left hom-cre-acc-right " style="min-height:500px;">
    	    <div class="col-sm-12 fullWidth-tab">
        		<div class="panel panel-bd lobidrag"> 
                	<div class="panel-body" id="result" > 
                    	<div class="table-responsive tab-inn ad-tab-inn active" id="active"  >
                        	<table class="table table-hover"  >
                            	<thead>
                                	<td style="width:250px;">Title</td> 
                                	<td style="width:120px;">Session Year </td>   
                                	<td class="width:120px; ">Sent Date</td>  
                                	<td class="width:120px; ">Total Students</td> 
                            	    <td class="col-md-2">Action</td>
                            	</thead>
                                <tbody>
                        	<?php 
                        	if(count($reminder_lists) > 0) 
                        	{
                            	foreach($reminder_lists as $reminder)
                            	{
                        	?>  
                        	<tr     >  
                            	<td class="business_list_"><?php echo $reminder->title; ?></td>   
                            	<td class="business_list_"><?php echo $reminder->session_year;     ?></td> 
                            	<td class="business_list_ "><?php  echo date('D, M d, Y', strtotime($reminder->date_created));  ?></td>  
                            	<td class="business_list_"><?php echo $reminder->total_students;     ?></td> 
                        	    <td><a href="javascript:void(0)"  onclick="showhide2('<?php echo $reminder->students_late_fee_reminder_id; ?>');"    ><i class="fa fa-eye" style="font-size:20px;"></i></a> </td> 
                        	</tr>  
                        	
                        	<tr class=" business_list_dropdown login2<?php echo $reminder->students_late_fee_reminder_id; ?>">
                                <td colspan="4">   
                                    <table class="table table-hover"  >
                                    	<thead>
                                        	<td style="width:250px;">Student Name</td> 
                                        	<td style="width:110px;">Class Section</td>   
                                        	<td style="width:120px;">Date Of Birth</td>   
                                        	<td class="text-left">Father Name</td>  
                                        	<td class="text-left">Parent Mobile</td> 
                                    	</thead>
                                        <tbody> 
                                             <?php 
                                                $class_register_student_ids = $reminder->class_register_students_list;   
                                                $student_details = reminder_students_details($class_register_student_ids);  
                                                
                                            	foreach($student_details as $student)
                                    	        {
                                             ?>
                                             <tr>
                                                <td>
                                                    <?php echo $student->first_name." ".$student->last_name; ?>   </p>
                                                </td>
                                                <td><?php echo $student->class_name_section ; ?></td>
                                                <td><?php echo $student->date_of_birth; ?></td>
                                                <td><?php echo $student->father_name; ?></td>
                                                <td><?php echo $student->parent_mobile_no; ?></td>
                                             </tr>
                                             <?php } ?>
                                        </tbody> 
                        	        </table>
                                </td>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Late Fee Reminders List</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page is designed to list all the PAST-LATE-FEE-REMINDERS school has sent so far for a specific Session-Year.</li>
                  <li >This list is filtered only by Session-Year.</li>
                  <li >You can DOWNLOAD this pdf-report if you want to follow-up with these listed STUDENTS/PARENTS.</li>
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

