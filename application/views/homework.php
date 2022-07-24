<script type="text/javascript">  
var mzOptions = {
    zoomMode: 'off' 
}; 
$(document).ready(function(){ 
    $(document).on("click",".mz-button-close",function() {
         $('.bottomMenu ').css('position','fixed');
    }); 
  
}); 
</script> 
<script type="text/javascript">
$(document).ready(function(){ 
    $(".view-homework").click(function() {
        $('.showhomeworkdetail').html('');
        var homework_id=$(this).attr("homework_id"); 
    	$.ajax({
    			type: "POST",
    			data: { homework_id: homework_id },
    			url:"https://localhost/project/zumilyschool/homework-details",
    			success: function(response){  
    			    $('.showhomeworkdetail').html(response);
    			}
    		});
    }); 
}); 
</script> 
<script>  
function session_event()
{ 
    $("#is_session_changed").val(1); 
}
function deletehomework(val1)
{  
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Remember, if you delete this homework, all recipients will not be able to see it on the app.<br> Are you sure, you want to delete it?", function (e) 
    { 
        if (e) 
        { 
            var homework_id = val1;  
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-homework/"+homework_id,
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
<!--CENTER SECTION-->
<div class="tz-2 mainContant zumily_mainContent">
    <div class="tz-2-com tz-2-main"> 
	    <form method="get" action="<?php echo base_url(); ?>homework" >
    	<div class="row" style="background: #151f31;" >
    		<div class="col-md-6 col-xs-3" > 
    			<h4>Homework List </h4>
    		</div>
    		<div class="col-md-6 col-xs-9" >
		        <input type="hidden" value= "0" name="is_session_changed" id="is_session_changed" />
    		    <div class="row">
    		        <div class="col-md-3"   >
    		            <?php ?>
            		    <select id="session_id" class="form-control  " name="session_id" required=""  style="border: 1px solid rgb(189, 185, 185);height:30px;  margin: 7px; " onchange="session_event();this.form.submit()">
                            <option value="" disabled>Select session year  </option> 
                            <?php foreach($session_years as $session_year) { ?>
                            <option value="<?php echo base64_encode($session_year->session_id); ?>" <?php if($selected_session == $session_year->session_id ) { ?>selected <?php } ?>  ><?php echo $session_year->session_year; ?></option>
                            <?php } ?>
                        </select> 
                    </div> 
                    <div class="col-md-3"   > 
            		    <select id="class_register_id" class="form-control  " name="class_register_id"   style="border: 1px solid rgb(189, 185, 185);  margin: 7px; height:30px;" onchange="this.form.submit()">
                            <option value="">All Classes</option> 
                            <?php foreach($classregister_lists as $class) { ?>
                            <option value="<?php echo base64_encode($class->class_register_id); ?>" <?php if($selected_class == $class->class_register_id ) { ?>selected <?php } ?>  ><?php echo $class->class_name_section; ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                       
                    <div class="col-md-4"  style="padding-right: 0px;" >  
                        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url(); ?>homework-pdf/<?php echo base64_encode($selected_session); ?>-<?php echo base64_encode($selected_class); ?>" target="_blank" title="Generate Report"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: 9px; margin-right: 10px;" class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; &nbsp;</a>
        		        <a  style="  margin-right:10px;margin-top: 11px;" class="  pull-right" href="<?php echo base_url();?>add-homework"><i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-plus-circle"></i></a> 
        		         
                    </div>
    			</div>
    		</div>
    	</div>  
		</form>
    	
    	<div class="hom-cre-acc-left hom-cre-acc-right ">
    	    <div class="col-sm-12 fullWidth-tab">
    		<div class="panel panel-bd lobidrag"> 
            	<div class="panel-body" id="result">
                     
                	<div class="table-responsive tab-inn ad-tab-inn active" id="active">
                    	<table class="table table-hover">
                        	<thead>
                            	<td style="width:50px;">Class</td> 
                            	<td style="width:250px;">Title</td> 
                            	<td>Submit-in </td> 
                            	<td>Created-by</td> 
                            	<td>Created-on</td>
                            	<td>Due Date</td>
                            	<td>Students HW</td>
                            	<td class="text-right" style="width:60px;">Action</td>
                        	</thead>
                            <tbody>
                    	<?php 
                    	if(count($homework_lists) > 0) 
                    	{
                        	foreach($homework_lists as $homework)
                        	{
                    	?> 
                    
                    	<tr class="login<?php echo $homework->homework_id; ?>"    >
                        	<td class="business_list_"><?php echo $homework->class_name_section; ?></td>  
                        	<td class="business_list_"><?php echo $homework->title; ?></td>  
                        	<td class="business_list_"><?php if($homework->homework_type == 'O'){ echo "Online"; } else if($homework->homework_type == 'C') { echo "In-Class";  }    ?></td>  
                        	<td class="business_list_"><?php echo $homework->teacher_name;     ?></td> 
                        	<td class="business_list_"><?php echo date('D, M d, Y', strtotime($homework->date_created)); ?></td> 
                        	<td class="business_list_"><?php echo date('D, M d, Y', strtotime($homework->due_date)); ?></td> 
                    		<td class="business_list_ text-center"> 
                    		    <a href="<?php echo base_url(); ?>homework-students/<?php echo base64_encode($homework->homework_id); ?>">Check HW</a>
                		    </td>                         	
                		    <td class="text-right">
                        	    <?php if(strtotime($homework->due_date) >= strtotime($currentdate)) { ?>
                        	    &nbsp;<a href="javascript:void(0)" title="Delete this Homework" onclick = "deletehomework(<?php echo $homework->homework_id; ?>)"  ><i class="fa fa-trash-o" style="font-size:20px;"></i></a>
                        	    &nbsp;<a href="<?php echo base_url(); ?>update-homework/<?php echo base64_encode($homework->homework_id); ?>" title="Edit Homework"><i class="fa fa-edit" style="font-size:20px;"></i></a>
                        	    <?php } ?>
                        	    &nbsp;<a href="javascript:void(0)"  onclick="showhide2('<?php echo $homework->homework_id; ?>');"   ><i class="fa fa-eye" style="font-size:20px;"></i></a>
                        	    
                    	    </td> 
                    	</tr>  
                    	
                    	
                    	
                            	<tr class=" business_list_dropdown login2<?php echo $homework->homework_id; ?>">
                                    <td colspan="7">  
                                        <div class="col-sm-12"> 
                                             <?php  $leave_request_images =   $homework->homework_documents_images;  ?>
                                            <div class="col-md-12 flyer_detail_show" >   
                                                <div class="row title">
                                                	<div class="col-md-12">   
                                                    		<h4 style="color: #000000;background-color:#ffffff;padding-left:0px;"><?php echo $homework->title; ?></h4>   
                                                	</div> 
                                                </div>  
                                                <div class="row">
                                                	<div class="col-md-12"> <?php echo $homework->description; ?>
                                                	</div> 
                                                </div>   
                                                <br>
                                                <div class="clearfix"></div> 
                                                <?php if($homework->homework_documents_images != ''){ ?>
                                                <div class="preview col">   
                                                    <div class="app-figure" id="zoom-fig"> 
                                                        <div id="myCarouselflyer<?php echo $homework->homework_id; ?>" class="carousel slide" data-ride="carousel"> 
                                                            <!-- Indicators -->
                                                            <div class="carousel-inner"> 
                                                                <?php  
                                                                $document_array = explode(';',$homework->homework_documents_images);  
                                                                for($i=0;$i<count($document_array);$i++)
                                                                { 
                                                                    $string_array = explode('|',$document_array[$i]);
                                                                ?>  
                                                                    <div class="item <?php if($i == 1){ ?>active <?php } ?> "> 
                                                                        <a id="Zoom-flyer<?php echo $homework->homework_id; ?>" style="max-height: 500px;min-height: 500px;" class="MagicZoom" onclick="imageevent();"  href="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>">
                                                                            <img data-animation="animated zoomInLeft" style="max-height: 500px;min-height: 500px;" src="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>"> 
                                                                        </a> 
                                                                    </div>  
                                                                    <a class="left carousel-control" href="#myCarouselflyer<?php echo $homework->homework_id; ?>" data-slide="prev"><i class="fa fa-chevron-left" style="margin: 225px 0px;
                                                                    font-size: 28px; background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                    <a class="right carousel-control" href="#myCarouselflyer<?php echo $homework->homework_id; ?>" data-slide="next"><i class="fa fa-chevron-right" style="margin: 225px 0px; font-size: 28px;
                                                                    background-color: rgba(0,0,0,0.5); border-radius: 50%; height: 50px; width: 50px; text-align: center; line-height: 51px;"></i></a> 
                                                                    <div class="selectors">
                                                                        <a data-zoom-id="Zoom-flyer<?php echo $homework->homework_id; ?>" style="max-height: 500px;min-height: 500px;" href="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>"
                                                                        data-image="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>" >
                                                                        <img style="max-height: 500px;min-height: 500px;" srcset="<?php echo base_url(); ?>/assets/uploadimages/homeworkimages/<?php echo $string_array[1]; ?>">
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
                                                    <span class="pull-right border_btn mt10 mr10"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp; <?php echo $homework->date_created; ?> </span> 
                                                </div> 
                                                <div class="clearfix"></div>   
                                            </div>  
                                        </div>  
                                    </td>
                                </tr>
                    	
                    	<?php } }  else { ?>
                    	<tr>
                    		<td colspan="2"  class="business_list_">You have no homework. <a href="<?php echo base_url(); ?>/add-homework">Click here</a> to create one.</td>
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

<style>
.business_list_dropdown{ display:none;} 
</style>
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Homework</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >By default, it lists all the home work created by all the TEACHERS in the DESCENDING order of date-created.</li>
                  <li >You can filter HOMEWORK by a specific Session-Year by selecting it.</li>
                  <li >It can be filtered by a specific Class-Register(class) by selecting it from drop-down list. It will all Homework created by all teachers for this selected class.</li>
                  <li >It can also be filtered by a specific Teacher which will list all the HW created by this selected teacher for all the years.</li>
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

