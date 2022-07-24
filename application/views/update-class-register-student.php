 
<div class="tz-2 mainContant">
    <div class="tz-2-com tz-2-main"> 
        <h4>Manage Student Documents  
            <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4>
        <div class="col-sm-12" style="padding-top:10px;background: #ffffff;">
        	
        	<p> 
        	    <strong>Student Name:</strong> <?php echo urldecode($student_name); ?>&nbsp;&nbsp; 
        	    <strong>Class:</strong> <?php echo urldecode($class_name) ; ?>&nbsp;&nbsp; &nbsp;&nbsp; 
        	    <strong>Registration No.:</strong> <?php echo $registration_no; ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>DOB:</strong> <?php echo urldecode($date_of_birth); ?>&nbsp;&nbsp;&nbsp;&nbsp; 
        	    <strong>Father Name:</strong> <?php echo urldecode($father_name); ?>&nbsp;&nbsp;
        	</p>
         
        </div>
        <div class="db-list-com tz-db-table"> 
            <div class="hom-cre-acc-left hom-cre-acc-right">
                <span id="errorMsg" style="color:red;"></span>
                <form id="formCheck" action="<?php echo base_url();?>/update-class-register-student-process" method="POST" enctype="multipart/form-data" autocomplete="off"  onsubmit="return Validate(this);">
                    
                    <input type="hidden" name="class_register_student_id" value="<?php echo $class_register_student_id; ?>">
                    <input type="hidden" name="class_register_id" value="<?php echo $class_register_id; ?>">
                    <input type="hidden" name="class" value="<?php echo urldecode($class_name); ?>">
                    <input type="hidden" name="student_name" value="<?php echo urldecode($student_name); ?>">
                    <input type="hidden" name="registration_no" value="<?php echo $registration_no; ?>">
                    <input type="hidden" name="dob" value="<?php echo urldecode($date_of_birth); ?>">
                    <input type="hidden" name="father_name" value="<?php echo urldecode($father_name); ?>">
                    <input type="hidden" name="profile_picture" value="<?php echo urldecode($profile_picture); ?>">
                    <input type="hidden" name="student_id" value="<?php echo urldecode($student_id); ?>">
                    <div class="row" style="margin-top:20px;"> 
                        <div class="form-group col-md-4">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="file" name="document" id="document" class="inline imageselect">
                        </div> 
                        <!--<div class="form-group col-md-4 pull-right"> 
                        <?php if($class_register_student_info['documents_info'] != '') { ?><a href="<?php echo base_url(); ?>assets/uploadimages/student/report_card/<?php echo $class_register_student_info['report_card']; ?>"><img src="<?php echo base_url(); ?>assets/uploadimages/student/report_card/<?php echo $class_register_student_info['report_card']; ?>" style="width:80px;height:70px;"></a><?php } ?>
                        </div> -->
                        <div class="clearfix"></div>
                        <div id="uploaded_image"></div>
                    </div> 

                    <div class="col-md-6 col-md-offset-3" style="margin-top:15px;"> 
                    <input type="submit" class="check1 btn btn-success col-md-12" id="  signup" name="update" value="Submit">
                     
                    </div>

                    <div class="clearfix"></div>
                   <div class="row" style="margin-top:10px;"> 
                        <div class="gallery"> 
                            <ul id="sortable" class="reorder_ul reorder-photos-list">
                                <?php 
                                if($class_register_student_info['documents_info'] != '')
                                {
                                    $document_array = explode(';',$class_register_student_info['documents_info']);  
                                ?> 
                                <?php  
                                for($i=0;$i<count($document_array);$i++)
                                { 
                                    $string_array = explode('|',$document_array[$i]);
                                ?> 
                                    <li id="image_li_<?php echo $string_array[0]; ?>" class="ui-state-default">
                                    <p><?php echo $string_array[1]; ?> &nbsp;&nbsp; <a style="float: right;" href="javascript:void(0)" title="Delete this Class" onclick = "delete_student('<?php echo $class_register_student_info['class_register_student_id']; ?>','<?php echo $string_array[0]; ?>','<?php echo urldecode($class_name); ?>','<?php echo urldecode($student_name); ?>','<?php echo $registration_no; ?>','<?php echo urldecode($date_of_birth); ?>','<?php echo urldecode($father_name); ?>');"    ><i class="fa fa-trash-o" style="font-size:24px;"></i></a></p> 
                                    <a href="javascript:void(0);" style="float:none;" class="image_link">
                                    	<img src="<?php echo base_url(); ?>/assets/uploadimages/student/documents/<?php echo $string_array[2]; ?>" alt="" style="height:150px; width:155px;">
                                    </a>
                                    </li>
                                <?php  } } ?> 
                            </ul>
                        </div>
                    </div> 
                    <br>
                </form>
            </div>
            </div> 
        </div>
</div>  
</div> 
  <script>  
function delete_student(val1,val2,val3,val4,val5,val6,val7)
{ 
    alertify.set({
       labels : {
          ok     : "Yes, I want to delete it.",
          cancel : "Cancel"
       }, 
       buttonReverse : false,
       buttonFocus   : "ok"
    });
    alertify.confirm("Are you sure to delete this document?", function (e) 
    { 
        if (e) 
        { 
        	var pass_data = {class_register_student_id: val1,document_id: val2,class_id: val3,student_name: val4,registration_no: val5,dob: val6,father_name: val7};
        	$.ajax({
        	url : "<?php echo base_url(); ?>delete-student-document",
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
<script>
      $(".check1").click(function(){  
    var title = $('#title').val();  
    
    var document = $('#document').val();  
    if(title == '')
    {
        $('#errorMsg').html("Please enter title!");
        $('#title').css("border","1px solid red");
		$('#title').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#title').css("border","1px solid #c9c9c9");
    } 
    
    if(document == '')
    {
        $('#errorMsg').html("Please select document");
        $('#document').css("border","1px solid red");
		$('#document').focus();
		return false;
    }
    else
    {
        $('#errorMsg').html("");
        $('#document').css("border","1px solid #c9c9c9");
    } 
    
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit();  
    $("#preloader").show();
    }); 
   
  </script> 
 
 
   
<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Manage-Student-Documents</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >This page is designed to list and upload documents to a specific student.</li>
                  <li >It displays student's info on the TOP of the page so please CONFIRM student-name, class, DOB, father'-name before uploading a document..</li>
                  <li >Remember, Student and Parent can see these uploaded Documents in realtime on Zumily-School app, means immediately as you upload it.</li>
                  <li >You don't want uploaded documents to be seen by Student/Parent other than belongs to, so match the student's info on this page and a document you are uploading it.</li>
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


