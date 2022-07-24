 
<style>
    .btn-success
    {
            background-color: #15726e!important;
            border-color: #15726e!important;
    }
</style>  
 
<script>

$(document).ready(function(){ 
    $('.teacher').change(function() {  
        var teacher_id = $(this).val();   
        $.ajax({
        type: "POST",  
        url: "https://localhost/project/zumilyschool/get-teacher-classes",  
        data:{teacher_id:teacher_id},  
        success:function(response){   
            $(".class").html(response);   
            }
        }); 
    }); 
    
    var today = new Date().toDateString("ddd, MMM DD, YYYY"); 
    var sd = today;
    var ed = today;  
     
    $('#due_date').datetimepicker({
      pickTime: false,
      format: "ddd, MMM DD, YYYY",
      minDate:sd, 
      todayBtn: true
    });  
    //passing 1.jquery form object, 2.start date dom Id, 3.end date dom Id
    bindDateRangeValidation($("#formCheck"), 'due_date');
 
  
    
}); 
</script>

<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$homework_info['homework_id'] != '') { echo "Update"; }else { echo "Add";} ?> Homework  <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" aria-hidden="true"></i></h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-homework-process" method="POST" enctype="multipart/form-data" 
                    id="subnewtopicform" style="background:#fff; border:1px solid #fff;" autocomplete="off"> 
                        <input type="hidden"  name="id" value="<?php echo @$homework_info['homework_id']; ?>"  > 
                        <input type="hidden"  name="total_document" value="<?php echo @$homework_info['total_document']; ?>"  > 
                        <input type="hidden"  name="old_documents"  value="<?php echo @$homework_info['homework_documents_images']; ?>" >
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12"> 
                            <div class="form-group"> 
                                <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo @$homework_info['title']; ?>" required="true" id="title" onBlur="checkval()" autocomplete="off">
                                <input type="hidden"  name="old_title"  value="<?php echo @$homework_info['title']; ?>" >
                            </div>
                        </div>
                        <div class="row col-md-12">
                                <div class="form-group col-sm-6">
                                    <select class="form-control teacher " name="teacher_id" id="teacher_id" <?php if(@$homework_info['homework_id'] != '') { echo "disabled";} ?> >
                                    <option value="">Select Subject Teacher</option>
                                        <?php 
                                    	foreach($teacher_lists as $teacher)
                                    	{
                                    	?> 
                                        <option value="<?php echo $teacher->teacher_id; ?>" <?php if($teacher->teacher_id == @$homework_info['teacher_id']) { echo "selected"; } ?> ><?php echo $teacher->first_name." ".$teacher->last_name; ?> (<?php echo $teacher->subject1; ?>)</option> 
                                        <?php } ?>
                                    </select> 
                                    <input type="hidden" id="teacher_name" name="teacher_name" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <select class="form-control class  " name="class_register_id" id="class_register_id" <?php if(@$homework_info['homework_id'] != '') { echo "disabled";} ?>>
                                    <?php if(@$homework_info['homework_id'] != '') { ?>
                                    <option value="<?php echo $homework_info['class_register_id'];  ?>" selected><?php echo $homework_info['class_name_section'];  ?></option>
                                    <?php } else { ?>
                                    <option value="">Select Class</option>
                                        <!--<?php 
                                    	foreach($classregister_lists as $classregister)
                                    	{
                                    	?> 
                                        <option value="<?php echo $classregister->class_register_id; ?>" <?php if($classregister->class_register_id == @$homework_info['class_register_id']) { echo "selected"; } ?> ><?php echo $classregister->class_name." ".$classregister->section; ?> (<?php echo  $classregister->first_name." ".$classregister->last_name; ?>)</option> 
                                        <?php } ?>-->
                                    <?php } ?>    
                                    </select> 
                                    <input type="hidden" id="class_section_name" name="class_section_name" />
                                </div>
                                
                                 
                                <div class="form-group col-sm-6">
                                    <select class="form-control  " name="submit_type" id="submit_type">
                                        <option value="">Submit Type</option>
                                        <option value="O" <?php if(@$homework_info['homework_type'] == 'O') { echo "selected"; } ?> >Online</option>
                                        <option value="C" <?php if(@$homework_info['homework_type'] == 'C') { echo "selected"; } ?>>In-Class</option>
                                        
                                    </select>
                                    <input type="hidden"  name="old_submit_type"  value="<?php echo @$homework_info['homework_type']; ?>" >
                                </div>
                                <div class="form-group col-sm-6"> 
                                    <input type="text" name="due_date" id="due_date" readonly placeholder="Due Date" value="<?php if(@$homework_info['due_date'] != '') { echo date("D, M d, Y",strtotime(@$homework_info['due_date'])); } ?>"/>
                                    
                                    <input type="hidden"  name="old_due_date"  value="<?php echo @$homework_info['due_date']; ?>" >
                                </div>
                            </div>
                            <div class="col-md-12"> 
                             
                                <div class="form-group"> 
                                    <textarea rows="3"   name="desc" id="elm1"   placeholder="Description"  style="width: 100%; height: 200px;" ><?php echo @$homework_info['description']; ?></textarea> 
                                    <input type="hidden"  name="old_desc"  value="<?php echo @$homework_info['description']; ?>" >
                                    <span id="errorMsg1" style="color:red;"></span> 
                                </div>  
                                <div class="col-sm-6 form-group next">
                            		<label>Upload Image</label> 
                            		<input type="file"  name="documents[]" id="subnewtopic" multiple="multiple"    />  
                                            
                            	</div>   
                            
                            <div class="clearfix" ></div>
                            
                            <?php if(@$homework_info['homework_id'] !=''){ ?>
                            
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
                            
                            <?php } ?>
                            <div style="margin-bottom:10px;" class="col-md-6 col-md-offset-3">
                                <input type="submit"  class="check1   btn btn-success col-md-12  " name="Save" value="Save & Reorder Documents"  style="margin-bottom:10px;"/>
                                  
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
    var teacher_id = $('#teacher_id').val();  
    var class_register_id = $('#class_register_id').val(); 
    var submit_type = $('#submit_type').val(); 
    var due_date = $('#due_date').val(); 
    
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
    
    if(teacher_id == '')
    {
        $('#errorMsg').html("<div class='alert alert-danger'>Please select subject teacher!</div>");
        $('#teacher_id').css("border","1px solid red");
		$('#teacher_id').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#teacher_id').css("border","1px solid #c9c9c9");
    }
    
    if(class_register_id == '')
    {
        $('#errorMsg').html("<div class='alert alert-danger'>Please select class!</div>");
        $('#class_register_id').css("border","1px solid red");
		$('#class_register_id').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#class_register_id').css("border","1px solid #c9c9c9");
    }
    
    if(submit_type == '')
    {
        $('#errorMsg').html("<div class='alert alert-danger'>Please select submit type!</div>");
        $('#submit_type').css("border","1px solid red");
		$('#submit_type').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#submit_type').css("border","1px solid #c9c9c9");
    }
    
    if(due_date == '')
    {
        $('#errorMsg').html("<div class='alert alert-danger'>Please select homework due date!</div>");
        $('#due_date').css("border","1px solid red");
		$('#due_date').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#due_date').css("border","1px solid #c9c9c9");
    }
    
    var class_section_name = $("#class_register_id option:selected").text(); 
    $("#class_section_name").val(class_section_name);
    
    var teacher_name = $("#teacher_id option:selected").text(); 
    $("#teacher_name").val(teacher_name);
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
    $("#formCheck").submit(); // Submit the form it is in. 
     
    $("#preloader").show();
    
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