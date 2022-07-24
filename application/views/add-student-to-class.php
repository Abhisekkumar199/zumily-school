 
<script>
$(document).ready(function(){  
    
    $(".mobile_no").keyup(function(){  
        var mobile_no = $(this).val();  
        var student_id = $("#studentId").val(); 
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/check-student-mobile",  
        data:{mobile_no:mobile_no,student_id:student_id},  
        success:function(response){   
    	    if(response == 1)
    	    { 
    	       
                $('#errorMsg').html("Mobile number already used by another student"); 
                $('#mobile_no').css("border","1px solid red");  
                $(".check1").attr("disabled", true);
               return false; 
    	    }
    	    else
    	    {
    	        $('#errorMsg').html(""); 
                $('#mobile_no').css("border","1px solid #c9c9c9");  
                $(".check1").attr("disabled", false);
                
    	    }
            }
        }); 
    }); 
    $(".check1").click(function(){    
        
        var d = new Date();  
        var fullYear =  d.getFullYear();
        var fullMonth =  d.getMonth() + 1;
        var fullDate =  d.getDate();
        var current_date = fullYear+"-"+fullMonth+"-"+fullDate; 
        
        var file = $('#file').val();     
        var student_id = $('#studentId').val();
        var first_name = $('#first_name').val(); 
        var last_name = $('#last_name').val();  
        
        
        var reg_date = $('#reg_date').val(); 
        var reg_month = $('#reg_month').val(); 
        var reg_year = $('#reg_year').val(); 
        
        var birth_date = $('#birth_date').val(); 
        var birth_month = $('#birth_month').val(); 
        var birth_year = $('#birth_year').val(); 
        
	    var gender = parseInt($('input[name="gender"]:checked').length); 
        var mobile_no = $('#mobile_no').val();  
        var email_id = $('#email_id').val();  
        var father_name = $('#father_name').val();  
        var parent_mobile_no = $('#parent_mobile_no').val();  
        var parent_email_id = $('#parent_email_id').val();   
        
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
        
        
        if(reg_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select registration date.</div>");
            $('#reg_date').css("border","1px solid red");
    		$('#reg_date').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#reg_date').css("border","1px solid #c9c9c9");
        } 
        
        if(reg_month == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select registration month.</div>");
            $('#reg_month').css("border","1px solid red");
    		$('#reg_month').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#reg_month').css("border","1px solid #c9c9c9");
        } 
        
        if(reg_year == '')
        { 
            $('#errorMsg').html("<div class='alert alert-danger'>Please select registration year.</div>");
            $('#reg_year').css("border","1px solid red");
    		$('#reg_year').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#reg_year').css("border","1px solid #c9c9c9");
        } 
        
        var selected_reg_date = reg_year+'-'+reg_month+'-'+reg_date;
        if(Date.parse(selected_reg_date) > Date.parse(current_date))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Registration date can't be a future date.</div>");
            $('#reg_year').css("border","1px solid red");
    		$('#reg_year').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#reg_year').css("border","1px solid #c9c9c9");
        } 
          
        
        if(gender <= 0)
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select a gender.</div>"); 
    		return false;
        }
        else
        {
            $('#errorMsg').html(""); 
        } 
        
        
        
        if(birth_date == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select Birth date.</div>");
            $('#birth_date').css("border","1px solid red");
    		$('#birth_date').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#birth_date').css("border","1px solid #c9c9c9");
        } 
        
        if(birth_month == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select Birth month.</div>");
            $('#birth_month').css("border","1px solid red");
    		$('#birth_month').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#birth_month').css("border","1px solid #c9c9c9");
        } 
        
        if(birth_year == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select Birth year.</div>");
            $('#birth_year').css("border","1px solid red");
    		$('#birth_year').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#birth_year').css("border","1px solid #c9c9c9");
        } 
        
        var selected_birth_date = birth_year+'-'+birth_month+'-'+birth_date;
        if(Date.parse(selected_birth_date) > Date.parse(current_date))
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Date of birth can't be a future date</div>");
            $('#birth_year').css("border","1px solid red");
    		$('#birth_year').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#birth_year').css("border","1px solid #c9c9c9");
        } 
        
         
        
        
        if(mobile_no != '')
        {
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
        }
        
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
        
        
        if(father_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter father name.</div>");
            $('#father_name').css("border","1px solid red");
    		$('#father_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#father_name').css("border","1px solid #c9c9c9");
        } 
        
        if(parent_mobile_no != '')
        {
            var regexMobile = /^\d{10}$/;
            if(!regexMobile.test(parent_mobile_no)) 
            {
                $('#parent_mobile_no').css("border","1px solid red");
        		$('#parent_mobile_no').focus(); 
        		$('#errorMsg').html("<div class='alert alert-danger'>Parent Mobile No. is invalid.</div>");
        		return false;
            }
            else
            {
               $('#parent_mobile_no').css("border","1px solid #bdb9b9"); 
               $('#errorMsg').html("");
            }
        }
        
        if(parent_mobile_no != '')
        {
            if(mobile_no == parent_mobile_no)
            {
                $('#errorMsg').html("<div class='alert alert-danger'>Student and Parent phone numbers can't be same.</div>");
                $('#parent_mobile_no').css("border","1px solid red");
        		$('#parent_mobile_no').focus();
        		return false;
            }
            else
            {
                $('#errorMsg').html("");
                $('#parent_mobile_no').css("border","1px solid #c9c9c9");
            } 
        }
        if(parent_email_id != '')
        {
    	    var regexEmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regexEmail.test(parent_email_id)) 
            {
                $('#parent_email_id').css("border","1px solid red");
        		$('#parent_email_id').focus(); 
        		$('#errorMsg').html("<div class='alert alert-danger'>Email Id is invalid.</div>");
        		return false;
            }
            else
            {
               $('#parent_email_id').css("border","1px solid #bdb9b9"); 
               $('#errorMsg').html("");
            }
        }
         
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/check-if-student-exist",  
        data:{first_name:first_name,last_name:last_name,date_of_birth:selected_birth_date,parent_mobile_no:parent_mobile_no,student_id:student_id},  
        success:function(response){    
             
    	    if(response == 1)
    	    { 
    	        
                $("#preloader").hide(); 
                $('#errorMsg').html("<div class='alert alert-danger'>Entered student info - First Name, Last Name, DOB, and Parent Name already exist. Please check the data.</div>"); 
                $('#first_name').css("border","1px solid red");  
    		    $('#first_name').focus();
                
                return false; 
    	    }
    	    else
    	    {
    	        if(file != '')
                { 
                    $("#preloader").show();
                }
    	        $('#errorMsg').html("");  
    	        
                $(this).attr('disabled', true);  
                document.student.submit(); 
    	    }
            
            }
        });
    
        
        
        
    });  
    
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;

    console.log(sd);
    $('#date_of_birth').datetimepicker({
      pickTime: false,
      maxDate: ed,
      format: "ddd, MMM DD, YYYY", 
      todayBtn: true
    });
    
    $('#registration_date').datetimepicker({
      pickTime: false,
      maxDate: ed,
      format: "ddd, MMM DD, YYYY", 
      todayBtn: true
    });
    
    bindDateRangeValidation($("#formCheck"), 'date_of_birth','registration_date');
}); 
</script> 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 ><?php if(@$student_info['student_id'] != '') { echo "Edit"; }else { echo "Add";} ?> Student Information  
			<a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
		</h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck"   name="student" action="<?php echo base_url();?>/add-student-to-class-process" method="POST" enctype="multipart/form-data"  style="background:#fff; border:1px solid #fff;"  onsubmit="return Validate(this);"> 
                        <?php
                        $success = $this->session->userdata('success'); 
                        if (!empty($success)) 
                        {
                            echo  $success ;
                            $this->session->unset_userdata('success');
                        }
                        ?> 
                        <input type="hidden" name="class_register_id" id="class_register_id" value="<?php echo @$class_register_id; ?>">  
                        <input type="hidden" name="class_section_name" id="class_section_name" value="<?php echo @$class_section_name; ?>">  
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        
                        <div class="form-group col-md-12">
                                <label>Profile Picture</label> 
                        </div>
                            <div class="form-group col-md-2"> 
                                <?php if(@$student_info['profile_picture'] != '')
                                { ?> 
                                <img src="<?php echo base_url();?>assets/uploadimages/studentimages/<?php echo @$student_info['profile_picture']; ?>" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/> 
                                <?php } else { ?>
                                <img src="<?php echo base_url();?>assets/images/name.png" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/>
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-7">
                            <input type="file" name="picture_name" id="file" class="inline imageselect"style="margin-top:10px;margin-top: 15px; margin-left: 10px;">
                             
                            </div>  
                            <div class="form-group col-md-3">
                                <img id="result" name="image_base64_string"  >
                                <input type="hidden" id="result1" name="result1" value="" />
                            </div>
                            
                            <input type="hidden" name="oldimage" value="<?php echo @$student_info['profile_picture']; ?>">
                            <div class="clearfix"></div>
                            <div id="uploaded_image"></div>
                        
                        
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="first_name"  name="first_name" placeholder="First Name" data-toggle="tooltip" data-placement="top" title="First name" value="<?php echo @$student_info['first_name'];  ?>"maxlength="30" autocomplete="nofill" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="middle_name"  name="middle_name" placeholder="Middle Name" data-toggle="tooltip" data-placement="top" title="Middle name" value="<?php echo @$student_info['middle_name'];  ?>" maxlength="30" autocomplete="nofill" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="last_name"  name="last_name" placeholder="Last Name" data-toggle="tooltip" data-placement="top" title="Last name" value="<?php echo @$student_info['last_name'];  ?>" maxlength="30" autocomplete="nofill" >
                            </div>
                        </div>
                        
                         
                       
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="text" class="form-control  test " id="registration_no"  name="registration_no" placeholder="Registration no" data-toggle="tooltip" data-placement="top" title="Registration no" value="<?php echo @$student_info['registration_no'];  ?>" maxlength="20"   autocomplete="nofill" >
                            </div> 
                        </div>  
                        <div class="form-group col-sm-6">  
                            <?php 
                            @$reg_date  = explode('-',@$student_info['registration_date']);
                            ?>
                            
                            <div class="row" > 
                                <div class="col-md-3 text-left">
                                    <label>Reg. Date</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="reg_date" value="<?php if(@$reg_date[2] > 0) { echo @$reg_date[2]; } ?>" placeholder="DD"  style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="2" maxlength="2"   id="reg_date"  autocomplete="off">
                                        </div>
                                        
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span> </div>
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="reg_month" value="<?php if(@$reg_date[1] > 0) { echo @$reg_date[1]; } ?>" placeholder="MM" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="2" maxlength="2" id="reg_month"  autocomplete="off">
                                        </div>
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span></div>
                                        <div class="col-md-4" style="padding:0px;width: 27%!important;">
                                            <input type="text" class="form-control" name="reg_year" value="<?php if(@$reg_date[0] > 0) { echo @$reg_date[0]; } ?>" placeholder="YYYY" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="reg_year"  autocomplete="off">
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;" id="male"   name="gender"   value="M"  <?php if(@$student_info['gender'] == 'M' ) { echo "checked";} ?> >
                                <label for="male">Male</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="female"  name="gender"   value="F" <?php if(@$student_info['gender'] == 'F' ) { echo "checked";} ?>   > 
                                <label for="female">Female</label>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6"> 
                            <?php 
                            @$birth_date  = explode('-',@$student_info['date_of_birth']);
                            ?>
                            
                            <div class="row" > 
                                <div class="col-md-3 text-left">
                                    <label>Date of Birth </label>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="birth_date" value="<?php if(@$birth_date[2] > 0) { echo @$birth_date[2]; } ?>" placeholder="DD"  style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="2" maxlength="2"   id="birth_date"  autocomplete="off">
                                        </div>
                                        
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span> </div>
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="birth_month" value="<?php if(@$birth_date[1] > 0) { echo @$birth_date[1]; } ?>" placeholder="MM" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="2" maxlength="2" id="birth_month"  autocomplete="off">
                                        </div>
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span></div>
                                        <div class="col-md-4" style="padding:0px;width: 27%!important;">
                                            <input type="text" class="form-control" name="birth_year" value="<?php if(@$birth_date[0] > 0) { echo @$birth_date[0]; } ?>" placeholder="YYYY" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="birth_year"  autocomplete="off">
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                         </div>
                         
                        
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;" id="na"   name="caste"   value="NA"  <?php if(@$student_info['caste'] == 'NA' or @$student_info['caste'] == '') { echo "checked";} ?> >
                                <label for="na">NA</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="general"  name="caste"   value="GEN" <?php if(@$student_info['caste'] == 'GEN' ) { echo "checked";} ?>   > 
                                <label for="general">General</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="obc"  name="caste"   value="OBC" <?php if(@$student_info['caste'] == 'OBC' ) { echo "checked";} ?>   > 
                                <label for="obc">OBC</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="sc"  name="caste"   value="SC" <?php if(@$student_info['caste'] == 'SC' ) { echo "checked";} ?>   > 
                                <label for="sc">SC</label>&nbsp;&nbsp;
                                <input type="radio" class="form-control  " style="font-size: 1.5rem;margin-left: 0px;"  id="st"  name="caste"   value="ST" <?php if(@$student_info['caste'] == 'ST' ) { echo "checked";} ?>   > 
                                <label for="st">ST</label>
                            </div>
                        </div>
                        
                        
                        <div class="form-group col-sm-6"> 
                            <?php 
                            @$aadhar_no  = explode('-',@$student_info['aadhar_card_number']);
                            ?>
                            
                            <div class="row" > 
                                <div class="col-md-3 text-left">
                                    <label>Aadhar no</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="aadhar1" value="<?php if(@$aadhar_no[2] > 0) { echo @$aadhar_no[2]; } ?>" placeholder="----"  style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4"  id="aadhar1"  autocomplete="off">
                                        </div>
                                        
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span> </div>
                                        <div class="col-md-3" style="padding:0px;width: 20%!important;">
                                            <input type="text" class="form-control" name="aadhar2" value="<?php if(@$aadhar_no[1] > 0) { echo @$aadhar_no[1]; } ?>" placeholder="----" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="aadhar2"  autocomplete="off">
                                        </div>
                                        <div class="col-md-1" style="padding:0px;width: 8%!important;"><span style="font-size:25px; font-family: auto;">/</span></div>
                                        <div class="col-md-4" style="padding:0px;width: 27%!important;">
                                            <input type="text" class="form-control" name="aadhar3" value="<?php if(@$aadhar_no[0] > 0) { echo @$aadhar_no[0]; } ?>" placeholder="----" style="padding:0px;border-top:none;border-left:none;border-right:none;text-align: center;" onkeypress="return isNumberKey(event)" minlength="4" maxlength="4" id="aadhar3"  autocomplete="off">
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                         </div> 
                         
                        
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="hidden"   id="old_mobile_no"  name="old_mobile_no"    value="<?php echo @$student_info['mobile_no'];  ?>"   >
                                <input type="text" class="form-control test mobile_no " id="mobile_no"  name="mobile_no" placeholder="Mobile No." data-toggle="tooltip" data-placement="top" title="Mobile no" value="<?php echo @$student_info['mobile_no'];  ?>" maxlength="10" autocomplete="nofill" >
                            </div> 
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="text" class="form-control  test " id="email_id"  name="email_id" placeholder="Email Id" data-toggle="tooltip" data-placement="top" title="Email id" value="<?php echo @$student_info['email_id'];  ?>" maxlength="100" autocomplete="nofill" >
                            </div> 
                        </div> 
                        
                        <div class="col-md-6">
                            <div class="form-group">  
                                <input type="text" class="form-control test " id="father_name"  name="father_name" placeholder="Father Name" data-toggle="tooltip" data-placement="top" title="Father name" value="<?php echo @$student_info['father_name'];  ?>" maxlength="50"   autocomplete="nofill" >
                            </div> 
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="text" class="form-control test " id="mother_name"  name="mother_name" placeholder="Mother Name" data-toggle="tooltip" data-placement="top" title="Mother name" value="<?php echo @$student_info['mother_name'];  ?>" maxlength="50"   autocomplete="nofill" >
                            </div> 
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">  
                                <input type="hidden"   id="old_parent_mobile_no"  name="old_parent_mobile_no"    value="<?php echo @$student_info['parent_mobile_no'];  ?>"   >
                                <input type="text" class="form-control test" id="parent_mobile_no"  name="parent_mobile_no" placeholder="Parent Mobile" data-toggle="tooltip" data-placement="top" title="Parent mobile" value="<?php echo @$student_info['parent_mobile_no'];  ?>" maxlength="10" autocomplete="nofill" >
                            </div> 
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group"> 
                                <input type="text" class="form-control test" id="parent_email_id"  name="parent_email_id" placeholder="Parent Email Id" data-toggle="tooltip" data-placement="top" title="Parent email id" value="<?php echo @$student_info['parent_email_id'];  ?>" maxlength="100" autocomplete="nofill" >
                            </div> 
                        </div> 
                        
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="text" class="form-control test" id="address"  name="address" placeholder="Address" data-toggle="tooltip" data-placement="top" title="Address" value="<?php echo @$student_info['address'];  ?>" maxlength="100" autocomplete="nofill" >
                            </div> 
                        </div> 
                        <div class="col-sm-12">
                            <label>Stream</label>
                            <br>
                            <input type="radio" name="stream" value="N" required checked > <strong>None</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="stream" value="A" required > <strong>Arts</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="stream" value="S" required > <strong>Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="stream" value="B" required > <strong>Biology</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="stream" value="H" required > <strong>Home Science</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="stream" value="M" required > <strong>Mathematics</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div> 
                        
                         
                        <div class="col-md-12">  
                            <div class="row" style="margin-bottom:20px;margin-top: 15px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="button" class="check1 btn btn-success col-md-12  " style="background-color: #15726e;border-color: #15726e;"  id="class" name="update" value="Submit"> 
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add New Student</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page is being used to add STUDENT's information when he/she joins the school very first time..</li>
                  <li >Once you create STUDENT's record here in Zumily-School apllication, it will be used all the places whenever STUDENT needs to be connected, such as assigning to a specific class-Register. </li>
                  <li >You dont need to create student's record every year rather this will be used is Class-Register when STUDENT passes and move to higher classes.</li>
                  <li >Some of the information is not EDITABLE so be check the data before you save it.</li>           
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
    function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;
      return true;
   }
   
   
    $("#reg_date").keyup(function(){ 
        var d = new Date();   
        var fullDate =  d.getDate();
        
        var val = $(this).val(); 
        if(val > 31)
        {
            $('#reg_date').val('');
            $('#reg_date').focus();
            alert("Invalid Date");
        }
        
        var count = $(this).val().length;  
        if(count == 2)
        { 
    		$('#reg_month').focus();
        } 
    });
    $("#reg_month").keyup(function(){  
        
        
        var date =  $('#reg_date').val().length;
        if(date < 2)
        { 
            alert("Invalid Date");
            $('#reg_date').focus();
        }
        
        var d = new Date();   
        var fullMonth =  d.getMonth() + 1; 
        
        var val = $(this).val(); 
        if(val > 12)
        {
            $('#reg_month').val('');
            $('#reg_month').focus();
            alert("Invalid Month");
        }
        var count = $(this).val().length;  
        if(count == 2)
        { 
    		$('#reg_year').focus();
        } 
    }); 
    $("#reg_year").keyup(function(){ 
        
        var month =  $('#reg_month').val().length;
        if(month < 2)
        { 
            alert("Invalid Month");
            $('#reg_month').focus();
        } 
        
        var d = new Date();  
        var fullYear =  d.getFullYear();  
        var val = $(this).val(); 
        if(val > fullYear)
        {
            $('#reg_year').val('');
            $('#reg_year').focus();
            alert("You can't enter future year");
        }
    });
    $("#birth_date").keyup(function(){ 
        var d = new Date();   
        var fullDate =  d.getDate();
        
        var val = $(this).val(); 
        if(val > 31)
        {
            $('#birth_date').val('');
            $('#birth_date').focus();
            alert("Invalid Date");
        }
        
        var count = $(this).val().length;  
        if(count == 2)
        { 
    		$('#birth_month').focus();
        } 
    });
    $("#birth_month").keyup(function(){  
        
        
        var date =  $('#birth_date').val().length;
        if(date < 2)
        { 
            alert("Invalid Date");
            $('#birth_date').focus();
        }
        
        var d = new Date();   
        var fullMonth =  d.getMonth() + 1; 
        
        var val = $(this).val(); 
        if(val > 12)
        {
            $('#birth_month').val('');
            $('#birth_month').focus();
            alert("Invalid Month");
        }
        var count = $(this).val().length;  
        if(count == 2)
        { 
    		$('#birth_year').focus();
        } 
    }); 
    $("#birth_year").keyup(function(){ 
        
        var month =  $('#birth_month').val().length;
        if(month < 2)
        { 
            alert("Invalid Month");
            $('#birth_month').focus();
        } 
        
        var d = new Date();  
        var fullYear =  d.getFullYear();  
        var val = $(this).val(); 
        if(val > fullYear)
        {
            $('#birth_year').val('');
            $('#birth_year').focus();
            alert("You can't enter future year");
        }
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
    
</script>


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
