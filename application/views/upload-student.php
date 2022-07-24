<style type="text/css">
#country-list li{width: auto; background: #fff; list-style-type:none;}
#country-list li:hover{background:#ece3d2;cursor: pointer; list-style-type:none;}
ul.dropdown-menu.main 
{
display: block;
}
.cnter{
display: table;
margin: auto;
}
.tz2-form-com form{
float:left;
}
#preloader 
{ 
    display: none;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
    
 $(".check1").click(function(){ 
    var fname = $('#fname').val(); 
    var lname = $('#lname').val(); 
    var phone = $('#phone').val();  
    
    if(fname == '')
    {
        $('#errorMsg').html("Please enter first name");
        $('#fname').css("border","1px solid red");
		$('#fname').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#fname').css("border","1px solid #c9c9c9");
    }
    if(lname == '')
    {
        $('#errorMsg').html("Please enter last name");
        $('#lname').css("border","1px solid red");
		$('#lname').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#lname').css("border","1px solid #c9c9c9");
    } 
    if(phone == '')
    {
        $('#errorMsg1').html("Please enter phone number");
        $('#phone').css("border","1px solid red");
		$('#phone').focus();
		return false;
    }
    else
    {
        $('#errorMsg1').html("");
        $('#phone').css("border","1px solid #c9c9c9");
    }
});    
    
    
$("#search-box").keyup(function(){
var keyword1 = $(this).val();
var radiovalue = $('input[name=vote]:checked').val();
$.ajax({
type: "POST",
url: "result.php",
data:{keyword: $(this).val(),vote : radiovalue},
beforeSend: function(){
$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
},
success: function(data){
$("#suggesstion-box").show();
$("#suggesstion-box").html(data);
$("#search-box").css("background","#FFF");
}
});
});
});
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>
<script>
function selectCountry(val) {
$("#keysearch-box").val(val);
$("#result").hide();
}

function getVote(int) {
if (window.XMLHttpRequest) {
// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
} else {  // code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function() {
if (this.readyState==4 && this.status==200) {
document.getElementById("poll").innerHTML=this.responseText;
}
}
xmlhttp.open("GET","result.php?vote="+int,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function()
{
$("#username").change(function() 
{ 
var username = $("#username").val();
var msgbox = $("#status");

if(username.length > 4)
{
$("#status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');

$.ajax({  
type: "POST",  
url: "ajax.php",  
data: "username="+ username,  
success: function(msg){ /* GET THE TO BE RETURNED DATA */
$(".status").html(msg);
} 

}); 

}
else
{
$("#username").addClass("red");
$("#status").html('<font color="#cc0000">Please enter atleast 5 characters</font>');
}
return false;
});

});
</script>
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;">Upload Student Data</h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form autocomplete="off"  action="student_process.php" method="post" enctype="multipart/form-data"  style="background:#fff; border:1px solid #fff;" >
                   
                    <div class="row">
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                    	<div class="form-group col-sm-4">
                    	    <label>First Name</label>
                    	    <input type="hidden" class="validate  form-control" id="id" name="id" value="">
                    	    <input  autocomplete="aa" type="text" class="validate  form-control" id="fname" name="abcd1" value="" autocomplete="off"  >
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>Middle Name</label>
                    	    <input  autocomplete="aa"  type="text" class="validate form-control" id="abcd2" name="abcd2" value="" autocomplete="off">
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>Last Name</label>
                    	    <input  autocomplete="aa"  type="text" class="validate form-control" id="lname" name="abcd3" value="" autocomplete="off" >
                    	</div>
                    	
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                    	    <label>Student Id</label> 
                    	    <input autocomplete="aa" type="text" class="validate  form-control" id="abcd4" name="abcd4" value="" autocomplete="off" >
                    	</div>
                        <div class="form-group col-sm-4">
                    	    <label>Class</label>
                    	    <input autocomplete="aa"  type="text" class="validate  form-control" id="abcd5" name="abcd5" value="" autocomplete="off" >
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>School Year</label>
                    	    <select class="validate  form-control"  id="schoolyear" name="schoolyear"  >
                    	        <option value="">Select</option>
                    	        <option value="2018-19"  >2018-19</option>
                    	        <option value="2019-20"  >2019-20</option>
                    	    </select>
                    	</div>
                    	
                    </div>
                    <div class="row"> 
                        <div class="form-group col-sm-4">
                    	    <label>Personal Mobile No.</label>
                    	    <input autocomplete="aa" type="text" class="validate  form-control" id="phone" name="abcd6" value="" autocomplete="off" >
                    	</div> 
                    	<div class="form-group col-sm-4">
                    	    <label>Email Id</label>
                    	    <input  autocomplete="aa"  type="text" class="validate  form-control" id="abcd7" name="abcd7" value="" autocomplete="off" >
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>Father Name</label>
                    	    <input  autocomplete="aa"  type="text" class="validate form-control" id="abcd8" name="abcd8" value="" autocomplete="off" >
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="form-group col-sm-4">
                    	    <label>Father Mobile No. </label>
                    	    <input autocomplete="aa" type="text" class="validate form-control" id="abcd9" name="abcd9" value=""  autocomplete="off" >
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>Father Email Id</label>
                    	    <input  autocomplete="aa"  type="text" class="validate form-control" id="abcd10" name="abcd10" value="" autocomplete="off">
                    	</div>
                    	<div class="form-group col-sm-4">
                    	    <label>Mother Mobile No.</label>
                    	    <input  autocomplete="aa"  type="text" class="validate form-control" id="abcd11" name="abcd11" value="" autocomplete="off">
                    	</div>
                    	
                    </div>
                     
                    <div class="db-mak-pay-bot col-md-6 col-md-offset-3" style="margin-bottom:17px;">
                    <button type="submit" name="Submit" id="regis" class="check1 btn btn-primary form-control" >Save</button>
                    </div>
                    </div>
                    
                    
                    
                     
                    
                     
                     
                    </form>
                </div>
            </div>
        </div>  
 

 
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
 
<script src="<?php echo base_url(); ?>assets/js/materialize.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>