<script type="text/javascript">
function validar()
{
var right = 1;
if(document.getElementById('email').value.length==0)
{
right = 0;
document.getElementById('emptymail').innerHTML = "Empty email or username";
}
if(document.getElementById('password').value.length==0)
{
right = 0;
document.getElementById('emptypass').innerHTML = "Empty password";
}
if(right == 1)
{
document.forms["formu"].submit();
}
}
</script>
<script>
var input = document.getElementById("password2");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementByClass("logincheck").click();
  }
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<style>
button{
background: transparent;
border: transparent;
}
.tz-regi-form form input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
 color: #999999;
 font-weight:900;
}
.tz-regi-form form input::-moz-placeholder { /* Firefox 19+ */
 color: #999999;
 font-weight:900;
}
.tz-regi-form form input:-ms-input-placeholder { /* IE 10+ */
 color: #999999;
 font-weight:900;
}
.tz-regi-form form input:-moz-placeholder { /* Firefox 18- */
 color: #999999;
 font-weight:900;
}

.tz-regi-form input[type="submit"] {
    padding: 0px;
    font-size: 18px !important;
    margin-top: 0px;
    color: #FFF;
}
.soc-login ul li
{
    width:100%;
}
.soc-login { 
    border-top: none;
    padding:20px;
    padding-top: 2px;
    padding-bottom: 40px;
}
</style>
<section class="tz-register" style="min-height:400px;background: url(<?php echo base_url(); ?>assets/images/face.jpg)">
<div class="tz-regi-form tz-regi-form1">
<div class="row">
    <div class="col-md-12" style="padding-right:0px;"><h4 style=" font-size:32px; color: #1d2e63;">Welcome back</h4></div> 
</div>    
<p><?php echo @$this->session->flashdata('message'); ?></p>
<form  method="post" action="<?php echo base_url(); ?>school-login" class="col s12" >
<span id="message"></span>
<div class="row">
<div class="input-field col s12" style="color:#000;">
<input type="text" class=" test validate form-control" name="emailid" id="emailid2"    placeholder="Email Address OR Mobile No." data-toggle="tooltip" title="Enter your email address or mobile no, you used when created this account."  >

</div>
</div>
<div class="row">
<div class="input-field col s12">
<input type="password" class="test validate form-control" name="password" id="password2" placeholder="Password" data-toggle="tooltip" title="Enter your password."  >
<a class="pull-right" href="<?php echo base_url(); ?>forgot-password">forgot password</a> 
</div>
</div>
<div class="row">
    
<div class="input-field  col s12">
<input type="submit" class="btn btn-primary form-control logincheck" style="background-color:#1d2e63!important; border-color: #1d2e63!important;" name="Submit" value="Log in">
</div>    
</div>  

</form> 
</div>
</section>
 