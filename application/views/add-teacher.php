 <script>
$(document).ready(function(){  
    $(".check1").click(function(){   
        var country = 'IN';
        var email_id = $('#email_id').val(); 
        var mobile_no = $('#mobile_no').val(); 
        var first_name = $('#first_name').val(); 
        var last_name = $('#last_name').val(); 
        var address = $('#address').val(); 
        var subject1 = $('#subject1').val(); 
        var subject2 = $('#subject2').val(); 
        var subject3 = $('#subject3').val(); 
        var joining_date = $('#joining_date').val();
        var termination_date = $('#termination_date').val();
        var ternimation_reason = $('#ternimation_reason').val();
        
        
        var aadhar1 = $('#aadhar1').val(); 
        var aadhar2 = $('#aadhar2').val(); 
        var aadhar3 = $('#aadhar3').val(); 
	    var gender = parseInt($('input[name="gender"]:checked').length);  
	    
	    
	    if(email_id != '')
        {
    	    var regexEmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regexEmail.test(email_id)) 
            {
                $('#email_id').css("border","1px solid red");
        		$('#email_id').focus(); 
        		$('#errorMsg').html("<div class='alert alert-danger'>Email Id is invalid.</div>");
        		return false;
            }
            else
            {
               $('#email_id').css("border","1px solid #bdb9b9"); 
               $('#errorMsg').html("");
            }
        }
        
        if(mobile_no == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter mobile no.</div>");
            $('#mobile_no').css("border","1px solid red");
    		$('#mobile_no').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#mobile_no').css("border","1px solid #c9c9c9");
        }
        
    	var regexMobile = /^\d{10}$/;
        if(!regexMobile.test(mobile_no)) 
        {
            $('#mobile_no').css("border","1px solid red");
    		$('#mobile_no').focus(); 
    		$('#errorMsg').html("<div class='alert alert-danger'>Mobile No. is invalid.</div>");
    		return false;
        }
        else
        {
           $('#mobile_no').css("border","1px solid #bdb9b9"); 
           $('#errorMsg').html("");
        } 
         
         
        if(first_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter first name.</div>");
            $('#first_name').css("border","1px solid red");
    		$('#first_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#first_name').css("border","1px solid #c9c9c9");
        }
        
        if(last_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter last name.</div>");
            $('#last_name').css("border","1px solid red");
    		$('#last_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#last_name').css("border","1px solid #c9c9c9");
        }
        
        if(address == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter address.</div>");
            $('#address').css("border","1px solid red");
    		$('#address').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#address').css("border","1px solid #c9c9c9");
        }  
        if(subject1 == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select subject1.</div>");
            $('#subject1').css("border","1px solid red");
    		$('#subject1').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#subject1').css("border","1px solid #c9c9c9");
        } 
            
        if(subject1 == subject2 && (subject1 != '' || subject2 != ''))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Subject2 can't be same as Subject1.</div>");
            $('#subject2').css("border","1px solid red");
    		$('#subject2').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#subject2').css("border","1px solid #c9c9c9");
        }
        
        if(subject1 == subject3 && (subject1 != '' || subject3 != ''))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Subject3 can't be same as Subject1.</div>");
            $('#subject3').css("border","1px solid red");
    		$('#subject3').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#subject3').css("border","1px solid #c9c9c9");
        }
    
        if(subject2 == subject3 && (subject2 != '' || subject3 != ''))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Subject3 can't be same as Subject2.</div>");
            $('#subject3').css("border","1px solid red");
    		$('#subject3').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#subject3').css("border","1px solid #c9c9c9");
        }
        
        if(joining_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select joining date.</div>");
            $('#J-demo-04').css("border","1px solid red");
    		$('#J-demo-04').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#J-demo-04').css("border","1px solid #c9c9c9");
        }
        
        if(gender == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select a gender.</div>"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        } 
        
        if(aadhar1 != '' || aadhar2 != '' || aadhar3 != '')
        {
            
            if(aadhar1 < 1)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                $('#aadhar1').css("border","1px solid red");
        		$('#aadhar1').focus();
        		return false; 
            }
            else
            { 
                if(aadhar1 != '')
                {
                    var regexaadhar = /^\d{4}$/;
                    if(!regexaadhar.test(aadhar1)) 
                    {
                        $('#aadhar1').css("border","1px solid red");
                		$('#aadhar1').focus(); 
                		$('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                		return false;
                    } 
                }
                else
                { 
                    $('#errorMsg').html("");
                    $('#aadhar1').css("border","1px solid #c9c9c9");
                }
            }  
            
            if(aadhar2 < 1)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                $('#aadhar2').css("border","1px solid red");
        		$('#aadhar2').focus();
        		return false; 
            }
            else
            { 
                if(aadhar2 != '')
                {
                    var regexaadhar = /^\d{4}$/;
                    if(!regexaadhar.test(aadhar2)) 
                    {
                        $('#aadhar2').css("border","1px solid red");
                		$('#aadhar2').focus(); 
                		$('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                		return false;
                    } 
                }
                else
                { 
                    $('#errorMsg').html("");
                    $('#aadhar2').css("border","1px solid #c9c9c9");
                }
            } 
            
            if(aadhar3 < 1)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                $('#aadhar3').css("border","1px solid red");
        		$('#aadhar3').focus();
        		return false; 
            }
            else
            { 
                if(aadhar3 != '')
                {
                    var regexaadhar = /^\d{4}$/;
                    if(!regexaadhar.test(aadhar3)) 
                    {
                        $('#aadhar3').css("border","1px solid red");
                		$('#aadhar3').focus(); 
                		$('#errorMsg').html("<div class='alert alert-danger'>Invalid aadhar number</div>");
                		return false;
                    } 
                }
                else
                { 
                    $('#errorMsg').html("");
                    $('#aadhar3').css("border","1px solid #c9c9c9");
                }
            } 
        }
        
        if(termination_date != '')
        {
            if(Date.parse(termination_date) <= Date.parse(joining_date))
            { 
                $('#errorMsg').html("<div class='alert alert-danger'>Termination date must be greater than joining date.</div>");
                $('#termination_date').css("border","1px solid red");
        		$('#termination_date').focus();
        		return false;
            }
            else
            { 
                $('#errorMsg').html("");
                $('#termination_date').css("border","1px solid #c9c9c9"); 
            } 
            
            if(ternimation_reason == '')
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Please enter Ternimation reason.</div>");
                $('#ternimation_reason').css("border","1px solid red");
        		$('#ternimation_reason').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#ternimation_reason').css("border","1px solid #c9c9c9");
            }
            
        }
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit(); 
        $("#preloader").show();
        
    });
    
    $(".email_id").keyup(function(){  
        var email_id = $(this).val();   
        var teacher_id = $("#teacherId").val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-teacher-email",  
            data:{email_id:email_id,teacher_id:teacher_id},  
            success:function(response){    
        	    if(response == 1)
        	    { 
        	       
                    $('#errorMsg').html("Email id already exists"); 
                    $('#email_id').css("border","1px solid red");  
                    $(".check1").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#errorMsg').html(""); 
                    $('#email_id').css("border","1px solid #c9c9c9");  
                    $(".check1").attr("disabled", false); 
                    
            	    var obj = jQuery.parseJSON(response);   
                    $('#first_name').val(obj.first_name); 
                    $('#last_name').val(obj.last_name);  
                    $('#mobile_no').val(obj.mobile_no); 
                    $('#address').val(obj.address);
        	    }
                
                }
            }); 
        });
    $(".mobile_no").keyup(function(){  
        var mobile_no = $(this).val();  
        var teacher_id = $("#teacherId").val(); 
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/check-teacher-mobile",  
        data:{mobile_no:mobile_no,teacher_id:teacher_id},  
        success:function(response){   
    	    if(response == 1)
    	    { 
    	       
                $('#errorMsg').html("Mobile no already used by another teacher"); 
                $('#mobile_no').css("border","1px solid red");  
                $(".check1").attr("disabled", true);
               return false; 
    	    }
    	    else
    	    {
    	        $('#errorMsg').html(""); 
                $('#mobile_no').css("border","1px solid #c9c9c9");  
                $(".check1").attr("disabled", false);
                
                var obj = jQuery.parseJSON(response);   
                $('#first_name').val(obj.first_name); 
                $('#last_name').val(obj.last_name);  
                    $('#email_id').val(obj.email_id); 
                $('#address').val(obj.address);
    	    }
            }
        }); 
    }); 
    $("#aadhar1").keyup(function(){  
        var count = $(this).val().length;  
        if(count == 4)
        { 
    		$('#aadhar2').focus();
        } 
    });
    $("#aadhar2").keyup(function(){   
        var count = $(this).val().length;  
        if(count == 4)
        { 
    		$('#aadhar3').focus();
        } 
    }); 
    $("#aadhar3").keyup(function(){  
     
    });
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today; 
    
    $('#joining_date').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY", 
      maxDate: sd, 
      todayBtn: true
    }); 
    
    var joining_date = $("#joining_date_1").val(); 
    if( joining_date != '')
    { 
        var startdate = new Date(joining_date).toDateString("ddd, MMM DD, YYYY"); 
        $('#termination_date').datetimepicker({
          pickTime: false,
          format: "ddd, MMM DD, YYYY",
          minDate: startdate,  
          todayBtn: true
        }); 
    }
    else
    {
        $('#termination_date').datetimepicker({
          pickTime: false,
          format: "ddd, MMM DD, YYYY", 
          todayBtn: true
        });
    } 
    
    
    bindDateRangeValidation($("#formCheck"), 'joining_date', 'termination_date');
}); 


</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$teacher_info['teacher_id'] != '') { echo "Edit"; }else { echo "Add";} ?> Teacher Information 
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form   id="formCheck" action="<?php echo base_url();?>add-teacher-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  onsubmit="return Validate(this);" autofill="off"> 
                        <?php
                        $success = $this->session->userdata('success'); 
                        if (!empty($success)) 
                        {
                            echo  $success ;
                            $this->session->unset_userdata('success');
                        }
                        ?>
                        <input type="hidden" name="teacherId" id="teacherId" value="<?php echo @$teacher_info['teacher_id']; ?>"> 
                            
                            <div class="col-sm-12" style="margin-top: 10px;">
                            	<span id="errorMsg" style="color:red;"></span>
                            </div>
                            
                            <input type="hidden" id="profile_picture" name="profile_picture" value="<?php echo @$teacher_info['profile_picture']; ?>" />
                            
                            <div class="form-group col-md-12">
                                <label>Profile Picture</label> 
                            </div>
                            <div class="form-group col-md-2"> 
                                <?php if(@$teacher_info['profile_picture'] != '')
                                { ?> 
                                <img src="<?php echo base_url();?>assets/uploadimages/teacherimages/<?php echo @$teacher_info['profile_picture']; ?>" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/> 
                                <?php } else { ?>
                                <img src="<?php echo base_url();?>assets/images/name.png" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-7">
                            <input type="file" name="picture_name" id="file" class="inline imageselect"style="margin-top:10px;margin-top: 15px; margin-left: 10px;">
                             
                            </div> 
                            <input type="hidden" name="oldimage" value="<?php echo @$teacher_info['profile_picture']; ?>">
                            <div class="form-group col-md-3">
                                <img id="result" name="image_base64_string"  >
                                <input type="hidden" id="result1" name="result1" value="" />
                            </div>
                            
                            <div class="clearfix"></div>
                            <div id="uploaded_image"></div> 
                        
                        
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input  type="text"  class="form-control email_id test" id="email_id"  name="email_id" placeholder="Email Id" data-toggle="tooltip" data-placement="top" title="Email id" value="<?php echo @$teacher_info['email_id'];  ?>"  maxlength="60" autocomplete="1234" />
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="hidden"  id="old_mobile_no"  name="old_mobile_no"    value="<?php echo @$teacher_info['mobile_no'];  ?>"   />
                                <input type="text" class="form-control mobile_no test" id="mobile_no"  name="mobile_no" placeholder="Mobile No." data-toggle="tooltip" data-placement="top" title="Mobile no" value="<?php echo @$teacher_info['mobile_no'];  ?>"  maxlength="10" autocomplete="1234333" />
                            </div> 
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">  
                                <input  type="text"    class="form-control  test" id="first_name"  name="first_name" placeholder="First Name" data-toggle="tooltip" data-placement="top" title="First name" value="<?php echo @$teacher_info['first_name'];  ?>"maxlength="30" autocomplete="456454"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input  type="text"   class="form-control  test" id="last_name"  name="last_name" placeholder="Last Name" data-toggle="tooltip" data-placement="top" title="Last name" value="<?php echo @$teacher_info['last_name'];  ?>" maxlength="30" autocomplete="2245684"  />
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="text" class="form-control  test" id="address"  name="address" placeholder="Address" data-toggle="tooltip" data-placement="top" title="Address" value="<?php echo @$teacher_info['address'];  ?>" maxlength="100" autocomplete="333412442" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control  test" id="subject1"  name="subject1" data-toggle="tooltip" data-placement="top" title="Subject 1">
                                    <option value="">Select Subject 1</option>
                                    <?php
                                    foreach($subject_lists as $subject)
                    	            {
                	                ?>
                                    <option value="<?php echo $subject->subject_name; ?>" <?php if(@$teacher_info['subject1'] == $subject->subject_name)  { echo "selected";} ?>><?php echo $subject->subject_name; ?></option>
                                    <?php } ?>
                                    
                                </select>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                 <select class="form-control  test" id="subject2"  name="subject2" data-toggle="tooltip" data-placement="top" title="Subject 2">
                                    <option value="">Select Subject 2</option>
                                    <?php
                                    foreach($subject_lists as $subject)
                    	            {
                	                ?>
                                    <option value="<?php echo $subject->subject_name; ?>" <?php if(@$teacher_info['subject2'] == $subject->subject_name)  { echo "selected";} ?>><?php echo $subject->subject_name; ?></option>
                                    <?php } ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <select class="form-control  test" id="subject3"  name="subject3" data-toggle="tooltip" data-placement="top" title="Subject 3">
                                    <option value="">Select Subject 3</option>
                                    <?php
                                    foreach($subject_lists as $subject)
                    	            {
                	                ?>
                                    <option value="<?php echo $subject->subject_name; ?>" <?php if(@$teacher_info['subject3'] == $subject->subject_name)  { echo "selected";} ?>><?php echo $subject->subject_name; ?></option>
                                    <?php } ?>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="designation"  name="designation" placeholder="Designation" data-toggle="tooltip" data-placement="top" title="Designation" value="<?php echo @$teacher_info['designation'];  ?>" maxlength="100" autocomplete="34534534534" >
                            </div>
                        </div> 
                        <div class="form-group col-sm-6"> 
                            <input type="hidden"   id="joining_date_1"   value="<?php echo @$teacher_info['joining_date'] ;  ?>"   /> 
                        
                            <input type="text" class="test" name="joining_date" id="joining_date" readonly placeholder="Joining Date" data-toggle="tooltip" data-placement="top" title="Joining date" value="<?php if(@$teacher_info['joining_date'] != '') { echo date("D, M d, Y",strtotime(@$teacher_info['joining_date'])); } ?>"   />  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;" id="male"   name="gender"   value="M"  <?php if(@$teacher_info['gender'] == 'M' ) { echo "checked";} ?> >
                                <label for="male">Male</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="female"  name="gender"   value="F" <?php if(@$teacher_info['gender'] == 'F' ) { echo "checked";} ?>   > 
                                <label for="female">Female</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-6"> 
                            <?php 
                            @$aadhar_no  = explode('-',@$teacher_info['aadhar_card_number']);
                            ?>
                            
                            <div class="row" > 
                                <div class="col-md-3 text-left">
                                    <label>Aadhar no</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="aadhar1" value="<?php if(@$aadhar_no[0] > 0) { echo @$aadhar_no[0]; } ?>" placeholder=""  style="padding:0px;  text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4"  id="aadhar1"  autocomplete="off">
                                        </div>
                                        
                                        <div class="col-md-1" style="padding:0px;width: 4%!important;"><span style="font-size:25px; font-family: auto;">-</span> </div>
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="aadhar2" value="<?php if(@$aadhar_no[1] > 0) { echo @$aadhar_no[1]; } ?>" placeholder="" style="padding:0px; text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="aadhar2"  autocomplete="off">
                                        </div>
                                        <div class="col-md-1" style="padding:0px;width: 4%!important;"><span style="font-size:25px; font-family: auto;">-</span></div>
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="aadhar3" value="<?php if(@$aadhar_no[2] > 0) { echo @$aadhar_no[2]; } ?>" placeholder="" style="padding:0px;  text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="aadhar3"  autocomplete="off">
                                        </div>
                                    </div>
                            </div> 
                         </div>
                        <?php if(@$teacher_info['teacher_id'] > 0) { ?>
                        
                        <div class="spacer-10" style="margin-bottom:15px; margin-top:15px"></div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                 <input type="text" name="termination_date" id="termination_date" class="test" readonly placeholder="Termination Date" data-toggle="tooltip" data-placement="top" title="Termination date" value="<?php if(@$teacher_info['termination_date'] != '') { echo date("D, M d, Y",strtotime(@$teacher_info['termination_date'])); } ?>"   /> 
                        
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">  
                                 <input type="text" name="ternimation_reason" id="ternimation_reason" class="test"  placeholder="Termination Reason" data-toggle="tooltip" data-placement="top" title="Termination reason" value="<?php if(@$teacher_info['ternimation_reason'] != '') { echo  $teacher_info['ternimation_reason']; } ?>" autocomplete="3498923234"  /> 
                        
                            </div>
                        </div>
                        <?php } ?>
                        
                        
                        
                        
                        
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12 savesubject"  id="  class" name="update" value="Submit"> 
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add/Edit Teacher Information</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page is being used to Add or Change Teacher's information.</li>
                  <li >Please save as much as information regarding a teacher when creating NEW or UPDATING it. </li>
                  <li >Only ACTIVE teachers are being allowed to change information.</li>
                  <li >If a teacher leaves school or gets terminated, PLEASE  update TERMINATION-DATE and REASON which will move this teacher to TEMINATED-TEACHERS list.</li>
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

<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() { 
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGu4-4QYPkpQQrq5lf0T56Ou3YNMbVm4U&libraries=places&callback=initAutocomplete"
        async defer></script> 
