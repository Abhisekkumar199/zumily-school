 <script> 
$(document).ready(function(){  
    $("#student-search").keyup(function(){ 
         
        var classregisterid = <?php echo $class_register_id; ?> 
        var class_section_name = $("#class_section_name").val(); 
        var val = this.value;  
        var url = "<?php echo base_url();?>/student-search";
        var pass_data = { 'searchtext' : val,'classregisterid' : classregisterid,'class_section_name' : class_section_name}; 
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
function delete_class_register_student(val1,studentid,class_register_id)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to remove this student from this Class-Register?", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show(); 
        	var pass_data = {class_register_student_id: val1,studentid: studentid,class_register_id: class_register_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-class-register-student",
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
        <input type="hidden" id="class_section_name" value="<?php echo $class_section_name; ?>" />
        <div class="tz-2-com tz-2-main">
        <h4  >Class Register Students  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
            <a href="<?php echo base_url(); ?>class-register-students-pdf/<?php echo base64_encode($class_register_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
            
        </h4>  
            <div class="col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span>
            	<p><strong>Class:</strong> <?php echo $class_section_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Total Students:</strong> <?php echo $classregister_info['total_students']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>
            	</p>
             
            </div>
            <!--<?php if($classregister_info['is_class_register_active'] == 1) { ?>
            <div class="col-sm-12">
                <div class="col-sm-6" style="    padding-left: 0px;">
                    <form action="<?php echo base_url(); ?>search-result" method="post" class="student-form tourz-search-form tourz-top-search-form searchform" style="width: 431px; display:inline-block">
                        <div class="input-field"></div>
                        <div class="input-field autocomplete studentautocomplete search-wrap student-search-wrap" >
                        <input style="border: 1px solid #ddd;background-color: #ffffff;height: 34px;width: 431px;" type="text" id="student-search"   name="search"   class="typeahead form-control"    placeholder="Search Students/Father/ParentMobile" autocomplete="off">
                        
                        <span id="showstudents"  ></span> 
                        </div>
                        <div class="input-field" style="width:10%;">
                        <i class="waves-effect waves-light tourz-top-sear-btn waves-input-wrapper"> 
                        <input type="submit" name="find" id="find" value="" class="waves-button-input" style="float:left; line-height:0"></i> 
                        </div>
                    </form>  
                </div>
            </div>
            <?php } ?>-->
            <div class="col-sm-12 text-right" style="margin-top:10px;margin-bottom:10px;">
                
            <a href="<?php echo base_url(); ?>add-student-to-class/<?php echo base64_encode($class_register_id); ?>-<?php echo base64_encode($class_section_name); ?>"  ><strong>Add new student to this class</Strong></a>&nbsp;&nbsp;
            <a href="javascript:void(0);" id="showtext" onclick="show_unallocated_students();" ><strong>Show Unallocated Students</Strong></a>
            </div>
            <input type="hidden" id="show" value="0" >
            <?php
            if(count($class_unassigned_student_list) > 0)
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
                            	    <th style="width:26px">
                                        <label class="ui-check m-0"> <input style="margin-top: -6px;" type="checkbox" id="check"  ><i></i></label>
                                    </th>
                                	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name </a></span></td> 
                                	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Reg. No. </a></span></td> 
                                	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >Reg. Date </a></span></td> 
                                	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >DOB</a></span></td> 
                                	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Father Name</a></span></td>    
                            	</thead>
                            	<tbody> 
                            	    <?php  foreach($class_unassigned_student_list as $student) { ?>
                            	     <tr class=" "   >
                        	            <td>
                                            <label class="ui-check m-0">
                                            <input type="checkbox" class="allcheck" name="student_id[]" value="<?php echo $student->student_id ; ?>"  > <i></i></label>
                                        </td>
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
                            		</tr>
                            	    <?php } ?>
                            	    <tr><td colspan="6" class="text-center" style="background-color:#ffffff;padding: 15px;"><a style="  margin: -5px;margin-right: 10px;text-align:center;" class="btn btn-success dropdown-toggle height-36 text-center" onclick="sure();" href="javascript:void(0);">Add Student(s) to Class </a> </td></tr>
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
                         
                    	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                        	<table class="table table-hover">
                            	<thead>
                                	<td style="width: 260px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name </a></span></td> 
                                	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Reg. No. </a></span></td> 
                                	<td style="width: 130px;" ><span ><a href="javascript:void(0)"  >Reg. Date </a></span></td> 
                                	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >DOB</a></span></td> 
                                	<td style="width: 160px;" ><span ><a href="javascript:void(0)"  >Father Name</a></span></td>   
                                	<td style="width: 100px;" ><span ><a href="javascript:void(0)"  >Stream</a></span></td> 
                                	<td style="width: 105px;" ><span ><a href="javascript:void(0)"  >Total Docs</a></span></td>  
                                	<td style="width: 100px;" class="text-right">Action</td>
                            	</thead>
                            	<tbody> 
                            	    <?php
                            	    if(count($class_student_list) > 0) { 
                            	    foreach($class_student_list as $student) { ?>
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
                                		<td class="business_list_"><?php if($student->course_stream == 'A'){ echo "Arts"; } else if($student->course_stream == 'B'){ echo "Biology"; } else if($student->course_stream == 'H'){ echo "Home Science"; } else if($student->course_stream == 'M'){ echo "Mathematics"; } else if($student->course_stream == 'S'){ echo "Science"; }   ?></td>   
                                		
                                		<td class="business_list_"><?php  echo $student->total_documents; ?></td>  
                                		<td   class="text-right"> 
                                		    <?php if($classregister_info['is_class_register_active'] == 1) { ?>
                                		    <?php if($student->total_attendance_records == 0) { ?>
                                		    <a href="javascript:void(0)" title="Remove Student from this CR" onclick = "delete_class_register_student(<?php echo $student->class_register_student_id; ?>,<?php echo $student->student_id; ?>, <?php echo $class_register_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;color:#151f31;"></i></a>&nbsp;
                                		    <?php } ?>
                                		    <?php } ?>
                                		    <a href="<?php echo base_url(); ?>update-class-register-student/<?php echo base64_encode($student->class_register_student_id)."-".base64_encode($class_register_id); ?>"   title="Upload Documents"  ><i class="fa fa-upload" style="font-size:20px;color:#151f31;"></i></a>
                                		    <a  href="javascript:void(0);" data-toggle="modal" data-target="#myModal111" updateid="<?php echo $student->class_register_student_id;	?>" class="update"  ><i class="fa fa-pencil" style="font-size:20px;color:#151f31;"></i></a>
                                		    
                                		</td>  
                            		</tr>
                            	    <?php } } else { ?>
                            	    
                            	    <tr><td colspan="8"><p style="text-align:center;color:red;"><strong>*** No Student has been assigned to this Class-Register yet. ***</strong></p></td></tr>
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
  
  
  
<div id="myModal111" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <div class="row" style="width: 100%;">
              <div class="col-md-8">
                  <h4 class="modal-title"> Update Course Stream </h4>
              </div>
              <div class="col-md-4 text-right">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
          </div> 
      </div>
      <div class="modal-body">
           <form name="addForm" id="addForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>update-class-register-stream">  
            <input type="hidden" name="updateid" id="updateid"    value=""  /> 
            <input type="hidden" name="class_register_id" id="class_register_id"    value="<?php echo $class_register_id; ?>"  />
            <div class="padding"> 
                <div class="row">
                    <div class="col-md-12"> 
                        <div class="card"> 
                            <div class="card-body">   
                                <div class="clearfix"></div> 
                                <div class="col-sm-12">
                                    <input type="radio" name="stream" value="N" required checked > <strong>None</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="stream" value="A" required > <strong>Arts</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="stream" value="S" required > <strong>Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="stream" value="B" required > <strong>Biology</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="stream" value="H" required > <strong>Home Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="stream" value="M" required > <strong>Mathematics</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div> 
                                
                                <button type="submit" class="addcard btn w-sm mb-1 btn-success" style="float: right; margin-right: 12px;">SAVE</button>
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
<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Class-Register-Students</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This lists all the students enrolled to this Class-Register. All students displayed in the alphabetically order.</li>
                  <li >This page has UPLOAD ICON which can be used to upload documents against a student.</li>
                  <li >Here documents means, Exam Results, Termination Certificate, etc.</li>
                </ul> 
            </div> 
        </div> 
    </div>
</div> 
 <script>

$(document).ready(function(){   
		$(".update").click(function(){  
		    var updateid = $(this).attr('updateid');  
	        $("#updateid").val(updateid);   
		});
    
        $("#check").click(function(){  
        $(".allcheck").not(this).prop('checked', this.checked);
    });
});
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
function sure(vr, ac)
{
    var cat_check = $('input[name="student_id[]"]:checked').length; 
    if(cat_check > 0)
    {  
        alertify.set({
           labels : {
              ok     : "Yes",
              cancel : "Cancel"
           }, 
           buttonReverse : false,
           buttonFocus   : "ok"
        });
        alertify.confirm("Are you sure ! You want to add student?", function (e) 
        { 
            if (e) 
            { 
        		document.student.action='<?php echo base_url(); ?>add-class-register-students';
        		document.student.submit();
        		return true;
    	    }
        	else
        	{
        		return false;
        	} 
        });
        
    } 
    else
    {
        alertify.alert('Please select students!', function(){  });  
    }
}
</script>
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


  