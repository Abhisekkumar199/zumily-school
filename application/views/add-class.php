 
<script>
$(document).ready(function(){  
    $(".check1").click(function(){  
        var class_name = $('#class_name').val(); 
        var section = $('#section').val(); 
         
        if(class_name == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter class name</div>");
            $('#class_name').css("border","1px solid red");
    		$('#class_name').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#class_name').css("border","1px solid #c9c9c9");
        }
        
        if(section == '')
        {
            $('#errorMsg').html("<div class='alert alert-danger'>Please enter section</div>");
            $('#section').css("border","1px solid red");
    		$('#section').focus();
    		return false;
        }
        else
        {
            $('#errorMsg').html("");
            $('#section').css("border","1px solid #c9c9c9");
        }
        
        
        $(this).attr('disabled', true); // Disable this input.
        $("#formCheck").submit(); 
        
    });
    
    $(".checkclass").keyup(function(){  
        var section = $("#section").val(); 
        var class_name = $("#class_name").val(); 
        var classId = $("#classId").val();  
        $.ajax({
            type: "POST",  
            url: "https://localhost/project/zumilyschool/check-classname",  
            data:{class_name:class_name,section:section,classId:classId},  
            success:function(response){  
        	    if(response == 1)
        	    { 
        	       
                    $('#errorMsg').html("<div class='alert alert-danger'>Class already exists</div>"); 
                    $('#section').css("border","1px solid red");  
                    $(".check1").attr("disabled", true);
                   return false; 
        	    }
        	    else
        	    {
        	        $('#errorMsg').html(""); 
                    $('#section').css("border","1px solid #c9c9c9");  
                    $(".check1").attr("disabled", false);
        	    }
                }
            }); 
        });
       
    });
    
</script>
 
 
<div class="tz-2 mainContant" style="background-color:#ffffff;" >
    <div class="tz-2-com tz-2-main">
        <h4  ><?php if(@$class_info['class_id'] != '') { echo "Edit"; }else { echo "Add New";} ?> Class  
        <a href="javascript:void(0);" title="Help"> <i style="float: right;font-size: 26px;color:#ffffff;margin-top: -3px;" class="fa fa-question-circle" data-toggle="modal" data-target="#help_popup" aria-hidden="true"></i></a>
        </h4> 
        <div class="hom-cre-acc-left hom-cre-acc-right">
            <div class="panel-body">
                <div class="hom-cre-acc-left hom-cre-acc-right">
                    <form id="formCheck" action="<?php echo base_url();?>/add-class-process" method="POST" enctype="multipart/form-data" id="subnewtopicform" style="background:#fff; border:1px solid #fff;"  autocomplete="off" onsubmit="return Validate(this);"> 
                        <input type="hidden" name="classId" id="classId" value="<?php echo @$class_info['class_id']; ?>"> 
                        <div class="col-sm-12" style="margin-top:10px;">
                        	<span id="errorMsg" style="color:red;"></span>
                        </div>
                        <div class="col-md-12" >
                            <div class="form-group"> 
                                <input type="text" class="form-control checkclass test" id="class_name"  name="class_name" placeholder="Class Name" value="<?php echo @$class_info['class_name'];  ?>" data-toggle="tooltip" data-placement="top" title="Class name" required="true" utocomplete="off" >
                            </div>
                            <div class="form-group">  
                                <input type="text" class="form-control checkclass test" id="section"  name="section" placeholder="Section" value="<?php echo @$class_info['section'];  ?>" data-toggle="tooltip" data-placement="top" title="Section name" required="true" utocomplete="off" >
                            </div>  
                            <div class="row" style="margin-bottom:20px;margin-top: 20px;">  
                                <div class="col-md-6 col-md-offset-3"> 
                                    <input type="submit" class="check1 btn btn-success col-md-12  "  id="  class" name="update" value="Submit"> 
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
              <h3 class="modal-title"  style="color:#ffbf08;">Help - Add Class</h3>
            </div>
            <div class="modal-body"> 
                <ul class="popup" style="padding:15px;" >
                  <li >Here, you can add all the classes with Section.</li>
                  <li >This is just the Class-name and Section which is going to be used later when creating Class-Registers for a specific session-year.</li>
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
 