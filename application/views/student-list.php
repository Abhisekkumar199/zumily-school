<script>
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
</script>  
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent" >
    <div class="tz-2-com tz-2-main">   
        <form method="get" action="<?php echo base_url(); ?>students-list" >
		<div class="row" style="background: #151f31;"> 
    		<div class="col-md-6 col-xs-3" >  <h4>Students List</h4> </div>  
    		
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
                        <a href="<?php echo base_url(); ?>student-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        		        <a  style="  margin-right:10px;" class="  pull-right" href="<?php echo base_url();?>add-student"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px;" class="fa fa-plus-circle"></i></a> 
        		    </div> 
		        </div>
    	    </div>   
        </div>        	    
	    </form>
                
                
         <!--<a  style=" margin: -5px;margin-left:10px;margin-right:10px;" class="btn btn-success dropdown-toggle height-36 pull-right" href="<?php echo base_url();?>batch-lists">Batch List </a>
	    <a  style=" margin: -5px;margin-left:10px;" class="btn btn-success dropdown-toggle height-36 pull-right" href="<?php echo base_url();?>import-student">Import Data </a>-->
	     
    	<div class="col-sm-12 text-right" style="margin-top:10px;margin-bottom:10px;"> 
             <a href="javascript:void(0);" id="showtext" onclick="show_unallocated_students();" ><strong>Show Unallocated Students</Strong></a>
        </div>  
        
        <input type="hidden" id="show" value="0" >
        <?php
            if(count($unassigned_student_lists) > 0)
            {
        ?>
        <div class="col-sm-12 fullWidth-tab unallocated_students" style="display:none;">
            
            <form name="student" method="post" action="#"> 
            <input type="hidden" name="class_register_id" value="<?php echo $class_register_id ; ?>"  />  
            <input type="hidden" name="class_section_name" value="<?php echo $class_section_name ; ?>"  />  
    		<div class="panel panel-bd lobidrag"> 
    		    <h5 style="text-align:center;margin-top:10px;margin-bottom:10px;font-size:20px;color:red;"><strong>Unallocated Students List</strong></h5>
                <div class="panel-body" id="result"> 
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead> 
                            	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name </a></span></td> 
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Reg. No. </a></span></td> 
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Reg. Date </a></span></td> 
                            	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Date-of-birth</a></span></td> 
                            	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Father Name</a></span></td>   
                        	    <td ><span ><a href="javascript:void(0)"  >Parent&nbsp;Mobile</a></span></td>   
                        	</thead>
                        	<tbody> 
                        	    <?php  foreach($unassigned_student_lists as $student) { ?>
                        	     <tr class=" "   > 
                            		<td class="business_list_">
                            		     <?php if(!empty($student->profile_picture)) { ?>
                            		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $student->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                            		    <?php } else { ?>
                            		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                            		    <?php } ?>&nbsp;
                        		        <?php echo $student->first_name." ".$student->middle_name." ".$student->last_name; ?></td> 
                            		<td class="business_list_"><?php echo $student->registration_no;  ?></td> 
                            		<td class="business_list_"><?php echo date("M d, Y",strtotime(@$student->registration_date)) ; ?></td> 
                            		<td class="business_list_"><?php echo date("M d, Y",strtotime(@$student->date_of_birth)) ; ?></td>  
                            		<td class="business_list_"><?php  echo $student->father_name; ?></td>  
                    		        <td class="business_list_"><?php echo $student->parent_mobile_no; ?></td>   
                        		</tr>
                        	    <?php } ?>
                    	    </tbody>
                    	</table>
                	</div>
            	</div> 
    		</div>
    		</form>
    	</div>  
        <?php } ?>
        
    	<div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag">  
                <div class="panel-body" id="result"> 
                    <?php
                    $success = $this->session->userdata('success'); 
                    if (!empty($success)) 
                    {
                        echo  $success ;
                        $this->session->unset_userdata('success');
                    }
                    ?>
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td  ><span ><a href="javascript:void(0)" style="margin-left:40px;"  >Name </a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Reg. No. </a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Reg. Date </a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Date-of-birth </a></span></td> 
                            	<td ><span ><a href="javascript:void(0)"  >Father Name </a></span></td> 
                            	<td  ><span ><a href="javascript:void(0)"  >Parent Mobile</a></span></td>  
                            	<td class="text-right">Action</td>
                        	</thead>
                        	<tbody>
                        	<?php
                         	if(@$totalrecord > 0)
                        	{
                        	foreach($student_lists as $students)
                        	{
                        	?> 
                	        <tr class=" "   >
                        		<td  class="login<?php echo $students->student_id; ?>">
                        		    <?php if(!empty($students->profile_picture)) { ?>
                        		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $students->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                        		    <?php } else { ?>
                        		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                        		    <?php } ?>
                        		    <?php echo $students->first_name." ".$students->middle_name." ".$students->last_name; ?> (<?php echo $students->class_name_section; ?>)
                    		    </td> 
                        		<td class="business_list_"><?php echo $students->registration_no; ?></td> 
                        		<td class="business_list_"><?php if($students->registration_date!= ''){ echo date("M d, Y",strtotime($students->registration_date)); } ?></td> 
                        		<td class="business_list_"><?php if($students->date_of_birth!= ''){ echo date("M d, Y",strtotime($students->date_of_birth)); } ?></td>  
                        		<td class="business_list_"><?php echo $students->father_name; ?></td>
                        		<td class="business_list_"><?php echo $students->parent_mobile_no; ?></td> 
                        		<td class="text-right">  
                        			<a href="<?php echo base_url(); ?>update-student/<?php echo base64_encode($students->student_id); ?>"   title="Edit this Student's data"  ><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                        			<!--<?php if($students->displayflag == 1 ) { ?>
                        			<a href="<?php echo base_url(); ?>disable-student/<?php echo $students->student_id; ?>" title="disable"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                        			<?php } else { ?> 
                        			<a href="<?php echo base_url(); ?>enable-student/<?php echo $students->student_id; ?>"   title="enable"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                        			<?php } ?> -->
                        	    &nbsp;<a href="javascript:void(0)" student_id="<?php echo $students->student_id; ?>" class="student_details" onclick="showhide2('<?php echo $students->student_id; ?>');" title="View Student's complete Info."   ><i class="fa fa-eye" style="font-size:20px;color:#151f31;"></i></a>
                        		</td>
                        	</tr>
                        	 
                        	<tr style="display:none;" class=" business_list_dropdown login2<?php echo $students->student_id; ?>">
                                <td id="show_fee_data<?php echo $students->student_id; ?>"  colspan="7" style="background-color: #ffffff;">   
                                </td>
                            </tr> 
                    	<?php } } else { ?>
                    	<tr>
                    		<td colspan="4" class="business_list_"> You have no student added. <a href="<?php echo base_url(); ?>/add-student">Click here</a> to add one.</td>
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
 
 
<script type="text/javascript">
function show_unallocated_students()
{
    var check = $("#show").val();
    if(check == 0)
    {
        $(".unallocated_students").show();
        $("#show").val(1);
        $("#showtext").html("<strong>Hide Unallocated Students</Strong>");
    }
    else
    {
        $(".unallocated_students").hide();
        $("#show").val(0);
        $("#showtext").html("<strong>Show Unallocated Students</Strong>");
    }
}
$(document).ready(function(){   

    $(".student_details").click(function(){    
	var student_id=$(this).attr('student_id');  
	$("#show_fee_data"+student_id).html(' <img style="height:20px;width:20px;text-align-center;" src="https://localhost/project/zumilyschool/assets/images/loader.gif">');
	
	$.ajax({
	url : "<?php echo base_url(); ?>get-student-details",
	type : "POST",
    	data : {student_id:student_id},
	    success : function(data1) {  
	        
	   if(data1 == '')
	   {
	       
	        $("#show_fee_data"+student_id).html("<p style='color:red;text-align: center;'><strong>** This student has not been assigned to any Class-Register yet **</strong></p>");
	   }
	   else
	   {
	        $("#show_fee_data"+student_id).html(data1); 
	   }
	}
	});
	return false;
});

});
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Students</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page displays all the students enrolled to the applications in all the years.</li>
                  <li >You can filter students by Session-Year and/or by Class.</li>
                  <li >Student' record is EDITABLE only if he/she is active student in the school. Once, has left the school, record cannot be edited.</li>
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

