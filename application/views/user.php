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
<section class="tz-register" style="background: url(<?php echo base_url(); ?>assets/images/school_logo.png)">
<div class="tz-regi-form tz-regi-form1">
<div class="row">
    <div class="col-md-12" style="padding-right:0px;"><h4 style=" font-size:32px; ">Welcome </h4></div> 
</div>    
<h3><?php echo @$this->session->flashdata('message'); ?></h3>
 
</div>
</section>
 