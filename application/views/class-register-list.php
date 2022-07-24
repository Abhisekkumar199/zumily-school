 <script>  
function delete_class_register(class_register_id,class_teacher_id,session_id)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this Class-Register?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {class_register_id: class_register_id,class_teacher_id: class_teacher_id,session_id: session_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-class-register",
        	type : "POST",
        	data : pass_data,
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
<div class="tz-2 mainContant zumily_mainContent" >
<div class="tz-2-com tz-2-main">  
    <form method="get" action="<?php echo base_url(); ?>classes-register-list" >
	<div class="row" style="background: #151f31;" >
		<div class="col-md-6 col-xs-6" > 
			<h4>Classes Register List </h4>
        </div>
		<div class="col-md-6 col-xs-9" >
		    <div class="row">
		        <div class="col-md-3"   >
	            </div>
	            <div class="col-md-3"   >
	                <select id="session_year" class="form-control " name="session_year" onchange="this.form.submit()" style="border: 1px solid rgb(189, 185, 185);height:30px;  margin: 7px; " required=""   >
                        <option value=""  >Select session year  </option> 
                        <?php foreach($session_years as $session_year) { ?>
                        <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                        <?php } ?>
                    </select> 
	            </div>
                <div class="col-md-4"  style="padding-right: 0px;margin-top:12px;" >  
                    <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url(); ?>class-register-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        			<a  style="  margin-right:10px;" class=" pull-right" href="<?php echo base_url();?>add-class-register"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
        	    </div>	
		    </div>
		</div>
        </form>
	</div>
        
	<div class="col-sm-12 fullWidth-tab">
		<div class="panel panel-bd lobidrag"> 
             
            <div class="panel-body" id="result"> 
            	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                	<table class="table table-hover">
                	    <input type="hidden" name="current_date" id="current_date" />
                    	<thead>
                        	<td  style="width: 60px;" ><span ><a href="javascript:void(0)"  >Class </a></span></td> 
                        	<td  style="width: 70px;" ><span ><a href="javascript:void(0)"  >Session Year </a></span></td> 
                        	<td style="width: 60px;" ><span ><a href="javascript:void(0)"  >Room No. </a></span></td> 
                        	<td style="width: 80px;" ><span ><a href="javascript:void(0)"  >Total Students </a></span></td> 
                        	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Class Teacher </a></span></td>  
                        	<td class="text-center" ><span ><a href="javascript:void(0)"  >--------------- Activities --------------- </a></span></td>  
                        	<td class="text-right">Action</td>
                    	</thead>
                    	<tbody>
                    	<?php
                     	if(@$totalrecord > 0)
                    	{
                    	foreach($classregister_lists as $classregister)
                    	{
                    	?> 
            	        <tr class=" "   >
                    		<td class="business_list_"><?php echo $classregister->class_name_section; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->session_year; ?></td> 
                    		<td class="business_list_"><?php echo $classregister->room_no; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->total_students; ?></td>  
                    		<td class="business_list_"><?php echo $classregister->first_name." ".$classregister->last_name; ?></td> 
                    		<td class="business_list_ text-center"> 
                    		    <a href="<?php echo base_url(); ?>class-students/<?php echo base64_encode($classregister->class_register_id); ?>" >  Class Students</a>&nbsp;&nbsp;&nbsp; 
                    		    <?php if($classregister->total_students > 0){ ?><a href="<?php echo base_url(); ?>class-subject-teachers/<?php echo base64_encode($classregister->class_register_id); ?>" >  Map Subject Teachers</a><?php } else { echo "Map Subject Teachers";} ?>&nbsp;&nbsp;&nbsp;
                    		    <?php if($classregister->total_students > 0){ ?><a href="<?php echo base_url(); ?>student-attendance/<?php echo base64_encode($classregister->class_register_id); ?>" >  Attendance</a><?php } else { echo "Attendance";} ?>&nbsp;&nbsp;&nbsp;
                		    </td> 
                    		<td class="text-right">  
                    		
                    		    <?php if($classregister->total_students == 0 and $classregister->subject_teachers == '' ) { ?>
                    		    <a href="javascript:void(0)" title="Delete this Class Register" onclick = "delete_class_register(<?php echo $classregister->class_register_id; ?>,<?php echo $classregister->class_teacher_id; ?>,<?php echo $classregister->session_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;color:#151f31;"></i></a>&nbsp;
                    		    <?php } ?>
                    		    
                    		    <?php if($classregister->is_active == 1) { ?>
                    		    <a href="<?php echo base_url(); ?>update-class-register/<?php echo base64_encode($classregister->class_register_id); ?>"  title="Edit this Class Register"><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                    		    <?php } ?>
        		
                    			
                    		</td>
                    	</tr>
                
                	<?php } } else { ?>
                	<tr>
                		<td colspan="7" class="business_list_"> You have no class register added. <a href="<?php echo base_url(); ?>/add-class-register">Click here</a> to add one.</td>
                	</tr>
                	<?php } ?>
                	</tbody>
                	</table>
            	</div>
        	</div> 
		</div>
	</div>
</div>

</div>

</div>
</section>
  
  
  
  
<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Class Registers</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Remember, this is not same as Classes. Classes get setup only once in lifetime but Class-Registers get setup each year for those classes.</li>
                  <li >This displays all the Class Registers, setup by Admin OR Class Teachers every start of the session-year.</li>
                  <li >Basically, Class-Register defines a class running in a specific Session-Year, Room#, Total-Students, Class-Teacher, etc.</li>
                  <li >You can EDIT a CR, only if it ACTIVE. It means, you cannot change room# or Class-Teacher for previous years CR.</li>
                  <li >From this page, you can go and see all the students enrolled to a specific CR, assign Subject-Teachers to it, Take/Edit Attendance for the day.</li>
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

