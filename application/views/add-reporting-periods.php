 <script>
$(document).ready(function(){  
    $(".subjects").change(function(){
        var subject_count =  $('#subject_count').val();
        if(subject_count == '')
        {
            var newcount  =  1 ;
        }
        else
        {
            var newcount  =  parseInt(subject_count) + 1 ;
        }
        
        $('#subject_count').val(newcount);
        
    });
    $(".check1").click(function(){     
        var exam_name = $('#exam_name').val(); 
        var start_date = $('#start_date').val(); 
        var end_date = $('#end_date').val(); 
        var subjects = $('.subjects').val(); 
        var subject_count = $('#subject_count').val();
        
        
        
        
        
        if(exam_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter exam name.</div>");
            $('#exam_name').css("border","1px solid red");
    		$('#exam_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#exam_name').css("border","1px solid #c9c9c9");
        } 
        
        if(start_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select start date.</div>");
            $('#start_date').css("border","1px solid red");
    		$('#start_date').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#start_date').css("border","1px solid #c9c9c9");
        }
        
        if(end_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select end date.</div>");
            $('#end_date').css("border","1px solid red");
    		$('#end_date').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#end_date').css("border","1px solid #c9c9c9");
        }
        
     
        if(Date.parse(end_date) <= Date.parse(start_date))
        { 
            $('#errorMsg').html("<div class='alert alert-danger'>End date should be greater than start date.</div>");
            $('#termination_date').css("border","1px solid red");
    		$('#termination_date').focus();
    		return false;
        }
        else
        { 
            $('#errorMsg').html("");
            $('#termination_date').css("border","1px solid #c9c9c9"); 
        }  
        
        duplicatecheck = false ;     
        if(subject_count != '')
        { 
            var duplicatecheck = inputsHaveDuplicateValues();
        } 
         
        if(duplicatecheck == true)
        {
            $('#errorMsg').html("<div class='alert alert-danger'>You cannot have Duplicate Subject for the same Reporting Period..</div>"); 
    		return false;
        }
        
    }); 
    
}); 

function inputsHaveDuplicateValues() {
    var hasDuplicates = false;
    $('.subjects').each(function () {
        var inputsWithSameValue = $(this).val();
        hasDuplicates = $('.subjects').not(this).filter(function () {
            return $(this).val() === inputsWithSameValue;
        }).length > 0;
        if (hasDuplicates) return false
    });
    return hasDuplicates;
}
</script>
<script>
$(document).ready(function(){  
    var date = new Date();
    
    var month_first_day = new Date(date.getFullYear(), date.getMonth(), 1).toDateString("MMM DD, YYYY"); 
    var today = new Date().toDateString("MMM DD, YYYY"); 
    var sd = today;
    var ed = new Date();
  
    console.log(sd);
    $('#start_date').datetimepicker({
      pickTime: false,
      format: "MMM DD, YYYY",  
      todayBtn: true
    });
     $('#end_date').datetimepicker({
      pickTime: false,
      format: "MMM DD, YYYY",
      defaultDate: today,  
      todayBtn: true
    });
 
    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#date_form"), 'start_date', 'end_date');

     
});  

</script>
<script type="text/javascript">
    jQuery(function ($) 
    {    
        var i=1;
        jQuery("#EventbtnAdd").bind("click", function () { 
        	if(i==10) 
        	{
            	alert("Not allowed add more"); 
            	return false
        	} 
        	else 
        	{
                var div = $("<div />");
                div.html(GetDynamicTextBox(i));
                jQuery("#EventTextBoxContainer").append(div);
                 
                
                
        	}
    		i=i+1;
        });
        jQuery("body").on("click", ".remove", function () { 
            jQuery(this).parent().parent().remove();
    		i = i-1;
        });
    });
    function GetDynamicTextBox(value) 
    {
        var value12 = value;
        var sizecharthtml = $(".sizecharthtml").html();
        //alert(sizecharthtml);
        return '<div class="row" style="margin-bottom:10px;">'+sizecharthtml+'<div class="col-sm-3"  > <span class="input-group-text remove red " style="background: #4f92fe; color: #fff;margin-bottom:5px;"><i style="float: left;font-size: 25px;color:#151f31;margin-top: 6px;" class="fa fa-minus-circle"></i></span></div></div>';
    }
    function hidesize(val1)
    {
        if(val1 == 1)
        {
            $('#hidesize').hide();
            $('.showmsg').show();
            
        }
        else
        {
            $('#hidesize').show();
            $('.showmsg').hide();
        }
        
    }
    
 
</script> 
<input type="hidden" id="subject_count" name="subject_count" >
<span class="sizecharthtml" style="display:none;"> 
    <div class="col-sm-3"  > 
        <select class="form-control subjects" name="subjects[]"     style="background-color:#ffffff;margin-bottom:5px;" required>
            <option value="">Select</option>
            <?php 
                foreach($subject_lists as $subject)
    	        {  
    	    ?>
                <option value="<?php echo $subject->subject_id; ?>"><?php echo $subject->subject_name; ?></option>
            <?php } ?>
        </select>  
    </div> 
    <div class="col-sm-3"  > 
        <input type="text" id="size" name="marks[]" placeholder="Maximum Marks" style="background-color:#ffffff;margin-bottom:5px;" class="form-control" required>
    </div> 
</span> 
 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>Add Reporting Period For a Class-Register
            <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i> 
        </h4>
        
        <div class="col-sm-12" style="margin-top:6px;">
        	<span id="errorMsg" style="color:red;"></span>
        	<p><strong>Class:</strong> <?php echo $classregister_info['class_name']." ".$classregister_info['section'] ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	    <strong>Total Students:</strong> <?php echo $classregister_info['total_students']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	    <strong>Session:</strong> <?php echo $classregister_info['session_year']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class Teacher:</strong> <?php echo $classregister_info['first_name']." ".$classregister_info['last_name']; ?>
        	</p>
         
        </div>
        <form id="date_form" method="POST" action="<?php echo base_url();?>add-period-process"> 
        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo $class_register_id; ?>" />
        <div class="col-sm-12 "  style="margin-top:10px;min-height:400px; " > 
            <p id="errorMsg"></p>  
            <div class="row" style="padding-top:0px;background: #ffffff;">  
    			<div class="col-sm-3" > 
    			    <label class="change_title_start">Exam Name</label>
                    <input type="text" class="form-control"  name="exam_name" id="exam_name" style="background-color:#ffffff;"    placeholder="Exam Name"   />      
                </div> 
    			<div class="col-sm-3" > 
                    <label class="change_title_start">Start Date</label>
                    <input type="text" class="form-control"  name="start_date" id="start_date" style="background-color:#ffffff;"   value="<?php echo date("M d, Y",strtotime(date('01-m-Y'))); ?>"  placeholder="Start Date"   />   
                    
                </div>   
                <div class="col-sm-3"  > 
                    <label class="change_title_end">End Date</label>
                    <input type="text" class="form-control"  name="end_date" id="end_date" style="background-color:#ffffff;"   value="<?php echo date("M d, Y",strtotime($this->session->userdata('current_date'))); ?>"  placeholder="End Date"   />   
                   
                </div> 
                
            </div>  
            
            <div class=" row" style="margin-top:25px;margin-bottom:5px;background: #ffffff;"> 
                <div class="col-sm-3"  > 
                    <label class="change_title_start">Subject</label>
                </div> 
                <div class="col-sm-3"  > 
                    <label class="change_title_start">Maximum Marks</label>
                </div>
                <div class="col-sm-3"  > 
                    <span class="input-group-text" id="EventbtnAdd"  ><i style="float: left;font-size: 25px;color:#151f31;margin-top:5px;" class="fa fa-plus-circle"></i></span>
                </div> 
            </div>   
            <div class="row"  >  
                <div class="col-sm-3"  > 
                    <select class="form-control subjects" name="subjects[]"     style="background-color:#ffffff;margin-bottom:5px;" required>
                        <option value="">Select</option>
                        <?php 
                            foreach($subject_lists as $subject)
                	        {  
                	    ?>
                            <option value="<?php echo $subject->subject_id; ?>"><?php echo $subject->subject_name; ?></option>
                        <?php } ?>
                    </select>  
                </div> 
                <div class="col-sm-3"  > 
                    <input type="text" id="size" name="marks[]" placeholder="Maximum Marks" maxlength="3" style="background-color:#ffffff;margin-bottom:10px;"  class="form-control" required>
                </div>  
            </div>     
            <span id="EventTextBoxContainer"> 
            </span> 
            
            <div class="row"  style="margin-top:15px;">
                <div class="col-sm-4"  ></div>
                <div class="col-sm-4 "  >
                    <span>&nbsp;</span>
                    <input type="submit" class="check1 btn btn-success col-sm-12  add_period" id="add_period" name="add_period" value="Submit">
                </div>
            </div> 
    	 </div>
    	 </form>
    </div> 
        <br> 
    </div>
</div>  
 
 