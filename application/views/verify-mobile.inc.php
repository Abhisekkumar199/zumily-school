<?php 
if($_REQUEST['type'] == "login")
{
    
    
    $phone = $_SESSION['mobile'];
    $otp = mt_rand(100000, 999999);  
    $sqlfil=mysql_query("update `users` set mobileotp='".$otp."' where  phone='".$phone."'"); 
    
    $str="Welcome to Zumily.com. Your OTP is  ".$otp; 
    $message=urlencode($str); 
    $username="zumily"; 
    $password="zumily123@"; 
    $senderid="ZUMILY";  
    
    $url="http://sms.webkype.in/sms_api/sendsms.php?username=$username&password=$password&message=$message&sendername=$senderid&mobile=$phone";  
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_POST, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
    curl_exec($ch);
    curl_error($ch);
    $_SESSION['sessionMsg']='<font color="red" style="font-size:14px;"><b>OTP has been sent.</b></font>'; 
}
?>
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
<section class="tz-register">
<div class="tz-regi-form tz-regi-form1">
<div class="row">
    <div class="col-md-12" style="padding-right:0px;"><h4 style=" font-size:32px; color: #1d2e63;">Verifying your Phone Number</h4></div> 
</div>  
<div class="row">
    <div class="col-md-12" style="padding-right:0px;"><p style=" font-size:14px; ">For your security, Zumily wants to make sure that it is really you. Please enter 6-digit OTP code, sent on your registered phone.</p></div> 
</div> 
<p><?php echo $_SESSION['loginmsg']." ".$_SESSION['sessionMsg']; ?></p>
<form action="<?php echo URL; ?>/verify-mobileno-process.php" method="post" class="col s12" >
<div class="row">
    <div class="input-field col s12" style="color:#000;">
    <input type="text" class=" test validate form-control"  value="<?php echo $_SESSION['mobile']; ?>" maxlength="10"  placeholder="Mobile No." data-toggle="tooltip" title="Mobile No." disabled  >
    <input type="hidden" value="<?php echo $_SESSION['mobile']; ?>" name="mobileno" id="mobileno" />
    </div>
    <span id="errormobile"></span>
</div>  
    <div class="row">
        <div class="input-field col s12">
        <input type="text" class="test validate form-control" name="otp" id="otp" placeholder="Enter your OTP" data-toggle="tooltip" title="Enter your OTP."  > 
        </div>
    </div>
    <div class="row"> 
        <div class="input-field  col s12">
            <input type="submit" class="btn btn-success form-control verifymobile"  style="background-color:#1d2e63!important; border-color: #1d2e63!important;" name="Submit" value="Verify">
        </div>    
    </div>   

</form>
 
</div>
</section>
<!--MOBILE APP-->

<!--FOOTER SECTION-->
<?php
unset($_SESSION['sessionMsg']);
unset($_SESSION['loginmsg']);
?>