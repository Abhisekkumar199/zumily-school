 <div class="tz-2 mainContant" style="background-color:#ffffff;">
    <div class="tz-2-com tz-2-main">
        <h4>School Information     
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4>
        <div class="db-list-com tz-db-table">
            <div id="snackbar">Profile updated Successfully!</div>    
            <table class="responsive-table bordered" style="width:100%">
                <tbody> 
                    <tr> 
                        <td style="width:90px;" >
                            <?php if($user_info['school_logo']) { ?> 
                            <img src="<?php echo base_url();?>assets/uploadimages/schoolimages/<?php echo $user_info['school_logo']; ?>" style="width:90px; height:90px;" class="img-circle"/>
                            <?php } else { ?>
                            <img src="<?php echo base_url();?>assets/images/name.png" style="width:90px; height:90px;" class="img-circle"/>
                            <?php } ?>
                            
                        </td> 
                        <td colspan="2" >
                             <strong><font color="red"><?php echo $user_info['school_name']; ?></font></strong> <br>
                             <?php echo $user_info['school_address']; ?> <br> 
                            
                            <strong><?php echo $user_info['contact_person']; ?></strong> (School Manager) <br>
                            <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp; <?php echo $user_info['phone']; ?> 
                        </td>    
                    </tr> 
                    <tr style="border-bottom:none;">
                        <td colspan="2" >
                            
                            <?php if($user_info['principal_name'] != '') { ?><strong><?php echo $user_info['principal_name']; ?> (Principal)</strong> &nbsp;&nbsp;&nbsp;<?php } ?> <?php if($user_info['principal_mobile_no'] != '') { ?> <i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $user_info['principal_mobile_no']; ?><?php } ?> <?php if($user_info['principal_name'] != '') { ?><br><?php } ?>
                            <?php if($user_info['vice_principal_name'] != '') { ?><strong><?php echo $user_info['vice_principal_name']; ?> (Vice Principal)</strong>&nbsp;&nbsp;&nbsp;<?php } ?> <?php if($user_info['vice_principal_mobile_no'] != '') { ?> <i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $user_info['vice_principal_mobile_no']; ?><?php } ?> <?php if($user_info['vice_principal_name'] != '') { ?><br><?php } ?>
                            <?php if($user_info['transport_incharge'] != '') { ?> <strong><?php echo $user_info['transport_incharge']; ?> (Transport Incharge)</strong> &nbsp;&nbsp;&nbsp;<?php } ?>  <?php if($user_info['transport_incharge_mobile_no'] != '') { ?> <i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $user_info['transport_incharge_mobile_no']; ?><?php } ?> <?php if($user_info['transport_incharge'] != '') { ?><br><?php } ?>
                            <br>
                            <i class="fa fa-globe test" style="color:red;font-size:24px;" data-toggle="tooltip" data-placement="right" title="School website" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo $user_info['school_website']; ?>" target="_blank"><?php echo $user_info['school_website']; ?> </a><br>
                            <i class="fa fa-facebook-square test" style="color:#3b5998;font-size:24px;" data-toggle="tooltip" data-placement="right" title="School facebook page" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;  <a href="<?php echo $user_info['school_facebook_page']; ?>" target="_blank"><?php echo $user_info['school_facebook_page']; ?></a> <br>
                            <i class="fa fa-youtube test" style="color:red;font-size:24px;" data-toggle="tooltip" data-placement="right" title="School youtube channel" aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;  <a href="<?php echo $user_info['school_youtube_channel']; ?>" target="_blank"><?php echo $user_info['school_youtube_channel']; ?></a> <br>
                        </td>  
                    </tr>
                     
                </tbody> 
            </table> 
            <div class="db-mak-pay-bot col-md-6 col-md-offset-3"> 
                <a href="<?php echo base_url(); ?>school-information" class="btn btn-primary form-control">Edit School info</a> 
            </div> 
        </div> 
    </div> 
</div>  



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