
<link href="<?php echo base_url(); ?>assets/css/style3.css" rel="stylesheet" type="text/css" />
<style>
    .btn-success
    {
            background-color: #15726e!important;
            border-color: #15726e!important;
    }
</style>
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
  
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> 
 
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false
    } );
    $('#example1').DataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false
    } );
} );
$(document).ready(function(){
 
$('input[type=radio][class=sent_to]').change(function() {
 
    if (this.value == 'selected') 
    {
         $('.showstudent').hide();
        $('.showclass').show();
    }
    else if (this.value == 'students') 
    {
         $('.showclass').hide();
        $('.showstudent').show();
    }
    else 
    {
         $('.showclass').hide();
         $('.showstudent').hide();
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
});
$(document).ready(function(){
    $("#allcheck").click(function(){ 
    $(".allclass").not(this).prop('checked', this.checked);
});
 $("#allcheckstudent").click(function(){ 
    $(".allstudent").not(this).prop('checked', this.checked);
});
});
  
 
</script>

<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$student_info['student_id'] != '') { echo "Update"; }else { echo "Add";} ?> Message  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-message-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off">
                        <input type="hidden"  name="id" value="<?php echo @$message_id; ?>"  > 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group"> 
                                <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo @$message_info['title']; ?>" required="true" id="title" onBlur="checkval()" autocomplete="off">
                            </div>
                            <div class="form-group"> 
                                <select class="form-control  " name="message_type_id" id="message_type_id">
                                <option value="">Select Message Type </option>
                                    <?php 
                                	foreach($message_type_lists as $message_type)
                                	{
                                	?> 
                                    <option value="<?php echo $message_type->message_type_id; ?>"><?php echo $message_type->display_name; ?></option> 
                                    <?php } ?>
                                </select>
                                <input type="hidden" value="" name="message_type_text" id="message_type_text" />
                            </div>
                            <div class="form-group"> 
                                <textarea rows="3"   name="desc" id="elm1"   placeholder="Description"  style="width: 100%; height: 250px;" ><?php echo @$message_info['description']; ?></textarea> 
                                <span id="errorMsg1" style="color:red;"></span> 
                           </div> 
                           
                           
                           <div class="col-sm-6 form-group next">
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
                            	<label for="radio3" style="font-size:14px;">&nbsp; Classes</label>&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
                            	<input type="radio" class="sent_to" id="radio4" name="sent_to"   value="students" <?php if($totalstudent < 1) { ?>disabled<?php } ?> /> 
                            	<label for="radio4" style="font-size:14px;">&nbsp; Students</label> 
                            </div>  
                            <div class="showclass" style="display:none;">
                            
                               <table id="example" class="table table-striped table-bordered "   >
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" style="position:relative;" id="allcheck"   class="messagecheckbox " /> </th>
                                            <th>Class</th> 
                                            <th>Session Year</th>  
                                            <th>Teacher</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    	foreach($classregister_lists as $classregister)
                                    	{
                                    	?> 
                                        <tr>
                                            <td > <input type="checkbox"    style="position:relative;" name ="class_register_ids[]" value="<?php echo $classregister->class_register_id; ?>" class="allclass messagecheckbox" />  </td> 
                                            <td><?php echo $classregister->class_name." ".$classregister->section; ?> </td>  
                                            <td><?php echo $classregister->session_year; ?> </td>  
                                            <td><?php echo  $classregister->first_name." ".$classregister->last_name; ?> </td> 
                                        </tr>
                                        <?php } ?> 
                                    </tbody> 
                                </table>
                        
                            </div>
                            <div class="showstudent" style="display:none;">
                            
                               <table id="example1" class="table table-striped table-bordered "   >
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" style="position:relative;" id="allcheckstudent"   class="messagecheckbox " /> </th>
                                            <th>Students</th> 
                                            <th>Class</th>
                                            <th>Father Name</th
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                    	foreach($student_lists as $student)
                                    	{
                                    	?> 
                                        <tr>
                                            <td > <input type="checkbox"    style="position:relative;" name ="students[]" value="<?php echo $student->student_id; ?>" class="allstudent messagecheckbox" />  </td> 
                                            <td><?php echo $student->first_name." ".$student->last_name; ?></td> 
                                            <td><?php echo $student->class_name." ".$student->section; ?> </td> 
                                            <td><?php echo $student->father_name." (".$student->parent_mobile_no.")"; ?> </td> 
                                        </tr>
                                        <?php } ?> 
                                    </tbody> 
                                </table>
                        
                            </div>
                            <div class="clearfix" ></div>
                            <div style="margin-bottom:10px;" class="col-md-6 col-md-offset-3">
                                <input type="submit"  class="check1   btn btn-success col-md-12  " name="Save" value="Save & Reorder Images"  style="margin-bottom:10px;"/>
                                  
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
 
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>  
 <script>
      $(".check1").click(function(){ 
    var title = $('#title').val();  
    var message_type = $('#message_type_id').val(); 
    
    var editors = textboxio.get('#elm1');
    var editor = editors[0];
    var flyer_desc = editor.content.get(); 
    var imageCheck = $('#subnewtopic').val();  
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
    
    if(message_type == '')
    {
        $('#errorMsg').html("<div class='alert alert-danger'>Please select message type!</div>");
        $('#message_type_id').css("border","1px solid red");
		$('#message_type_id').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#message_type_id').css("border","1px solid #c9c9c9");
    }
    
    var message_type_text = $("#message_type_id option:selected").text(); 
    $("#message_type_text").val(message_type_text);
    
    
    if(flyer_desc == '<p><br /></p>')
    {
        if(imageCheck == '')
        {
            $('#errorMsg').html("Please enter description or select Image");
            $('#elm1').css("border","1px solid red");
    		$('#elm1').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#elm1').css("border","1px solid #c9c9c9");
        } 
    }
    
     $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
     
    $("#preloader").show();
      });
  </script> 