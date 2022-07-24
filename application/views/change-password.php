          

<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 >Change Password  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right"> 
                    <form name="obaby"  > 
                    <span id="message"></span>  
                     <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"> </span>
                        	<span id="error" style="color:red;"> </span>
                    </div> 
                    <div class="form-group col-sm-6" style="padding-left: 0px;"> 
                        <input   class=" form-control" placeholder="Old Password" type="password" name="oldfpassword" id="oldfpassword" data-toggle="tooltip" title="Old Password cannot be blank" > 
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6" style="padding-left: 0px;"> 
                        <input   class=" form-control" placeholder="New Password" type="password" name="cfpassword" id="cfpassword" value="" data-toggle="tooltip" title="New password cannot be blank"> 
                    </div>
                    <div class="clearfix"></div>
                    <span id="errorpassword"></span>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6" style="padding-left: 0px;"> 
                    <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="Confirm New Password" value=""  data-toggle="tooltip"  title="Confirm new password should be same as new password"  >
                    
                    </div>
                    <div class="db-mak-pay-bot col-md-6 col-md-offset-3" style="margin-bottom:17px;">
                        <button type="button" name="Submit" id="regis" class="  btn btn-primary form-control changepassword">Update Password</button> 
                    </div>
                     
                
                    </form>   
                </div>  
            </div>
        </div>
    </div> 
</div> 
 

<script src="<?php echo base_url()."assets"; ?>/js/jquery.min.js"></script>
<script> 
    $('.changepassword').click(function(){
    var oldfpassword = $('#oldfpassword').val();    
    var password = $('#cfpassword').val(); 
	var cpassword = $('#newpassword').val(); 
	if(oldfpassword == '')
	{   
		$('#oldfpassword').css("border","1px solid red");
		$('#oldfpassword').focus();
		
		$('#message').html("<div class='alert alert-danger'>Please enter old password.</div>");
		return false;
	}
	else
	{ 
		$('#oldfpassword').css("border","1px solid #bdb9b9"); 
	} 
	
	if(password == '')
	{   
		$('#cfpassword').css("border","1px solid red");
		$('#cfpassword').focus();
		$('#message').html("<div class='alert alert-danger'>Please enter new password.</div>");
		return false;
	}
	else
	{ 
		$('#cfpassword').css("border","1px solid #bdb9b9"); 
	} 
	
	var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})"); 
	if(strongRegex.test(password) == false ) 
	{
        $('#passwordreg').css("border","1px solid red");
		$('#passwordreg').focus();
		$('#message').html("<div class='alert alert-danger'>Password should be atleast 8 character and atleast 1 uppercase, 1 lowercase and 1 number.</div>");
		return false;
    }
	else
	{ 
		$('#passwordreg').css("border","1px solid #bdb9b9"); 
		$('#errorpassword').html("");
	}  
	
	
	if(cpassword == '')
	{  
		$('#newpassword').css("border","1px solid red");
		$('#newpassword').focus();
		$('#message').html("<div class='alert alert-danger'>Please enter confirm new password.</div>");
		return false;
	}
	else
	{ 
		$('#newpassword').css("border","1px solid #bdb9b9"); 
	} 
	
	if(password != cpassword)
	{  
	    
		$('#newpassword').css("border","1px solid red");
		$('#newpassword').focus(); 
		$('#message').html("<div class='alert alert-danger'>New password and confirm new password must be same.</div>");
		return false;
	}
	else
	{ 
		$('#newpassword').css("border","1px solid #bdb9b9"); 
	} 
	
	
	$.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/change-password-process',
        data: { oldfpassword: oldfpassword,password: password},
        success:function(msg){   
                $("#message").html(msg); 
        }
    }); 
}); 

</script>


 <!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Change Password</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >You can change password for your School-Account-Login here..</li>
                  <li >To change it, you need to remember your OLD PASSWORD otherwise you cannot do it.. </li>
                  <li >NEW PASSWORD should have minimum 8 characters, one upper, and one number.</li>
                  <li >NEW-PASSWORD and CONFIRM-NEW-PASSWORD should match to change it.</li>
                  <li >If you DO NOT remember your OLD PASSWORD, LOGOUT and do the FORGOT-PASSWORD.</li>           
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
