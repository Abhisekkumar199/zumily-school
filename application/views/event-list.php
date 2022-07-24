<script type="text/javascript">
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
    $(".view-event").click(function() {
        $('.showeventdetail').html('');
        var event_id=$(this).attr("event_id"); 
    	$.ajax({
    			type: "POST",
    			data: { event_id: event_id },
    			url:"https://localhost/project/zumilyschool/event-details",
    			success: function(response){  
    			    $('.showeventdetail').html(response);
    			}
    		});
    }); 
}); 
</script> 

<script>  
function deleteevent(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Remember, if you delete this event, all recipients will not be able to see it on the app.<br> Are you sure, you want to delete it?", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show();
            var event_id = val1; 
        	var pass_data = {event_id: event_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-event/"+event_id,
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
.business_list_dropdown{ display:none;} 
</style>
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
    	<div class="row" style="background: #d5d5d5;" >
    		<div class="col-md-12 col-xs-12" >
    			<h4>Events List   
                <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                <a href="<?php echo base_url(); ?>events-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
    			
    			<a  style=" margin-right:10px;" class=" pull-right" href="<?php echo base_url();?>add-event"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a> 
    			</h4>
    		</div>
    	</div> 
    	<div class="hom-cre-acc-left hom-cre-acc-right ">
    	    <div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag"> 
            	<div class="panel-body" id="result">
                     
                	<div class="table-responsive tab-inn ad-tab-inn active" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td class="col-md-3">Title</td>  
                            	<td class="col-md-2">Event Date</td>
                            	<td class="col-md-1">Start Time</td>
                            	<td class="col-md-1">End Time</td> 
                            	<td class="col-md-2 text-right">Action</td>
                        	</thead>
                            <tbody>
                    	<?php 
                    	if(count($event_lists) > 0) 
                    	{
                    	foreach($event_lists as $events)
                    	{
                    	?> 
                    
                        	<tr class="login<?php echo $events->event_id; ?>"    >
                            	<td class="business_list_"><?php echo $events->title;    ?></td>  
                            	<td class="business_list_"><?php echo date('D, d M , Y', strtotime($events->start_date)); ?></td>  
                            	<td class="business_list_"><?php echo date('h:i A', strtotime($events->start_time)); ?></td>  
                            	<td class="business_list_"><?php echo date('h:i A', strtotime($events->end_time)); ?></td>    
                            	
                            	<td class="col-md-2 text-right">
                          
                            	   <?php if( strtotime($this->session->userdata('current_date')) <= strtotime($events->start_date) ) { ?>
                            	   &nbsp; <a href="<?php echo base_url(); ?>update-event/<?php echo base64_encode($events->event_id); ?>"   title="edit"  ><i class="fa fa-edit" style="font-size:20px;"></i></a> 
                        			&nbsp;<a href="javascript:void(0)" title="delete" onclick = "deleteevent(<?php echo $events->event_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;"></i></a>
                        		    <?php } else { ?>
                        			&nbsp;<a href="<?php echo base_url(); ?>upload-event-images/<?php echo base64_encode($events->event_id); ?>" title="upload event images"  ><i class="fa fa-upload" style="font-size:20px;"></i></a>
                        		    <?php } ?>
                        	    &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $events->event_id; ?>');"     ><i class="fa fa-eye" style="font-size:20px;"></i></a>
                        	    </td>
                        	</tr> 
                        	
                        	
                        	<tr class=" business_list_dropdown login2<?php echo $events->event_id; ?>">
                                <td colspan="7">  
                                    <div class="col-sm-12">  
                                        <div class="col-md-12 flyer_detail_show" >   
                                            <div class="row title">
                                            	<div class="col-md-12">   
                                                		<h4 style="color: #000000;background-color:#ffffff;padding-left:0px;"><?php echo $events->title; ?></h4>   
                                            	</div> 
                                            </div>  
                                            <div class="row">
                                            	<div class="col-md-12"> <?php echo $events->description; ?>
                                            	</div> 
                                            </div>  
                                             
                                            <br>
                                            <div class="clearfix"></div> 
                                            <div class="preview col">   
                                                <div class="app-figure" id="zoom-fig"> 
                                                    <div id="myCarouselflyer<?php echo $events->event_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                        <!-- Indicators -->
                                                        <div class="carousel-inner"> 
                                                            <?php 
                                                            $document_array = explode(';',$events->event_images);   
                                                            for($i=0;$i<count($document_array);$i++)
                                                            { 
                                                                $string_array = explode('|',$document_array[$i]);
                                                            ?>  
                                                                <div class="item <?php if($i == 0){ ?>active <?php } ?>"> 
                                                                    <a id="Zoom-flyer<?php echo $events->event_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>">
                                                                        <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>"> 
                                                                    </a> 
                                                                </div>  
                                                                <a class="left carousel-control" href="#myCarouselflyer<?php echo $events->event_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                <a class="right carousel-control" href="#myCarouselflyer<?php echo $events->event_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                <div class="selectors">
                                                                    <a data-zoom-id="Zoom-flyer<?php echo $events->event_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>"
                                                                    data-image="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>" >
                                                                    <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>">
                                                                    </a>
                                                                </div>  
                                                            <?php   } ?> 
                                                           
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="row" style="margin:15px 0px;">  
                                                <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $events->date_created; ?> </span> 
                                            </div> 
                                            <div class="clearfix"></div>   
                                        </div>  
                                    </div>  
                                </td>
                            </tr>
                        	
                    	<?php } }  else { ?>
                    	<tr>
                    		<td colspan="2"  class="business_list_">You have no upcoming events. <a href="<?php echo base_url(); ?>add-event">Click here</a> to add one for future dates.</td>
                    	</tr>
                    	<?php } ?>
                    	</tbody> 
                    	</table>
                	</div>
            	</div> 
    	    </div>
    	</div>	</div>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Events</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page displays all the Events created and sent by School or Teachers.</li>
                  <li >To view the complete information for a specific event, click on the VIEW-ICON which will display description, images, and other information underneath it.</li>
                  <li >Event is allowed to delete only if it is in future. You cannot delete an EVENT if it has already been passed.</li>
                  <li >If you DELETE an Event, it will remove for all the delevered STUDENTS, PARENTS, & TEACHERS from EVENT list so you need to be very careful.</li>
                  <li >Remember, once you delete, it cannot be UNDO, means gone for forever.</li>
                  <li >You will have an option to upload EVENT pictures if date has already been passed.</li>
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

