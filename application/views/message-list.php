<script type="text/javascript">  
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
    $(".view-message").click(function() {
        $('.showmessagedetail').html('');
        var message_id=$(this).attr("message_id"); 
    	$.ajax({
    			type: "POST",
    			data: { message_id: message_id },
    			url:"https://localhost/project/zumilyschool/message-details",
    			success: function(response){  
    			    $('.showmessagedetail').html(response);
    			}
    		});
    }); 
}); 
</script> 
<script>  
function deletemessage(val1)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Remember, if you delete this message, all recipients will not be able to see it on the app.<br> Are you sure, you want to delete it?", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show();
            var message_id = val1; 
        	var pass_data = {message_id: message_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-message/"+message_id,
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
        <div id="snackbar">Message updated Successfully!</div>
    	<div class="row" style="background: #d5d5d5;" >
    		<div class="col-md-12 col-xs-12" >
    			<h4>Messages List  
                <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>                
                <a href="<?php echo base_url(); ?>message-pdf" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
    		 
    			<a  style=" margin-right:10px;" class=" pull-right" href="<?php echo base_url();?>add-message"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a>
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
                            	<td class="col-md-6">Title</td> 
                            	<td  >Type </td>
                            	<td  >Sent to</td>
                            	<td class="col-md-2">Date-time-sent</td>
                            	<td class="col-md-2">Action</td>
                        	</thead>
                            <tbody>
                    	<?php 
                    	if(count($message_lists) > 0) 
                    	{
                    	foreach($message_lists as $messages)
                    	{
                    	    
                    	?> 
                    
                    	<tr class="login<?php echo $messages->message_id; ?>"  >
                        	<td class="business_list_"><?php echo $messages->title; ?></td> 
                        	<td class="business_list_"><?php echo $messages->display_name; ?></td> 
                        	<td class="business_list_"><?php if($messages->sending_to == 'A'){ echo "All&nbsp;Students"; } else if($messages->sending_to == 'C') { echo "Selected&nbsp;Classes";  } else if($messages->sending_to == 'S') { echo "Selected&nbsp;Students";  }   ?></td> 
                        	
                        	<td class="business_list_"><?php echo $messages->message_date_created; ?></td> 
                        	<td>
                        	   
                        	    <!--<a href="<?php echo base_url(); ?>copy-message/<?php echo base64_encode($messages->message_id); ?>"  data-toggle="tooltip" title="" data-original-title="You can copy and modify this message and send to new GROUP or FOLLOWERS.">Copy</a>-->
                        	    &nbsp;<a href="javascript:void(0)" title="Delete this Message" onclick = "deletemessage(<?php echo $messages->message_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;"></i></a>
                        	    &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $messages->message_id; ?>');" title="Delete this Message" onclick = "deletemessage(<?php echo $messages->message_id; ?>)"  ><i class="fa fa-eye" style="font-size:20px;"></i></a>
                    	    </td> 
                    	</tr> 
                    	
                    	
                    	
                    	<tr class=" business_list_dropdown login2<?php echo $messages->message_id; ?>">
                            <td colspan="7">  
                                <div class="col-sm-12">  
                                    <div class="col-md-12 flyer_detail_show" >   
                                        <div class="row title">
                                        	<div class="col-md-12">   
                                            		<h4 style="color: #000000;background-color:#ffffff;padding-left:0px;"><?php echo $messages->title; ?></h4>   
                                        	</div> 
                                        </div>  
                                        <div class="row">
                                        	<div class="col-md-12"> <?php echo $messages->description; ?>
                                        	</div> 
                                        </div>  
                                         
                                        <br>
                                        <div class="clearfix"></div> 
                                        
                                        <?php if($messages->message_images != ''){ ?>
                                            <div class="preview col">   
                                                <div class="app-figure" id="zoom-fig"> 
                                                    <div id="myCarouselflyer<?php echo $messages->message_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                        <!-- Indicators -->
                                                        <div class="carousel-inner"> 
                                                            <?php  
                                                            $document_array = explode(';',$messages->message_images);   
                                                            for($i=0;$i<count($document_array);$i++)
                                                            { 
                                                                $string_array = explode('|',$document_array[$i]);
                                                            ?>  
                                                                <div class="item <?php if($i == 0){ ?>active <?php } ?> "> 
                                                                    <a id="Zoom-flyer<?php echo $messages->message_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>">
                                                                        <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>"> 
                                                                    </a> 
                                                                </div>  
                                                                <a class="left carousel-control" href="#myCarouselflyer<?php echo $messages->message_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                <a class="right carousel-control" href="#myCarouselflyer<?php echo $messages->message_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                <div class="selectors">
                                                                    <a data-zoom-id="Zoom-flyer<?php echo $messages->message_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>"
                                                                    data-image="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>" >
                                                                    <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>">
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
                                            <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $messages->message_date_created; ?> </span> 
                                        </div> 
                                        <div class="clearfix"></div>   
                                    </div>  
                                </div>  
                            </td>
                        </tr>
                    	
                    	<?php } }  else { ?>
                    	<tr>
                    		<td colspan="2"  class="business_list_">You have no sent messages. <a href="<?php echo base_url(); ?>/add-message">Click here</a> to create one.</td>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Messages</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page displays all the messages created and sent by School or Teachers.</li>
                  <li >To view the complete information for a specific message, click on the VIEW-ICON which will display description, images, and other information underneath it.</li>
                  <li >If you want to DELETE a message, click on the DELETE-ICON which will ask you to confirm it in case you click it by mistake.</li>
                  <li >If you DELETE a message, it will remove for all the delevered STUDENTS, PARENTS, & TEACHERS from MESSAGE list so you need to be very careful.</li>
                  <li >Remember, once you delete, it cannot be UNDO, means gone for forever.</li>
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


 