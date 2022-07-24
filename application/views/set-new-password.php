<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<section class="tz-register">
<div class="tz-regi-form tz-regi-form1">
<h4  style=" font-size:32px;color: #1d2e63; ">Set New Password</h4> 
<div id="frmContact">
<span id="message"> </span>
<span id="errorpassword"></span>
<form name="obaby" > 
    <input name="mobile" type="hidden" value="<?php echo @$mobile_no; ?>">
    <input name="school_id" id="school_id" type="hidden" value="<?php echo @$school_id; ?>">
    <div class="row">
        <div class="input-field col s12">
        <input class=" form-control" placeholder="Password" type="password" name="password" id="password">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="row">
    <div class="input-field col s12">
    <input type="password" name="cfpassword" id="cfpassword" class="form-control" placeholder="Confirm Password" data-toggle="tooltip" title="" data-original-title="Conform Password should be same as password">
    </div>
    </div>
    <div class="row">
    <div class="input-field col s12 " style=""> 
    <input type="button" class="btn btn-success form-control    setNewPassword" style="background-color:#1d2e63!important; border-color: #1d2e63!important;" name="Submit" value="SUBMIT">
    </div>
    </div>  
</form>
</div> 

</div>
</section>
<!--MOBILE APP-->
 <?php unset($_SESSION['loginmsg']); ?>
<?php unset($_SESSION['sessionMsg']); ?>