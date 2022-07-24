 <script> 
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
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
	    <form method="get" action="<?php echo base_url(); ?>fee-concessions" >
        <div class="row" style="background: #151f31;" >
    		<div class="col-md-6 col-xs-3" > 
    			<h4>Fee Concessions</h4>
    		</div>
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
                        <?php if($class_register_student_id > 0) { ?>
                        <a href="<?php echo base_url(); ?>fee-concession-pdf/<?php echo base64_encode($class_register_student_id); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
                        <?php } ?> 
                    </div>
    			</div>
    		</div>
    	</div>  
        </form>
        
     
       
        <div class="col-sm-12" style="margin-top:6px;"> <span id="errorMsg" style="color:red;"></span> </div> 
        <div class="col-sm-12">
            <div class="col-sm-1" style="    padding-left: 0px;"></div>
            <div class="col-sm-10" style="    padding-left: 0px;">
                <form action="<?php echo base_url(); ?>search-result" method="post" class="student-form tourz-search-form tourz-top-search-form searchform" style="width: 597px; display:inline-block">
                    <div class="input-field"></div>
                    <div class="input-field autocomplete studentautocomplete search-wrap student-search-wrap" >
                    <input style="border: 1px solid #ddd;background-color: #ffffff;height: 34px;width: 597px;" type="text" id="student-search"   name="search"   class="typeahead form-control"    placeholder="Search Student Name OR Reg# to add Fee Concession " autocomplete="off">
                    
                    <span id="showstudents"  ></span> 
                    </div>
                    <div class="input-field" style="width:8%;">
                    <i class="waves-effect waves-light tourz-top-sear-btn waves-input-wrapper"> 
                    <input type="submit" name="find" id="find" value="" class="waves-button-input" style="float:left; line-height:0"></i> 
                    </div>
                </form>  
            </div>
        </div>
        <?php if($student_details != '') { ?>
        <div class="col-sm-12" style="margin-top:20px;">
            <div class="col-sm-12 addressshow" 
            <p><strong>Student Detail:</strong> <?php echo $student_details; ?></p> 
            </div>  
        </div>  
        
        <?php if($is_active_concession < 1) { ?>
        <div class="col-sm-12 addressshow" >
            <form name="frmshipping" id="frmshipping" action="<?php echo base_url();?>/add-fee-concession-process" method="post" novalidate="novalidate">  
                <input type="hidden" name="class_register_student_id" value="<?php echo $class_register_student_id; ?>" /> 
                <input type="hidden" name="class_register_id" value="<?php echo $class_register_id; ?>" /> 
                <input type="hidden" name="first_name"   value="<?php echo $first_name; ?>" />
                <input type="hidden" name="middle_name"   value="<?php echo $middle_name; ?>" />
                <input type="hidden" name="last_name"   value="<?php echo $last_name; ?>" />
                <input type="hidden" name="father_name"   value="<?php echo $father_name; ?>" /> 
                <input type="hidden" name="class_name_section"   value="<?php echo $class_name_section; ?>" />
                <input type="hidden" name="student_id"   value="<?php echo $student_id; ?>" />
                <span id="errorMsg"></span>
                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <label>Concession Type</label>
                    <div id="Shipping_divEmail" class="form-group uplabel">
                        <input style="margin-right: 2px;" name="concession_type" type="radio" value="Flat" checked >
                        <span class="checkmark"></span>
                        <span  ><strong>Flat</strong></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>Frequency</label>
                    <div id="Shipping_divEmail" class="form-group uplabel">
                        <input name="frequency" type="radio" value="Onetime"  style="margin-right: 2px;" >
                        <span class="checkmark"></span>
                        <span  ><strong>Onetime</strong> &nbsp;</span>
                        
                        <input name="frequency" type="radio" value="Regular" style="margin-right: 2px;" >
                        <span class="checkmark"></span>
                        <span  ><strong>Recurring</strong> &nbsp;</span> 
                    </div>
                </div>
                <div class="col-sm-3">
                    <div id="Shipping_divFirstName" class="form-group uplabel">
                        <input style=" background-color:#ffffff;margin-top: 11px;"  name="amount" id="amount" class="form-control" type="text" placeholder="Amount">
                        <div id="Register_divErrorMsg1" class="text-danger"></div>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div id="Shipping_divLastName" class="form-group uplabel">
                        <input style=" background-color:#ffffff;"  name="reason" id="reason" class="form-control" type="text" placeholder="Reason For Concession">				  
                    </div>
                </div>
              
                <div class="col-sm-4">
                    <div id="Shipping_divLastName" class="form-group uplabel">
                        <span>Concession Document If Any</span>
                        <input name="concession_document" id="concession_document" class="form-control" type="file" >				  
                    </div>
                </div>
                
                <div class="col-sm-3"> 
                    
                </div> 
                <div class="col-sm-3"> 
                    <div id="Shipping_divMobile" class="form-group uplabel" style="margin-top:15px;">
                        <button  class="btn btn-primary pull-right check" type="submit" style="width:48%;color:#ffffff;">Submit</button> 
                    </div> 
                </div> 
            </form>
        </div>
        
        <?php } ?>
        <?php } ?> 
        <div class="col-sm-12 fullWidth-tab" style="min-height:500px;">
    		<div class="panel panel-bd lobidrag" <?php if($student_details == '') { ?> style="background-color:#ffffff!important; box-shadow: none;" <?php } ?> >  
                <div class="panel-body" id="result">  
                	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td style="width:250px;">Student&nbsp;Name</td> 
                            	<td style="width:60px;">Class</td>  
                            	<td>Father&nbsp;Name</td> 
                            	<td  style="width: 260px;" >Amount</td> 
                            	<td  style="width: 160px;" >Type</td> 
                            	<td  style="width: 160px;" >Frequency</td> 
                            	<td style="width: 160px;" >Date&nbsp;Created</td>   
                            	<td style="width: 160px;" >Status</td>   
                            	<td class="text-right">Action</td>
                        	</thead>
                        	<tbody> 
                        	    <?php  
                        	    if(count($student_fee_concession_list) >0)
                        	    {
                        	    foreach($student_fee_concession_list as $fee_concession) { ?>
                        	     <tr class=" "   > 
                            	     <td class="business_list_">
                                	    <?php if(!empty($fee_concession->profile_picture)) { ?>
                            		        <img src="https://localhost/project/zumilyschool/assets/uploadimages/studentimages/<?php echo $fee_concession->profile_picture; ?>" style="width:30px; height:30px;" class="img-circle">
                            		    <?php } else { ?>
                            		        <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                            		    <?php } ?>
                                	    <?php echo $fee_concession->first_name." ".$fee_concession->last_name; ?>
                                	</td>  
                                	<td class="business_list_"><?php echo $fee_concession->class_name_section; ?></td>    
                                	<td class="business_list_"><?php echo $fee_concession->father_name;     ?></td> 
                            		<td class="business_list_"><?php echo $fee_concession->concession_amount;  ?></td>  
                            		<td class="business_list_"><?php  echo $fee_concession->concession_type; ?></td>  
                            		<td class="business_list_"><?php  echo $fee_concession->concession_frequency; ?></td>  
                            		<td class="business_list_"><?php echo date("M d, Y",strtotime(@$fee_concession->date_created)) ; ?></td> 
                            		<td class="business_list_"><?php    if($fee_concession->status == '1') { echo "Active"; } else if($fee_concession->status == '0') { echo "Disabled"; }else { echo "Used";}  ?></td>  
                            		<td   class="text-right"> 
                            		   <?php if($fee_concession->status == '1' ) { ?>
                            		    <a href="javascript:void(0)" title="Disable current concession for this STUDENT" onclick = "disable_fee_concession(<?php echo $fee_concession->students_fee_concession_id; ?>)"  ><i class="fa fa-ban" style="font-size:20px;color:red;"></i></a>&nbsp;
                            		    <?php } ?>
                            		</td>  
                        		</tr>
                        	    <?php } } else { ?>
                        	    
                	                <tr><td colspan="9"><p class="text-center" style="color:red;"><strong>*** No concession has been assigned to this student yet *** </strong></p></td></tr>
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
      $(".check").click(function(){  
          
    	    var concession_type = parseInt($('input[name="concession_type"]:checked').length); 
    	    var concession_type_value = $('input[name="concession_type"]:checked').val(); 
    	    var frequency = parseInt($('input[name="frequency"]:checked').length);
            var amount = $('#amount').val();  
            var reason = $('#reason').val();  
            var imageCheck = $('#concession_document').val();  
            
            if(concession_type <= 0)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please select concession type</div>"); 
        		return false;
            }
            else
            {
                $('#errorMsg').html(""); 
            } 
            
            if(frequency == '')
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please select frequency</div>"); 
        		return false;
            }
            else
            {
                $('#errorMsg').html(""); 
            }
            
            if(amount == '')
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please enter amount</div>");
                $('#amount').css("border","1px solid red");
        		$('#amount').focus();
        		return false;
            }
            else if(amount < 1)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Entered amount should be greater than Zero(0).</div>");
                $('#amount').css("border","1px solid red");
        		$('#amount').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#amount').css("border","1px solid #c9c9c9");
            }
            
           
            
            if(concession_type_value == "Percent")
            {
                if(amount > 100)
                {
                    $('#errorMsg').html("<div class='alert alert-danger'>Concession Percent cann't be greater than 100</div>");
                    $('#amount').css("border","1px solid red");
            		$('#amount').focus();
            		return false;
                }
                else
                {
                    $('#errorMsg').html("");
                    $('#amount').css("border","1px solid #c9c9c9");
                }
            }
    
            if(reason == '')
            {
                if(imageCheck == '')
                {
                    $('#errorMsg').html("<div class='alert alert-danger'>Please enter reason or upload image</div>");
                    $('#reason').css("border","1px solid red");
            		$('#reason').focus();
            		return false;
                }
                else
                {
                    $('#errorMsg').html("");
                    $('#reason').css("border","1px solid #c9c9c9");
                } 
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
