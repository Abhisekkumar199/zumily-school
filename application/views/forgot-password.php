<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<section class="tz-register">
<div class="tz-regi-form tz-regi-form1">
<h4  style=" font-size:32px; color: #1d2e63; ">Forgot Password</h4> 
<div id="frmContact"> 
<form class="col s12"  >
<span id="message"></span>    
<div class="row">
<div class="input-field col s12">
<input type="text" class="test validate demoInputBox form-control" placeholder="Mobile Number" name="mobile" id="mobile" data-toggle="tooltip" title="Enter your mobile no., you used when created an account." >
</div>
</div>

<div class="row">
<div class="input-field col s12 " style=""> 
<input type="button" class="btn btn-success form-control  btnAction forgotCheck" style="background-color:#1d2e63!important; border-color: #1d2e63!important;" name="Submit" value="SUBMIT"  >
</div>
</div>
</form>
</div> 

</div>
</section>
<!--MOBILE APP-->
 <?php unset($_SESSION['loginmsg']); ?>
<?php unset($_SESSION['sessionMsg']); ?>