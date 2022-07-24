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
 
</style>
 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>  
<script>
$(document).ready(function(){
    
$(".check1").click(function(){ 
    var fname = $('#fname').val(); 
    var lname = $('#lname').val(); 
    var phone = $('#phone').val();  
    var specials=/[*|\":<>[\]{}`\\()';@&$]/;
    if(fname == '')
    {
        $('#errorMsg').html("Please enter first name");
        $('#fname').css("border","1px solid red");
		$('#fname').focus();
		return false;
    }
    else
    {
        if(specials.test(fname))
        {  
            $('#errorMsg').html("Special Character not allowed!"); 
            $('#fname').css("border","1px solid red");
            return false;
        }
        else
        { 
            $('#errorMsg').html("");
            $('#fname').css("border","1px solid #c9c9c9");
        }
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
        if(specials.test(lname))
        {  
            $('#errorMsg').html("Special Character not allowed!"); 
            $('#lname').css("border","1px solid red");
            return false;
        }
        else
        { 
            $('#errorMsg').html("");
            $('#lname').css("border","1px solid #c9c9c9");
        }
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
    var regexMobile = /^\d{10}$/;
    if(!regexMobile.test(phone)) 
    {
        $('#phone').css("border","1px solid red");
		$('#phone').focus(); 
		$('#errorMsg1').html("<font color='red'>Mobile No. is invalid.</font>");
		return false;
    }
    else
    {
       $('#phone').css("border","1px solid #bdb9b9"); 
       $('#errorMsg1').html("");
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
 
</script>
 <script> 
 var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Uploaded file is invalid, Please upload only Images" );
                    return false;
                }
            }
        }
    }
  
    return true;
}
</script> 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;">Edit Profile  </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form action="business_edit_process.php" method="post" enctype="multipart/form-data" style="background:#fff; border:1px solid #fff;"    autocomplete="off" onsubmit="return Validate(this);">
                     
                    
                    <div class="col-md-12">
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                    	<div class="form-group col-sm-12" style="padding-left: 0px;">
                    	<input type="text" class="validate  form-control" id="fname" name="b12345" value="<?php echo $user_info['contact_person']; ?>" autocomplete="off">
                    	</div> 
                    </div>
                    <div class="col-md-12"  >
                      
                    	
                    	<div class="col-sm-12">
                        	<span id="errorMsg1" style="color:red;"></span>
                        </div>
                        
                    	<div class="form-group col-sm-6" style="padding-left: 0px;">
                    	 
                    	    <input type="text"  maxlength="10" class="validate form-control" name="d12345" id="phone" placeholder="Enter Mobile Number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" value="<?php echo $user_info['phone']; ?>" autocomplete="off" <?php  if($user_info['phone']!='') { ?> readonly="readonly"<?php } ?> >
                    	</div>
                    	
                    	<div class="form-group col-sm-6" style="padding-right: 0px;">
                     
                    
                    	<input type="text"  maxlength="10" class="validate form-control" name="email" id="email" placeholder="Enter Email"  value="<?php echo $user_info['email_id']; ?>" autocomplete="off" <?php  if($user_info['email_id']!='') { ?> readonly="readonly"<?php } ?> >
                    	</div>  
                    </div>
                    <div class="col-md-12">  
                            <label>Upload Profile Image</label>
                            <input name="upload_image" id="upload_image" type="file" accept=".jpg,.jpeg,.png,.gif" value="<?php echo $user_info['school_logo'];?>"/>
                            <input type="hidden" name="blank_image" id="blank_image" value="<?php echo $user_info['school_logo'];?>"/>
                            <br>
                            <div id="uploaded_image"></div>
                            
                            <span id="oldimage">
                            <?php if($user_info['school_logo']){?>				
                            <img src="<?php echo base_url();?>/uploadimages/merchantimages/<?php echo $user_info['school_logo'];?>" class="img-circle" style="width:45px; height:45px; float:left; margin-right:10px"/>
                            <?php } else { ?>
                            <img src="<?php echo base_url();?>/images/name.png" class="img-circle" style="width:45px; height:45px; float:left; margin-right:10px"/>
                            <?php } ?>
                            </span>  
                            
                    </div>
                    <div class="db-mak-pay-bot col-md-6 col-md-offset-3" style="margin-bottom:17px;">
                        <button type="submit" name="Submit" id="regis" class="check1 btn btn-primary form-control" >Update Profile</button>
                    </div>
                    </form>
                </div>  
            </div>
        </div>
    </div> 
</div>  
<!--RIGHT SECTION-->
  


 
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
 
<script src="<?php echo URL; ?>/js/materialize.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
</html>