<script type="text/javascript">  
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
  
}); 
</script> 
<script>  
function deleteholiday(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure, want to delete this holiday(s) from this Session Year?", function (e) 
    {
        if (e) 
        {
            var holiday_id = val1; 
        	var pass_data = {holiday_id: holiday_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-holiday/"+holiday_id,
        	type : "POST",
        	data : pass_data,
        	success : function(data) {
        	location.reload();
        	}
        	});
        	return false;
        } 
        else 
        { 
        }
    }); 
      
} 
</script>
<style>
    .col-md-3
    {
        width: 25%!important;
    }
</style> 
<style>
.business_list_dropdown{ display:none;} 
</style>
<!--CENTER SECTION-->
    <div class="tz-2 mainContant zumily_mainContent" >
        <div class="tz-2-com tz-2-main"> 
        	<div class="row" style="background: #151f31;" >
        		<div class="col-md-3 col-xs-3" > 
        			<h4>Leave Requests List
        			
        			</h4>
        		</div>
        		<div class="col-md-9 col-xs-9" >
        		    <form method="get" action="<?php echo base_url(); ?>leave-request-list" >
		            <input type="hidden" value= "0" name="is_session_changed" id="is_session_changed" />
        		    <div class="row">
        		        <div class="col-md-3" style="width: 22%!important;" >
        		            <?php ?>
                		    <select id="session_id" class="form-control  " name="session_id" required=""  style="border: 1px solid rgb(189, 185, 185);height:30px;  margin: 7px; " onchange="session_event();this.form.submit()">
                                <option value="" disabled>Select session year  </option> 
                                <?php foreach($session_years as $session_year) { ?>
                                <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                                <?php } ?>
                            </select> 
                        </div> 
                        <div class="col-md-3" style="width: 22%!important;" > 
                		    <select id="class_register_id" class="form-control  " name="class_register_id"   style="border: 1px solid rgb(189, 185, 185);  margin: 7px; height:30px;" onchange="this.form.submit()">
                                <option value="">All Classes</option> 
                                <?php foreach($classregister_lists as $class) { ?>
                                <option value="<?php echo base64_encode($class->class_register_id); ?>" <?php if($selected_class == $class->class_register_id ) { ?>selected <?php } ?>  ><?php echo $class->class_name_section; ?></option>
                                <?php } ?>
                            </select>
                        </div> 
                        <div class="col-md-3" style="width: 22%!important;" > 
                		    <select id="approve_status" class="form-control  " name="approve_status"  style="border: 1px solid rgb(189, 185, 185);  margin: 7px; width: 135px;height:30px;  " onchange="this.form.submit()">
                                <option value="">All Status</option> 
                                <option value="1"  <?php if($selected_status == '1' ) { ?>selected <?php } ?>>Approved</option>  
                                <option value="0"  <?php if($selected_status == '0' ) { ?>selected <?php } ?>>Denied</option> 
                                <option value="2"  <?php if($selected_status == '2' ) { ?>selected <?php } ?>>Pending</option> 
                            </select>
                        </div> 
                        <div class="col-md-3" style="width: 34%!important;" > 
                            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                            <a href="<?php echo base_url(); ?>leave-request-pdf/<?php echo base64_encode($selected_session); ?>-<?php echo base64_encode($selected_class); ?>-<?php echo base64_encode($selected_status); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
                		     
                        </div> 
        			</div>
        			</form>
        		</div>
        	</div> 
        	<div class="col-sm-12 fullWidth-tab">
        		<div class="panel panel-bd lobidrag"> 
                        
                    <div class="panel-body" id="result"> 
                    	<div class="table-responsive tab-inn ad-tab-inn" id="active">
                        	<table class="table table-hover">
                            	<thead> 
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button"  link_value="desc"  value="delivery">Name</a></span>  </td> 
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Class</a></span>  </td>
                                	<td style="width:220px;"><span ><a href="javascript:void(0)" name="order" class="button"   link_value="desc"  value="delivery">Title</a></span></td>
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Start Date </a></span>  </td>
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">End Date </a></span>  </td> 
                                	<td> <span ><a href="javascript:void(0)" name="order" class="button" column_value="start_date" link_value="desc"  value="delivery">Status</a></span>  </td> 
                                	<td>Action</td>
                            	</thead>
                            	<tbody>
                            	<?php 
                             	if(count($leave_request_lists) > 0)
                             	{
                            	foreach($leave_request_lists as $leave_request)
                            	{
                            	?>
                        
                    	        <tr class="  login"  > 
                    	            <td>
									<?php 
									if($leave_request->profile_picture != '')
									{
									    ?>
									    <img src="<?php echo base_url(); ?>/assets/uploadimages/studentimages/<?php echo $leave_request->profile_picture; ?>" class="img-circle" style="width:30px; height:30px;" />
								    <?php  }else { ?>
								        <img src="<?php echo base_url(); ?>/assets/images/name.png" class="img-circle" style="width:30px; height:30px;" /> 
									<?php } ?> 
									<?php echo $leave_request->first_name." ".$leave_request->last_name; ?>
									</td> 
                            		<td class="business_list_"><?php echo  $leave_request->class_name; ?></td>  
                            		<td class="business_list_"><?php echo $leave_request->request_title; ?></td> 
                            		<td class="business_list_"><?php echo date("D, M d, Y",strtotime(@$leave_request->start_date)) ; ?></td>
                            		<td class="business_list_"><?php if($leave_request->end_date != '') { echo date("D, M d, Y",strtotime(@$leave_request->end_date)) ;  } ?></td>
                            		<td class="business_list_"><?php if($leave_request->request_status == 0) { echo 'Denied'; } else if($leave_request->request_status == 1) { echo 'Approved'; }else { echo 'Pending'; } ?></td> 
                            		<td class="text-right"> 
                        		         <?php if($leave_request->request_status == 2) { ?>
                        	            <a href="<?php echo base_url(); ?>leave-request-approval/<?php echo base64_encode($leave_request->student_leave_request_id); ?>" title="Edit this Leave Request"><i class="fa fa-edit" style="font-size:20px;"></i></a>
                            			<?php } ?>
                            			<!--<?php if($leave_request->displayflag1 == 1 ) { ?>
                            			<a href="<?php echo base_url(); ?>disable-holiday/<?php echo $leave_request->student_leave_request_id; ?>" title="disable"  ><i class="fa fa-ban" style="color:green;" style="font-size:25px;"></i></a>
                            			<?php } else { ?> 
                            			<a href="<?php echo base_url(); ?>enable-holiday/<?php echo $leave_request->student_leave_request_id; ?>"   title="enable"  ><i class="fa fa-ban" style="color:red;" style="font-size:25px;"></i></a>
                            			<?php } ?> -->
                            			&nbsp;&nbsp;
                        	            &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $leave_request->student_leave_request_id; ?>');"     ><i class="fa fa-eye" style="font-size:20px;"></i></a>
                            		</td>
                            	</tr>
                            	
                            	<tr class=" business_list_dropdown login2<?php echo $leave_request->student_leave_request_id; ?>">
                                    <td colspan="7">  
                                        <div class="col-sm-12">  
                                            <div class="col-md-12 flyer_detail_show" >   
                                                <div class="row title">
                                                	<div class="col-md-12">   
                                                    		<h4 style="color: #000000;background-color:#ffffff;padding-left:0px;"><?php echo $leave_request->request_title; ?></h4>   
                                                	</div> 
                                                </div>  
                                                <div class="row">
                                                	<div class="col-md-12"> <?php echo $leave_request->request_reason; ?>
                                                	</div> 
                                                </div>  
                                                 
                                                <br>
                                                <div class="clearfix"></div> 
                                                <?php if($leave_request->leave_requests_images != '') { ?>
                                                <div class="preview col">   
                                                    <div class="app-figure" id="zoom-fig"> 
                                                        <div id="myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                            <!-- Indicators -->
                                                            <div class="carousel-inner"> 
                                                                <?php  
                                                                    $document_array = explode(';',$leave_request->leave_requests_images);   
                                                                    for($i=0;$i<count($document_array);$i++)
                                                                    { 
                                                                        $string_array = explode('|',$document_array[$i]);
                                                                    ?> 
                                                                    <div class="item <?php if($i == 0){ ?>active <?php } ?> "> 
                                                                        <a id="Zoom-flyer<?php echo $leave_request->student_leave_request_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                                                            <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"> 
                                                                        </a> 
                                                                    </div>  
                                                                    <a class="left carousel-control" href="#myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                    font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                    <a class="right carousel-control" href="#myCarouselflyer<?php echo $leave_request->student_leave_request_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                    background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                    <div class="selectors">
                                                                        <a data-zoom-id="Zoom-flyer<?php echo $leave_request->student_leave_request_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>"
                                                                        data-image="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>" >
                                                                        <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/leaverequests/<?php echo $string_array[1]; ?>">
                                                                        </a>
                                                                    </div>  
                                                                <?php   } ?> 
                                                               
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                                <div class="row" style="margin:15px 0px;">  
                                                    <?php if($leave_request->comment != '' or $leave_request->comment != NULL) { ?><p>Comment: <?php echo $leave_request->comment; ?></p><?php  } ?>
                                                    <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $leave_request->date_created; ?> </span> 
                                                </div> 
                                                <div class="clearfix"></div>   
                                            </div>  
                                        </div>  
                                    </td>
                                </tr>
                        
                        	<?php } }  else { ?>
                            	<tr>
                            		<td colspan="2"  class="business_list_">*** No Leave Request for this combination  ***</td>
                            	</tr>
                        	<?php } ?>
                        	 
                        	<?php ?>
                        	</tbody>
                        	</table>
                        	</div>
                        	</div>
                     
        		 
        		</div>
        	</div>
        </div> 
    </div> 
</div>
</section> 

<script type="text/javascript">
function showhide2(id) {
$(".login2"+id).toggle();  
}
function imageevent(){ 
    $('.bottomMenu ').css('position','inherit');
}
</script> 



<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Leave Requests</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page displays LR based on filteration by session-year, All-Classes OR a specific Class, all Status or any of them (Pending, Approved, Denied).</li>
                  <li >You can view complete Leave-Request detail information including images if any uploaded by Student/Parent just by clicking on View-Icon.</li>
                  <li >If you want to change Status of a Leave Request, click on the Edit-Icon and proceed with comment and Approve or Deny it.</li>
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
  width: 1em;font-size: 25px;
  margin-left: -1em;
  margin-right: 10px;
}
</style>


