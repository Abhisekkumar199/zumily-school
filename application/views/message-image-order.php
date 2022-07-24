<link href="<?php echo base_url(); ?>assets/css/style3.css" rel="stylesheet" type="text/css" />
<style>
    .btn-success
    {
            background-color: #15726e!important;
            border-color: #15726e!important;
    }
</style> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
} );
</script> 
<script> 
$(document).ready(function(){  
    $('.check1').on('click',function(){ 
        
        $("#preloader").show();
        var message_id = $("#message_id").val(); 
        var ids = [];
        var image_names = [];
        $("ul.reorder-photos-list li").each(function() {  ids.push($(this).attr('id').substr(9));  });
        $("ul.reorder-photos-list li").each(function() {  image_names.push($(this).attr('image_name'));  });  
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>message-image-order-process",
            data: {message_id:message_id,image_names:image_names},
            success: function(response){ 
            window.location.replace("https://localhost/project/zumilyschool/messages-list");
             
        }
        });
        
        
        	
    }); 
}); 
</script>
 <script>  
function deletemessageimage(val1)
{  
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure you want to delete this image?", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show();
            var message_id = val1; 
        	var pass_data = {message_id: message_id};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-message-image/"+message_id,
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
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;">Reorder Message Images </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/message-image-order-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off">
                        <input type="hidden" id="message_id"  name="id" value="<?php echo @$message_id; ?>"  > 
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <p><strong><?php echo @$message_date['title']; ?></strong></p> 
                           
                            <div class="clearfix"></div> 
                            <div class="row" style="margin-top:0px;"> 
                                <div class="gallery"> 
                                    <ul id="sortable" class="reorder_ul reorder-photos-list">
                                        
                                        
                                        <?php 
                                        if($message_date['message_images'] != '')
                                        {
                                            $document_array = explode(';',$message_date['message_images']);  
                                        ?> 
                                        <?php  
                                        for($i=0;$i<count($document_array);$i++)
                                        { 
                                            $string_array = explode('|',$document_array[$i]);
                                        ?> 
                                         
                                            <li id="image_li_<?php echo $string_array[0]; ?>" image_name="<?php echo $string_array[1]; ?>" class="ui-state-default">
                                            <p>Image-<?php echo $string_array[0]; ?> &nbsp;&nbsp;  <a href="<?php echo base_url(); ?>/delete-message-image/<?php echo $message_date['message_id']; ?>-<?php echo $string_array[0]; ?>" title="delete"     ><i class="fa fa-trash-o" style="font-size:24px;margin-top:5px;"></i></a></p> 
                                            <a href="javascript:void(0);" style="float:none;" class="image_link">
                                            	<img src="<?php echo base_url(); ?>/assets/uploadimages/messageimages/<?php echo $string_array[1]; ?>" alt="" style="height:150px; width:155px;">
                                            </a>
                                            </li>
                                                
                                            
                                        <?php  } } ?>
                                         
                                    </ul>
                                </div>
                            </div> 
                             
                            
                            <div class="col-md-6 col-md-offset-3">
                                <input type="button"  class="check1 btn btn-success col-md-12 " name="Save" value="Save & Send Message"  style="margin-bottom:10px;"/>
                                &nbsp;  
                            </div>
                            <br />  
                        </div>
                    </form>
                </div>  
            </div>
        </div>
    </div> 
</div> 
</div>
</div>
 
   