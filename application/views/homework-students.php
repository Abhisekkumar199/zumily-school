 <script> 
$(document).ready(function(){  
    $("#student-search").keyup(function(){ 
         
        var classregisterid = <?php echo $class_register_id; ?> 
        var val = this.value;  
        var url = "<?php echo base_url();?>/student-search";
        var pass_data = { 'searchtext' : val,'classregisterid' : classregisterid}; 
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
        <div class="tz-2-com tz-2-main">
        <h4  >Class Students <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i> </h4>  
            <div class="col-sm-12" style="margin-top:6px;">
            	<span id="errorMsg" style="color:red;"></span>
            	<p> <strong>Class:</strong> <?php echo $homework_info['class_name_section']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Title:</strong> <?php echo $homework_info['title'];  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Created-on:</strong> <?php echo date('D, d M , Y', strtotime($homework_info['date_created'])); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    <strong>Due Date:</strong> <?php echo date('D, d M , Y', strtotime($homework_info['due_date'])); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	    
            	</p>
             
            </div>
           
            <div class="col-sm-12 fullWidth-tab">
        		<div class="panel panel-bd lobidrag">  
                    <div class="panel-body" id="result"> 
                    	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                        	<table class="table table-hover">
                            	<thead>
                                	<td  style="width: 260px;" ><span ><a href="javascript:void(0)"  >Student&nbsp;name </a></span></td>  
                                	<td class="text-right">Uploaded Documents </td>
                            	</thead>
                            	<tbody> 
                            	    <?php  foreach($homework_student_list as $student) { ?>
                            	     <tr class=" "   >
                                		<td class="business_list_">
                                		     <?php if(!empty($student->profile_picture)) { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $student->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } else { ?>
                                		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                		    <?php } ?>&nbsp;
                            		        <?php echo $student->first_name." ".$student->middle_name." ".$student->last_name; ?> 
                            		       
                        		        </td> 
                                	 	<td   class="text-right"> 
                                		     &nbsp;<a href="https://localhost/project/zumilyschool/student-homework-details/<?php echo base64_encode($homework_id); ?>-<?php echo base64_encode($student->student_id); ?>"    title="View Homework detail"  ><i class="fa fa-eye" style="font-size:20px;" aria-hidden="true"></i></a> 
                        	    
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

 