 <script> 
$(document).ready(function(){  
    $("#student-search").keyup(function(){ 
           
        var val = this.value;  
        var url = "<?php echo base_url();?>/student-search-for-fee-concession";
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
 <script>  
function disable_fee_concession(id)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to disable it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("If you disable this concession, student won’t be able to use this concession.", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show(); 
        	var pass_data = {id: id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>disable-fee-concession",
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
<div class="tz-2 mainContant zumily_mainContent" >
    <div class="tz-2-com tz-2-main"> 
    	<div class="row" style="background: #151f31;" >
    		<div class="col-md-3 col-xs-3" > 
			<h4> Setup Grades </h4>
    		</div>
    		<div class="col-md-9 col-xs-9" > 
    		</div>
    	</div> 
       
         
        <div class="col-sm-12 addressshow" >
            <form name="frmshipping" id="frmshipping" action="<?php echo base_url();?>/add-grade-process" method="post" novalidate="novalidate">  
                <input type="hidden" id="grade_id" name="grade_id" value="<?php echo $grade_info['reporting_grade_id']; ?>" />
                <div class="col-sm-6" style="margin-top: 20px;">
                    <span    id="errorMsg"></span>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <label>Grade</label>
                    <div id="Shipping_divEmail" class="form-group uplabel"> 
                        <select class="form-control" name="grade"  id="grade"> 
                            <option  value="">Select a Grade</option>
                            <option  value="A-Excellent"  <?php if($grade_info['grade']."-".$grade_info['description'] == "A-Excellent") { echo "selected"; }  ?> >A-Excellent</option>
                            <option  value="B-Good" <?php if($grade_info['grade']."-".$grade_info['description'] == "B-Good") { echo "selected"; }  ?>>B-Good</option>
                            <option  value="C-Average" <?php if($grade_info['grade']."-".$grade_info['description'] == "C-Average") { echo "selected"; }  ?>>C-Average</option>
                            <option  value="D-Below Average" <?php if($grade_info['grade']."-".$grade_info['description'] == "D-Below Average") { echo "selected"; }  ?>>D-Below Average</option>
                            <option  value="F-Fail" <?php if($grade_info['grade']."-".$grade_info['description'] == "F-Fail") { echo "selected"; }  ?>>F-Fail</option>  
                            <option  value="No Pregress" <?php if($grade_info['grade'] == "No Pregress") { echo "selected"; }  ?>>No Pregress</option>
                            <option  value="No Marks" <?php if($grade_info['grade']  == "No Marks") { echo "selected"; }  ?>>No Marks</option>
                            <option  value="Pass" <?php if($grade_info['grade']  == "Pass") { echo "selected"; }  ?> >Pass</option>
                            <option  value="Incomplete" <?php if($grade_info['grade']  == "Incomplete") { echo "selected"; }  ?>>Incomplete</option>
                        </select>
                    </div>
                </div> 
                <div class="col-sm-3"> 
                    <label>Minimum Marks</label>
                    <div id="Shipping_divFirstName" class="form-group uplabel">
                        <input style=" background-color:#ffffff;"  name="minimum_marks" id="minimum_marks" maxlength="3" value="<?php echo $grade_info['min_marks']; ?>" class="form-control" type="text" placeholder="Minimum Marks"> 
                    </div>
                </div>
                <div class="col-sm-3"> 
                    <label>Maximum Marks</label>
                    <div id="Shipping_divFirstName" class="form-group uplabel">
                        <input style=" background-color:#ffffff;"  name="maximum_marks" id="maximum_marks" maxlength="3" value="<?php echo $grade_info['max_marks']; ?>" class="form-control" type="text" placeholder="Maximum Marks"> 
                    </div>
                </div> 
                <div class="col-sm-3"> 
                    <div id="Shipping_divMobile" class="form-group uplabel" style="margin-top:15px;">
                        <button  class="btn btn-primary pull-right check" type="submit" style="width:48%;color:#ffffff;">Submit</button> 
                    </div> 
                </div> 
            </form>
        </div>
         
        <div class="col-sm-12 fullWidth-tab" style="min-height:500px;">
    		<div class="panel panel-bd lobidrag" style="background-color:#ffffff!important; box-shadow: none;"   >  
                <div class="panel-body" id="result">  
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td style="width:250px;">Grade</td> 
                            	<td style="width:60px;">Description</td>  
                            	<td>Minimum Marks</td> 
                            	<td  style="width: 260px;" >Maximum Marks</td>  
                            	<td>Action</td>
                        	</thead>
                        	<tbody> 
                        	    <?php  
                        	    if(count($grade_lists) >0)
                        	    {
                        	    foreach($grade_lists as $grade) { ?>
                        	     <tr class=" "   >  
                                	<td class="business_list_"><?php echo $grade->grade; ?></td>    
                                	<td class="business_list_"><?php echo $grade->description;     ?></td> 
                            		<td class="business_list_"><?php echo $grade->min_marks;  ?></td>  
                            		<td class="business_list_"><?php  echo $grade->max_marks; ?></td>  
                            		<td> 
                    		            <a href="javascript:void(0)" title="Delete this Class" onclick = "delete_grade(<?php echo $grade->reporting_grade_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;"></i></a>&nbsp;
                    			        <a href="<?php echo base_url(); ?>update-grade/<?php echo base64_encode($grade->reporting_grade_id); ?>"     ><i class="fa fa-edit" style="font-size:20px;"></i></a> 
                            		</td>
                        		</tr>
                        	    <?php } } else { ?> 
                	                <tr><td colspan="5"><p class="text-center"><strong>** No record found **</strong></p></td></tr>
                        	    <?php  } ?>
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
 <script>  
function delete_grade(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to delete this Grade?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {grade_id: val1};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-grade",
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
 <script>
   function showaddress()
    {
        $('.addressshow').show();
        $('#is_add_ddress').val(1);
        $('.checkoutbutton'). hide();
    }
    function hideaddress()
    {
        $('.checkoutbutton').show();
        $('#is_add_ddress').val('');
        $('.addressshow'). hide();
    }
 </script> 
    <script>
    
    $("#grade").change(function(){  
        var grade = $(this).val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-if-grade-exist",  
            data:{grade:grade},  
            success:function(response){  
        	    if(response == 1)
        	    { 
        	       
                    $('#errorMsg').html("<div class='alert alert-danger'>Grade already exists</div>"); 
                    $('#grade').css("border","1px solid red");  
                    $(".check").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#errorMsg').html(""); 
                    $('#grade').css("border","1px solid #c9c9c9");  
                    $(".check").attr("disabled", false); 
                     
        	    }
                
                }
            }); 
        });
    $(".check").click(function(){  
        var grade = $('#grade').val();  
        var minimum_marks = $('#minimum_marks').val();  
        var maximum_marks = $('#maximum_marks').val();   
        
        if(grade == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select a grade</div>"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        }
        
        if(minimum_marks == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter minimum marks</div>");
            $('#minimum_marks').css("border","1px solid red");
    		$('#minimum_marks').focus();
    		return false;
        }
        
        if(maximum_marks == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter maximum marks</div>");
            $('#maximum_marks').css("border","1px solid red");
    		$('#maximum_marks').focus();
    		return false;
        } 
        
        
        if(parseInt(minimum_marks) >= parseInt(maximum_marks))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Maximum marks should be greater than minimum marks</div>");
            $('#maximum_marks').css("border","1px solid red");
    		$('#maximum_marks').focus();
    		return false;
        } 
    });
    </script> 
  
  
  <!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Fee Concession</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Fee concession is the place where you can SET or VIEW FEE-CONCESSION given to a student.</li>
                  <li >Search STUDENT name in the search box. It will list, Student-name, Father-Name, Parent-Mobile-No, and Class-section he/she is in. </li>
                  <li >Click on the name of the STUDENT from SEARCH RESULT, you want to give FEE-CONCESSION or VIEW it. It will list all the concession records for the selected STUDENT.</li>
                  <li >You can have only one ACTIVE concession record, means if record is ACTIVE then you won't see "+" sign to add another concession.</li>           
                  <li >If you want give different concession than listed currently, then DISABLE the current ACTIVE CONCESSION. Once you do this, "+" will show up on the page.</li>           
                  <li >To add a new concession, CLICK on the "+" which will guide you to add a new FEE-CONCESSION to the listed student.</li>           
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
