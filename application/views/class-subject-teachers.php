 <script> 
$(document).ready(function(){  
    $("#teacher-search").keyup(function(){ 
         
        var classregisterid = <?php echo $class_register_id; ?> 
        var session_id = <?php echo $session_id; ?> 
        var val = this.value;  
        var url = "<?php echo base_url();?>/teacher-search";
        var pass_data = { 'searchtext' : val,'classregisterid' : classregisterid,'session_id' : session_id}; 
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
 <script>  
function delete_class_register_sub_teacher(val1,class_register_id,sub_teacher_id,session_id)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this sub teacher from this Class-Register?", function (e) 
    { 
        if (e) 
        {  
        	var pass_data = {class_register_sub_teacher_id: val1,class_register_id: class_register_id,sub_teacher_id: sub_teacher_id,session_id: session_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-class-register-sub-teacher",
        	type : "POST",
        	data : pass_data,
        	success : function(data) {  
        	//console.log(data);
        	
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
 <style>
    .student-search-wrap #top-select-searchautocomplete-list, .student-search-wrap #top-select-searchautocomplete-list div
    {
        width: 431px!important;
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
 
<div class="tz-2 mainContant zumily_mainContent"  >
        <div class="tz-2-com tz-2-main" ;>
        <h4  >Class Register - Subject Teachers  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>class-register-teachers-pdf/<?php echo base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        
        </h4>  
            <div class="col-sm-12" style="margin-top:10px;">
            	<span id="errorMsg" style="color:red;"></span>
            	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Total Students:</strong> <?php echo $classregister_info['total_students']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>
            	</p>
             
            </div>
            <?php if($classregister_info['is_class_register_active'] == 1) { ?>
            <div class="col-sm-12">
                <div class="col-sm-6" style="    padding-left: 0px;">
                    <form action="<?php echo base_url(); ?>search-result" method="post" class="student-form tourz-search-form tourz-top-search-form searchform" style="width: 431px; display:inline-block">
                        <div class="input-field"></div>
                        <div class="input-field autocomplete studentautocomplete search-wrap student-search-wrap" >
                        <input style="border: 1px solid #ddd;background-color: #ffffff;height: 34px;width: 431px;" type="text" id="teacher-search"   name="search"   class="typeahead form-control"    placeholder="Search Teachers" autocomplete="off">

                        <span id="showstudents"  ></span> 
                        </div>
                        <div class="input-field" style="width:10%;">
                        <i class="waves-effect waves-light tourz-top-sear-btn waves-input-wrapper"> 
                        <input type="submit" name="find" id="find" value="" class="waves-button-input" style="float:left; line-height:0"></i> 
                        </div>
                    </form>  
                </div>
            </div>
            <?php } ?>
            <div class="col-sm-12 fullWidth-tab" style="min-height:400px;">
        		<div class="panel panel-bd lobidrag">  
                    <div class="panel-body" id="result" > 
                    	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                        	<table class="table table-hover">
                            	<thead>
                                	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Teacher&nbsp;name </a></span></td> 
                                	<td  style="width: 100px;" ><span ><a href="javascript:void(0)"  >Mobile No. </a></span></td> 
                                	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Subjects </a></span></td>  
                                	<td  style="width: 250px;" ><span ><a href="javascript:void(0)"  >Teaching in classes </a></span></td>  
                            	    <?php if($classregister_info['is_class_register_active'] == 1) { ?>
                                	<td class="text-right">Action</td>
                                	<?php } ?>
                            	</thead>
                            	<tbody> 
                            	    <?php  
                            	    if(count($class_subject_teacher_list) > 0)
                            	    {
                            	    foreach($class_subject_teacher_list as $teacher) { ?>
                            	     <tr class=" "   >
                                		<td class="business_list_">
                                		    <?php if(!empty($teacher->profile_picture)) { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/teacherimages/<?php echo $teacher->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } else { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } ?>
                                		    <?php echo $teacher->first_name." ".$teacher->last_name; ?>
                            		    </td> 
                                		<td class="business_list_"><?php echo $teacher->mobile_no; ?></td> 
                                		<td class="business_list_"><?php if($teacher->subject1!= '') {echo $teacher->subject1; } if($teacher->subject2!= '') {echo ", ".$teacher->subject2; } if($teacher->subject3!= '') {echo ", ".$teacher->subject3; }  ?></td>
                                		<td class="business_list_"><?php echo $teacher->sub_class_name_sections; ?></td> 
                                	 	<?php if($classregister_info['is_class_register_active'] == 1) { ?>
                                	 	<td   class="text-right">  
                                		    <a href="javascript:void(0)" title="Remove Teacher from this CR" onclick = "delete_class_register_sub_teacher(<?php echo $teacher->class_register_sub_teacher_id; ?> , <?php echo $class_register_id; ?>,<?php echo $teacher->sub_teacher_id; ?>,<?php echo $teacher->session_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;color:#151f31;"></i></a>&nbsp;
                                		       
                                		</td>  
                                		<?php } ?>
                            		</tr>
                            	    <?php } } else { ?>
                            	    
                            	    <tr><td colspan="8"><p style="text-align:center;color:red;"><strong>*** No Subject-Teacher has been assigned to this Class-Register yet. ***</strong></p></td></tr>
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
</div>
  
  
<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Class Register-Subject Teachers </h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page is desigmned to List, Add, OR Delete a Subject-Teacher to the listed class-Register.</li>
                  <li >It displays CR info on the TOP of the page, which consists of Class, Session-Year, and Class-Teacher.</li>
                  <li >To add a Subject Teacher to this class, search the name of the teacher in the search box and CLICK to add it.</li>
                  <li >You can click on Delete-Icon to remove a teacher from this class.</li>
                  <li >Remember, you can Add/Remove a teacher from a CR only if it is ACTIVE, means for previous year classes, Add/Remove is not allowed.</li>
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


  