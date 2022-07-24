<div class="tz-2 mainContant">
    <div class="tz-2-com tz-2-main"> 
        <h4>School information
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4>
        <div class="db-list-com tz-db-table"> 
            <div class="hom-cre-acc-left hom-cre-acc-right">
                <span id="message" style="color:red;margin-bottom:20px;"></span>
                <form id="formCheck" autocomplete="nofill"  action="<?php echo base_url();?>update-school-process" method="POST" enctype="multipart/form-data"  onsubmit="return Validate(this);">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Upload School Logo</label> 
                        </div>
                        <div class="form-group col-md-2"> 
                            <?php if($user_info['school_logo'] != '')
                            { ?> 
                            <img src="<?php echo base_url();?>assets/uploadimages/schoolimages/<?php echo $user_info['school_logo']; ?>" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/> 
                            <?php } else { ?>
                            <img src="<?php echo base_url();?>assets/images/school.png" style="width:64px; height:64px; float:left; margin-right:10px" class="img-circle"/>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-7">
                            <input type="file" name="picture_name" id="file" class="inline imageselect" style="margin-top:10px;margin-top: 15px; margin-left: 10px;" /> 
                        </div> 
                        
                        <input type="hidden" name="oldimage" value="<?php echo $user_info['school_logo']; ?>">
                         
		                <div class="form-group col-md-3">
                            <img id="result" name="image_base64_string"  >
                            <input type="hidden" id="result1" name="result1" value="" />
                        </div>
                        <div class="clearfix"></div>
                        <div id="uploaded_image"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="text" class="test form-control" name="school_name" id="school_name" placeholder="School/College Name" value="<?php echo $user_info['school_name']; ?>" data-toggle="tooltip" title="School name" required="true" autocomplete="nofill">
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" class="test form-control" name="school_address" id="school_address" placeholder="School address" value="<?php echo $user_info['school_address']; ?>" data-toggle="tooltip" title="School address" required="true" autocomplete="nofill">
                        </div>
                        <div class="form-group col-md-12">
                            <textarea class="form-control" name="school_description" placeholder="School description"  style="width: 100%; height: 250px;" ><?php echo $user_info['school_description']; ?></textarea>
                        </div> 
                    </div>
                    
                    <div class="row"> 
                        <div class="form-group col-md-6">
                            <span id="errorMsg" style="color:red;"></span>
                            <input type="text" class="test validate form-control" name="contact_person" id="contact_person" placeholder="Contact Person" value="<?php echo $user_info['contact_person']; ?>" data-toggle="tooltip" title="Contact person's name. Avoid using periods and commas as they will not be captured." autocomplete="contact_person">
                        </div> 
                        <div class="form-group col-md-6"> 
                            <input type="text" class="test form-control" name="phone" id="phone" maxlength="10"   placeholder="Contact No." value="<?php echo $user_info['phone']; ?>"    data-toggle="tooltip" title="Contact person's phone number. It cannot begin with 1 or 0." autocomplete="nofill" disabled>
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-12"> 
                        <input type="text"  id="email_id"   value="<?php echo $user_info['email_id']; ?>"  class="test validate form-control email_id" name="email_id"  placeholder="Email id" data-toggle="tooltip"  title="Email id" autocomplete="nofill" <?php if($user_info['email_id'] != '') { ?> disabled <?php } ?> >
                        <div id="postal_code"></div> 
                    </div>
                     
                    <div class="form-group col-md-6"> 
                        <input type="text"  id="principal_name"   value="<?php echo $user_info['principal_name']; ?>"  class="test validate form-control" name="principal_name"  placeholder="Enter principal name"  data-toggle="tooltip" title="Principal name" autocomplete="nofill" >
                        <div id="postal_code"></div> 
                    </div>
                    <div class="form-group col-md-6"> 
                        <input type="text" class="test form-control" name="principal_mobile_no" id="principal_mobile_no" maxlength="10"   placeholder="Principal Mobile No" value="<?php echo $user_info['principal_mobile_no']; ?>"    data-toggle="tooltip" title="Principal mobile number. It cannot begin with 1 or 0." autocomplete="nofill"  >
                    </div>
                    <div class="form-group col-md-6"> 
                        <input type="text"  id="vice_principal_name"   value="<?php echo $user_info['vice_principal_name']; ?>"  class="test validate form-control" name="vice_principal_name"  placeholder="Enter vice principal name"  data-toggle="tooltip" title="Vice principal name" autocomplete="nofill" >
                        <div id="postal_code"></div> 
                    </div>
                    <div class="form-group col-md-6"> 
                        <input type="text" class="test form-control" name="vice_principal_mobile_no" id="vice_principal_mobile_no" maxlength="10"   placeholder="Vice Principal Mobile No" value="<?php echo $user_info['vice_principal_mobile_no']; ?>"    data-toggle="tooltip" title="Vice principal mobile number. It cannot begin with 1 or 0." autocomplete="nofill"  >
                    </div>
                    
                    <div class="form-group col-md-6"> 
                        <input type="text"  id="transport_incharge"   value="<?php echo $user_info['transport_incharge']; ?>"  class="test validate form-control" name="transport_incharge"  placeholder="Enter transport incharge name" data-toggle="tooltip"  title="Transport incharge name" autocomplete="nofill" >
                        <div id="postal_code"></div> 
                    </div>
                    <div class="form-group col-md-6"> 
                        <input type="text" class="test form-control" name="transport_incharge_mobile_no" id="transport_incharge_mobile_no" maxlength="10"   placeholder="Transport Incharge Mobile No" value="<?php echo $user_info['transport_incharge_mobile_no']; ?>"    data-toggle="tooltip" title="Transport incharge mobile number. It cannot begin with 1 or 0." autocomplete="nofill"  >
                    </div>
                    
                    <div class="form-group col-md-12"> 
                        <input type="text" class="test form-control" name="school_website" id="school_website"   placeholder="School Website" value="<?php echo $user_info['school_website']; ?>"    data-toggle="tooltip" title="School website" autocomplete="nofill"  >
                    </div>
                    
                    <div class="form-group col-md-12"> 
                        <input type="text" class="test form-control" name="school_facebook_page" id="school_facebook_page"   placeholder="School facebook page" value="<?php echo $user_info['school_facebook_page']; ?>"    data-toggle="tooltip" title="School facebook page" autocomplete="nofill"  >
                    </div>
                    
                    <div class="form-group col-md-12"> 
                        <input type="text" class="test form-control" name="school_youtube_channel" id="school_youtube_channel"    placeholder="School youtube channel" value="<?php echo $user_info['school_youtube_channel']; ?>"    data-toggle="tooltip" title="School youtube channel" autocomplete="nofill"  >
                    </div>
                      
                    <div class="col-md-6 col-md-offset-3" style="color:red;margin-top:20px;"> 
                    <input type="submit" class="schoolinfo check1 btn btn-success col-md-12" id="  signup" name="update" value="Submit"  /> 
                    </div>
                </form>
            </div>
            </div> 
        </div>
</div>  
</div> 

<script>
    $('.schoolinfo').click(function(){   
	var school_name = $('#school_name').val();   
	var emailid = $('#email_id').val();  
	var phone = $('#phone').val();   
	var principal_name = $('#principal_name').val();   
	var principal_mobile_no = $('#principal_mobile_no').val();   
	var vice_principal_name = $('#vice_principal_name').val();   
	var vice_principal_mobile_no = $('#vice_principal_mobile_no').val();   
	var transport_incharge = $('#transport_incharge').val();   
	var transport_incharge_mobile_no = $('#transport_incharge_mobile_no').val();  
	
	
	if(school_name == '')
	{  
		$('#school_name').css("border","1px solid red");
		$('#school_name').focus();
		$('#message').html("<div class='alert alert-danger'>Please enter School name</div>");
		return false;
	}
	else
	{ 
		$('#school_name').css("border","1px solid #bdb9b9"); 
	}
	
 
    if(emailid != '')
    {
	    var regexEmail = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regexEmail.test(emailid)) 
        {
            $('#email_id').css("border","1px solid red");
    		$('#email_id').focus(); 
    		$('#message').html("<div class='alert alert-danger'>Email Id is invalid.</div>");
    		return false;
        }
        else
        {
           $('#email_id').css("border","1px solid #bdb9b9"); 
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
    
    if(principal_mobile_no != '')
	{  
        if(principal_name == '')
    	{  
    		$('#principal_name').css("border","1px solid red");
    		$('#principal_name').focus();
    		$('#message').html("<div class='alert alert-danger'>Please enter Principal Name</div>");
    		return false;
    	}
    	else
    	{ 
    		$('#principal_name').css("border","1px solid #bdb9b9"); 
    	}
    	
    	
    	var regexMobile = /^\d{10}$/;
        if(!regexMobile.test(principal_mobile_no)) 
        {
            $('#principal_mobile_no').css("border","1px solid red");
    		$('#principal_mobile_no').focus(); 
    		$('#message').html("<div class='alert alert-danger'>Principal Mobile No. is invalid.</div>");
    		return false;
        }
        else
        {
           $('#principal_mobile_no').css("border","1px solid #bdb9b9"); 
           $('#message').html("");
        }  
	}
    
    if(vice_principal_mobile_no != '')
	{ 
    
        if(vice_principal_name == '')
    	{  
    		$('#vice_principal_name').css("border","1px solid red");
    		$('#vice_principal_name').focus();
    		$('#message').html("<div class='alert alert-danger'>Please enter Vice Principal Name</div>");
    		return false;
    	}
    	else
    	{ 
    		$('#vice_principal_name').css("border","1px solid #bdb9b9"); 
    	}
    	
    	
    	var regexMobile = /^\d{10}$/;
        if(!regexMobile.test(vice_principal_mobile_no)) 
        {
            $('#vice_principal_mobile_no').css("border","1px solid red");
    		$('#vice_principal_mobile_no').focus(); 
    		$('#message').html("<div class='alert alert-danger'>Vice Principal Mobile No. is invalid.</div>");
    		return false;
        }
        else
        {
           $('#vice_principal_mobile_no').css("border","1px solid #bdb9b9"); 
           $('#message').html("");
        }  
	}
    
    if(transport_incharge_mobile_no != '')
	{  
        if(transport_incharge == '')
    	{  
    		$('#transport_incharge').css("border","1px solid red");
    		$('#transport_incharge').focus();
    		$('#message').html("<div class='alert alert-danger'>Please enter Transport Incharge Name</div>");
    		return false;
    	}
    	else
    	{ 
    		$('#transport_incharge').css("border","1px solid #bdb9b9"); 
    	}
    	
    	var regexMobile = /^\d{10}$/;
        if(!regexMobile.test(transport_incharge_mobile_no)) 
        {
            $('#transport_incharge_mobile_no').css("border","1px solid red");
    		$('#transport_incharge_mobile_no').focus(); 
    		$('#message').html("<div class='alert alert-danger'>Transport Incharge Mobile No. is invalid.</div>");
    		return false;
        }
        else
        {
           $('#transport_incharge_mobile_no').css("border","1px solid #bdb9b9"); 
           $('#message').html("");
        }  
	}
     
    $(this).attr('disabled', true); // Disable this input.
    $("#formCheck").submit(); 
    
    $("#preloader").show();
    
    
    
    
    
});

    $(".email_id").keyup(function(){  
        var email_id = $(this).val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-school-email",  
            data:{email_id:email_id},  
            success:function(response){  
        	    if(response == 1)
        	    { 
        	       
                    $('#message').html("Email id already exists"); 
                    $('#email_id').css("border","1px solid red");  
                    $(".check1").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#message').html(""); 
                    $('#email_id').css("border","1px solid #c9c9c9");  
                    $(".check1").attr("disabled", false);  
                    
        	    }
                
                }
            }); 
        });
   
  </script> 
 
<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() { 
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('school_address')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGu4-4QYPkpQQrq5lf0T56Ou3YNMbVm4U&libraries=places&callback=initAutocomplete"
        async defer></script> 


<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - School Information</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page contains main information for your school. Same information will be displayed and accessible on the Zumily-School App to all Parents/Students/Teachers.</li>
                  <li >Please save as much as information you can including, School logo, Full School Name, Address, Contact person, Contact phone, etc.</li>
                  <li >Also, save websites url's if you do have School's own website, Youtube page, and/or FB page.</li>
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
  width: 1em;font-size: 18px;
  margin-left: -1em;
  margin-right: 10px;
}
</style>  