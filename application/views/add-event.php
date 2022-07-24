 
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
    

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>      

<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$student_info['student_id'] != '') { echo "Update"; }else { echo "Add";} ?> Event  
        <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-event-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off">
                        <input type="hidden"  name="id" value="<?php echo @$event_id; ?>"  > 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group" style="margin-bottom:8px!important;"> 
                                <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo @$event_info['title']; ?>" required="true" id="title" onBlur="checkval()" autocomplete="off">
                            </div> 
                            <div class="form-group"> 
                                <textarea rows="3"   name="desc" id="elm1"   placeholder="Description"  style="width: 100%; height: 200px;" ><?php echo @$event_info['description']; ?></textarea> 
                                <span id="errorMsg1" style="color:red;"></span> 
                           </div> 
                           
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label>Event Date</label>
                                    <input type="text" name="start_date" id="startDate" readonly placeholder="Start Date" value="<?php if(@$event_info['start_date'] != '') { echo date("D, M d, Y",strtotime(@$session_info['start_date'])); } ?>"/>
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
                           
                           <div class="clearfix"></div>
                            <?php 
                        	    $totalstudent = 5;
                        	?>
                            <div class="btn-group form-group">  
                            	<input type="radio" class="sent_to" id="radio1" name="sent_to"  value="all" checked="checked"   /> 
                            	<label for="radio1" style="font-size:14px;">&nbsp; All</label>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            	<input type="radio" class="sent_to" id="radio3" name="sent_to"   value="selected" <?php if($totalstudent < 1) { ?>disabled<?php } ?> /> 
                            	<label for="radio3" style="font-size:14px;">&nbsp; Classes</label> 
                            </div>  
                            <div class="showclass" style="display:none;">
                            
                           <table id="example" class="table table-striped table-bordered "   >
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" style="position:relative;" id="allcheck"   class="eventcheckbox " /> </th>
                                        <th>Class</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                	foreach($classregister_lists as $classregister)
                                	{
                                	?> 
                                    <tr>
                                        <td > <input type="checkbox"    style="position:relative;" name ="class_register_ids[]" value="<?php echo $classregister->class_register_id; ?>" class="allclass eventcheckbox" />  </td> 
                                        <td><?php echo $classregister->class_name." ".$classregister->section; ?></td> 
                                    </tr>
                                    <?php } ?> 
                                </tbody> 
                            </table>
                        
                            </div> 
                            <div class="clearfix"></div>
                            <div class="form-group text-right">
                                <input type="submit"  class="check1 btn btn-success col-md-5 col-xs-12" name="Save" value="Send"  style="margin-bottom:20px;margin-top: 20px;"/>
                                &nbsp;
                                <a href="https://localhost/project/zumilyschool/event-list"  class="  btn btn-danger col-md-5 col-xs-12 pull-right" value="Discard"  style="margin-bottom:20px;margin-top: 20px;"/>Discard</a> 
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
         $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
    $("#preloader").show();
    });
  </script> 