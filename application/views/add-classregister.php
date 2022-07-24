<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
        var class_register_id = $('#class_register_id').val();  
        var class_id = $('#class_id').val();    
        var session_id = $('#session_id').val();  
        var class_teacher_id = $('#class_teacher_id').val();  
        var subject_teacher_id = $('#subject_teacher_id').val();  
        var session_year = $("#session_id option:selected").text();
         
        if(class_id == '')
        {
            $('#errorMsg').html("Please select class");
            $('#class_id').css("border","1px solid red");
    		$('#class_id').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#class_id').css("border","1px solid #c9c9c9");
        }
        
        if(session_id == '')
        {
            $('#errorMsg').html("Please select session year");
            $('#session_id').css("border","1px solid red");
    		$('#session_id').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#session_id').css("border","1px solid #c9c9c9");
        }
        $('#session_year').val(session_year);
        if(class_register_id == '')
        {
            if(class_teacher_id == '')
            {
                $('#errorMsg').html("Please select class teacher");
                $('#class_teacher_id').css("border","1px solid red");
        		$('#class_teacher_id').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#class_teacher_id').css("border","1px solid #c9c9c9");
            }
        }
        
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
        
    }); 
    $('.session').change(function() {  
        var session_id = $(this).val();   
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/get-unallocated-classes",  
        data:{session_id:session_id},  
        success:function(response){   
            
            var jd = JSON.parse(response);  
            $("#class_id").html(jd.class_list);  
	    	$("#class_teacher_id").html(jd.class_teacher_list);  
            
            }
        }); 
    }); 
    $('#class_id').change(function() {     
        var class_name = $("#class_id option:selected").text();
        $("#class_name").val(class_name);  
    });
     $('.change_class_teacher').click(function() {   
         
        $(".show_class_teacher").show();  
    });
}); 
</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$classregister_info['class_register_id'] != '') { echo "Edit"; }else { echo "Add";} ?> Class Register  
			<a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-classregister-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  aautocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo @$classregister_info['class_register_id']; ?>"> 
                        <input type="hidden" name="class_name_section" id="class_name_section" value="<?php echo @$classregister_info['class_name']." ".@$classregister_info['section']; ?>"> 
                        <input type="hidden" name="current_class_teacher_id"  value="<?php echo @$classregister_info['class_teacher_id']; ?>"> 
                        <input type="hidden" name="class_register_session_id"  value="<?php echo @$classregister_info['session_id']; ?>"> 
                        <input type="hidden" name="session_year" id="session_year" value=""> 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        
                        <?php if(@$classregister_info['class_register_id'] != '') { ?> 
                        
                        <div class="col-sm-12" style="margin-bottom:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	<strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	<a href="javascript:void(0)" class="change_class_teacher" ><strong>Change Class Teacher</strong></a>
                        	</p>
                        </div> 
                        <?php } else { ?>
                        <div class="col-md-4" >
                            <div class="form-group"> 
                                <select class="form-control session  test" id="session_id"  name="session_id" data-toggle="tooltip" data-placement="top" title="Session">
                                    <option value="">Select Session</option>
                                    <?php
                                    foreach($session_lists as $session)
                    	            {
                	                ?>
                                    <option value="<?php echo $session->school_session_id; ?>" <?php if(@$classregister_info['session_id'] == $session->school_session_id)  { echo "selected";} ?>><?php echo $session->session_year; ?></option>
                                    <?php } ?> 
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <input type="hidden"  id="class_name"  name="class_name"  value="">
                                <select class="form-control  test" id="class_id"  name="class_id" data-toggle="tooltip" data-placement="top" title="Class">
                                    <option value="">Select Class</option>
                                    <!--<?php
                                    foreach($class_lists as $class)
                    	            {
                	                ?>
                                    <option value="<?php echo $class->class_id; ?>" <?php if(@$classregister_info['class_id'] == $class->class_id)  { echo "selected";} ?>><?php echo $class->class_name." (".$class->section.")"; ?></option>
                                    <?php } ?>--> 
                                </select>    
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="room_no"  name="room_no" placeholder="Room no" data-toggle="tooltip" data-placement="top" title="Room no" value="<?php echo @$classregister_info['room_no'];  ?>" maxlength="30" autocomplete="off" >
                            </div>
                        </div>
                        
                         
                       
                        <div class="col-md-6">
                            <div class="form-group show_class_teacher" <?php if(@$classregister_info['class_register_id'] != '') { ?> style="display:none;" <?php } ?>  > 
                                <select class="form-control test " id="class_teacher_id"  name="class_teacher_id" data-toggle="tooltip" data-placement="top" title="Class teacher">
                                    <option value="">Select Class Teacher To Change</option>
                                    
                                    <?php if(@$classregister_info['class_register_id'] != '') { ?>
                                    <?php
                                    foreach($class_teacher_lists as $teacher)
                    	            {
                	                ?>
                                    <option value="<?php echo $teacher->teacher_id; ?>"  ><?php echo $teacher->first_name.' '.$teacher->last_name." (".$teacher->subject1.")"; ?></option>
                                    <?php } } ?>
                                    
                                </select> 
                            </div> 
                        </div>  
              
                          
                         
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  class" name="update" value="Submit"> 
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
 



<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add New Class-Register</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >You create Class-Register at the start of the Session-Year.</li>
                  <li >Class-Register is nothing but combination of a SESSION-YEAR, CLASS with SECTION, ROOM#, and a CLASS-TEACHER. </li>
                  <li >Once you you create a Class-Register, start assigning STUDENTS & SUBJECT TEACHERS to complete this process.</li>
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

 
