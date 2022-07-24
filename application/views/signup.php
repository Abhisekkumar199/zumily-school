
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    $("#account_type").change(function(){
    var accounttype = $(this).val();
    if(accounttype == "4")
    {
       $("#showsubtype").show();  
       $("#address").prop('required',true);
       $("#city").prop('required',true);
       $("#bigcity").prop('required',true);
       $("#cell").prop('required',true);
    }
    else
    {
        $("#showsubtype").hide(); 
        $("#address").prop('required',false);
        $("#city").prop('required',false);
        $("#bigcity").prop('required',false);
        $("#cell").prop(false);
    } 
});
    
});
</script> 
<style>
    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
    position: fixed;
    visibility:hidden;
}
.dir-alp-l-com1 {
    padding: 0px;
}
.dir-alp-l3 ul li label {
    display: block;
    font-size: 13px !important;
    color: #8f8d8d;
}
.dir-alp-l3 ul li {
    list-style-type: none;
    border-bottom: none; 
}
.dir-alp-l-com1 a {
    margin-top: 5px;
    background: none;
    color: #337ab7;
    border: none;
}
.dir-alp-l-com1 a:hover { 
    color: #337ab7;
    background: none;
    border: none;
}
.tz-regi-form
{
    text-align:left!important;
}
</style>
 
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/intlTelInput.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/demo.css">
<section class="tz-register">
    <div class="tz-regi-form tz-regi-form1" style="padding-bottom:57px;">
        <div class="row">
            <div class="col-md-12" style="padding-right:0px;"><h4 style=" font-size:32px; color: #1d2e63; ">Welcome to Zumily School</h4></div> 
        </div>    
     
       
        <span class="termsmsg" style="color:red;"></span>
        <span class="usertypemsg" style="color:red;"></span>
        <span id="message"></span>
        <form  method="post" id="myform" autocomplete="off">
      
            <input type="hidden" name="country" id="country" value="IN" />
            <input type="hidden" name="dailcode" id="dailcode" value="" />
            <div class="row"> 
            
                <div class="col-xs-12 col-sm-12" >
                    <div class="form-group" >
                    <input type="text" name="contact_person_name" id="contact_person_name" data-toggle="tooltip"   title="Avoid using periods and commas."  placeholder="Contact Person Name" class="test form-control" autocomplete="off" />
                    </div>
                </div> 
                
                <div class="col-xs-12 col-sm-12" >
                    <div class="form-group" >
                    <input type="text" name="emailid" id="emailidreg"  data-toggle="tooltip" title="Enter your email address. We'll be sending you updates and recovery info so give the email you check frequently." placeholder="Email Address"
                    filter="email" class="test form-control" autocomplete="off" />
                    </div>
                </div>
                <span id="erroremail"></span>
                <div class="clearfix"></div> 
                <div class="col-xs-12 col-sm-12" >
                    <div class="form-group" >
                        
                    <input type="text" id="phone" name="phone" type="text" ata-toggle="tooltip"  title="Mobile Phone" placeholder="Cell/Mobile Phone" class="test form-control" autocomplete="off" > 
                    </div>  
                    <span id="errormobile"></span>
                </div>
                <div class="clearfix"></div> 
                
                <div class="col-xs-12 col-sm-6" >
                    <div class="form-group" >
                    <input type="password" name="password" id="passwordreg" data-toggle="tooltip"  title="Enter New Password" placeholder="Enter Password"
                    class="test form-control"  autocomplete="off" /> 
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6" >
                    <div class="form-group" >
                    <input type="password" name="cpassword" id="cpassword" data-toggle="tooltip"  title="Conform Password should be same as password" placeholder="Conform Password"
                    class="test form-control" autocomplete="off" />
                    </div>
                </div>  
                <span id="errorpassword"></span>
                 
                 
                
             
                      
                    <div class="clearfix"></div>
                    <div class="dir-alp-l3 dir-alp-l-com attribute_tab" style="margin-top:5px;"> 
                        <div class="dir-alp-l-com1 dir-alp-p3 showFilter" id="showFilter0005"> 
                            <ul style="padding-left:13px!important;">
                                <li>
                                    <input class="  " name="terms" type="checkbox" id="terms" value="">
                                    <label for="terms" style="float: left;padding-left:25px;">I agree to the <a href="https://localhost/project/zumilyschool/terms-of-use" target="blank" >terms of service</a> and <a href="https://localhost/project/zumilyschool/privacy-policy" target="blank">privacy policy</a></label>
                                </li>
                                <!--<li>
                                    <input class=" " name="location" type="checkbox" id="location" onclick="showLocation1()" value="">
                                    <label for="location" style="float: left;padding-left:25px;" data-toggle="tooltip"  title="We need your location to serve fliers, coupons, deals, &
             reminders from your neighborhood businesses, organizations,
            & schools. You cannot use our app or website without opt-in.">  Yes, I agree to share my Location</label>
                                </li> -->
                                <div class="clearfix"></div> 
                            </ul>
                        </div>
                      </div> 
            
                
                    <div class="col-xs-12 col-md-12">  
                        <input type="submit" class="btn btn-success form-control submitSignup" style="background-color:#1d2e63!important;border-color: #1d2e63!important;" name="Submit" value="Sign up"> 
                    </div>
            
             
            
            
            </div> 
        </form>
        
        <div class="col-md-12" style="padding-top:20px;">
        <p>Already have an account? <a href="login">Log in</a> </p>
        </div>		
    </div>
</section>
<!--MOBILE APP-->

<script src="https://localhost/project/zumilyschool/assets/js/niceCountryInput.js"></script>
 <script>
        function onChangeCallback(ctr){
            console.log("The country was changed: " + ctr);
            alert(ctr);
            //$("#selectionSpan").text(ctr);
        }

        $(document).ready(function () {
            $(".niceCountryInputSelector").each(function(i,e){
                new NiceCountryInput(e).init();
            });
        });
    </script>
 