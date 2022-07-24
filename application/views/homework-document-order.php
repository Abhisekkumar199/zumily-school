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
        var homework_id = $("#homework_id").val();
        $("#preloader").show();
        var ids = [];
        var image_names = [];
        $("ul.reorder-photos-list li").each(function() {  ids.push($(this).attr('id').substr(9));  });
        $("ul.reorder-photos-list li").each(function() {  image_names.push($(this).attr('image_name'));  }); 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>homework-document-order-process",
            data: {homework_id:homework_id,image_names:image_names},
            success: function(response){  
            window.location.replace("https://localhost/project/zumilyschool/homework");
             
        }
        });
        
        
        	
    }); 
}); 
</script>
 <script>  
function deletehomeworkdocument(val1)
{  
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure you want to delete this document?", function (e) 
    { 
        if (e) 
        {
            $("#preloader").show(); 
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-homework-document/"+val1,
        	type : "POST", 
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
        <h4 style="font-size: 14px;">Reorder Homework Documents </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/homework-document-order-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off">
                        <input type="hidden"  name="id" id="homework_id" value="<?php echo @$homework_id; ?>"  > 
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <p><strong><?php echo @$homework_info['title']; ?></strong></p> 
                           
                            <div class="clearfix"></div> 
                            <div class="row" style="margin-top:0px;"> 
                                <div class="gallery"> 
                                    <ul id="sortable" class="reorder_ul reorder-photos-list">
                                        
                                        <?php 
                                        if($homework_info['homework_documents_images'] != '')
                                        {
                                            $document_array = explode(';',$homework_info['homework_documents_images']);  
                                        ?> 
                                        <?php  
                                        for($i=0;$i<count($document_array);$i++)
                                        { 
                                            $string_array = explode('|',$document_array[$i]);
                                        ?> 
                                         
                                            <li id="image_li_<?php echo $string_array[0]; ?>" image_name="<?php echo $string_array[1]; ?>" class="ui-state-default">
                                            <p>Image-<?php echo $string_array[0]; ?> &nbsp;&nbsp;  <a href="<?php echo base_url(); ?>/delete-homework-document/<?php echo $homework_info['homework_id']; ?>-<?php echo $string_array[0]; ?>" title="delete"     ><i class="fa fa-trash-o" style="font-size:24px;margin-top:5px;"></i></a></p> 
                                            <a href="javascript:void(0);" style="float:none;" class="image_link">
                                            	<img src="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>" alt="" style="height:150px; width:155px;">
                                            </a>
                                            </li>
                                                
                                            
                                        <?php  } } ?> 
                                        
                                 
                                    </ul>
                                </div>
                            </div> 
                            <div class="col-md-6 col-md-offset-3">
                                <input type="button"  class="check1 btn btn-success col-md-12 " name="Save" value="Save & Send Homework"  style="margin-bottom:10px;"/>
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
 
   