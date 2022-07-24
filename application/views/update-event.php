 
<style>
    .btn-success
    {
            background-color: #15726e!important;
            border-color: #15726e!important;
    } 
    .dtp_modal-digits {
    font-size: 50px!important; 
}
.form-group{ margin-bottom:0 !important;}
</style>  
 
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
$(document).ready(function(){
 
$('input[type=radio][class=sent_to]').change(function() {
 
    if (this.value == 'selected') 
    { 
        $('.showclass').show();
    }
    
    else 
    {
         $('.showclass').hide(); 
    }
     
});
$(".studentclass").change(function() {
    var studentclass=$(this).val();  
	$.ajax({
			type: "POST",
			data: { studentclass: studentclass },
			url:"https://www.zumily.com/ajaxClassWiseStudent.php",
			success: function(response){ 
			    $('#studentdata').html(response);
			}
		});
}); 
$("#allcheck").click(function(){ 
    $(".allclass").not(this).prop('checked', this.checked);
}); 

    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;

    console.log(sd);
    $('#startDate').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY",
      defaultDate: sd, 
      todayBtn: true
    });

    $('#endDate').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY",
     defaultDate: ed, 
      todayBtn: true
    });

    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#formCheck"), 'startDate', 'endDate');

}); 
</script> 
    
     

<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4 style="font-size: 14px;"><?php if(@$student_info['student_id'] != '') { echo "Update"; }else { echo "Add";} ?> Event  </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/update-event-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off">
                        <input type="hidden"  name="event_id" value="<?php echo @$event_id; ?>"  >
                        <input type="hidden"  name="image_count" value="<?php echo @$event_info['total_images']; ?>"  > 
                        <div class="col-sm-12">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group" style="margin-bottom:20px!important;"> 
                                <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo @$event_info['title']; ?>" required="true" id="title" onBlur="checkval()" autocomplete="off">
                            </div> 
                            <div class="form-group"> 
                                <textarea rows="3"   name="desc" id="elm1"   placeholder="Description"  style="width: 100%; height: 300px;" ><?php echo @$event_info['description']; ?></textarea> 
                                <span id="errorMsg1" style="color:red;"></span> 
                           </div> 
                           
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Event Date</label>
                                    <input type="text" name="start_date" id="startDate" readonly placeholder="Start Date" value="<?php if(@$event_info['start_date'] != '') { echo date("D, M d, Y",strtotime(@$event_info['start_date'])); } ?>"/>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Start Time </label>
                                    <select class="form-control  " id="start_time"  name="start_time">
                                    <option value="">Select</option>
                                    <?php
                                    foreach($event_time_lists as $time)
                    	            {
                	                ?>
                                    <option value="<?php echo $time->timing; ?>" <?php if(@$event_info['start_time'] == $time->timing)  { echo "selected";} ?>><?php echo $time->format; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                </div>
                                 
                                <div class="form-group col-sm-3">
                                    <label>End Time </label>
                                    <select class="form-control  " id="end_time"  name="end_time">
                                    <option value="">Select</option>
                                    <?php
                                    foreach($event_time_lists as $time)
                    	            {
                	                ?>
                                    <option value="<?php echo $time->timing; ?>" <?php if(@$event_info['end_time'] == $time->timing)  { echo "selected";} ?>><?php echo $time->format; ?></option>
                                    <?php } ?>
                                    
                                    </select>
                                </div>
                            </div>
                           <div class="col-sm-6 form-group next" style="padding-left:0px;">
                        		<label>Upload Image</label> 
                        		<input type="file"  name="images[]" id="subnewtopic" multiple="multiple"    />   
                        	</div> 
                        	<input type="hidden" name="event_images" value="<?php echo $event_info['event_images']; ?>">
                           
                           <div class="clearfix"></div>
                           <div class="row" style="margin-top:0px;"> 
                                <div class="gallery"> 
                                    <ul id="sortable" class="reorder_ul reorder-photos-list">
                                    <?php 
                                        if($event_info['event_images'] != '')
                                        {
                                            $document_array = explode(';',$event_info['event_images']); 
                                            for($i=0;$i<count($document_array);$i++)
                                            { 
                                            $string_array = explode('|',$document_array[$i]);
                                        ?>  
                                        <li id="image_li_<?php echo $string_array[0]; ?>" image_name="<?php echo $string_array[1]; ?>" class="ui-state-default">
                                        <p>Image-<?php echo $string_array[0]; ?>  </p> 
                                        <a href="javascript:void(0);" style="float:none;" class="image_link">
                                        	<img src="<?php echo base_url(); ?>/assets/uploadimages/eventimages/<?php echo $string_array[1]; ?>" alt="" style="height:150px; width:155px;">
                                        </a>
                                        </li>
                                    <?php   } } ?>
                                    </ul>
                                </div>
                            </div> 
                            <?php 
                        	    $totalstudent = 5;
                        	?>
                             
                            <div class="clearfix"></div>
                            <div class="form-group text-right">
                                <input type="submit"  class="check1 btn btn-success col-md-5 col-xs-12" name="Save" value="Update"  style="margin-bottom:10px;"/>
                                &nbsp;
                                <a href="https://localhost/project/zumilyschool/events-list"  class="  btn btn-danger col-md-5 col-xs-12 pull-right" value="Discard"  style="margin-bottom:10px;"/>Discard</a> 
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
 
 <script>
    $(".check1").click(function(){ 
         
        var title = $('#title').val();   
        var editors = textboxio.get('#elm1');
        var editor = editors[0];
        var flyer_desc = editor.content.get(); 
        var startDate = $('#startDate').val();  
        var start_time = $('#start_time').val();  
        var end_time = $('#end_time').val();  
        if(title == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter title!</div>");
            $('#title').css("border","1px solid red");
    		$('#title').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#title').css("border","1px solid #c9c9c9");
        }
        
         
        
        if(flyer_desc == '<p><br /></p>')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter description!</div> ");
            $('#elm1').css("border","1px solid red");
    		$('#elm1').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#elm1').css("border","1px solid #c9c9c9");
        }
        
        
        if(startDate == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select start date</div>");
            $('#startDate').css("border","1px solid red");
    		$('#startDate').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#startDate').css("border","1px solid #c9c9c9");
        } 
        
        if(start_time == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select start time</div>");
            $('#start_time').css("border","1px solid red");
    		$('#start_time').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#start_time').css("border","1px solid #c9c9c9");
        } 
        
         
            
        if(end_time == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please select start time</div>");
            $('#end_time').css("border","1px solid red");
    		$('#end_time').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#end_time').css("border","1px solid #c9c9c9");
        }  
    
    $("#preloader").show();
    });
  </script> 