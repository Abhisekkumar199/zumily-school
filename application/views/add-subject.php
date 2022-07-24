 
<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
        var name = $('#subject_name').val(); 
        var description = $('#elm1').val(); 
        var editors = textboxio.get('#elm1');
        var editor = editors[0];
        var flyer_desc = editor.content.get();  
        var flyer_desc1 = flyer_desc.replace(/&nbsp;/g,''); 
        var flyer_desc2 = flyer_desc1.replace(/ /g,'');    
        var linebreak = flyer_desc2.indexOf("<p><br/></p>");
     
      
        if(name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter subject name</div>");
            $('#subject_name').css("border","1px solid red");
    		$('#subject_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#subject_name').css("border","1px solid #c9c9c9");
        }
        
        
        if(flyer_desc == '<p><br /></p>' || flyer_desc2 == '<p></p>' || flyer_desc2 == '' || linebreak >= 0)
        { 
            $('#errorMsg').html("<div class='alert alert-danger'>Please add the description</div>");
            $('#elm1').css("border","1px solid red");
        	 $('#elm1').focus();
	        return false; 
        } 
        else
        {
            $('#errorMsgImage').html("");
             $('#elm1').css("border","1px solid #c9c9c9");  
        }
          
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit(); 
    });
    
    $("#subject_name").keyup(function(){  
        var subject_name = $(this).val();  
        var subjectId = $("#subjectId").val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-subjectname",  
            data:{subject_name:subject_name,subjectId:subjectId},  
            success:function(response){  
        	    if(response == 1)
        	    { 
        	       
                    $('#errorMsg').html("<div class='alert alert-danger'>Subject name already exists</div>"); 
                    $('#subject_name').css("border","1px solid red");  
                    $(".check1").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#errorMsg').html(""); 
                    $('#subject_name').css("border","1px solid #c9c9c9");  
                    $(".check1").attr("disabled", false);
        	    }
                }
            }); 
        });
       
    });
    
</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$subject_info['subject_id'] != '') { echo "Edit"; }else { echo "Add New";} ?> Subject  
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-subject-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="subjectId" id="subjectId" value="<?php echo @$subject_info['subject_id']; ?>"> 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"> 
                                <input type="text" class="form-control subject_name test" id="subject_name"  name="subject_name" placeholder="Subject Name" value="<?php echo @$subject_info['subject_name'];  ?>" data-toggle="tooltip" data-placement="top" title="Subject name" required="true" autocomplete="off" >
                            </div>
                            <div class="form-group"> 
                                <textarea rows="3"   name="description" id="elm1" placeholder="Enter description..." class=" widgEditor nothing" style="width: 100%; height: 250px;"><?php echo @$subject_info['description']; ?></textarea> 
                            </div>  
                            <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12 savesubject"  id="  signup" name="update" value="Submit"> 
                                </div> 
                            </div>  
                        </div> 
                    </form>
                </div>  
            </div>
        </div>
    </div> 
</div> 
</div>
</div>
 



<!-- Modal -->
<div class="modal fade" id="help_popup" role="dialog" style="top: 40px;">
    <div class="modal-dialog"> 
      <!-- Modal content-->
        <div class="modal-content"  style="border: 3px solid #141E30;    border-radius: 6px;  ">
            <div class="modal-header" style="background: #141E30;box-shadow: 0px -1px 0px 1px #141E30;"  >
              <button type="button" style="color:red!important;font-size:35px!important;text-shadow: none!important;" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add Subject</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Here, you can add all the Subjects with Description being taught in your school.</li>
                  <li >Description can be same as subject name if nothing else to describe.</li>
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
 
