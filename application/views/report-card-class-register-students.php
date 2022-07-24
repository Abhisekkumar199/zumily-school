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
<div class="tz-2 mainContant  " style="min-height: 500px;background-color:#ffffff;"  >
        <input type="hidden" id="class_section_name" value="<?php echo $class_section_name; ?>" />
        <div class="tz-2-com tz-2-main">
        <h4  >Students list to Update Report Card  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4>  
            <div class="col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span>
            	<p><strong>Class:</strong> <?php echo $class_section_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Total Students:</strong> <?php echo $classregister_info['total_students']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>
            	</p>
             
            </div>
           
            <div class="col-sm-12 fullWidth-tab">
        		<div class="panel panel-bd lobidrag">  
                    <div class="panel-body" id="result"> 
                    	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                        	<table class="table table-hover">
                            	<thead>
                                	<td  style="width: 300px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name </a></span></td> 
                                	<td  style="width: 150px;" ><span ><a href="javascript:void(0)"  >Reg No. </a></span></td> 
                                	<td  style="width: 160px;" ><span ><a href="javascript:void(0)"  >DOB</a></span></td> 
                                	<td style="width: 220px;" ><span ><a href="javascript:void(0)"  >Father Name</a></span></td> 
                                	<td style="width: 200px;" class="text-right">Action</td>
                            	</thead>
                            	<tbody> 
                            	    <?php  foreach($class_student_list as $student) { ?>
                            	     <tr class=" "   >
                                		<td class="business_list_">
                                		     <?php if(!empty($student->profile_picture)) { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $student->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } else { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } ?> 
                            		        <?php echo $student->first_name." ".$student->middle_name." ".$student->last_name; ?></td> 
                                		<td class="business_list_"><?php echo $student->registration_no;  ?></td> 
                                		<td class="business_list_"><?php echo date("M d, Y",strtotime(@$student->date_of_birth)) ; ?></td>  
                                		<td class="business_list_"><?php  echo $student->father_name; ?></td> 
                                		<td   class="text-right">  
                                		    <a href="<?php echo base_url(); ?>update-class-register-student-report-card/<?php echo base64_encode($student->class_register_student_id)."-".base64_encode($class_register_id); ?>"   title="Upload Documents"  >Update Report Card</a>
                                		    
                                		</td>  
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
</div>
  