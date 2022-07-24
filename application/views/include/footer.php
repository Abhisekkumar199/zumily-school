 
  <style>
     .foot-logo img { 
    padding-bottom: 5px!important;
}
 </style>
<!--FOOTER SECTION-->
 
<footer id="colophon" class="site-footer clearfix"> 
    <div id="quaternary" class="sidebar-container " role="complementary">
			<div class="sidebar-inner">
				<div class="widget-area clearfix">
					<div id="azh_widget-2" class="widget widget_azh_widget">
						<div data-section="section">
							<div class="container">
								<div class="row footer">
									<div class="col-sm-6 foot-social">
										<h4>Follow with us</h4>
										<p style="font-size:15px;">Join the thousands of other There are many variations of passages of Lorem Ipsum available</p>
										<ul>
											<li><a href="#!"><img style="width:35px;height:35px;" src="https://localhost/project/zumilyschool/assets/icons/facebook.png"></a> </li> 
											<li><a href="#!"><img style="width:35px;height:35px;" src="https://localhost/project/zumilyschool/assets/icons/twitter.png"></a> </li>
											<li><a href="#!"><img style="width:35px;height:35px;" src="https://localhost/project/zumilyschool/assets/icons/linkedin.png"></a> </li>
											<li><a href="#!"><img style="width:35px;height:35px;" src="https://localhost/project/zumilyschool/assets/icons/whatsapp.png"></a> </li>
											<li><a href="#!"><img style="width:35px;height:35px;" src="https://localhost/project/zumilyschool/assets/icons/instagram.png"></a> </li>
										</ul>
										<br>
										<div class="clearfix"></div>
										<h4 class="text-left" style="margin-top:20px;">Powered by - Avant IT Solutions.</h4>
									</div>
                                    <div class="col-sm-4 col-md-3">
                                        <h4>&nbsp;</h4>
                                        <ul class="two-columns"> 
                                            <li><a href="<?php echo base_url(); ?>faq"> FAQ</a></li>
                                            <li><a href="<?php echo base_url(); ?>terms-of-use"> Terms of use</a></li> 
                                            <li><a href="<?php echo base_url(); ?>privacy-policy"> Privacy Policy</a></li> 
                                        </ul> 
                                    </div>  
									 
									<div class="col-sm-4 col-md-3"> 
									    
                                            <h4>&nbsp;</h4>
										<ul class="two-columns">
											<li> <a href="<?php echo base_url(); ?>signup">Sign up</a> </li>
											<li> <a href="<?php echo base_url(); ?>login">Log in</a> </li> 
											<li> <a href="<?php echo base_url(); ?>contact-us">Contact Us</a> </li> 
										</ul>
									</div>
								</div>
							</div>
						</div>
					 
					</div>
				</div>
				<!-- .widget-area -->
			</div>
			<!-- .sidebar-inner -->
		</div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 
<!-- #quaternary -->
</footer>
<!--COPY RIGHTS-->
<section class="copy">
<div class="container"> 
<p>&copy; <?php echo date('Y'); ?> All rights reserved. <a href="https://localhost/project/zumilyschool/">zumily</a> </p>
</div>
</section>
<!--QUOTS POPUP-->
<section>
<!-- GET QUOTES POPUP -->
<div class="modal fade dir-pop-com" id="list-quo" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header dir-pop-head">
<button type="button" class="close" data-dismiss="modal">×</button>
<h4 class="modal-title">Get a Quotes</h4>
<!--<i class="fa fa-pencil dir-pop-head-icon" aria-hidden="true"></i>-->
</div>
<div class="modal-body dir-pop-body">
<form method="post" class="form-horizontal">
<!--LISTING INFORMATION-->
<div class="form-group has-feedback ak-field">
<label class="col-md-4 control-label">Full Name *</label>
<div class="col-md-8">
<input type="text" class="form-control" name="fname" placeholder="" required> </div>
</div>
<!--LISTING INFORMATION-->
<div class="form-group has-feedback ak-field">
<label class="col-md-4 control-label">Mobile</label>
<div class="col-md-8">
<input type="text" class="form-control" name="mobile" placeholder=""> </div>
</div>
<!--LISTING INFORMATION-->
<div class="form-group has-feedback ak-field">
<label class="col-md-4 control-label">Email</label>
<div class="col-md-8">
<input type="text" class="form-control" name="email" placeholder=""> </div>
</div>
<!--LISTING INFORMATION-->
<div class="form-group has-feedback ak-field">
<label class="col-md-4 control-label">Message</label>
<div class="col-md-8 get-quo">
<textarea class="form-control"></textarea>
</div>
</div>
<!--LISTING INFORMATION-->
<div class="form-group has-feedback ak-field">
<div class="col-md-6 col-md-offset-4">
<input type="submit" value="SUBMIT" class="pop-btn"> </div>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- GET QUOTES Popup END -->
</section>
<!--SCRIPT FILES-->
<script src="<?php echo base_url()."assets"; ?>/js/intlTelInput.js"></script>
<script src="<?php echo base_url()."assets"; ?>/js/jquery.min.js"></script>
<script src="<?php echo base_url()."assets"; ?>/js/bootstrap.js" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets"; ?>/js/custom.js"></script>
	<script src="<?php echo base_url()."assets"; ?>/js/materialize.min.js" type="text/javascript"></script>
</body>
</html>
<script>
$('.submitSignup').click(function(e){  
    
    e.preventDefault();
	//var country = $('#country').val();
	var contact_person_name = $('#contact_person_name').val();  
	var emailid = $('#emailidreg').val();  
	var password = $('#passwordreg').val(); 
	var country = $('#country').val();    
	var cpassword = $('#cpassword').val();  
	var check = 1;  
	var phone = $('#phone').val(); 
	var terms =   parseInt($('input[name="terms"]:checked').length);
	var location = parseInt($('input[name="location"]:checked').length); 
   
      
	if(contact_person_name == '')
	{  
		$('#contact_person_name').css("border","1px solid red");
		$('#contact_person_name').focus();
		return false;
	}
	else
	{ 
		$('#contact_person_name').css("border","1px solid #bdb9b9"); 
	}
	
 
    if(emailid != '')
    {
	    var regexEmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regexEmail.test(emailid)) 
        {
            $('#emailidreg').css("border","1px solid red");
    		$('#emailidreg').focus(); 
    		$('#message').html("<div class='alert alert-danger'>Email Id is invalid.</div>");
    		return false;
        }
        else
        {
           $('#emailidreg').css("border","1px solid #bdb9b9"); 
           $('#message').html("");
        }
    }
    
    
    if(phone == '')
	{  
		$('#phone').css("border","1px solid red");
		$('#phone').focus(); 
		$('#message').html("<div class='alert alert-danger'>Please enter Mobile No.</div>");
		return false;
	}
	else
	{ 
		$('#phone').css("border","1px solid #bdb9b9"); 
        $('#message').html("");
	} 
	var regexMobile = /^\d{10}$/;
    if(!regexMobile.test(phone)) 
    {
        $('#phone').css("border","1px solid red");
		$('#phone').focus(); 
		$('#message').html("<div class='alert alert-danger'>Mobile No. is invalid.</div>");
		return false;
    }
    else
    {
       $('#phone').css("border","1px solid #bdb9b9"); 
       $('#message').html("");
    } 

	
	if(password == '')
	{  
		$('#passwordreg').css("border","1px solid red");
		$('#passwordreg').focus();
		return false;
	}
	else
	{ 
		$('#passwordreg').css("border","1px solid #bdb9b9"); 
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
		$('#message').html("");
	}  
	
	
	
	if(cpassword == '')
	{  
		$('#cpassword').css("border","1px solid red");
		$('#cpassword').focus();
		return false;
	}
	else
	{ 
		$('#cpassword').css("border","1px solid #bdb9b9"); 
	} 
	
	
	
	
	if(password != cpassword)
	{  
		$('#cpassword').css("border","1px solid red");
		$('#cpassword').focus();
		return false;
	}
	else
	{ 
		$('#cpassword').css("border","1px solid #bdb9b9"); 
	}  
	
 
	
	if(terms < check)
	{  
		$('#message').html("<div class='alert alert-danger'>Please agree to the terms of service and privacy policy to continue.</div>"); 
		return false;
	}
	else
	{ 
		$('#message').html(""); 
	}
	
   
	$.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/signup-process',
        data: { contact_person_name: contact_person_name,emailid: emailid,password: password,phone: phone,country: country},
        success:function(msg){   
            if(msg == "verify-mobile")
            {
                window.location = "https://localhost/project/zumilyschool/verify-mobile";
            } 
            else if(msg == "verify-email")
            {
                window.location = "https://localhost/project/zumilyschool/signup";
            }
            else
            {
                $("#message").html(msg);
            }
        }
    }); 
});
$('.logincheck').click(function(){
	var emailid = $('#emailid2').val();
	var password = $('#password2').val(); 
	if(emailid == '')
	{  
		$('#emailid2').css("border","1px solid red");
		$('#emailid2').focus();
		return false;
	}
	else
	{ 
		$('#emailid2').css("border","1px solid #bdb9b9"); 
	} 
	if(password == '')
	{  
		$('#password2').css("border","1px solid red");
		$('#password2').focus();
		return false;
	}
	else
	{ 
		$('#password2').css("border","1px solid #bdb9b9"); 
	}  
 
	 
}); 
$('.forgotCheck').click(function(){ 
	var mobile = $('#mobile').val(); 
	if(mobile == '')
	{  
		$('#mobile').css("border","1px solid red");
		$('#mobile').focus();
		return false;
	}
	else
	{ 
		$('#mobile').css("border","1px solid #bdb9b9"); 
	} 
	$.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/forgot-password-process',
        data: { mobile: mobile},
        success:function(msg){  
            if(msg == 1)
            {
                window.location = "https://localhost/project/zumilyschool/verify-forgot-password-mobile";
            } 
            else
            {
                $('#message').html(msg);
            }
            
        }
    });
	 
});
$('.verifyForgetPasswordOTP').click(function(){ 
	var school_otp = $('#school_otp').val(); 
	var otp = $('#otp').val(); 
	if(otp == '')
	{ 
		$('#otp').css("border","1px solid red");
		$('#otp').focus();
		return false;
	}
	if(school_otp != otp)
	{  
	    $('#otperror').html("<div class='alert alert-danger'>Invalid OTP</div>");
		$('#otp').css("border","1px solid red");
		$('#otp').focus();
		return false;
	}
	else
	{ 
		window.location = "https://localhost/project/zumilyschool/set-new-mobile";
	}  
	 
});
$('.setNewPassword').click(function(){ 
	var password = $('#password').val(); 
	var cfpassword = $('#cfpassword').val(); 
	var school_id = $('#school_id').val();  
	if(password == '')
	{ 
		$('#password').css("border","1px solid red");
		$('#password').focus();
		return false;
	}
	if(cfpassword == '')
	{ 
		$('#cfpassword').css("border","1px solid red");
		$('#cfpassword').focus();
		return false;
	}
	if(password != cfpassword)
	{   
	    $("#errorpassword").html("Conform Password should be same as password");
		$('#cfpassword').css("border","1px solid red");
		$('#cfpassword').focus();
		return false;
	}
	else
	{ 
		$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>set-new-password-process',
            data: { school_id: school_id,password: password},
            success:function(msg){   
                   window.location = "https://localhost/project/zumilyschool/login"; 
            }
        });
	}  
	 
});
$('.sendotp').click(function(){
	var mobileno = $('#mobileno').val();
	var otp = $('#otp').val(); 
	if(mobileno == '')
	{  
		$('#mobileno').css("border","1px solid red");
		$('#mobileno').focus();
		return false;
	}
	else
	{
    	var regexMobile = /^\d{10}$/;
        if(!regexMobile.test(mobileno)) 
        {
            $('#mobileno').css("border","1px solid red");
    		$('#mobileno').focus(); 
    		$('#errormobile').html("<font color='red'>Mobile No. is invalid.</font>");
    		return false;
        }
        else
        {
           $('#mobileno').css("border","1px solid #bdb9b9"); 
           $('#errormobile').html("");
        } 
        $(".hide1").hide();
        $("#showverify").show();
	}
	
	$.ajax({
      type:'POST',
      url:'https://localhost/project/zumilyschool/sendotp.php',
      data:'mobileno='+mobileno,
      success:function(msg){  
                    $('#errormobile').html(msg);
      }
     });
    	
	 
});
$('.verifymobile').click(function(){
	var emailid = $('#mobileno').val();
	var otp = $('#otp').val(); 
	if(emailid == '')
	{  
		$('#mobileno').css("border","1px solid red");
		$('#mobileno').focus();
		return false;
	}
	else
	{ 
		$('#mobileno').css("border","1px solid #bdb9b9"); 
	} 
	if(otp == '')
	{  
		$('#otp').css("border","1px solid red");
		$('#otp').focus();
		return false;
	}
	else
	{ 
		$('#otp').css("border","1px solid #bdb9b9"); 
	} 
	 
});

</script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, { 
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
      // preferredCountries: ['cn', 'jp'],
      // separateDialCode: true,
      utilsScript: "build/js/utils.js",
    });
  </script>

<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?5lUKkrjbGE5QCTlyb0JlsPFT6dT2OmCQ";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->

 
