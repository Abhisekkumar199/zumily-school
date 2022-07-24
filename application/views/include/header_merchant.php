<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
$unread_leave_request_list = get_unread_leave_request_list($this->input->cookie('school_id',true));
?>
<?php 
$keys="zumily"; 
if(!$this->input->cookie('school_id',true))
{
    ?>
    <script language="javascript">
    window.location.href="<?php echo base_url(); ?>";
    </script>
    <?php
}
?>   
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Connecting your Schools with your Students, Parents, & Teachers in realtime!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="shortcut icon" href="images/logo3.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url()."assets/"; ?>css/materialize.css" rel="stylesheet"> 
        <link href="<?php echo base_url()."assets/"; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo base_url()."assets/"; ?>css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url()."assets/"; ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()."assets/"; ?>css/responsive.css" rel="stylesheet">   
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
        <script src="<?php echo base_url()."assets/"; ?>js/jstz-1.0.4.min.js"></script> 
         
        <script type='text/javascript' src='<?php echo base_url()."assets/"; ?>/textboxio-client/textboxio/textboxio.js'></script> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/"; ?>/textboxio-client/example.css" /> 
        
        
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />   
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">  
        <link href="<?php echo base_url(); ?>assets/css/style3.css" rel="stylesheet" type="text/css" /> 
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/pixelarity.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"> 
        
        
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-vk5WoKIaW/vJyUAd9n/wmopsmNhiy+L2Z+SBxGYnUkunIxVxAv/UtMOhba/xskxh" crossorigin="anonymous"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/pixelarity-face.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/script-face.js"></script> 
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>   
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
        
        <link href="<?php echo base_url(); ?>/assets/magiczoomplus/magiczoomplus.css" rel="stylesheet" type="text/css" media="screen"/>
        <script src="<?php echo base_url(); ?>/assets/magiczoomplus/magiczoomplus.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>/assets/magiczoomplus/prettify.min.css" rel="stylesheet" type="text/css" media="screen"/>
        <script src="<?php echo base_url(); ?>/assets/magiczoomplus/prettify.min.js" type="text/javascript"></script>
        
        <style type="text/css">
            img 
            {
                image-orientation: 0deg;
                -ms-transform: rotate(0deg); /* IE 9 */
                -webkit-transform: rotate(0deg); /* Chrome, Safari, Opera */
                transform: rotate(0deg);
            }
            #result
            {
            	display: block;
            	position: relative; 
            }
            .face
            {
            	position: absolute;
            	height: 0px;
            	width: 0px;
            	background-color: transparent;;
            	border: 4px solid rgba(10,10,10,0.5);
                display: none;
            }
            div.pac-container 
            {
                z-index: 1050 !important;
            }
            td.day{height:20px;line-height:20px;width:20px; color:black}
               
        </style> 
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script src="<?php echo base_url()."assets/"; ?>js/alertify.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>css/alertify.core.css" />
        <link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>css/alertify.default.css" id="toggleCSS" />
        <style>
        	.alertify  
        	{
        	    margin-top: 80px;
        	}
        	.alertify-buttons
        	{
        	    box-shadow: none;
        	}
        	nav
        	{
        	    background-color: #fff;
        	}
            .divclass 
            {
              background: #415665;
              height: 50px;
              width:200px;
              border-radius: 2px;
              padding:20px;
              font-size:22px;
              color:#fff;   
            }
        </style> 
        <?php
            $url = str_replace("/","",$_SERVER['REQUEST_URI']);
          $url = rtrim($url," ");
          if($url != "add-school-payment")
          {
            if($this->input->cookie('subscription_status',true) == 1)
            {
            ?>
            <script> 
             $(document).ready(function(){ 
                 $('#myModal1').modal('show');
                 var status = 0;
                 var pass_data = { 'subscription_status' : status};
                	$.ajax({
                    	url : "<?php echo base_url(); ?>/reset-subscription-status",
                    	type : "POST",
                    	data : pass_data,
                    	success : function(data) {  
                    	}
                	});
             });
            </script>
            <?php } else if($this->input->cookie('subscription_status',true) == 2) { ?>
            <script> 
             $(document).ready(function(){ 
                 $('#myModal1').modal('show'); 
            
             });
            </script> 
            <?php } ?>
            
           <?php } ?> 
            <script> 
                (adsbygoogle = window.adsbygoogle || []).push({
                      google_ad_client: "ca-pub-1261417894699300",
                      enable_page_level_ads: true
                 }); 
                var instantiateTextbox = function () 
                { 
                    textboxio.replaceAll('textarea', {
                      paste: {
                        style: 'clean'
                      },
                      css: {
                        stylesheets: ['<?php echo base_url()."assets/"; ?>/textboxio-client/example.css']
                      }
                    }); 
                };
                $(document).ready(function(){  
                    
                    
                    var d = new Date();  
                    var fullYear =  d.getFullYear();
                    var fullMonth =  d.getMonth() + 1;
                    if(fullMonth < 10)
                    {
                        fullMonth =  "0"+fullMonth;
                    }
                    var fullDate =  d.getDate();
                    
                    if(fullDate < 10)
                    {
                        fullDate =  "0"+fullDate;
                    }
                    var date1 = fullYear+"-"+fullMonth+"-"+fullDate; 
                    
                    var time = new Date();  
                    var hour =  time.getHours(); 
                    var minute =  time.getMinutes(); 
                    var second =  time.getSeconds(); 
                    if(minute < 10)
                    {
                        minute = "0"+minute;
                    }
                    if(second < 10)
                    {
                        second = "0"+second;
                    }
                    var date2 = hour+" "+minute;  
                    var minutes = time.getMinutes();   
                    var dayOfWeek = time.getDay();  
                    var current_date_time = date1+" "+hour+":"+minute+":"+second;  
                    
                    var pass_data = { 'current_date' : date1,'current_time' : date2,'current_date_time' : current_date_time,'day_of_month' : fullDate,'minutes' : minutes,'dayOfWeek' : dayOfWeek};
                	$.ajax({
                    	url : "<?php echo base_url(); ?>/set-currentdate",
                    	type : "POST",
                    	data : pass_data,
                    	success : function(data) {  
                    	}
                	});
                	
                	$('.dropdownlist').on("click", function(e){
                    $(this).next('ul').toggle();
                    e.stopPropagation();
                    e.preventDefault();
                    }); 
                    
                    $('.sidebar-menu li a').click(function(e) { 
                        $('.nav li.active').removeClass('active'); 
                        var $parent = $(this).parent();
                        $parent.addClass('active'); 
                    }); 
    
                    $(document).mouseup(function(e) { 
                        if(e.target.Id == "top-select-search")
                        {
                            return false;
                        }
                        var container = $("#autosearchshow");
                        
                        if (!container.is(e.target) && container.has(e.target).length === 0) 
                        { 
                            container.fadeOut(); 
                        }
                    }); 
                    
               
                
                    $( document ).on( 'keydown', function ( e ) {
                        if ( e.keyCode === 27 ) 
                        {  
                            var container = $("#autosearchshow"); 
                            var container_dropdown = $("#dropdown-menu"); 
                            var searchvalue = $("#top-select-search").val(); 
                            if(searchvalue != '')
                            {
                                container.fadeOut(); 
                            }
                            $(".dropdown").removeClass("open");
                        }
                    }); 
                    
                    $('.imageselect').change(function() { 
                        $(".login_loaderhide").show(); 
                        setTimeout(function() { $(".login_loaderhide").hide(); }, 3000);
                    }); 
                    
                    $("#top-select-search").click(function() {
                        event.preventDefault(); 
                        $(this.nextElementSibling).fadeToggle();
                    });
                    
                    $("#top-select-search").keyup(function(){ 
                       var val = this.value;  
                            var url = "<?php echo base_url();?>/ajax-auto-search";
                            $.ajax({
                            type: "POST",
                            url:  url,
                            data: 'searchtext='+ val,
                            success: function(data)
                            {      
                                 
                            $("#autosearchshow").html(data);  
                            }               
                            });
                        
                      	
                          return false;
                    });   
                });      
                
                var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
                function Validate(oForm) 
                {
                    var arrInputs = oForm.getElementsByTagName("input");
                    for (var i = 0; i < arrInputs.length; i++) 
                    {
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
            
            <script>
            $( document ).ready(function() {
                $(".submenu").click(function(){   
                    $(".parent_menu").addClass('open'); 
                });
            });
        </script>
    </head> 
    <!-- Button trigger modal -->
 
    
    <!-- Modal -->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h3 class="modal-title" id="exampleModalLabel"><strong>Payment Reminder</strong></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -27px!important;">
              <span aria-hidden="true" style="font-size:30px;color:red;">&times;</span>
            </button>
          </div>
           <div class="modal-body">
            <p style="color:red;font-size:18px;"><?php echo $this->input->cookie('subscription_message',true); ?></p>
          </div>
          <div class="modal-footer text-center" style="text-align:center!important;border-top:none!important;background-color: white;"> 
            <a href="<?php echo base_url(); ?>add-school-payment" style="float:none!important;" class="btn btn-primary">Make Payment</a>
          </div>
        </div>
      </div>
    </div>
    
    <body onload="instantiateTextbox();" class="main_body">
    <div id="preloader" style="display:none;">
		<div id="status">&nbsp;</div>
	</div>
    <section class="bottomMenu dir-il-top-fix" id="header">
        <div class="container top-search-main">
            <div class="row">
                <div class="ts-menu">
                    <!-- logo  -->
                    <div class="ts-menu-2">
                        <a href="<?php echo base_url(); ?>dashboard" class="t-bb"><img src="<?php echo base_url(); ?>assets/images/zumily-logo-new.png" style="width:80%;"></a>
                      
                    </div> 
                    <!-- search  -->
                    <div class="col-sm-5">
                        <form action="<?php echo base_url(); ?>search-result" method="post" class="tourz-search-form tourz-top-search-form searchform" style="width:100%; display:inline-block">
                            <div class="input-field"></div>
                            <div class="input-field autocomplete search-wrap" >
                            <input type="text" id="top-select-search"   name="search" value="<?php  echo @htmlspecialchars($_REQUEST['search']);  ?>" class="typeahead form-control"    placeholder="Search Students, Parents, OR Teachers" autocomplete="off">
                            
                            <span id="autosearchshow"  ></span> 
                            </div>
                            <div class="input-field" style="width:10%;">
                            <i class="waves-effect waves-light tourz-top-sear-btn waves-input-wrapper">
                            <input type="submit" name="find" id="find" value="" class="waves-button-input" style="float:left; line-height:0"></i> 
                            </div>
                        </form>  
                    </div>
                    
                    <!-- link  --> 
                    <div class="topbar-icon"> 
                        <div class="icon-box mgn-right-10">
                            <a href="<?php echo base_url(); ?>attendance"   title="Attendance">
                                <div class="icon">
                                    <img style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/attendance.png">
                                </div> 
                            </a>
                        </div>
                        <div class="icon-box mgn-right-10">
                            <a href="<?php echo base_url(); ?>messages-list"   title="Messages">
                                <div class="icon">
                                    <img style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/message.png">
                                </div> 
                            </a>
                        </div>
                        <div class="icon-box" style="margin-right: 10px;">
                            <a href="<?php echo base_url(); ?>events-list"   title="Events">
                                <div class="icon">
                                    <img style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/event.png">
                                </div> 
                            </a>
                        </div>
                        <div class="icon-box" style="margin-right: 10px;">
                            <a href="<?php echo base_url(); ?>leave-request-list"   title="Leave Requests">
                                <div class="icon">
                                    <img style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/homework64kb.png">
                                </div> 
                            </a>
                        </div>
                        <div class="icon-box dropdown" style="margin-right: 10px;">
                            <a class="btn-noti dropdown-toggle" href="#"  data-toggle="dropdown" data-placement="bottom" title="Notification">
                                <div class="icon">
                                    <img style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/bell32k.png">
                                    <?php if(count($unread_leave_request_list) > 0) { ?><span><?php echo count($unread_leave_request_list); ?></span><?php } ?>
                                </div> 
                            </a>
                            <ul class="dropdown-menu" style="left: -370px;overflow-y: scroll;height:350px;width: 400px;">
                                <?php    
                                foreach($unread_leave_request_list as  $leave_request)
                                {     
                                ?>
                                <?php if($leave_request->read_by == '') {  $bdcolor =  "background-color:#efefef;";  } else {  $bdcolor =  "background-color:#ffffff;"; } ?>
                                	 <li style="<?php echo $bdcolor; ?>border-bottom: 1px solid #efefef;padding: 0px 2px!important; " class="  ">
                                	     <a style="color:#000000;padding:0px;" href="<?php echo base_url(); ?>/leave-request-approval/<?php echo base64_encode($leave_request->student_leave_request_id); ?>">
                                	     <table class="responsive-table bordered" style="width:100%">
                                            <tbody> 
                                                <tr style="border-bottom:none;"> 
                                                    <td style="width:50px;">
                                                        <?php if($leave_request->profile_picture) { ?> 
                                                		<img src="<?php echo base_url(); ?>assets/uploadimages/studentimages/<?php echo $leave_request->profile_picture; ?>" style="width: 45px; height: 45px;"  class="img-circle logoimage"/>
                                                		<?php } else { ?>
                                                		<img src="<?php echo base_url(); ?>assets/images/name.png" style="width: 45px; height: 45px;" class="img-circle logoimage"/>
                                                		<?php } ?>               
                                                    </td> 
                                                    <td colspan="2">
                                                        <?php
                                                        if($leave_request->year_ago > 0)
                                                        {
                                                            $date_to_show = $leave_request->year_ago."y";
                                                        }
                                                        else if($leave_request->month_ago > 0)
                                                        {
                                                            $date_to_show = $leave_request->month_ago."m";
                                                        }
                                                        else if($leave_request->day_ago > 0)
                                                        {
                                                            $date_to_show = $leave_request->day_ago."d";
                                                        }
                                                        else if($leave_request->year_ago > 0)
                                                        {
                                                            $date_to_show = $leave_request->hour_ago."h";
                                                        }
                                                        else if($leave_request->minute_ago > 0)
                                                        {
                                                            $date_to_show = $leave_request->minute_ago."m";
                                                        }
                                                        ?>
                                                         <strong><?php echo $leave_request->first_name." ".$leave_request->last_name; ?> (<?php echo $leave_request->class_name; ?>)</strong>   <span class="pull-right"><?php  echo $date_to_show; ?> ago</span> <br>
                                                         <a style="color:#000000;" href="<?php echo base_url(); ?>/leave-request-approval/<?php echo base64_encode($leave_request->student_leave_request_id); ?>"><?php echo $leave_request->request_title; ?></a>  
                                                    </td>    
                                                </tr> 
                                               
                                            </tbody> 
                                        </table>
                                	     </a> 
                                      </li>  
                                <?php }  ?>  
                            </ul> 
                        </div>
                    </div> 
                
                    <div class="ts-menu-3 pull-right mr-l-none login-listing" style="width:18%;padding-top:0px;" >
                        <div class="dropdown">
                                <?php if($user_info['school_logo']) { ?> 
                                <a title="<?php echo $user_info['school_name']; ?>" class="btn btn-success dropdown-toggle height-36" type="button" data-toggle="dropdown" style="text-transform:capitalize;font-weight: 600;margin-top: 6px;float: right;background-color: #141E30!important;border-color: #141E30!important;box-shadow:none!important;">
                                   <img src="<?php echo base_url();?>assets/uploadimages/schoolimages/<?php echo $user_info['school_logo']; ?>" style="width:30px; height:30px;" class="img-circle"/>&nbsp;
                                    <?php 
                                    if(strlen(strip_tags($user_info['school_name'])) > 25)
                                    {  
                                        echo  substr(strip_tags($user_info['school_name']), 0, 25)."...";   
                                    } 
                                    else 
                                    {  
                                        echo  strip_tags($user_info['school_name']);    
                                    } 
                                    ?>
                                </a>
                                <?php } else { ?>
                                    <a title="<?php echo $user_info['school_name']; ?>" class="btn btn-success dropdown-toggle height-36" type="button" data-toggle="dropdown" style="text-transform:capitalize;font-weight: 600;margin-top: 6px;float: right;background-color: #141E30!important;border-color: #141E30!important;box-shadow:none!important;">
                                 
                                    <img src="https://localhost/project/zumilyschool/assets/images/name.png" style="width:30px; height:30px;" class="img-circle">
                                    <?php 
                                    if(strlen(strip_tags($user_info['school_name'])) > 25)
                                    {  
                                        echo  substr(strip_tags($user_info['school_name']), 0, 25)."...";   
                                    } 
                                    else 
                                    {  
                                        echo  strip_tags($user_info['school_name']);    
                                    } 
                                    ?>
                                    </a>
                                <?php } ?>   
                                 
                            
                            <ul class="dropdown-menu"> 
                                    <li><a href="<?php echo base_url(); ?>change-password"><img  style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/password32k.png"   > Change Password</a></li>   
                                    <li><a href="<?php echo base_url(); ?>terms-of-use" target="_blank"><img  style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/terms32k.png">  Terms of use</a></li> 
                                    <li><a href="<?php echo base_url(); ?>privacy-policy" target="_blank"><img  style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/privacy32k.png"> Privacy Policy</a></li> 
                                    <li><a href="<?php echo base_url(); ?>contact-us" ><img  style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/terms32k.png">  Contact Us</a></li> 
                                    <li><a href="<?php echo base_url(); ?>logout"><img  style="width:30px;height:30px;" src="https://localhost/project/zumilyschool/assets/icons/logout.png"> Logout</a></li> 
                            </ul> 
                              
                        </div>
                    </div>
                    <!--SECTION: REGISTER,SIGNIN AND ADD YOUR BUSINESS-->
                    <div class="ts-menu-6">
                    
                    
                    </div>
                
                    <!--MOBILE MENU ICON:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->
                    <div class="ts-menu-5"><span><i class="fa fa-bars" aria-hidden="true"></i></span> </div>
                    <!--MOBILE MENU CONTAINER:IT'S ONLY SHOW ON MOBILE & TABLET VIEW-->					
                </div>
            </div>
        </div>
    </section>
<!-- Modal --> 
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();   
});
</script>
